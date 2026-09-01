<?php
session_start();
require_once "../models/UserModel.php";
require_once "../models/Database.php";

$userModel = new UserModel();

$userId = $_SESSION['user']['user_id'] ?? null;
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && $userId) {
    $newPassword = $_POST['new_password'] ?? '';
    $oldPassword = $_POST['old_password'] ?? '';
    $profilePic  = $_POST['profile_pic'] ?? '';
    $phone       = $_POST['phone'] ?? '';
    $address     = $_POST['address'] ?? '';
    $gender      = $_POST['gender'] ?? '';
    $dob         = $_POST['dob'] ?? '';
    $bio         = $_POST['bio'] ?? '';

    // Handle upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $uploadDir = "../uploads/profile_pics/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileTmp  = $_FILES['profile_pic']['tmp_name'];
        $fileName = time() . "_" . basename($_FILES['profile_pic']['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmp, $filePath)) {
            $profilePic = "uploads/profile_pics/" . $fileName;
        } else {
            $errors['profile_pic'] = "Failed to upload profile picture";
        }
    }

    $result = $userModel->updateAccountSettings(
        $userId,
        $newPassword,
        $oldPassword,
        $profilePic,
        $phone,
        $address,
        $gender,
        $dob,
        $bio
    );

    if ($result['success']) {
        $_SESSION['user'] = $userModel->getUserById($userId);
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['errors'] = ['password' => $result['message']];
    }

    if ($_SESSION['user']['role'] === 'admin') {
        header("Location: ../views/admin/admin_layout.php?page=account_settings");
    } else if ($_SESSION['user']['role'] === 'doctor') {
        header("Location: ../views/doctor/doctor_layout.php?page=account_settings");
    } else if ($_SESSION['user']['role'] === 'patient') {
        header("Location: ../views/patient/patient_layout.php?page=account_settings");
    }
    exit();
}
