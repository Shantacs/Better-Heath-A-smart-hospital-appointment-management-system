const validateLogin = (event) => {
    const form = event.target;

    let isValid = true;

    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

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

    return isValid;
}