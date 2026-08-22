<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Better Health - Dashboard</title>
</head>
<body>
    <h1>Welcome to Your Dashboard, <?php echo htmlspecialchars($user['first_name']); ?>!</h1>
    <p>Your email: <?php echo htmlspecialchars($user['email']); ?></p>
    <!-- <a href="logout.php">Logout</a> -->
</body>
</html>