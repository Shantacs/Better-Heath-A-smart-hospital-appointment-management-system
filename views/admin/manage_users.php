<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];
$pageTitle = "Manage Users";

include '../../controllers/getusersController.php';

$users = getAllUsers();


?>

<link rel="stylesheet" href="../../assets/styles/manage_users.css">

<div class="dashboard-header">
    <h1>Manage Users</h1>
    <p>Manage doctors, patients, and admins</p>
</div>
<div class="dashboard-section">
    <!-- Filters -->
    <div class="filters" style="display:flex; gap:15px; margin-bottom:20px;">
        <select id="roleFilter" class="form-control" style="width:200px;">
            <option value="all">All Users</option>
            <option value="doctor">Doctors</option>
            <option value="patient">Patients</option>
            <option value="admin">Admins</option>
        </select>

        <input type="text" id="userSearch" placeholder="Search by name or email..." class="form-control" style="flex:1;">
    </div>
    

    <!-- Users Table -->
    <div class="table-container">
        <table class="users-table appointments-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="usersTableBody">
                <?php foreach ($users as $u): ?>
                    <tr data-role="<?php echo $u['role']; ?>">
                        <td><?php echo $u['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($u['first_name'] . " " . $u['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td><?php echo htmlspecialchars($u['dob']); ?></td>
                        <td><?php echo htmlspecialchars($u['gender']); ?></td>
                        <td>
                            <select class="role-dropdown form-control" data-user-id="<?php echo $u['user_id']; ?>"
                                <?php echo ($u['user_id'] == $_SESSION['user']['user_id']) ? 'disabled' : ''; ?>>
                                <option value="doctor" <?php echo $u['role'] === 'doctor' ? 'selected' : ''; ?>>Doctor</option>
                                <option value="patient" <?php echo $u['role'] === 'patient' ? 'selected' : ''; ?>>Patient</option>
                                <option value="admin" <?php echo $u['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            </select>
                        </td>
                        <td>
                            <span class="status-badge status-<?php echo $u['is_banned'] ? 'banned' : 'active'; ?>">
                                <?php echo ucfirst($u['is_banned'] ? 'Banned' : 'Active'); ?>
                            </span>
                        </td>
                        <td><?php echo date('M j, Y', strtotime($u['created_at'])); ?></td>
                        <td>
                            <div class="user-actions" style="display:flex; gap:8px;">
                                <?php if ($u['user_id'] != $_SESSION['user']['user_id']): ?>
                                    <button class="btn btn-secondary btn-sm btn-ban"
                                        data-user-id="<?php echo $u['user_id']; ?>"
                                        data-status="<?php echo $u['is_banned'] ? 1 : 0; ?>">
                                        <?php echo $u['is_banned'] ? 'Unban' : 'Ban'; ?>
                                    </button>
                                    
                                    <button class="btn btn-danger btn-sm btn-remove"
                                        data-user-id="<?php echo $u['user_id']; ?>"
                                        data-name="<?php echo htmlspecialchars($u['first_name']); ?>">
                                        Delete
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</div>


<script src="../../assets/scripts/manage_users.js"></script>