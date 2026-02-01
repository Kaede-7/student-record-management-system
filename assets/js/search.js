document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("studentSearch");
  const table = document.getElementById("studentTable");

  if (searchInput && table) {
    const rows = table
      .getElementsByTagName("tbody")[0]
      .getElementsByTagName("tr");

    searchInput.addEventListener("keyup", function () {
      const filter = searchInput.value.toLowerCase();

      for (let i = 0; i < rows.length; i++) {
        // Column 0 is Name, Column 1 is Course
        const nameText = rows[i]
          .getElementsByTagName("td")[0]
          .textContent.toLowerCase();
        const courseText = rows[i]
          .getElementsByTagName("td")[1]
          .textContent.toLowerCase();

        if (nameText.includes(filter) || courseText.includes(filter)) {
          rows[i].style.display = ""; // Show row
        } else {
          rows[i].style.display = "none"; // Hide row
        }
      }
    });
  }
});
