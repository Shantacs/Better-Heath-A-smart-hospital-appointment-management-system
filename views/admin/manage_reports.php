<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

?>

<div class="container">
    <h1>Manage Reports</h1>
    <p>Welcome to the report management page. Here you can view and generate reports.</p>
</div>