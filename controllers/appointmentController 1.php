<?php
session_start();
require_once "../models/AppointmentModel.php";

$model = new AppointmentModel();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? null;

    switch ($action) {
        case 'request':
            $patientId = $_SESSION['user']['user_id'] ?? null;
            $doctorId = $_GET['doctor_id'] ?? null;
            $condition = $_GET['condition'] ?? '';
            $requestedDateTime = $_GET['requested_datetime'] ?? null;
            $result = requestAppointmentAction($patientId, $doctorId, $condition, $requestedDateTime);
            echo json_encode($result);
            if ($result['success']) header("Location: ../views/patient/patient_layout.php?page=my_appointments");
            else {
                header("Location: ../views/patient/patient_layout.php?page=view_schedule&doctor_id=" . ($doctorId ?? ''));
                $_SESSION['error_message'] = $result['message'];
            }
            break;

        case 'remove':
            $appointmentId = $_GET['appointment_id'] ?? null;
            $result = removeAppointmentAction($appointmentId);
            echo json_encode($result);
            break;

        case 'approve':
            $appointmentId = $_GET['appointment_id'] ?? null;
            $scheduledDateTime = $_GET['scheduled_datetime'] ?? null;
            $result = approveAppointmentAction($appointmentId, $scheduledDateTime);
            echo json_encode($result);
            break;

        case 'reject':
            $appointmentId = $_GET['appointment_id'] ?? null;
            $result = rejectAppointmentAction($appointmentId);
            echo json_encode($result);
            break;

        case 'complete':
            $appointmentId = $_GET['appointment_id'] ?? null;
            $result = completeAppointmentAction($appointmentId);
            echo json_encode($result);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }


    exit();
}

// Request a new appointment
function requestAppointmentAction($patientId, $doctorId, $condition, $requestedDateTime)
{
    global $model;
    if (!$patientId || !$doctorId || !$requestedDateTime) {
        return ["success" => false, "message" => "Missing parameters."];
    }
    return $model->requestAppointment($patientId, $doctorId, $condition, $requestedDateTime);
}

// Remove an appointment
function removeAppointmentAction($appointmentId)
{
    global $model;
    if (!$appointmentId) {
        return ["success" => false, "message" => "Missing appointment ID."];
    }
    $success = $model->deleteAppointment($appointmentId);
    return [
        "success" => $success,
        "message" => $success ? "Appointment removed." : "Failed to remove."
    ];
}

// Approve appointment
function approveAppointmentAction($appointmentId, $scheduledDateTime)
{
    global $model;
    if (!$appointmentId || !$scheduledDateTime) {
        return ["success" => false, "message" => "Missing parameters."];
    }
    $success = $model->approveAppointment($appointmentId, $scheduledDateTime);
    return [
        "success" => $success,
        "message" => $success ? "Appointment approved." : "Failed to approve."
    ];
}

// Reject appointment
function rejectAppointmentAction($appointmentId)
{
    global $model;
    if (!$appointmentId) {
        return ["success" => false, "message" => "Missing appointment ID."];
    }
    $success = $model->rejectAppointment($appointmentId);
    return [
        "success" => $success,
        "message" => $success ? "Appointment rejected." : "Failed to reject."
    ];
}

// Complete appointment
function completeAppointmentAction($appointmentId)
{
    global $model;
    if (!$appointmentId) {
        return ["success" => false, "message" => "Missing appointment ID."];
    }
    $success = $model->completeAppointment($appointmentId);
    return [
        "success" => $success,
        "message" => $success ? "Appointment completed." : "Failed to mark complete."
    ];
}


// // Fetch appointments by status
// function fetchAppointments($status = null, $id = null) {
//     global $model;
//     return $model->getAppointments($status, $id);
// }