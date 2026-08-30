<?php
require_once "Database.php";

class BillingModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getDashboardStats()
    {
        $sql = "SELECT
            COALESCE(SUM(CASE WHEN status = 'paid' AND YEAR(issue_date)=YEAR(CURDATE()) AND MONTH(issue_date)=MONTH(CURDATE()) THEN total_amount ELSE 0 END),0) AS monthly_revenue,
            SUM(status = 'pending') AS pending_invoices,
            SUM(status = 'paid') AS paid_invoices,
            COALESCE(SUM(CASE WHEN status IN ('pending','overdue') THEN balance_due ELSE 0 END),0) AS outstanding
            FROM invoices";
        $row = $this->conn->query($sql)->fetch(PDO::FETCH_ASSOC);
        return [
            'monthly_revenue'=>(float)$row['monthly_revenue'],
            'pending_invoices'=>(int)$row['pending_invoices'],
            'paid_invoices'=>(int)$row['paid_invoices'],
            'outstanding'=>(float)$row['outstanding']
        ];
    }

    public function getRecentTransactions($limit=10)
    {
        $sql = "SELECT i.invoice_id, i.invoice_number, CONCAT(u.first_name,' ',u.last_name) patient,
                       i.issue_date, i.total_amount, i.status,
                       COALESCE(p.method,'—') method
                FROM invoices i
                JOIN users u ON u.user_id=i.patient_id
                LEFT JOIN payments p ON p.invoice_id=i.invoice_id
                ORDER BY i.issue_date DESC, i.invoice_id DESC LIMIT :limit";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindValue(':limit',(int)$limit,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInvoices($status=null)
    {
        $sql="SELECT i.*, CONCAT(u.first_name,' ',u.last_name) patient
              FROM invoices i JOIN users u ON u.user_id=i.patient_id";
        $params=[];
        if($status){$sql.=" WHERE i.status=:status";$params[':status']=$status;}
        $sql.=" ORDER BY i.issue_date DESC, i.invoice_id DESC";
        $stmt=$this->conn->prepare($sql); $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPatients()
    {
        $stmt=$this->conn->query("SELECT user_id, first_name, last_name, email FROM users WHERE role='patient' ORDER BY first_name,last_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createInvoice($patientId,$service,$amount,$dueDate,$appointmentId=null)
    {
        $amount=(float)$amount;
        $invoiceNumber='INV-'.date('YmdHis').'-'.random_int(100,999);
        $sql="INSERT INTO invoices (invoice_number,patient_id,appointment_id,service_description,issue_date,due_date,total_amount,balance_due,status)
              VALUES (:number,:patient,:appointment,:service,CURDATE(),:due,:amount,:amount,'pending')";
        $stmt=$this->conn->prepare($sql);
        return $stmt->execute([
            ':number'=>$invoiceNumber,':patient'=>$patientId,':appointment'=>$appointmentId ?: null,
            ':service'=>$service,':due'=>$dueDate ?: null,':amount'=>$amount
        ]);
    }

    public function getPayments()
    {
        $sql="SELECT p.*, i.invoice_number, CONCAT(u.first_name,' ',u.last_name) patient
              FROM payments p JOIN invoices i ON i.invoice_id=p.invoice_id
              JOIN users u ON u.user_id=i.patient_id
              ORDER BY p.payment_date DESC,p.payment_id DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPayableInvoices()
    {
        return $this->conn->query("SELECT invoice_id,invoice_number,balance_due FROM invoices WHERE balance_due>0 ORDER BY due_date,invoice_id")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function recordPayment($invoiceId,$amount,$method,$reference='')
    {
        $this->conn->beginTransaction();
        try {
            $stmt=$this->conn->prepare("SELECT balance_due FROM invoices WHERE invoice_id=:id FOR UPDATE");
            $stmt->execute([':id'=>$invoiceId]);
            $invoice=$stmt->fetch(PDO::FETCH_ASSOC);
            if(!$invoice || (float)$amount<=0 || (float)$amount>(float)$invoice['balance_due']){
                throw new RuntimeException("Invalid payment amount.");
            }
            $stmt=$this->conn->prepare("INSERT INTO payments(invoice_id,payment_date,amount,method,reference_number)
                                        VALUES(:invoice,CURDATE(),:amount,:method,:reference)");
            $stmt->execute([':invoice'=>$invoiceId,':amount'=>$amount,':method'=>$method,':reference'=>$reference ?: null]);
            $balance=(float)$invoice['balance_due']-(float)$amount;
            $status=$balance<=0 ? 'paid' : 'pending';
            $stmt=$this->conn->prepare("UPDATE invoices SET balance_due=:balance,status=:status WHERE invoice_id=:id");
            $stmt->execute([':balance'=>$balance,':status'=>$status,':id'=>$invoiceId]);
            $this->conn->commit();
            return true;
        } catch(Throwable $e) {
            if($this->conn->inTransaction()) $this->conn->rollBack();
            return false;
        }
    }

    public function getFinancialSummary()
    {
        $sql="SELECT
              COALESCE(SUM(total_amount),0) gross_revenue,
              COALESCE(SUM(total_amount-balance_due),0) collected,
              COALESCE(SUM(balance_due),0) outstanding,
              COALESCE(SUM(total_amount-balance_due)/NULLIF(SUM(total_amount),0)*100,0) collection_rate
              FROM invoices";
        return $this->conn->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
}
