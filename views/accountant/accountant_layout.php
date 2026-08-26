<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'accountant') { header('Location: ../login.php'); exit(); }
$user = $_SESSION['user'];
$pageTitle = 'Accountant Dashboard';
$currentPage = $_GET['page'] ?? 'accountant_dashboard';
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Better Health - <?php echo htmlspecialchars($pageTitle); ?></title><link rel="stylesheet" href="../../assets/styles/dashboard.css"><link rel="stylesheet" href="../../assets/styles/billing.css"></head>
<body><div class="dashboard-container">
<?php include 'accountant_sidebar.php'; ?>
<div class="dashboard-content">
<?php
if ($currentPage === 'account_settings') include '../account_settings.php';
else { $file=$currentPage.'.php'; if (file_exists($file)) include $file; else include 'accountant_dashboard.php'; }
?>
</div></div></body></html>
