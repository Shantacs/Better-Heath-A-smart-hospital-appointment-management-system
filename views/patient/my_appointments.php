<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'patient') {
    header("Location: ../login.php");
    exit();
}

include "../../controllers/getPatientAppointment.php";
$user = $_SESSION['user'];
$appointments = getAllAppointments($user['user_id']);
?>

<link rel="stylesheet" href="../../assets/styles/my_appointments.css">

<div class="dashboard-header">
    <h1>My Appointments</h1>
    <p>Welcome back, <?php echo htmlspecialchars($user['first_name'] . " " . $user['last_name']); ?>! Here you can view and manage your appointments.</p>
</div>

<div class="dashboard-section">
    <table class="appointments-table">
        <thead>
            <tr>
                <th>Appointment Code</th>
                <th>Doctor</th>
                <th>Requested Time</th>
                <th>Condition</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($appointments)): ?>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($appointment['appointment_code']); ?></td>
                        <td>Dr. <?php echo htmlspecialchars($appointment['doctor'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($appointment['requested_datetime']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['condition']); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo strtolower($appointment['status']); ?>">
                                <?php echo ucfirst($appointment['status']); ?>
                            </span>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-remove" id="remove-appointment-btn" data-appointment-id="<?php echo $appointment['id']; ?>"
                                <?php echo ($appointment['status'] !== 'pending') ? 'disabled' : ''; ?>>
                                Remove
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">You have no appointments.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="../../assets/scripts/patient_appointments.js"></script>