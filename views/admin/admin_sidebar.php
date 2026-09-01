<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Determine current page for active navigation
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'admin_dashboard';
?>

<div class="dashboard-sidebar">
    <div class="sidebar-header">
        <h2>Better Health</h2>
        <p>Welcome, <?php echo $user['first_name'] . " " . $user['last_name']; ?></p>
    </div>
    
    <ul class="sidebar-nav">
        <li>
            <a href="?page=admin_dashboard" class="nav-link <?php echo $currentPage === 'admin_dashboard' ? 'active' : ''; ?>">
                <img src="../../assets/icons/dashboard.svg" alt="Dashboard">
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="?page=manage_users" class="nav-link <?php echo $currentPage === 'manage_users' ? 'active' : ''; ?>">
                <img src="../../assets/icons/users.svg" alt="Manage Users">
                <span>Manage Users</span>
            </a>
        </li>
        <li>
            <a href="?page=manage_doctors" class="nav-link <?php echo $currentPage === 'manage_doctors' ? 'active' : ''; ?>">
                <img src="../../assets/icons/hospital.svg" alt="Manage Doctors">
                <span>Manage Doctors Departments</span>
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