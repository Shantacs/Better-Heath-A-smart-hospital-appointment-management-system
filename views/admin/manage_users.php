<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once "../../models/UserModel.php";
$userModel = new UserModel();
$users = $userModel->getUsers();
$message = $_SESSION['accountant_message'] ?? '';
unset($_SESSION['accountant_message']);
$error = $_SESSION['errors']['accountant'] ?? '';
unset($_SESSION['errors']['accountant']);
?>

<div class="dashboard-header">
    <h1>Manage Users</h1>
    <p>Create and manage hospital users, including accountant accounts.</p>
</div>

<?php if ($message): ?>
    <div class="accountant-note"><?php echo htmlspecialchars($message); ?></div><br>
<?php endif; ?>
<?php if ($error): ?>
    <div class="error-message" style="display:block;"><?php echo htmlspecialchars($error); ?></div><br>
<?php endif; ?>

<div class="dashboard-section">
    <h2>Create Accountant Account</h2>
    <form method="POST" action="../../controllers/createAccountantController.php" class="accountant-form">
        <div class="form-grid">
            <div><label>First Name</label><input type="text" name="fname" required></div>
            <div><label>Last Name</label><input type="text" name="lname" required></div>
            <div><label>Email</label><input type="email" name="email" required></div>
            <div><label>Password</label><input type="password" name="password" minlength="8" required></div>
            <div><label>Date of Birth</label><input type="date" name="dob" required></div>
            <div><label>Gender</label>
                <select name="gender" required>
                    <option value="">Select gender</option>
                    <option value="male">Male</option><option value="female">Female</option><option value="other">Other</option>
                </select>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Create Accountant</button>
    </form>
</div>

<div class="dashboard-section">
    <h2>Registered Users</h2>
    <table class="appointments-table">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Date of Birth</th><th>Gender</th><th>Role</th></tr></thead>
        <tbody>
        <?php foreach ($users as $account): ?>
            <tr>
                <td><?php echo (int)$account['user_id']; ?></td>
                <td><?php echo htmlspecialchars($account['first_name'].' '.$account['last_name']); ?></td>
                <td><?php echo htmlspecialchars($account['email']); ?></td>
                <td><?php echo htmlspecialchars($account['dob']); ?></td>
                <td><?php echo ucfirst(htmlspecialchars($account['gender'])); ?></td>
                <td><span class="status-badge status-<?php echo htmlspecialchars($account['role']); ?>"><?php echo ucfirst(htmlspecialchars($account['role'])); ?></span></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
