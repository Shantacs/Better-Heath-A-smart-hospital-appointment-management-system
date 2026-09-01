<?php
require_once "../../models/AppointmentModel.php";

$appointmentModel = new AppointmentModel();

function getAllAppointments($doctorId, $status = null)
{
    global $appointmentModel;
    return $appointmentModel->getAppointmentsByDoctor($doctorId, $status);
}

