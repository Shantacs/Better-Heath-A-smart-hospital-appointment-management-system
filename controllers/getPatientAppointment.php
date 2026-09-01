<?php
require_once "../../models/AppointmentModel.php";

$appointmentModel = new AppointmentModel();

function getAllAppointments($patientId, $status = null)
{
    global $appointmentModel;
    return $appointmentModel->getAppointmentsByPatient($patientId, $status);
}

