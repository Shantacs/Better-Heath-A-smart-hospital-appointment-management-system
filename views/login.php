<?php

session_start();
$errors = $_SESSION['errors'] ?? [];
// $errors['login'] = 'yummy';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Better Health - Login</title>
    <link rel="stylesheet" href="../assets/styles/global.css">
    <link rel="stylesheet" href="../assets/styles/auth.css">
    <link rel="stylesheet" href="../assets/styles/login.css">
</head>

<body>
    <div class="container">
        <div class="image-section">
            <div class="welcome-text">
                <h1>Welcome to Better Health Hospital</h1>
                <p>Dedicated to our patients at Better Health Hospital. Book your appointments, access your
                    prescriptions, and connect with our doctors.</p>
            </div>
            <ul class="features">
                <li>
                    <img src="../assets/icons/calendar.svg" alt="Schedule" class="feature-icon">
                    Schedule appointments 24/7
                </li>
                <li>
                    <img src="../assets/icons/clock.svg" alt="Clock" class="feature-icon">
                    Reduce waiting times
                </li>
                <li>
                    <img src="../assets/icons/doctor.svg" alt="Doctor" class="feature-icon">
                    Connect with top specialists
                </li>
                <li>
                    <img src="../assets/icons/prescription.svg" alt="Prescription" class="feature-icon">
                    Get prescriptions
                </li>
            </ul>

        </div>

        <div class="login-section">
            <div class="logo">
                <h2>Login</h2>
                <p>Better Health Appointment System</p>
            </div>

            <form class="login-form" onsubmit="return validateLogin(event)" action="../controllers/loginController.php" method="POST">
                <div class="input-group">
                    <img src="../assets/icons/user.svg" alt="icon">
                    <input name="email" type="text" placeholder="Email">
                    <span class="error-message" id="email-error"><?php echo $errors['email'] ?? ''; ?></span>
                </div>

                <div class="input-group">
                    <img src="../assets/icons/lock.svg" alt="icon">
                    <input name="password" type="password" placeholder="Password">
                    <span class="error-message" id="password-error"><?php echo $errors['password'] ?? ''; ?></span>
                </div>

                <div class="remember-forgot">
                    <!-- <label>
                        <input type="checkbox"> Remember me
                    </label> -->
                    <a href="./forgot_password.php">Forgot password?</a>
                </div>

                <button type="submit" class="login-button">Login to Your Account</button>
                <span class="error-message" id="login-error"><?php echo $errors['login'] ?? ''; ?></span>
            </form>

            <div class="signup-link">
                Don't have an account? <a href="./register.php">Sign up now</a>
            </div>
        </div>
    </div>

    <script src="../assets/scripts/login.js"></script>
</body>

</html>