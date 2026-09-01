document.addEventListener("DOMContentLoaded", function () {
  const departmentFilter = document.getElementById("departmentFilter");
  const searchInput = document.getElementById("doctorSearch");
  const doctorCards = document.querySelectorAll(".action-card");

  // Department filter
  departmentFilter.addEventListener("change", function () {
    const selected = this.value.toLowerCase();

    doctorCards.forEach((card) => {
      const department = card.querySelector("p:nth-of-type(3)").textContent
        .replace("Department:", "")
        .trim()
        .toLowerCase();

      card.style.display =
        selected === "all" || department === selected.toLowerCase()
          ? ""
          : "none";
    });
  });

  // Search filter
  searchInput.addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();

    doctorCards.forEach((card) => {
      const name = card.querySelector("h3").textContent.toLowerCase();
      const email = card.querySelector("p:nth-of-type(1)").textContent.toLowerCase();

      card.style.display =
        name.includes(searchTerm) || email.includes(searchTerm) ? "" : "none";
    });
  });
});
