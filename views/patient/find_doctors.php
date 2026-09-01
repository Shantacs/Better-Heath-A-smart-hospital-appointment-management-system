<?php

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'patient') {
    header("Location: ../login.php");
    exit();
}

include_once "../../controllers/getDoctorsController.php";
$doctors = getAllDoctors();

$user = $_SESSION['user'];
?>

<div class="dashboard-header">
    <h1>Find Doctors</h1>
    <p>Browse available doctors and book your appointments.</p>
</div>

<div class="dashboard-section">
    <!-- Filters -->
    <div class="filters" style="display:flex; gap:15px; margin-bottom:20px;">
        <select id="departmentFilter" class="form-control" style="width:200px;">
            <option value="all">All Departments</option>
            <option value="Cardiology">Cardiology</option>
            <option value="Neurology">Neurology</option>
            <option value="Orthopedics">Orthopedics</option>
            <option value="Pediatrics">Pediatrics</option>
            <option value="Dermatology">Dermatology</option>
            <option value="Unassigned">Unassigned</option>
        </select>

        <input type="text" id="doctorSearch" placeholder="Search by name or email..." class="form-control" style="flex:1;">
    </div>

    <?php if (count($doctors) > 0): ?>
        <div class="action-grid">
            <?php foreach ($doctors as $doctor): ?>
                <div class="action-card">
                    <div class="action-icon">
                        <img src="../../assets/imgs/pfp-placeholder.webp" alt="Doctor">
                    </div>
                    <h3>Dr. <?php echo htmlspecialchars($doctor['first_name'] . " " . $doctor['last_name']); ?></h3>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($doctor['email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($doctor['phone'] ?? "N/A"); ?></p>
                    <p><strong>Department:</strong>
                        <?php echo !empty($doctor['department']) ? htmlspecialchars($doctor['department']) : "Unassigned"; ?>
                    </p>
                    <form action="" method="get">
                        <input type="hidden" name="page" value="view_schedule">
                        <input type="hidden" name="doctor_id" value="<?php echo $doctor['user_id']; ?>">
                        <button type="submit" class="btn btn-primary" style="margin-top: 16px;">View Available Schedule</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No doctors available at the moment.</p>
    <?php endif; ?>
</div>

<script src="../../assets/scripts/find_doctors.js"></script>