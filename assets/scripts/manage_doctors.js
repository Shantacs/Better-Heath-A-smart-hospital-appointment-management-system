document.querySelectorAll(".update-dept-btn").forEach((button) => {
  button.addEventListener("click", function () {
    const doctorId = this.dataset.doctorId;
    const select = document.querySelector(
      `.department-dropdown[data-doctor-id="${doctorId}"]`
    );
    const newDept = select.value;

    const params = new URLSearchParams({
      action: "update_department",
      doctor_id: doctorId,
      department: newDept,
    });

    fetch("../../controllers/manageDoctorsController.php?" + params.toString())
      .then((res) => res.text())
      .then((data) => {
        location.reload();
      })
      .catch((err) => console.error("Fetch error:", err));
  });
});
