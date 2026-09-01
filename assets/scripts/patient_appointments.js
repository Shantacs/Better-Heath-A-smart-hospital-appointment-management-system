document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("#remove-appointment-btn").forEach((btn) => {
    btn.addEventListener("click", async (e) => {
      e.preventDefault();
      const appointmentId = btn.dataset.appointmentId;

      if (!appointmentId) return;

      if (!confirm("Are you sure you want to remove this appointment?")) return;

      try {
        const params = new URLSearchParams({
          action: "remove",
          appointment_id: appointmentId,
        });

        fetch(
          "../../controllers/appointmentController.php?" + params.toString()
        )
          .then((res) => res.text())
          .then((data) => {
            location.reload();
          })
          .catch((err) => console.error("Fetch error:", err));
      } catch (err) {
        console.error(err);
        alert("An error occurred while removing the appointment.");
      }
    });
  });
});
