<?php
session_start();
require_once "../models/DoctorModel.php";

$doctorModel = new DoctorModel();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? null;
    $doctorId = isset($_GET['doctor_id']) ? (int)$_GET['doctor_id'] : null;
    $department = $_GET['department'] ?? '';

    switch ($action) {
        case 'update_department':
            $result = updateDepartment($doctorId, $department);
            echo json_encode($result);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }

    exit();
}

// Update doctor department 
function updateDepartment($doctorId, $department)
{
    global $doctorModel;

    if (!$doctorId) {
        $_SESSION['admin_error'] = 'Doctor ID is required.';
        return ['success' => false, 'message' => 'Doctor ID is required'];
    }

    $result = $doctorModel->updateDepartment($doctorId, $department);

    if ($result['success']) {
        $_SESSION['admin_success'] = $result['message'];
    } else {
        $_SESSION['admin_error'] = $result['message'];
    }

    return $result;
}
