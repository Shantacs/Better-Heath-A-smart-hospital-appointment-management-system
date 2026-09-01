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

    // Get appointments by doctor
    public function getAppointmentsByDoctor($doctorId, $status = null)
    {
        $sql = "
        SELECT 
            a.appointment_id AS id,
            a.appointment_code,
            a.patient_condition AS `condition`,
            a.status,
            a.requested_datetime,
            a.scheduled_datetime,
            CONCAT(p.first_name, ' ', p.last_name) AS patient
        FROM appointments a
        JOIN users p ON a.patient_id = p.user_id
        WHERE a.doctor_id = :doctor_id
        ";

        $params = [':doctor_id' => $doctorId];

        if ($status) {
            $sql .= " AND a.status = :status";
            $params[':status'] = $status;
        }

        $sql .= " ORDER BY a.requested_datetime DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get appointments by patient
    public function getAppointmentsByPatient($patientId, $status = null)
    {
        $sql = "
        SELECT 
            a.appointment_id AS id,
            a.appointment_code,
            a.patient_condition AS `condition`,
            a.status,
            a.requested_datetime,
            a.scheduled_datetime,
            CONCAT(d.first_name, ' ', d.last_name) AS doctor
        FROM appointments a
        JOIN users d ON a.doctor_id = d.user_id
        WHERE a.patient_id = :patient_id
        ";

        $params = [':patient_id' => $patientId];

        if ($status) {
            $sql .= " AND a.status = :status";
            $params[':status'] = $status;
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

    // Delete appointment
    public function deleteAppointment($appointmentId)
    {
        $sql = "DELETE FROM appointments WHERE appointment_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $appointmentId]);
    }

    // Request a new appointment
    public function requestAppointment($patientId, $doctorId, $condition, $requestedDateTime)
    {
        try {
            // Check if patient already has an appointment with this doctor on the same day
            $query = "
                SELECT COUNT(*) AS count 
                FROM appointments 
                WHERE patient_id = :patient_id 
                AND doctor_id = :doctor_id 
                AND DATE(requested_datetime) = DATE(:requested_datetime)
                AND status IN ('pending', 'confirmed')
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':patient_id' => $patientId,
                ':doctor_id' => $doctorId,
                ':requested_datetime' => $requestedDateTime
            ]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] > 0) {
                return [
                    'success' => false,
                    'message' => 'You already have an appointment with this doctor on this day.'
                ];
            }

            // Generate unique appointment code
            $appointmentCode = "A-" . rand(10000, 99999);

            // Insert new appointment
            $sql = "
                INSERT INTO appointments 
                (appointment_code, patient_id, doctor_id, patient_condition, requested_datetime, status, created_at, updated_at) 
                VALUES 
                (:appointment_code, :patient_id, :doctor_id, :condition, :requested_datetime, 'pending', NOW(), NOW())
            ";

            $stmt = $this->conn->prepare($sql);
            $success = $stmt->execute([
                ':appointment_code' => $appointmentCode,
                ':patient_id' => $patientId,
                ':doctor_id' => $doctorId,
                ':condition' => $condition,
                ':requested_datetime' => $requestedDateTime
            ]);

            if ($success) {
                return [
                    'success' => true,
                    'message' => 'Appointment request submitted successfully!',
                    'appointment_code' => $appointmentCode
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to request appointment.'
            ];

        } catch (PDOException $e) {
            error_log("Error in requestAppointment: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error occurred.'
            ];
        }
    }
}
