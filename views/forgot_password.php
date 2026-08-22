<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../assets/styles/global.css">
  <link rel="stylesheet" href="../assets/styles/auth.css">
  <link rel="stylesheet" href="../assets/styles/forgot-password.css">
</head>

<body>
  <div class="container">
    <!-- Left Image Section -->
    <div class="image-section">
      <div class="welcome-text">
        <h1>Reset Your Password</h1>
        <p>Enter your registered email address and we’ll send you instructions to reset your password.</p>
      </div>
      <ul class="features">
        <li><img src="../assets/icons/secure.svg" alt="icon" class="feature-icon"> <span>Safe and Secure</span></li>
        <li><img src="../assets/icons/mail.svg" alt="icon" class="feature-icon"> <span>Email Verification</span></li>
        <li><img src="../assets/icons/help.svg" alt="icon" class="feature-icon"> <span>24/7 Support</span></li>
      </ul>
    </div>

    <!-- Right Form Section -->
    <div class="login-section">
      <div class="logo">
        <h2>Forgot Password</h2>
        <p>Better Health Appointment System</p>
      </div>

      <!-- Step 1: Enter Email -->
      <form class="login-form" id="emailForm">
        <div class="input-group">
          <img src="../assets/icons/mail-blue.svg" alt="icon">
          <input name="email" type="email" placeholder="Enter your email">
          <span class="error-message" id="emailError"></span>
        </div>

        <button type="submit" class="login-button">Send Reset Link</button>

        <div class="signup-link">
          <p>Remembered your password? <a href="login.php">Back to Login</a></p>
        </div>
      </form>

      <!-- Step 2: Enter OTP -->
      <form class="login-form" id="otpForm" style="display:none;">
        <div class="input-group">
          <img src="../assets/icons/key.svg" alt="icon">
          <input type="text" placeholder="Enter OTP" name="otp">
          <span class="error-message" id="otpError"></span>
        </div>

        <button type="submit" class="login-button">Verify OTP</button>

        <div class="signup-link">
          <p><a href="#" class="changeEmail">Use different email</a></p>
        </div>
      </form>

      <!-- Step 3: Enter New Password -->
      <form class="login-form" id="passwordForm" style="display:none;">
        <div class="input-group">
          <img src="../assets/icons/lock.svg" alt="icon">
          <input type="password" id="newPassword" placeholder="New Password" name="newPassword">
          <span class="error-message" id="newPasswordError"></span>
        </div>

        <div class="input-group">
          <img src="../assets/icons/lock.svg" alt="icon">
          <input type="password" id="confirmPassword" placeholder="Confirm Password" name="confirmPassword">
          <span class="error-message" id="confirmPasswordError"></span>
        </div>

        <button type="submit" class="login-button">Reset Password</button>

        <div class="signup-link">
          <p><a href="#" class="changeEmail">Use different email</a></p>
        </div>
      </form>
    </div>
  </div>

  <script src="../assets/scripts/forgotPass.js"></script>
</body>

</html>