document.addEventListener("DOMContentLoaded", function () {
  // Load schedule data via AJAX
  fetch("../../controllers/scheduleController.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        populateScheduleForm(data.weekly_schedule, data.break_times);
      }
    })
    .catch((error) => console.error("Error:", error));

  function populateScheduleForm(schedule, breaks) {
    // Loop through schedule and set values
    for (const [day, data] of Object.entries(schedule)) {
      const radioBtn = document.querySelector(
        `input[name="available[${day}]"]`
      );

      radioBtn.checked = data.available;
      const card = radioBtn.closest(".schedule-day-card");
      const timeInputs = radioBtn
        .closest(".schedule-day-card")
        .querySelector(".time-inputs");
      const inputs = timeInputs.querySelectorAll("input");

      if (radioBtn.checked) {
        timeInputs.style.display = "block";
        inputs.forEach((input) => (input.disabled = false));
        card.classList.remove("unavailable");
        card.classList.add("available");
      } else {
        timeInputs.style.display = "none";
        inputs.forEach((input) => (input.disabled = true));
        card.classList.remove("available");
        card.classList.add("unavailable");
      }

      document.querySelector(`input[name="start_time[${day}]"]`).value =
        data.start;
      document.querySelector(`input[name="end_time[${day}]"]`).value = data.end;
    }

    // Update preview section
    const previewContainer = document.querySelector(".preview-content");
    previewContainer.innerHTML = ""; // clear old preview

    for (const [day, data] of Object.entries(schedule)) {
      const dayDiv = document.createElement("div");
      dayDiv.classList.add("preview-day");

      dayDiv.innerHTML = `
      <strong>${day.charAt(0).toUpperCase() + day.slice(1)}:</strong>
      ${
        data.available
          ? `<span>${data.start} - ${data.end}</span>`
          : `<span class="unavailable-text">Not available</span>`
      }
    `;

      previewContainer.appendChild(dayDiv);
    }
  }

  // Toggle time inputs based on availability switch
  const switches = document.querySelectorAll('input[type="checkbox"]');
  switches.forEach((switchEl) => {
    switchEl.addEventListener("change", function () {
      const timeInputs =
        this.closest(".schedule-day-card").querySelector(".time-inputs");
      const inputs = timeInputs.querySelectorAll("input");
      const card = this.closest(".schedule-day-card");

      if (this.checked) {
        timeInputs.style.display = "block";
        inputs.forEach((input) => (input.disabled = false));
        card.classList.remove("unavailable");
        card.classList.add("available");
      } else {
        timeInputs.style.display = "none";
        inputs.forEach((input) => (input.disabled = true));
        card.classList.remove("available");
        card.classList.add("unavailable");
      }
    });
  });
});
