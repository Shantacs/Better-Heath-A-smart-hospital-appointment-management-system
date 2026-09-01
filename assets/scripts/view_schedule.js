document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("bookingModal");
  const closeBtn = document.querySelector(".close");
  const timeInput = document.getElementById("timeInput");
  const doctorIdInput = document.getElementById("doctorIdInput");
  const requestedDateTimeInput = document.getElementById("requestedDateTimeInput");

  const dayMap = {
    sunday: 0,
    monday: 1,
    tuesday: 2,
    wednesday: 3,
    thursday: 4,
    friday: 5,
    saturday: 6
  };

  // book button click
  document.querySelectorAll(".btn-book").forEach(btn => {
    btn.addEventListener("click", () => {
      if (btn.classList.contains("disabled")) return;

      const doctorId = btn.dataset.doctor;
      const day = btn.dataset.day.toLowerCase();
      const start = btn.dataset.start;
      const end = btn.dataset.end;

      doctorIdInput.value = doctorId;

      // Set min/max time
      timeInput.min = start;
      timeInput.max = end;
      timeInput.value = start;

      modal.style.display = "block";

      // Store the weekday 
      modal.dataset.selectedDay = day;
    });
  });

  // Close modal
  closeBtn.addEventListener("click", () => modal.style.display = "none");
  window.addEventListener("click", (e) => { if (e.target == modal) modal.style.display = "none"; });

  // On form submit
  document.getElementById("bookingForm").addEventListener("submit", (e) => {
    const day = modal.dataset.selectedDay;
    const time = timeInput.value;

    // Convert weekday to next calendar date
    const today = new Date();
    const todayDay = today.getDay(); // 0-6
    const targetDay = dayMap[day];
    let diff = targetDay - todayDay;
    if (diff < 0) diff += 7; 
    const appointmentDate = new Date();
    appointmentDate.setDate(today.getDate() + diff);

    // Set hours and minutes from time input
    const [hours, minutes] = time.split(":").map(Number);
    appointmentDate.setHours(hours, minutes, 0, 0);

    // Format as datetime string
    const yyyy = appointmentDate.getFullYear();
    const mm = String(appointmentDate.getMonth() + 1).padStart(2, "0");
    const dd = String(appointmentDate.getDate()).padStart(2, "0");
    const hh = String(appointmentDate.getHours()).padStart(2, "0");
    const min = String(appointmentDate.getMinutes()).padStart(2, "0");
    const ss = "00";

    requestedDateTimeInput.value = `${yyyy}-${mm}-${dd} ${hh}:${min}:${ss}`;
  });
});
