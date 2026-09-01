<?php

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include_once "../../controllers/dashboardController.php";
$adminStats = adminDashboard();

$stats = $adminStats['stats'];
$recent_appointments = $adminStats['recent_appointments'];


?>

<div class="dashboard-header">
    <h1>Admin Dashboard</h1>
    <p>Welcome back, <?php echo $user['first_name'] . " " . $user['last_name']; ?>! Here's an overview of the hospital appointment system.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/calendar-check.svg" alt="Total Appointments">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['total_appointments']; ?></h3>
            <p>Total Appointments</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/users.svg" alt="Total Patients">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['total_patients']; ?></h3>
            <p>Registered Patients</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/user-md.svg" alt="Total Doctors">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['total_doctors']; ?></h3>
            <p>Medical Doctors</p>
        </div>
    </div>
</div>

<div class="dashboard-section">
    <h2>Appointment Overview</h2>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #e8f5e9;">
                <img src="../../assets/icons/check-circle.svg" alt="Completed Appointments">
            </div>
            <div class="stat-info">
                <h3><?php echo $stats['completed_appointments']; ?></h3>
                <p>Completed Appointments</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #e8f5e9;">
                <img src="../../assets/icons/calendar-blue.svg" alt="Upcoming Appointments">
            </div>
            <div class="stat-info">
                <h3><?php echo $stats['upcoming_appointments']; ?></h3>
                <p>Upcoming Appointments</p>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-section">
    <h2>Quick Actions</h2>
    <div class="action-grid">
        <a href="?page=manage_users" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/user-plus.svg" alt="Add User">
            </div>
            <h3>Manage Users</h3>
            <p>Create new staff or patient accounts</p>
        </a>

        <a href="?page=manage_reports" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/chart-bar.svg" alt="Manage Reports">
            </div>
            <h3>Manage Departments</h3>
            <p>Manage departments and doctors</p>
        </a>
        
        <a href="?page=manage_users" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/search.svg" alt="Search Records">
            </div>
            <h3>Search Records</h3>
            <p>Find patient or appointment records</p>
        </a>
    </div>
</div>

<!-- <div class="dashboard-section">
    <h2>Recent Appointments</h2>
    <table class="appointments-table">
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recent_appointments as $appointment): ?>
            <tr>
                <td><?php echo $appointment['appointment_code']; ?></td>
                <td><?php echo $appointment['patient']; ?></td>
                <td><?php echo $appointment['doctor']; ?></td>
                <td><?php echo $appointment['scheduled_datetime']; ?></td>
                <td>
                    <span class="status-badge status-<?php echo $appointment['status']; ?>">
                        <?php echo ucfirst($appointment['status']); ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div> -->