<?php
require_once "../../models/Dashboard.php";

$dashboard = new Dashboard();

// Admin
function adminDashboard()
{
    global $dashboard;
    return $dashboard->adminDashboard();
}

// Doctor
function doctorDashboard($doctorId)
{
    global $dashboard;
    return $dashboard->doctorDashboard($doctorId);
}

// Patient
function patientDashboard($patientId)
{
    global $dashboard;
    return $dashboard->patientDashboard($patientId);
}
