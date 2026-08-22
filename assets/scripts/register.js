const validateRegistration = (event) => {
    const form = event.target;

    // Validate form fields
    let isValid = true;

    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

    // Validate first name
    const fname = form.fname.value.trim();
    if (!fname) {
        document.getElementById('fname-error').textContent = 'First name is required';
        isValid = false;
    }

    // Validate last name
    const lname = form.lname.value.trim();
    if (!lname) {
        document.getElementById('lname-error').textContent = 'Last name is required';
        isValid = false;
    }

    // Validate email
    const email = form.email.value.trim();
    if (!email) {
        document.getElementById('email-error').textContent = 'Email is required';
        isValid = false;
    } else if (!email.includes('@') || !email.includes('.')) {
        document.getElementById('email-error').textContent = 'Invalid email format';
        isValid = false;
    }

    // Validate password
    const password = form.password.value.trim();
    if (!password) {
        document.getElementById('password-error').textContent = 'Password is required';
        isValid = false;
    } else if (password.length < 8) {
        document.getElementById('password-error').textContent = 'Password must be at least 8 characters';
        isValid = false;
    }

    // Validate confirm password
    const confirmPassword = form.confirmPassword.value.trim();
    if (!confirmPassword) {
        document.getElementById('confirmPassword-error').textContent = 'Confirm password is required';
        isValid = false;
    } else if (confirmPassword !== password) {
        document.getElementById('confirmPassword-error').textContent = 'Passwords do not match';
        isValid = false;
    }

    // Validate date of birth
    const dob = form.dob.value.trim();
    if (!dob) {
        document.getElementById('dob-error').textContent = 'Date of birth is required';
        isValid = false;
    }

    // Validate gender
    const gender = form.gender.value.trim();
    if (!gender) {
        document.getElementById('gender-error').textContent = 'Gender is required';
        isValid = false;
    }

    return isValid;
}