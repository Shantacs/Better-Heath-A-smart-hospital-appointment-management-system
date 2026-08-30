<?php
require_once "../../models/BillingModel.php";
$summary=(new BillingModel())->getFinancialSummary();
?>
<div class="dashboard-header"><h1>Financial Reports</h1><p>Financial summaries generated directly from the billing database.</p></div>
<div class="report-grid">
<div class="report-card"><h3>Gross Revenue</h3><p>Total invoiced value.</p><strong>৳<?php echo number_format($summary['gross_revenue'],2); ?></strong></div>
<div class="report-card"><h3>Collected</h3><p>Total payments received.</p><strong>৳<?php echo number_format($summary['collected'],2); ?></strong></div>
<div class="report-card"><h3>Outstanding</h3><p>Remaining patient balances.</p><strong>৳<?php echo number_format($summary['outstanding'],2); ?></strong></div>
<div class="report-card"><h3>Collection Rate</h3><p>Collected amount as a percentage of invoiced value.</p><strong><?php echo number_format($summary['collection_rate'],2); ?>%</strong></div>
</div>
<div class="dashboard-section"><div class="accountant-toolbar"><h2>Report Summary</h2><button class="btn btn-primary" onclick="window.print()">Print Report</button></div>
<table class="appointments-table"><tbody>
<tr><th>Gross Revenue</th><td class="money">৳<?php echo number_format($summary['gross_revenue'],2); ?></td></tr>
<tr><th>Collected</th><td class="money">৳<?php echo number_format($summary['collected'],2); ?></td></tr>
<tr><th>Outstanding</th><td class="money">৳<?php echo number_format($summary['outstanding'],2); ?></td></tr>
<tr><th>Collection Rate</th><td><?php echo number_format($summary['collection_rate'],2); ?>%</td></tr>
</tbody></table></div>
