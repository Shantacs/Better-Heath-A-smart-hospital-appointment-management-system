<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'accountant') {
    header("Location: ../login.php");
    exit();
}
$user=$_SESSION['user'];
$currentPage=$_GET['page'] ?? 'accountant_dashboard';
$pageTitles=[
 'accountant_dashboard'=>'Accountant Dashboard','billing'=>'Billing & Invoices',
 'payments'=>'Payments','financial_reports'=>'Financial Reports','account_settings'=>'Account Settings'
];
$pageTitle=$pageTitles[$currentPage]??'Accountant Dashboard';
$allowed=['accountant_dashboard','billing','payments','financial_reports','account_settings'];
if(!in_array($currentPage,$allowed,true)) $currentPage='accountant_dashboard';
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Better Health - <?php echo htmlspecialchars($pageTitle); ?></title>
<link rel="stylesheet" href="../../assets/styles/dashboard.css">
</head><body>
<div class="dashboard-container">
<?php include 'accountant_sidebar.php'; ?>
<div class="dashboard-content">
<?php
if($currentPage==='account_settings') include '../account_settings.php';
else include $currentPage.'.php';
?>
</div></div></body></html>
