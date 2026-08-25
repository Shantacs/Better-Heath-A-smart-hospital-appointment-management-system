<?php

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Sample data for demonstration
$stats = [
    'total_appointments' => 1247,
    'total_patients' => 856,
    'total_doctors' => 42,
    'completed_appointments' => 983,
    'upcoming_appointments' => 264,
    'cancelled_appointments' => 42
];

// Recent appointments sample data
$recent_appointments = [
    ['id' => 'A-10245', 'patient' => 'Abdul Rahman', 'doctor' => 'Dr. Ahmed Hussain', 'date' => '2023-11-15', 'time' => '10:30 AM', 'status' => 'completed'],
    ['id' => 'A-10246', 'patient' => 'Fatima Begum', 'doctor' => 'Dr. Salma Khan', 'date' => '2023-11-16', 'time' => '2:15 PM', 'status' => 'upcoming'],
    ['id' => 'A-10247', 'patient' => 'Mohammad Ali', 'doctor' => 'Dr. Jamal Uddin', 'date' => '2023-11-16', 'time' => '9:00 AM', 'status' => 'upcoming'],
    ['id' => 'A-10248', 'patient' => 'Ayesha Akter', 'doctor' => 'Dr. Nusrat Jahan', 'date' => '2023-11-14', 'time' => '4:45 PM', 'status' => 'completed'],
    ['id' => 'A-10249', 'patient' => 'Kamal Hossain', 'doctor' => 'Dr. Rajib Hasan', 'date' => '2023-11-17', 'time' => '11:00 AM', 'status' => 'confirmed'],
    
];
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
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/calendar-times.svg" alt="Cancelled Appointments">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['cancelled_appointments']; ?></h3>
            <p>Cancelled Appointments</p>
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
            <div class="stat-icon" style="background-color: #fff8e1;">
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
            <h3>Add New User</h3>
            <p>Create new staff or patient accounts</p>
        </a>

        <a href="?page=manage_reports" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/chart-bar.svg" alt="Manage Reports">
            </div>
            <h3>Manage Reports</h3>
            <p>Manage feedbacks and reports</p>
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

<div class="dashboard-section">
    <h2>Recent Appointments</h2>
    <table class="appointments-table">
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recent_appointments as $appointment): ?>
            <tr>
                <td><?php echo $appointment['id']; ?></td>
                <td><?php echo $appointment['patient']; ?></td>
                <td><?php echo $appointment['doctor']; ?></td>
                <td><?php echo $appointment['date']; ?></td>
                <td><?php echo $appointment['time']; ?></td>
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