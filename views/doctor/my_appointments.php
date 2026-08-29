<?php

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'doctor') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];

require_once "../../controllers/appointmentController.php";

$appointment_requests = fetchAppointments("pending", $user['user_id']);
$upcoming_appointments = fetchAppointments("confirmed", $user['user_id']);
$completed_appointments = fetchAppointments("completed", $user['user_id']);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/appointments.css">
    <title>Better Health | My Appointments</title>
</head>

<body>
    <div class="dashboard-header">
        <h1>My Appointments</h1>
        <p>Manage your appointments, view requests, and update status</p>
    </div>

    <div class="dashboard-section">
        <div class="tabs">
            <button class="tablink active" onclick="openTab(event, 'requests')">Appointment Requests <span class="badge"><?php echo count($appointment_requests); ?></span></button>
            <button class="tablink" onclick="openTab(event, 'upcoming')">Upcoming Appointments <span class="badge"><?php echo count($upcoming_appointments); ?></span></button>
            <button class="tablink" onclick="openTab(event, 'completed')">Completed Appointments <span class="badge"><?php echo count($completed_appointments); ?></span></button>
        </div>

        <!-- Appointment Requests Tab -->
        <div id="requests" class="tabcontent" style="display: block;">
            <h2>Appointment Requests</h2>
            <p>Review and respond to new appointment requests from patients</p>

            <?php if (count($appointment_requests) > 0): ?>
                <div class="appointments-list">
                    <?php foreach ($appointment_requests as $appointment): ?>
                        <div class="appointment-card">
                            <div class="appointment-info">
                                <h3>Appointment #<?php echo $appointment['id']; ?></h3>
                                <p><strong>Patient:</strong> <?php echo $appointment['patient']; ?></p>
                                <p><strong>Requested Date:</strong> <?php echo $appointment['date']; ?> at <?php echo $appointment['time']; ?></p>
                                <p><strong>Condition:</strong> <?php echo $appointment['condition']; ?></p>
                                <p><strong>Requested:</strong> <?php echo date('M j, Y g:i A', strtotime($appointment['requested_at'])); ?></p>
                            </div>
                            <div class="appointment-actions">
                                <button class="btn btn-success" onclick="approveAppointment('<?php echo $appointment['id']; ?>')">Approve</button>
                                <button class="btn btn-danger" onclick="rejectAppointment('<?php echo $appointment['id']; ?>')">Reject</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <img src="../../assets/icons/calendar-check.svg" alt="No appointments" width="80">
                    <h3>No appointment requests</h3>
                    <p>You don't have any pending appointment requests at the moment.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Upcoming Appointments Tab -->
        <div id="upcoming" class="tabcontent">
            <h2>Upcoming Appointments</h2>
            <p>Your confirmed upcoming appointments</p>

            <?php if (count($upcoming_appointments) > 0): ?>
                <div class="appointments-list">
                    <?php foreach ($upcoming_appointments as $appointment): ?>
                        <div class="appointment-card">
                            <div class="appointment-info">
                                <h3>Appointment #<?php echo $appointment['id']; ?></h3>
                                <p><strong>Patient:</strong> <?php echo $appointment['patient']; ?></p>
                                <p><strong>Scheduled Date:</strong> <?php echo $appointment['date']; ?> at <?php echo $appointment['time']; ?></p>
                                <p><strong>Condition:</strong> <?php echo $appointment['condition']; ?></p>
                                <p><strong>Status:</strong> <span class="status-badge status-<?php echo $appointment['status']; ?>"><?php echo ucfirst($appointment['status']); ?></span></p>
                            </div>
                            <div class="appointment-actions">
                                <button class="btn btn-primary" onclick="markAsCompleted('<?php echo $appointment['id']; ?>')">Mark as Completed</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <img src="../../assets/icons/calendar-blue.svg" alt="No appointments" width="80">
                    <h3>No upcoming appointments</h3>
                    <p>You don't have any upcoming appointments scheduled.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Completed Appointments Tab -->
        <div id="completed" class="tabcontent">
            <h2>Completed Appointments</h2>
            <p>Your past completed appointments</p>

            <?php if (count($completed_appointments) > 0): ?>
                <div class="appointments-list">
                    <?php foreach ($completed_appointments as $appointment): ?>
                        <div class="appointment-card">
                            <div class="appointment-info">
                                <h3>Appointment #<?php echo $appointment['id']; ?></h3>
                                <p><strong>Patient:</strong> <?php echo $appointment['patient']; ?></p>
                                <p><strong>Date:</strong> <?php echo $appointment['date']; ?> at <?php echo $appointment['time']; ?></p>
                                <p><strong>Condition:</strong> <?php echo $appointment['condition']; ?></p>
                                <p><strong>Status:</strong> <span class="status-badge status-<?php echo $appointment['status']; ?>"><?php echo ucfirst($appointment['status']); ?></span></p>
                            </div>
                            <div class="appointment-actions">
                                <!-- <?php if (!$appointment['has_prescription']): ?>
                                    <button class="btn btn-primary" onclick="addPrescription('<?php echo $appointment['id']; ?>', '<?php echo $appointment['patient']; ?>')">Add Prescription</button>
                                <?php else: ?>
                                    <button class="btn btn-secondary" onclick="viewPrescription('<?php echo $appointment['id']; ?>')">View Prescription</button>
                                <?php endif; ?> -->

                                <button class="btn btn-primary" onclick="addPrescription('<?php echo $appointment['id']; ?>', '<?php echo $appointment['patient']; ?>')">Add Prescription</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <img src="../../assets/icons/check-circle.svg" alt="No appointments" width="80">
                    <h3>No completed appointments</h3>
                    <p>You haven't completed any appointments yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="../../assets/scripts/doctor_appointments.js"></script>

</body>

</html>