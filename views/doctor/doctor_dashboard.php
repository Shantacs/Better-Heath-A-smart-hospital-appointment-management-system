<?php

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'doctor') {
    header("Location: ../login.php");
    exit();
}

// Sample data for demonstration with
$stats = [
    'today_appointments' => 14,
    'total_patients' => 327,
    'pending_prescriptions' => 8,
    'completed_appointments' => 1246
];

// Today's appointments sample data
$todays_appointments = [
    ['id' => 'A-10251', 'patient' => 'Abdul Rahman', 'time' => '9:00 AM', 'status' => 'completed', 'condition' => 'Fever'],
    ['id' => 'A-10252', 'patient' => 'Fatima Begum', 'time' => '10:30 AM', 'status' => 'upcoming', 'condition' => 'Diabetes Checkup'],
    ['id' => 'A-10253', 'patient' => 'Mohammad Ali', 'time' => '11:15 AM', 'status' => 'upcoming', 'condition' => 'Hypertension'],
    ['id' => 'A-10254', 'patient' => 'Ayesha Akter', 'time' => '2:00 PM', 'status' => 'upcoming', 'condition' => 'Pregnancy Checkup'],
    ['id' => 'A-10255', 'patient' => 'Kamal Hossain', 'time' => '3:30 PM', 'status' => 'upcoming', 'condition' => 'Back Pain']
];

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
                <td><?php echo $appointment['id']; ?></td>
                <td><?php echo $appointment['patient']; ?></td>
                <td><?php echo $appointment['time']; ?></td>
                <td><?php echo $appointment['condition']; ?></td>
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
