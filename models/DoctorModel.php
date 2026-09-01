<?php
require_once "Database.php";

class DoctorModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Get all users who are doctors
    public function getAllDoctors()
    {
        $sql = "
            SELECT user_id, first_name, last_name, email, department, created_at
            FROM users
            WHERE role = 'doctor'
            ORDER BY first_name, last_name
        ";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update doctor's department
    public function updateDepartment($userId, $department)
    {
        $allowedDepartments = [
            'Unassigned',
            'Cardiology',
            'Neurology',
            'Orthopedics',
            'Pediatrics',
            'Dermatology',
            'General'
        ];

        if (!in_array($department, $allowedDepartments)) {
            return ['success' => false, 'message' => 'Invalid department'];
        }

        $sql = "UPDATE users SET department = :department WHERE user_id = :user_id AND role = 'doctor'";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            ':department' => $department,
            ':user_id'    => $userId
        ]);

        if ($result) {
            return ['success' => true, 'message' => 'Department updated successfully'];
        }

        return ['success' => false, 'message' => 'Failed to update department'];
    }
}
