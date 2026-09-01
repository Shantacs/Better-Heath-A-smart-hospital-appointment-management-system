let allData = [];

function openTab(evt, tabName) {
  let i, tabcontent, tablinks;

  // Hide all tab content
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the specific tab content
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

function closeModal(modalId) {
  document.getElementById(modalId).style.display = "none";
}

// Close modals when clicking on X
document.querySelectorAll(".close").forEach((closeBtn) => {
  closeBtn.addEventListener("click", function () {
    this.closest(".modal").style.display = "none";
  });
});


// AJAX functions
function approveAppointment(id) {
  fetch(
    `../../controllers/AppointmentController.php?action=approve&appointment_id=${id}&scheduled_datetime=${encodeURIComponent(
      new Date().toISOString().slice(0, 19)
    )}`
  )
    .then((res) => res.text())
    .then((data) => {
      alert("Appointment approved successfully.");
      location.reload();
    })
    .catch((err) => console.error(err));
}

function rejectAppointment(id) {
  if (!confirm("Are you sure you want to reject this appointment?")) return;

  fetch(
    `../../controllers/AppointmentController.php?action=reject&appointment_id=${id}`
  )
    .then((res) => res.text())
    .then((data) => {
      alert("Appointment rejected successfully.");
      location.reload();
    })
    .catch((err) => console.error(err));
}

function markAsCompleted(id) {
  fetch(
    `../../controllers/AppointmentController.php?action=complete&appointment_id=${id}`
  )
    .then((res) => res.text())
    .then((data) => {
      alert("Appointment marked as completed.");
      location.reload();
    })
    .catch((err) => console.error(err));
}

function openPrescriptionModal(appointmentId, patientName) {
  document.getElementById("prescriptionAppointmentId").value = appointmentId;
  document.getElementById("prescriptionPatient").value = patientName;
  document.getElementById("prescriptionNotes").value = "";
  document.getElementById("prescriptionModal").style.display = "block";
}

function closeModal(id) {
  document.getElementById(id).style.display = "none";
}
