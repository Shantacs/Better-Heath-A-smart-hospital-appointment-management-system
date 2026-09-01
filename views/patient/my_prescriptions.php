<?php

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'patient') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];
// $prescriptionModel = new PrescriptionModel();
require_once "../../controllers/getPrescriptionController.php";

// Fetch prescriptions for this patient
$prescriptions = getAllPrescriptions($user['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Prescriptions</title>
    <link rel="stylesheet" href="../../assets/styles/prescription.css">
</head>
<body>
    <div class="container">
        <h1>My Prescriptions</h1>
        <p>Hello, <?php echo $user['first_name'] . " " . $user['last_name']; ?>! Here are your prescriptions:</p>

        <?php if (!empty($prescriptions)): ?>
            <table class="prescriptions-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Doctor</th>
                        <th>Appointment ID</th>
                        <th>Date</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prescriptions as $index => $prescription): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td>Dr. <?php echo $prescription['doctor']; ?></td>
                            <td><?php echo $prescription['appointment_id']; ?></td>
                            <td><?php echo date("d M Y", strtotime($prescription['prescribed_at'])); ?></td>
                            <td><?php echo $prescription['notes']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty">You have no prescriptions yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
