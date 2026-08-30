<?php
require_once "../../models/BillingModel.php";
$model=new BillingModel();
$stats=$model->getDashboardStats();
$transactions=$model->getRecentTransactions();
function taka($n){return '৳'.number_format((float)$n,2);}
?>
<div class="dashboard-header"><h1>Accountant Dashboard</h1>
<p>Welcome back, <?php echo htmlspecialchars($user['first_name'].' '.$user['last_name']); ?>! Manage billing, payments and financial records.</p></div>
<div class="stats-grid">
<div class="stat-card"><div class="stat-icon"><img src="../../assets/icons/chart-bar.svg"></div><div class="stat-info"><h3><?php echo taka($stats['monthly_revenue']); ?></h3><p>This Month's Revenue</p></div></div>
<div class="stat-card"><div class="stat-icon"><img src="../../assets/icons/calendar-check.svg"></div><div class="stat-info"><h3><?php echo $stats['pending_invoices']; ?></h3><p>Pending Invoices</p></div></div>
<div class="stat-card"><div class="stat-icon"><img src="../../assets/icons/check-circle.svg"></div><div class="stat-info"><h3><?php echo $stats['paid_invoices']; ?></h3><p>Paid Invoices</p></div></div>
<div class="stat-card"><div class="stat-icon"><img src="../../assets/icons/clock-blue.svg"></div><div class="stat-info"><h3><?php echo taka($stats['outstanding']); ?></h3><p>Outstanding Amount</p></div></div>
</div>
<div class="dashboard-section"><h2>Quick Actions</h2><div class="action-grid">
<a href="?page=billing" class="action-card"><div class="action-icon"><img src="../../assets/icons/chart-bar.svg"></div><h3>Create Invoice</h3><p>Generate a bill for a patient.</p></a>
<a href="?page=payments" class="action-card"><div class="action-icon"><img src="../../assets/icons/check-circle.svg"></div><h3>Record Payment</h3><p>Record cash, card, bank or mobile payments.</p></a>
<a href="?page=financial_reports" class="action-card"><div class="action-icon"><img src="../../assets/icons/reports.svg"></div><h3>Financial Reports</h3><p>Review revenue and outstanding balances.</p></a>
</div></div>
<div class="dashboard-section"><div class="accountant-toolbar"><h2>Recent Transactions</h2><a class="btn btn-primary" href="?page=payments">View Payments</a></div>
<table class="appointments-table"><thead><tr><th>Invoice</th><th>Patient</th><th>Date</th><th>Amount</th><th>Method</th><th>Status</th></tr></thead><tbody>
<?php foreach($transactions as $t): ?><tr><td><?php echo htmlspecialchars($t['invoice_number']); ?></td><td><?php echo htmlspecialchars($t['patient']); ?></td><td><?php echo htmlspecialchars($t['issue_date']); ?></td><td class="money"><?php echo taka($t['total_amount']); ?></td><td><?php echo htmlspecialchars($t['method']); ?></td><td><span class="status-badge status-<?php echo htmlspecialchars($t['status']); ?>"><?php echo ucfirst($t['status']); ?></span></td></tr><?php endforeach; ?>
<?php if(!$transactions): ?><tr><td colspan="6">No transactions yet.</td></tr><?php endif; ?></tbody></table></div>
