<?php if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'accountant') { header('Location: ../login.php'); exit(); } ?>
<div class="dashboard-sidebar"><div class="sidebar-header"><h2>Better Health</h2><p>Welcome, <?php echo htmlspecialchars($user['first_name'].' '.$user['last_name']); ?></p><small>Accountant</small></div>
<ul class="sidebar-nav">
<li><a href="?page=accountant_dashboard" class="nav-link <?php echo $currentPage==='accountant_dashboard'?'active':''; ?>"><img src="../../assets/icons/dashboard.svg"><span>Dashboard</span></a></li>
<li><a href="?page=create_bill" class="nav-link <?php echo $currentPage==='create_bill'?'active':''; ?>"><img src="../../assets/icons/reports.svg"><span>Create Bill</span></a></li>
<li><a href="?page=payments" class="nav-link <?php echo $currentPage==='payments'?'active':''; ?>"><img src="../../assets/icons/check-circle.svg"><span>Record Payments</span></a></li>
<li><a href="?page=billing_history" class="nav-link <?php echo $currentPage==='billing_history'?'active':''; ?>"><img src="../../assets/icons/chart-bar.svg"><span>Billing History</span></a></li>
<li><a href="?page=account_settings" class="nav-link <?php echo $currentPage==='account_settings'?'active':''; ?>"><img src="../../assets/icons/settings.svg"><span>Account Settings</span></a></li>
<li><a href="../logout.php" class="nav-link"><img src="../../assets/icons/logout.svg"><span>Logout</span></a></li>
</ul></div>
