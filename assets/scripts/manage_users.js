document.addEventListener("DOMContentLoaded", function () {
  const roleFilter = document.getElementById("roleFilter");
  const searchInput = document.getElementById("userSearch");
  const tableRows = document.querySelectorAll("#usersTableBody tr");

  // Role filter
  roleFilter.addEventListener("change", function () {
    const selected = this.value;
    tableRows.forEach((row) => {
      const role = row.getAttribute("data-role");
      row.style.display = selected === "all" || role === selected ? "" : "none";
    });
  });

  // Search filter
  searchInput.addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();

    tableRows.forEach((row) => {
      // 2nd column is the name
      const nameCell = row.cells[1];
      const name = nameCell ? nameCell.textContent.toLowerCase() : "";

      row.style.display = name.includes(searchTerm) ? "" : "none";
    });
  });

  // Action handlers
  document.querySelectorAll(".btn-ban").forEach((btn) => {
    btn.addEventListener("click", function () {
      const userId = this.dataset.userId;
      const status = this.dataset.status;
      if (confirm(`Ban user?`)) {
        const params = new URLSearchParams({
          action: "ban_status",
          user_id: userId,
          current_status: status,
        });

        fetch(
          "/better health/controllers/manageUsersController.php?" +
            params.toString()
        )
          .then((res) => res.text())
          .then((data) => console.log("Response:", data))
          .catch((err) => console.error("Fetch error:", err));

        setTimeout(() => {
            location.reload();
        }, 1000);
      }
    });
  });

  document.querySelectorAll(".btn-remove").forEach((btn) => {
    btn.addEventListener("click", function () {
      const name = this.dataset.name;
      const userId = this.dataset.userId;
      if (confirm(`Delete user ${name}?`)) {
        const params = new URLSearchParams({
          action: "delete",
          user_id: userId,
        });
        fetch(
          "/better health/controllers/manageUsersController.php?" +
            params.toString()
        )
          .then((res) => {
            res.text();
            console.log(res);
          })
          .catch((err) => console.error("Fetch error:", err));

        setTimeout(() => {
          location.reload();
        }, 1000);
      }
    });
  });

  document.querySelectorAll(".role-dropdown").forEach((dropdown) => {
    dropdown.addEventListener("change", function () {
      const userId = this.dataset.userId;
      const newRole = this.value;

      const params = new URLSearchParams({
        action: "update_role",
        user_id: userId,
        new_role: newRole,
      });

      fetch(
        "/better health/controllers/manageUsersController.php?" +
          params.toString()
      )
        .then((res) => res.text())
        .catch((err) => console.error("Fetch error:", err));

      setTimeout(() => {
        location.reload();
      }, 1000);
    });
  });
});
