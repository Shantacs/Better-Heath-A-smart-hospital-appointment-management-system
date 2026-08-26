<?php
require_once '../../models/BillingModel.php';
$model = new BillingModel(); $stats=$model->getStats();
$msg=$_SESSION['billing_success']??''; $err=$_SESSION['billing_error']??''; unset($_SESSION['billing_success'],$_SESSION['billing_error']);
?>
<div class="dashboard-header"><h1>Accountant Dashboard</h1><p>Manage patient billing, payments and financial records.</p></div>
<?php if($msg): ?><div class="alert success"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?><?php if($err): ?><div class="alert error"><?php echo htmlspecialchars($err); ?></div><?php endif; ?>
<div class="billing-cards">
<div class="billing-card"><h3>Total Bills</h3><strong><?php echo $stats['bills']; ?></strong></div>
<div class="billing-card"><h3>Patients Billed</h3><strong><?php echo $stats['patients_billed']; ?></strong></div>
<div class="billing-card"><h3>Collected</h3><strong>$<?php echo number_format($stats['collected'],2); ?></strong></div>
<div class="billing-card"><h3>Outstanding</h3><strong>$<?php echo number_format($stats['outstanding'],2); ?></strong></div>
</div>
<div class="feature-grid"><a href="?page=create_bill"><h2>1. Create Patient Bill</h2><p>Add tests, medicines, consultation and other charges.</p></a><a href="?page=payments"><h2>2. Record Payment</h2><p>Record cash, card or bank payments against a bill.</p></a><a href="?page=billing_history"><h2>3. Billing History</h2><p>Search bills, check payment status and view totals.</p></a></div>
