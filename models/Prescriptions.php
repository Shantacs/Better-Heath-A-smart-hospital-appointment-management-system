<?php
require_once "Database.php";

class PrescriptionModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Add a new prescription by doctor for an appointment
    public function addPrescription($appointmentId, $doctorId, $notes)
    {
        try {
            // Get patient_id from appointment
            $query = "SELECT patient_id FROM appointments WHERE appointment_id = :appointment_id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':appointment_id' => $appointmentId]);
            $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$appointment) {
                return ['success' => false, 'message' => 'Appointment not found.'];
            }

            $patientId = $appointment['patient_id'];

            $sql = "
                INSERT INTO prescriptions (appointment_id, doctor_id, patient_id, prescribed_at, notes)
                VALUES (:appointment_id, :doctor_id, :patient_id, NOW(), :notes)
            ";

            $stmt = $this->conn->prepare($sql);
            $success = $stmt->execute([
                ':appointment_id' => $appointmentId,
                ':doctor_id' => $doctorId,
                ':patient_id' => $patientId,
                ':notes' => $notes
            ]);

            return $success
                ? ['success' => true, 'message' => 'Prescription added successfully.']
                : ['success' => false, 'message' => 'Failed to add prescription.'];

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    // View all prescriptions for a patient
    public function getPrescriptionsByPatient($patientId)
    {
        $sql = "
            SELECT 
                p.prescription_id,
                p.appointment_id,
                p.notes,
                p.prescribed_at,
                CONCAT(d.first_name, ' ', d.last_name) AS doctor
            FROM prescriptions p
            JOIN users d ON p.doctor_id = d.user_id
            WHERE p.patient_id = :patient_id
            ORDER BY p.prescribed_at DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':patient_id' => $patientId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // View prescription for a specific appointment
    public function getPrescriptionByAppointment($appointmentId)
    {
        $sql = "
            SELECT 
                p.prescription_id,
                p.notes,
                p.prescribed_at,
                CONCAT(d.first_name, ' ', d.last_name) AS doctor,
                CONCAT(pt.first_name, ' ', pt.last_name) AS patient
            FROM prescriptions p
            JOIN users d ON p.doctor_id = d.user_id
            JOIN users pt ON p.patient_id = pt.user_id
            WHERE p.appointment_id = :appointment_id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':appointment_id' => $appointmentId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
