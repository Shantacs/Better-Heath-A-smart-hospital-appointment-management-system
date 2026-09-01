<?php
session_start();
require_once "../models/UserModel.php";

$userModel = new UserModel();


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $_SESSION['error'] = $_GET['action'];
    $action = $_GET['action'];
    $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : null;

    switch ($action) {
        case 'delete':
            $result = deleteUser($userId);
            echo json_encode($result);
            break;

        case 'ban_status':
            
            $currentStatus = isset($_GET['current_status']) ? $_GET['current_status'] : '';
            $result = updateBanStatus($userId, $currentStatus);
            echo json_encode($result);
            break;

        case 'update_role':
            $newRole = isset($_GET['new_role']) ? $_GET['new_role'] : '';
            $result = updateRole($userId, $newRole);
            echo json_encode($result);
            break;

        default:
            $result = 'Invalid action.';
            echo json_encode($result);
            break;
    }

    exit();
}


// Remove user action
function deleteUser($userId)
{
    global $userModel;
    if (!$userId) {
        $_SESSION['error'] = 'User ID is required.';
        return;
    }

    $result = $userModel->deleteUser($userId);

        $_SESSION['errorss'] = $result;

    if ($result['success']) {
        $_SESSION['admin_success'] = $result['message'];
    } else {
        $_SESSION['admin_error'] = $result['message'];
    }
    return $result;
}

// Ban/Unban user action
function updateBanStatus($userId, $currentStatus)
{
    global $userModel;
    if (!$userId) {
        $_SESSION['admin_error'] = 'User ID is required.';
        return;
    }

    

    $result = $userModel->updateBanStatus($userId, $currentStatus);
    if ($result['success']) {
        $_SESSION['admin_success'] = $result['message'];
    } else {
        $_SESSION['admin_error'] = $result['message'];
    }
    return $result;
}

// Update user role action
function updateRole($userId, $newRole)
{
    global $userModel;
    if (!$userId) {
        $_SESSION['admin_error'] = 'User ID is required.';
        return;
    }

    $result = $userModel->updateRole($userId, $newRole);
    if ($result['success']) {
        $_SESSION['admin_success'] = $result['message'];
    } else {
        $_SESSION['admin_error'] = $result['message'];
    }
    return $result;
}