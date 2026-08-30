<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'accountant') {
    header("Location: ../views/login.php");
    exit();
}
require_once "../models/BillingModel.php";
$model = new BillingModel();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/accountant/accountant_layout.php");
    exit();
}

$action=$_POST['action'] ?? '';
$success=false;
$message='';

try {
    if($action==='create_invoice'){
        $patient=(int)($_POST['patient_id'] ?? 0);
        $service=trim($_POST['service'] ?? '');
        $amount=(float)($_POST['amount'] ?? 0);
        $due=$_POST['due_date'] ?? '';
        if(!$patient || $service==='' || $amount<=0) throw new RuntimeException('Patient, service and a valid amount are required.');
        $success=$model->createInvoice($patient,$service,$amount,$due,(int)($_POST['appointment_id']??0));
        $message=$success?'Invoice created successfully.':'Unable to create invoice.';
    } elseif($action==='record_payment'){
        $invoice=(int)($_POST['invoice_id'] ?? 0);
        $amount=(float)($_POST['amount'] ?? 0);
        $method=trim($_POST['method'] ?? '');
        $reference=trim($_POST['reference'] ?? '');
        if(!$invoice || $amount<=0 || $method==='') throw new RuntimeException('Invoice, amount and payment method are required.');
        $success=$model->recordPayment($invoice,$amount,$method,$reference);
        $message=$success?'Payment recorded successfully.':'Unable to record payment. Check the balance and amount.';
    } else {
        $message='Invalid billing action.';
    }
} catch(Throwable $e) {
    $message=$e->getMessage();
}
$_SESSION['billing_message']=$message;
$_SESSION['billing_success']=$success;
$target=$action==='record_payment'?'payments':'billing';
header("Location: ../views/accountant/accountant_layout.php?page=".$target);
exit();
