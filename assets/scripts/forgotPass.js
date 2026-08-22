
const emailForm = document.getElementById('emailForm');
const otpForm = document.getElementById('otpForm');
const passwordForm = document.getElementById('passwordForm');
const changeEmail = document.querySelectorAll('.changeEmail');


emailForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const email = e.target.email.value;

    isValid = true;

    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

    if (!email) {
        document.getElementById('emailError').textContent = "Email address is required.";
        isValid = false;
    } else if (!email.includes('@') || !email.includes('.')) {
        document.getElementById('emailError').textContent = "Please enter a valid email address.";
        isValid = false;
    }

    if (isValid) {
        alert("Your OTP is 1234");
        emailForm.style.display = 'none';
        otpForm.style.display = 'block';
    }

    return isValid;
});

otpForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const otp = e.target.otp.value;

    let isValid = true;

    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

    if (!otp) {
        document.getElementById('otpError').textContent = "OTP is required.";
        isValid = false;
    } else if (otp == '1234') {
        alert("OTP verified successfully.");
        otpForm.style.display = 'none';
        passwordForm.style.display = 'block';
    } else {
        document.getElementById('otpError').textContent = "Invalid OTP.";
        isValid = false;
    }

    return isValid;
});

passwordForm.addEventListener('submit', function (e) {
    const isValid = true;
    const newPass = e.target.newPassword.value;
    const confPass = e.target.confirmPassword.value;

    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

    if (!newPass) {
        document.getElementById('newPasswordError').textContent = "Password is required.";
        isValid = false;
    } else if (newPass.length < 8) {
        document.getElementById('newPasswordError').textContent = "Password must be at least 8 characters long.";
        isValid = false;
    }

    if (!confPass) {
        document.getElementById('confirmPasswordError').textContent = "Confirm Password is required.";
        isValid = false;
    } else if (newPass !== confPass) {
        document.getElementById('confirmPasswordError').textContent = "Passwords do not match.";
        isValid = false;
    }

    if (isValid) {
        location.reload();
        alert("Password has been reset successfully!");
    }

    return isValid;
});

changeEmail.forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        otpForm.style.display = 'none';
        passwordForm.style.display = 'none';
        emailForm.style.display = 'block';
    });
});

