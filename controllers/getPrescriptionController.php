<?php
require_once "../../models/Prescriptions.php";

$prescriptionModel = new PrescriptionModel();

// Get all prescriptions of a patient
function getAllPrescriptions($patientId)
{
    global $prescriptionModel;
    return $prescriptionModel->getPrescriptionsByPatient($patientId);
}

// Get prescription for a specific appointment
function getPrescriptionByAppointment($appointmentId)
{
    global $prescriptionModel;
    return $prescriptionModel->getPrescriptionByAppointment($appointmentId);
}