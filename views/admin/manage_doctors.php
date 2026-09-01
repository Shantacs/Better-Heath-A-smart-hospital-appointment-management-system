<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include_once "../../controllers/getDoctorsController.php";
$doctors = getAllDoctors();
?>

<div class="dashboard-section">
    <h2 class="mb-4">Manage Doctors</h2>

    <div class="table-responsive">
        <table class="appointments-table">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Joined</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="doctorsTableBody">
                <?php foreach ($doctors as $doc): ?>
                    <tr>
                        <td><?php echo $doc['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($doc['first_name'] . " " . $doc['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($doc['email']); ?></td>
                        <td>
                            <select class="form-control department-dropdown"
                                data-doctor-id="<?php echo $doc['user_id']; ?>">
                                <option value="Unassigned" <?php echo $doc['department'] === 'Unassigned' ? 'selected' : ''; ?>>Unassigned</option>
                                <option value="Cardiology" <?php echo $doc['department'] === 'Cardiology' ? 'selected' : ''; ?>>Cardiology</option>
                                <option value="Neurology" <?php echo $doc['department'] === 'Neurology' ? 'selected' : ''; ?>>Neurology</option>
                                <option value="Orthopedics" <?php echo $doc['department'] === 'Orthopedics' ? 'selected' : ''; ?>>Orthopedics</option>
                                <option value="Dermatology" <?php echo $doc['department'] === 'Dermatology' ? 'selected' : ''; ?>>Dermatology</option>
                                <option value="Pediatrics" <?php echo $doc['department'] === 'Pediatrics' ? 'selected' : ''; ?>>Pediatrics</option>
                            </select>
                        </td>
                        <td><?php echo date("M j, Y", strtotime($doc['created_at'])); ?></td>
                        <td class="text-center">
                            <button class="btn btn-primary btn-sm update-dept-btn"
                                data-doctor-id="<?php echo $doc['user_id']; ?>">
                                Update
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="../../assets/scripts/manage_doctors.js"></script>
