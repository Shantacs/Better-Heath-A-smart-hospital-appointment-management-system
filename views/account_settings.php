<?php
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

?>

<div class="container">
    <h1>Manage Users</h1>
    <p>Welcome to the user management page. Here you can add, edit, or remove users.</p>
</div>