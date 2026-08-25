<?php

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'patient') {
    header("Location: ../login.php");
    exit();
}

// Determine current page for active navigation
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'patient_dashboard';
?>

<div class="dashboard-sidebar">
    <div class="sidebar-header">
        <h2>Better Health</h2>
        <p>Welcome, <?php echo $user['first_name'] . " " . $user['last_name']; ?></p>
    </div>
    
    <ul class="sidebar-nav">
        <li>
            <a href="?page=patient_dashboard" class="nav-link <?php echo $currentPage === 'patient_dashboard' ? 'active' : ''; ?>">
                <img src="../../assets/icons/dashboard.svg" alt="Dashboard">
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="?page=find_doctors" class="nav-link <?php echo $currentPage === 'find_doctors' ? 'active' : ''; ?>">
                <img src="../../assets/icons/user-md.svg" alt="Find Doctors">
                <span>Find Doctors</span>
            </a>
        </li>
        <li>
            <a href="?page=my_appointments" class="nav-link <?php echo $currentPage === 'my_appointments' ? 'active' : ''; ?>">
                <img src="../../assets/icons/calendar-check.svg" alt="My Appointments">
                <span>My Appointments</span>
            </a>
        </li>
        <li>
            <a href="?page=my_prescriptions" class="nav-link <?php echo $currentPage === 'my_prescriptions' ? 'active' : ''; ?>">
                <img src="../../assets/icons/prescription-blue.svg" alt="My Prescriptions">
                <span>My Prescriptions</span>
            </a>
        </li>
        <li>
            <a href="?page=account_settings" class="nav-link <?php echo $currentPage === 'account_settings' ? 'active' : ''; ?>">
                <img src="../../assets/icons/settings.svg" alt="Account Settings">
                <span>Account Settings</span>
            </a>
        </li>
        <li>
            <a href="../logout.php" class="nav-link">
                <img src="../../assets/icons/logout.svg" alt="Logout">
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>