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
        try {
            $sql = "DELETE FROM users WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($sql);
            $success = $stmt->execute([':user_id' => $userId]);

            if ($success) {
                return ['success' => true, 'message' => 'User deleted successfully.'];
            } else {
                return ['success' => false, 'message' => 'Failed to delete user.'];
            }
        } catch (PDOException $e) {
            error_log("Database error while deleting user: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
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

        unset($user['password']);

        // success
        return [
            "success" => true,
            "user" => $user
        ];
    }

    // Get all users
    public function getAllUsers()
    {
        $sql = "SELECT user_id, first_name, last_name, email, dob, gender, role, is_banned, created_at 
                FROM users 
                ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update ban/unban status
    public function updateBanStatus($userId, $isBanned)
    {
        $newstatus = $isBanned ? 0 : 1;
        $sql = "UPDATE users SET is_banned = :newstatus WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':newstatus' => $newstatus,
            ':user_id' => $userId
        ]);
    }

    // update account settings
    public function updateAccountSettings($userId, $newPassword, $oldPassword, $profilePic, $phone, $address, $gender, $dob, $bio)
    {
        if (!empty($newPassword)) {
            $checkSql = "SELECT password FROM users WHERE user_id = :user_id";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $checkStmt->execute();
            $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if (!$result || !password_verify($oldPassword, $result['password'])) {
                return ['success' => false, 'message' => 'Password mismatch'];
            }
        }

        // Build update fields
        $fields = [
            "phone = :phone",
            "address = :address",
            "gender = :gender",
            "dob = :dob",
            "bio = :bio"
        ];

        if (!empty($profilePic)) {
            $fields[] = "profile_pic = :profile_pic";
        }

        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $fields[] = "password = :password";
        }

        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
        $stmt->bindParam(':bio', $bio, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if (!empty($profilePic)) {
            $stmt->bindParam(':profile_pic', $profilePic, PDO::PARAM_STR);
        }

        if (!empty($newPassword)) {
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        }

        $success = $stmt->execute();

        return $success
            ? ['success' => true, 'message' => 'Account updated successfully!']
            : ['success' => false, 'message' => 'Failed to update account settings.'];
    }
}
