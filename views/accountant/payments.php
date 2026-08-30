<?php
require_once "../../models/BillingModel.php";
$model=new BillingModel();
$payments=$model->getPayments(); $invoices=$model->getPayableInvoices();
$message=$_SESSION['billing_message']??''; $success=$_SESSION['billing_success']??false;
unset($_SESSION['billing_message'],$_SESSION['billing_success']);
?>
<div class="dashboard-header"><h1>Payments</h1><p>Record and review received patient payments.</p></div>
<?php if($message): ?><div class="<?php echo $success?'accountant-note':'error-message'; ?>" style="display:block;"><?php echo htmlspecialchars($message); ?></div><br><?php endif; ?>
<div class="dashboard-section"><h2>Record Payment</h2>
<form method="POST" action="../../controllers/billingController.php" class="accountant-form">
<input type="hidden" name="action" value="record_payment">
<div class="form-grid"><div><label>Invoice</label><select name="invoice_id" required><option value="">Select invoice</option><?php foreach($invoices as $i): ?><option value="<?php echo $i['invoice_id']; ?>"><?php echo htmlspecialchars($i['invoice_number'].' — Balance ৳'.number_format($i['balance_due'],2)); ?></option><?php endforeach; ?></select></div>
<div><label>Amount (BDT)</label><input type="number" name="amount" min="0.01" step="0.01" required></div>
<div><label>Method</label><select name="method" required><option value="">Select method</option><option>Cash</option><option>Card</option><option>Bank Transfer</option><option>Mobile Banking</option></select></div>
<div><label>Reference Number</label><input name="reference" placeholder="Optional"></div></div>
<button class="btn btn-primary" type="submit">Record Payment</button></form></div>
<div class="dashboard-section"><div class="accountant-toolbar"><h2>Payment History</h2><button class="btn btn-primary" onclick="window.print()">Print Receipts</button></div>
<table class="appointments-table"><thead><tr><th>Receipt</th><th>Invoice</th><th>Patient</th><th>Date</th><th>Method</th><th>Amount</th><th>Reference</th></tr></thead><tbody>
<?php foreach($payments as $p): ?><tr><td><?php echo htmlspecialchars($p['receipt_number']); ?></td><td><?php echo htmlspecialchars($p['invoice_number']); ?></td><td><?php echo htmlspecialchars($p['patient']); ?></td><td><?php echo htmlspecialchars($p['payment_date']); ?></td><td><?php echo htmlspecialchars($p['method']); ?></td><td class="money">৳<?php echo number_format($p['amount'],2); ?></td><td><?php echo htmlspecialchars($p['reference_number']??'—'); ?></td></tr><?php endforeach; ?>
<?php if(!$payments): ?><tr><td colspan="7">No payments recorded yet.</td></tr><?php endif; ?></tbody></table></div>
