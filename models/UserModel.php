<?php
require_once "Database.php";

class UserModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function createUser($firstName, $lastName, $email, $password, $dob, $gender, $role)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (first_name, last_name, email, password, dob, gender, role) 
            VALUES (:first_name, :last_name, :email, :password, :dob, :gender, :role)";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':first_name' => $firstName,
                ':last_name' => $lastName,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':dob' => $dob,
                ':gender' => $gender,
                ':role' => $role
            ]);

            return [
                'success' => true,
                'message' => "User created successfully!"
            ];
        } catch (PDOException $e) {
            // MySQL code 1062 = duplicate entry
            if ($e->errorInfo[1] == 1062) {
                return [
                    'success' => false,
                    'message' => "Email already exists!"
                ];
            }

            return [
                'success' => false,
                'message' => "Database error: " . $e->getMessage()
            ];
        }
    }


    // Get user by ID
    public function getUserById($userId)
    {
        $sql = "SELECT * FROM users WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get user by Email
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user info
    public function updateUser($userId, $firstName, $lastName, $dob, $gender, $role)
    {
        $sql = "UPDATE users 
                SET first_name = :first_name, last_name = :last_name, dob = :dob, 
                    gender = :gender, role = :role 
                WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':dob' => $dob,
            ':gender' => $gender,
            ':role' => $role,
            ':user_id' => $userId
        ]);
    }

    // Update password
    public function updatePassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET password = :password WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':password' => $hashedPassword,
            ':user_id' => $userId
        ]);
    }

    // Update role of a user
    public function updateRole($userId, $newRole)
    {
        try {
            $sql = "UPDATE users SET role = :role WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($sql);

            // bind parameters
            $stmt->bindParam(":role", $newRole);
            $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);

            return $stmt->execute(); // true if success
        } catch (PDOException $e) {
            echo "Error updating role: " . $e->getMessage();
            return false;
        }
    }

    // Delete user
    public function deleteUser($userId)
    {
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':user_id' => $userId]);
    }

    // Login user
    public function login($email, $password)
    {
        $user = $this->getUserByEmail($email);

        if (!$user) {
            // email not found
            return [
                "success" => false,
                "error" => "Email does not exist."
            ];
        }

        if (!password_verify($password, $user['password'])) {
            // password mismatch
            return [
                "success" => false,
                "error" => "Invalid credentials."
            ];
        }

        // success
        return [
            "success" => true,
            "user" => $user
        ];
    }
}
