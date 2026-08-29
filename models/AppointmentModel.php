<?php
require_once "Database.php";

class AppointmentModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Fetch all appointments 
    public function getAppointments($status = null, $doctorId = null)
    {
        $sql = "
        SELECT 
            a.appointment_id AS id,
            a.appointment_code,
            a.patient_condition AS `condition`,
            DATE(a.requested_datetime) AS `date`,
            TIME(a.requested_datetime) AS `time`,
            a.status,
            a.requested_datetime AS requested_at,
            CONCAT(u.first_name, ' ', u.last_name) AS patient
        FROM appointments a
        JOIN users u ON a.patient_id = u.user_id
        WHERE 1=1
    ";

        $params = [];

        if ($status) {
            $sql .= " AND a.status = :status";
            $params[':status'] = $status;
        }

        if ($doctorId) {
            $sql .= " AND a.doctor_id = :doctor_id";
            $params[':doctor_id'] = $doctorId;
        }

        $sql .= " ORDER BY a.requested_datetime DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Approve appointment
    public function approveAppointment($appointmentId, $scheduledDateTime)
    {
        $sql = "UPDATE appointments 
                SET status = 'confirmed', scheduled_datetime = :scheduled_datetime 
                WHERE appointment_id = :id AND status = 'pending'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":scheduled_datetime", $scheduledDateTime);
        $stmt->bindParam(":id", $appointmentId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Reject appointment 
    public function rejectAppointment($appointmentId)
    {
        $sql = "UPDATE appointments 
                SET status = 'cancelled' 
                WHERE appointment_id = :id AND status = 'pending'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $appointmentId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Mark as completed
    public function completeAppointment($appointmentId)
    {
        $sql = "UPDATE appointments 
                SET status = 'completed' 
                WHERE appointment_id = :id AND status = 'confirmed'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $appointmentId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
