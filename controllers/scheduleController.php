<?php
session_start();
require_once '../models/ScheduleModel.php';
header('Content-Type: application/json');

$doctor_id = $_SESSION['user']['user_id'];
$scheduleModel = new ScheduleModel($doctor_id);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // schedule data
    $appointmentDuration = $_POST['appointment_duration'] ?? 30;
    $scheduleData = [];
    
    foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day) {
        $scheduleData[$day] = [
            'start_time' => $_POST['start_time'][$day] ?? '',
            'end_time' => $_POST['end_time'][$day] ?? '',
            'available' => isset($_POST['available'][$day])
        ];
    }
    
    // Save schedule and break times
    if ($scheduleModel->saveSchedule($scheduleData, $appointmentDuration)) {
        $successMessage = "Schedule updated successfully!";
    } else {
        $errorMessage = "Failed to update schedule. Please try again.";
    }

    header("Location: ../views/doctor/doctor_layout.php?page=schedule");
    exit();
}

// Get current schedule data
$weekly_schedule = $scheduleModel->getWeeklySchedule();

$response = [
    'weekly_schedule' => $weekly_schedule ?? [],
    'success' => true
];

echo json_encode($response);
?>