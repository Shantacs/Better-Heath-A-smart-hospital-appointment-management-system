<?php

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'patient') {
    header("Location: ../login.php");
    exit();
}

// Sample data for demonstration with Bangladeshi context
$stats = [
    'upcoming_appointments' => 2,
    'completed_appointments' => 8,
    'active_prescriptions' => 3,
    'doctors_visited' => 4
];

// Upcoming appointments sample data with Bangladeshi doctors
$upcoming_appointments = [
    ['id' => 'A-10256', 'doctor' => 'Dr. Ahmed Rahman', 'specialty' => 'Cardiology', 'date' => '2023-11-18', 'time' => '10:00 AM', 'status' => 'confirmed'],
    ['id' => 'A-10257', 'doctor' => 'Dr. Fatima Jahan', 'specialty' => 'Gynecology', 'date' => '2023-11-20', 'time' => '3:30 PM', 'status' => 'confirmed']
];

// Recent prescriptions sample data
$recent_prescriptions = [
    ['id' => 'RX-0451', 'doctor' => 'Dr. Kamal Hossain', 'date' => '2023-11-10', 'medicines' => 4, 'status' => 'active'],
    ['id' => 'RX-0448', 'doctor' => 'Dr. Salma Akter', 'date' => '2023-10-28', 'medicines' => 3, 'status' => 'completed'],
    ['id' => 'RX-0442', 'doctor' => 'Dr. Abdul Malik', 'date' => '2023-10-15', 'medicines' => 2, 'status' => 'completed']
];

?>

<div class="dashboard-header">
    <h1>Patient Dashboard</h1>
    <p>Welcome back, <?php echo $user['first_name'] . " " . $user['last_name']; ?>! Here's your health overview and upcoming appointments.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/calendar-check.svg" alt="Upcoming Appointments">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['upcoming_appointments']; ?></h3>
            <p>Upcoming Appointments</p>
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
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/prescription-blue.svg" alt="Active Prescriptions">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['active_prescriptions']; ?></h3>
            <p>Prescriptions</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <img src="../../assets/icons/stethoscope.svg" alt="Doctors Visited">
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['doctors_visited']; ?></h3>
            <p>Doctors Visited</p>
        </div>
    </div>
</div>

<div class="dashboard-section">
    <h2>Upcoming Appointments</h2>
    <?php if (count($upcoming_appointments) > 0): ?>
    <table class="appointments-table">
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Doctor</th>
                <th>Specialty</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($upcoming_appointments as $appointment): ?>
            <tr>
                <td><?php echo $appointment['id']; ?></td>
                <td><?php echo $appointment['doctor']; ?></td>
                <td><?php echo $appointment['specialty']; ?></td>
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
    <?php else: ?>
    <p>You don't have any upcoming appointments. <a href="?page=find_doctors">Book an appointment now</a>.</p>
    <?php endif; ?>
</div>

<div class="dashboard-section">
    <h2>Quick Actions</h2>
    <div class="action-grid">
        <a href="?page=find_doctors" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/search.svg" alt="Find Doctors">
            </div>
            <h3>Find Doctors</h3>
            <p>Search and book appointments with specialists</p>
        </a>

        <a href="?page=my_appointments" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/calendar-check.svg" alt="My Appointments">
            </div>
            <h3>My Appointments</h3>
            <p>View and manage your appointments</p>
        </a>
        
        <a href="?page=my_prescriptions" class="action-card">
            <div class="action-icon">
                <img src="../../assets/icons/prescription-blue.svg" alt="My Prescriptions">
            </div>
            <h3>My Prescriptions</h3>
            <p>View your medication history</p>
        </a>
    </div>
</div>

<div class="dashboard-section">
    <h2>Recent Prescriptions</h2>
    <?php if (count($recent_prescriptions) > 0): ?>
    <table class="appointments-table">
        <thead>
            <tr>
                <th>Prescription ID</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Medicines</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recent_prescriptions as $prescription): ?>
            <tr>
                <td><?php echo $prescription['id']; ?></td>
                <td><?php echo $prescription['doctor']; ?></td>
                <td><?php echo $prescription['date']; ?></td>
                <td><?php echo $prescription['medicines']; ?> medicines</td>
                <td>
                    <span class="status-badge status-<?php echo $prescription['status']; ?>">
                        <?php echo ucfirst($prescription['status']); ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>You don't have any prescriptions yet.</p>
    <?php endif; ?>
</div>
