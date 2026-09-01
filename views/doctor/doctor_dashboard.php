<?php

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'doctor') {
    header("Location: ../login.php");
    exit();
}

include_once "../../controllers/dashboardController.php";
$doctorStats = doctorDashboard($_SESSION['user']['user_id']);
$todays_appointments = $doctorStats['todays_appointments'];

$stats = $doctorStats['stats'];

?>

<div class="dashboard-header">
    <h1>Doctor Dashboard</h1>
    <p>Welcome back, Dr. <?php echo $user['first_name'] . " " . $user['last_name']; ?>! Here's your schedule and patient overview for today.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/calendar-day.svg" alt="Today's Appointments">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['today_appointments']; ?></h3>
            <p>Today's Appointments</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/users.svg" alt="Total Patients">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['total_patients']; ?></h3>
            <p>Total Patients</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/check-circle.svg" alt="Completed Appointments">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['completed_appointments']; ?></h3>
            <p>Completed Appointments</p>
        </div>
    </div>
</div>

<div class="dashboard-section">
    <h2>Today's Appointments</h2>
    <table class="appointments-table">
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Time</th>
                <th>Condition</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($todays_appointments as $appointment): ?>
            <tr>
                <td><?php echo $appointment['appointment_code']; ?></td>
                <td><?php echo $appointment['patient']; ?></td>
                <td><?php echo $appointment['scheduled_datetime']; ?></td>
                <td><?php echo $appointment['patient_condition']; ?></td>
                <td>
                    <span class="status-badge status-<?php echo $appointment['status']; ?>">
                        <?php echo ucfirst($appointment['status']); ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="dashboard-section">
    <h2>Quick Actions</h2>
    <div class="action-grid">
        <a href="?page=my_appointments" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/calendar-check.svg" alt="View Appointments">
            </div>
            <h3>View All Appointments</h3>
            <p>Check your upcoming and previous appointments</p>
        </a>
        
        <a href="?page=schedule" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/clock-blue.svg" alt="Update Schedule">
            </div>
            <h3>Update Schedule</h3>
            <p>Modify your availability and appointment slots</p>
        </a>
    </div>
</div>
