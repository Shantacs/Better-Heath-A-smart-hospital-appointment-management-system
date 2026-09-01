document.addEventListener("DOMContentLoaded", () => {
    const resetBtn = document.getElementById("resetPasswordBtn");
    const passwordFields = document.getElementById("passwordFields");
    const cancelBtn = document.getElementById("cancelPasswordBtn");

    if (resetBtn) {
        resetBtn.addEventListener("click", () => {
            passwordFields.style.display = "block";
            resetBtn.style.display = "none";
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener("click", () => {
            passwordFields.style.display = "none";
            document.getElementById("old_password").value = "";
            document.getElementById("new_password").value = "";
            resetBtn.style.display = "inline-block";
        });
    }
});

const validatePass = (event) => {
    const form = event.target;
    const password = form.new_password.value;
    const oldPassword = form.old_password.value;

    const passwordError = document.getElementById("passwordError");
    if ((password.length > 0 && password.length < 8) || (oldPassword.length > 0 && oldPassword.length < 8)) {
        passwordError.textContent = "Password must be at least 8 characters long";
        passwordError.style.color = "red";
        return false;
    }
    passwordError.textContent = "";
    return true;
};

// Preview profile pic
const profileUpload = document.getElementById('profileUpload');
const profileImage = document.getElementById('profileImage');

if (profileUpload) {
    profileUpload.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
}
