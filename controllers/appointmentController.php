<?php
require_once "../../models/AppointmentModel.php";

$model = new AppointmentModel();

// Fetch appointments by status
function fetchAppointments($status = null, $id = null) {
    global $model;
    return $model->getAppointments($status, $id);
}

// Approve an appointment
function approveAppointmentAction($appointmentId, $scheduledDateTime) {
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

// Reject an appointment
function rejectAppointmentAction($appointmentId) {
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

// Mark appointment as completed
function completeAppointmentAction($appointmentId) {
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

