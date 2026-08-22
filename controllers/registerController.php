<?php

session_start();
require_once "../models/UserModel.php";

$userModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    $errors = [];
    $data = $_POST;

    // Validate form data
    if (empty($data['fname'])) {
        $errors['fname'] = "First name is required.";
    }

    if (empty($data['lname'])) {
        $errors['lname'] = "Last name is required.";
    }

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

    if (empty($data['confirmPassword'])) {
        $errors['confirmPassword'] = "Confirm password is required.";
    } elseif ($data['password'] !== $data['confirmPassword']) {
        $errors['confirmPassword'] = "Passwords do not match.";
    }

    if (empty($data['dob'])) {
        $errors['dob'] = "Date of birth is required.";
    }

    if (empty($data['gender'])) {
        $errors['gender'] = "Gender is required.";
    }

    // Redirect to registration form
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../views/register.php");
        exit();
    }

    if (empty($errors)) {
        $result = $userModel->createUser(
            $data['fname'],
            $data['lname'],
            $data['email'],
            $data['password'],
            $data['dob'],
            $data['gender'],
            'patient'
        );        

        if ($result["success"]) {
            $_SESSION['errors'] = [];
            header("Location: ../views/login.php");
        } else {
            $_SESSION['errors']['registration'] = $result['message'];
            header("Location: ../views/register.php");
        }
        exit();
    }
}


?>