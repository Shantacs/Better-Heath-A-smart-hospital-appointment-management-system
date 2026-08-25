<?php
session_start();
require_once "../models/UserModel.php";

$userModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $errors = [];
    $data = $_POST;

    // Validate form data
    if (empty($data['email'])) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (empty($data['password'])) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($data['password']) < 8) {
        $errors['password'] = "Password must be at least 8 characters.";
    }

    // Redirect to login form
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../views/login.php");
        exit();
    }

    if (empty($errors)) {
        $result = $userModel->login(
            $data['email'],
            $data['password']
        );

        if ($result["success"]) {
            $_SESSION['errors'] = [];
            $_SESSION['user'] = $result["user"];
            if ($result["user"]['role'] === 'admin') {
                header("Location: ../views/admin/admin_layout.php");
            } else if ($result["user"]['role'] === 'doctor') {
                header("Location: ../views/doctor/doctor_layout.php");
            } else if ($result["user"]['role'] === 'patient') {
                header("Location: ../views/patient/patient_layout.php");
            }
        } else {
            $_SESSION['errors']['login'] = $result["error"];
            header("Location: ../views/login.php");
        }
        exit();
    }
}

?>