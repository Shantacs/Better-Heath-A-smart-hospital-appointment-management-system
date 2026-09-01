<?php
require_once "../../models/DoctorModel.php";

$doctorModel = new DoctorModel();

function getAllDoctors()
{
    global $doctorModel;
    return $doctorModel->getAllDoctors();
}

