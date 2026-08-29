<?php
require_once 'Database.php';

class ScheduleModel {
    private $db;
    private $doctor_id;

    public function __construct($doctor_id) {
        $this->db = Database::getInstance()->getConnection();
        $this->doctor_id = $doctor_id;
    }

    // Get doctor's weekly schedule
    public function getWeeklySchedule() {
        try {
            $query = "SELECT * FROM doctor_schedule WHERE doctor_id = :doctor_id ORDER BY FIELD(day_of_week, 
                     'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday')";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':doctor_id', $this->doctor_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $schedule = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $schedule[$row['day_of_week']] = [
                    'start' => $row['start_time'],
                    'end' => $row['end_time'],
                    'available' => (bool)$row['is_available']
                ];
            }
            
            return $schedule;
        } catch (PDOException $e) {
            error_log("Error getting weekly schedule: " . $e->getMessage());
            return [];
        }
    }

    // Save/update weekly schedule
    public function saveSchedule($scheduleData, $appointmentDuration) {
        try {
            $this->db->beginTransaction();

            // Update each day's schedule
            foreach ($scheduleData as $day => $data) {
                $query = "INSERT INTO doctor_schedule (doctor_id, day_of_week, start_time, end_time, is_available, appointment_duration, updated_at)
                         VALUES (:doctor_id, :day, :start_time, :end_time, :available, :duration, NOW())
                         ON DUPLICATE KEY UPDATE 
                         start_time = VALUES(start_time), 
                         end_time = VALUES(end_time), 
                         is_available = VALUES(is_available),
                         appointment_duration = VALUES(appointment_duration),
                         updated_at = NOW()";
                
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':doctor_id', $this->doctor_id, PDO::PARAM_INT);
                $stmt->bindParam(':day', $day, PDO::PARAM_STR);
                $stmt->bindParam(':start_time', $data['start_time'], PDO::PARAM_STR);
                $stmt->bindParam(':end_time', $data['end_time'], PDO::PARAM_STR);
                $stmt->bindParam(':available', $data['available'], PDO::PARAM_BOOL);
                $stmt->bindValue(':duration', 30, PDO::PARAM_INT);
                $stmt->execute();
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error saving schedule: " . $e->getMessage());
            return false;
        }
    }

    // Check if doctor has any schedule set
    public function hasSchedule() {
        try {
            $query = "SELECT COUNT(*) as count FROM doctor_schedule 
                     WHERE doctor_id = :doctor_id AND is_available = TRUE";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':doctor_id', $this->doctor_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Error checking schedule: " . $e->getMessage());
            return false;
        }
    }
}
?>