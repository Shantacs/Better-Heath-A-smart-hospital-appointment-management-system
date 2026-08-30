<?php
require_once "../../models/BillingModel.php";
$model=new BillingModel();
$invoices=$model->getInvoices();
$patients=$model->getPatients();
$message=$_SESSION['billing_message']??''; $success=$_SESSION['billing_success']??false;
unset($_SESSION['billing_message'],$_SESSION['billing_success']);
?>
<div class="dashboard-header"><h1>Billing & Invoices</h1><p>Create invoices and manage patient balances.</p></div>
<?php if($message): ?><div class="<?php echo $success?'accountant-note':'error-message'; ?>" style="display:block;"><?php echo htmlspecialchars($message); ?></div><br><?php endif; ?>
<div class="dashboard-section"><h2>Create Invoice</h2>
<form method="POST" action="../../controllers/billingController.php" class="accountant-form">
<input type="hidden" name="action" value="create_invoice">
<div class="form-grid"><div><label>Patient</label><select name="patient_id" required><option value="">Select patient</option><?php foreach($patients as $p): ?><option value="<?php echo $p['user_id']; ?>"><?php echo htmlspecialchars($p['first_name'].' '.$p['last_name'].' — '.$p['email']); ?></option><?php endforeach; ?></select></div>
<div><label>Service</label><input name="service" required placeholder="Consultation / Diagnostic package"></div>
<div><label>Amount (BDT)</label><input type="number" name="amount" min="0.01" step="0.01" required></div>
<div><label>Due Date</label><input type="date" name="due_date"></div>
<div><label>Appointment ID (optional)</label><input type="number" name="appointment_id" min="1"></div></div>
<button class="btn btn-primary" type="submit">Create Invoice</button></form></div>
<div class="dashboard-section"><div class="accountant-toolbar"><h2>Invoice Register</h2><button class="btn btn-primary" onclick="window.print()">Print Register</button></div>
<table class="appointments-table"><thead><tr><th>Invoice</th><th>Patient</th><th>Service</th><th>Issue Date</th><th>Due Date</th><th>Total</th><th>Balance</th><th>Status</th></tr></thead><tbody>
<?php foreach($invoices as $i): ?><tr><td><?php echo htmlspecialchars($i['invoice_number']); ?></td><td><?php echo htmlspecialchars($i['patient']); ?></td><td><?php echo htmlspecialchars($i['service_description']); ?></td><td><?php echo htmlspecialchars($i['issue_date']); ?></td><td><?php echo htmlspecialchars($i['due_date']??'—'); ?></td><td class="money">৳<?php echo number_format($i['total_amount'],2); ?></td><td class="money">৳<?php echo number_format($i['balance_due'],2); ?></td><td><span class="status-badge status-<?php echo htmlspecialchars($i['status']); ?>"><?php echo ucfirst($i['status']); ?></span></td></tr><?php endforeach; ?>
<?php if(!$invoices): ?><tr><td colspan="8">No invoices found.</td></tr><?php endif; ?></tbody></table></div>
