<?php
require_once __DIR__ . '/Database.php';

class Dashboard
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function adminDashboard()
    {
        try {
            // Total appointments
            $stmt = $this->conn->query("SELECT COUNT(*) FROM appointments");
            $totalAppointments = $stmt->fetchColumn();

            // Total patients
            $stmt = $this->conn->query("SELECT COUNT(*) FROM users WHERE role = 'patient'");
            $totalPatients = $stmt->fetchColumn();

            // Total doctors
            $stmt = $this->conn->query("SELECT COUNT(*) FROM users WHERE role = 'doctor'");
            $totalDoctors = $stmt->fetchColumn();

            // Completed appointments
            $stmt = $this->conn->query("SELECT COUNT(*) FROM appointments WHERE status = 'completed'");
            $completedAppointments = $stmt->fetchColumn();

            // Upcoming appointments
            $stmt = $this->conn->query("SELECT COUNT(*) FROM appointments WHERE scheduled_datetime > NOW()");
            $upcomingAppointments = $stmt->fetchColumn();

            // Recent 5 appointments
            $stmt = $this->conn->query("
                SELECT a.appointment_code, 
                       CONCAT(p.first_name, ' ', p.last_name) AS patient, 
                       CONCAT(d.first_name, ' ', d.last_name) AS doctor, 
                       a.scheduled_datetime, 
                       a.status
                FROM appointments a
                LEFT JOIN users p ON a.patient_id = p.user_id
                LEFT JOIN users d ON a.doctor_id = d.user_id
                ORDER BY a.created_at DESC
                LIMIT 5
            ");
            $recentAppointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'stats' => [
                    'total_appointments'     => (int)$totalAppointments,
                    'total_patients'         => (int)$totalPatients,
                    'total_doctors'          => (int)$totalDoctors,
                    'completed_appointments' => (int)$completedAppointments,
                    'upcoming_appointments'  => (int)$upcomingAppointments,
                ],
                'recent_appointments' => $recentAppointments
            ];
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function doctorDashboard($doctorId)
    {
        try {
            // Today's appointments count
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) 
                FROM appointments 
                WHERE doctor_id = :doctor_id 
                  AND DATE(scheduled_datetime) = CURDATE()
            ");
            $stmt->execute(['doctor_id' => $doctorId]);
            $todayAppointments = $stmt->fetchColumn();

            // Total unique patients
            $stmt = $this->conn->prepare("
                SELECT COUNT(DISTINCT patient_id) 
                FROM appointments 
                WHERE doctor_id = :doctor_id
            ");
            $stmt->execute(['doctor_id' => $doctorId]);
            $totalPatients = $stmt->fetchColumn();

            // Completed appointments
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) 
                FROM appointments 
                WHERE doctor_id = :doctor_id AND status = 'completed'
            ");
            $stmt->execute(['doctor_id' => $doctorId]);
            $completedAppointments = $stmt->fetchColumn();

            // Today's appointments list
            $stmt = $this->conn->prepare("
                SELECT a.appointment_code, 
                       CONCAT(p.first_name, ' ', p.last_name) AS patient,
                       a.scheduled_datetime, 
                       a.status, 
                       a.patient_condition
                FROM appointments a
                INNER JOIN users p ON a.patient_id = p.user_id
                WHERE a.doctor_id = :doctor_id 
                  AND DATE(a.scheduled_datetime) = CURDATE()
                ORDER BY a.scheduled_datetime ASC
            ");
            $stmt->execute(['doctor_id' => $doctorId]);
            $todaysAppointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'stats' => [
                    'today_appointments'     => (int)$todayAppointments,
                    'total_patients'         => (int)$totalPatients,
                    'completed_appointments' => (int)$completedAppointments
                ],
                'todays_appointments' => $todaysAppointments
            ];
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function patientDashboard($patientId)
    {
        try {
            // Upcoming count
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) 
                FROM appointments 
                WHERE patient_id = :patient_id AND requested_datetime > NOW()
            ");
            $stmt->execute(['patient_id' => $patientId]);
            $upcomingAppointments = $stmt->fetchColumn();

            // Completed count
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) 
                FROM appointments 
                WHERE patient_id = :patient_id AND status = 'completed'
            ");
            $stmt->execute(['patient_id' => $patientId]);
            $completedAppointments = $stmt->fetchColumn();

            // Active prescriptions
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) 
                FROM prescriptions 
                WHERE patient_id = :patient_id
            ");
            $stmt->execute(['patient_id' => $patientId]);
            $activePrescriptions = $stmt->fetchColumn();

            // Distinct doctors visited
            $stmt = $this->conn->prepare("
                SELECT COUNT(DISTINCT doctor_id) 
                FROM appointments 
                WHERE patient_id = :patient_id AND doctor_id IS NOT NULL
            ");
            $stmt->execute(['patient_id' => $patientId]);
            $doctorsVisited = $stmt->fetchColumn();

            // Upcoming appointment list
            $stmt = $this->conn->prepare("
                SELECT a.appointment_code, 
                       CONCAT(d.first_name, ' ', d.last_name) AS doctor,
                       d.department AS specialty,
                       a.requested_datetime, 
                       a.status
                FROM appointments a
                INNER JOIN users d ON a.doctor_id = d.user_id
                WHERE a.patient_id = :patient_id AND a.requested_datetime > NOW()
                ORDER BY a.requested_datetime ASC
                LIMIT 5
            ");
            $stmt->execute(['patient_id' => $patientId]);
            $upcomingList = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'stats' => [
                    'upcoming_appointments'  => (int)$upcomingAppointments,
                    'completed_appointments' => (int)$completedAppointments,
                    'active_prescriptions'   => (int)$activePrescriptions,
                    'doctors_visited'        => (int)$doctorsVisited
                ],
                'upcoming_appointments_list' => $upcomingList
            ];
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
