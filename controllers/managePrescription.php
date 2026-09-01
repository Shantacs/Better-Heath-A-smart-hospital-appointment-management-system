<?php
session_start();
require_once "../models/Prescriptions.php";

$prescriptionModel = new PrescriptionModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    switch ($action) {
        case 'add_prescription':
            $appointmentId = isset($_POST['appointment_id']) ? (int)$_POST['appointment_id'] : null;
            $doctorId      = $_POST['doctor_id'] ?? null; 
            $notes         = $_POST['notes'] ?? '';

            if (!$appointmentId || !$doctorId) {
                echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
                exit();
            }

            $result = $prescriptionModel->addPrescription($appointmentId, $doctorId, $notes);
            echo json_encode($result);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
    header("Location: ../views/doctor/doctor_layout.php?page=my_appointments");
    exit();
}
