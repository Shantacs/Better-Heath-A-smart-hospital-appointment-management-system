<?php

session_start();
$errors = $_SESSION['errors'] ?? [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/global.css">
    <link rel="stylesheet" href="../assets/styles/auth.css">
    <link rel="stylesheet" href="../assets/styles/register.css">
    <title>Better Health - Registration</title>
</head>

<body>
    <div class="container">
        <div class="image-section">
            <div class="welcome-text">
                <h1>Join Better Health</h1>
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

        <div class="form-section">
            <div class="logo">
                <h2>Registration</h2>
                <p>Better Health Appointment System</p>
            </div>

            <form class="registration-form" onsubmit="return validateRegistration(event)" action="../controllers/registerController.php" method="POST">
                <div class="form-row">
                    <div class="input-group">
                        <img src="../assets/icons/user.svg" alt="icon">
                        <input name="fname" type="text" id="firstName" placeholder="Enter your first name">
                        <span class="error-message" id="fname-error"><?php echo $errors['fname'] ?? ''; ?></span>
                    </div>

                    <div class="input-group">
                        <img src="../assets/icons/user.svg" alt="icon">
                        <input name="lname" type="text" id="lastName" placeholder="Enter your last name">
                        <span class="error-message" id="lname-error"><?php echo $errors['lname'] ?? ''; ?></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <img src="../assets/icons/mail-blue.svg" alt="icon">
                        <input name="email" type="email" id="email" placeholder="Enter your email address">
                        <span class="error-message" id="email-error"><?php echo $errors['email'] ?? ''; ?></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <img src="../assets/icons/lock.svg" alt="icon">
                        <input name="password" type="password" id="password" placeholder="Create a password">
                        <span class="error-message" id="password-error"><?php echo $errors['password'] ?? ''; ?></span>
                    </div>

                    <div class="input-group">
                        <img src="../assets/icons/lock.svg" alt="icon">
                        <input name="confirmPassword" type="password" id="confirmPassword"
                            placeholder="Confirm your password">
                        <span class="error-message" id="confirmPassword-error"><?php echo $errors['confirmPassword'] ?? ''; ?></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <label for="dob">Date of Birth</label>
                        <img src="../assets/icons/calendar-blue.svg" alt="icon">
                        <input name="dob" type="date" id="dob">
                        <span class="error-message" id="dob-error"><?php echo $errors['dob'] ?? ''; ?></span>
                    </div>

                    <div class="input-group">
                        <label for="gender">Gender</label>
                        <img src="../assets/icons/gender.svg" alt="icon" class="gender-icon">
                        <select name="gender" id="gender">
                            <option value="">Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <span class="error-message" id="gender-error"><?php echo $errors['gender'] ?? ''; ?></span>
                    </div>
                </div>


                <button type="submit" class="register-button">Create Account</button>
                <span class="error-message" id="registration-error"><?php echo $errors['registration'] ?? ''; ?></span>

                <div class="login-link">
                    Already have an account? <a href="./login.php">Log in</a>
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/scripts/register.js"></script>
</body>

</html>