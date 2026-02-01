document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("studentSearch");
  const resultsDiv = document.getElementById("results");

  // Listen for typing in the search bar
  searchInput.addEventListener("input", function () {
    const query = this.value.trim();

    // Only search if the user has typed more than 1 character
    if (query.length > 1) {
      // Fetch data from the AJAX PHP handler
      // The path assumes the JS is called from a file in public/admin/
      fetch(`../search_ajax.php?term=${encodeURIComponent(query)}`)
        .then((response) => {
          if (!response.ok) throw new Error("Network response was not ok");
          return response.json();
        })
        .then((data) => {
          resultsDiv.innerHTML = ""; // Clear previous results

          if (data.length > 0) {
            resultsDiv.style.display = "block";

            // Create a div for each suggestion
            data.forEach((name) => {
              const div = document.createElement("div");
              div.className = "search-item";
              div.textContent = name;

              // Optional: When clicking a name, put it in the search box
              div.onclick = function () {
                searchInput.value = name;
                resultsDiv.style.display = "none";
              };

              resultsDiv.appendChild(div);
            });
          } else {
            resultsDiv.style.display = "none";
          }
        })
        .catch((error) => {
          console.error("Error fetching search results:", error);
        });
    } else {
      resultsDiv.style.display = "none";
    }
  });

  // Close the results list if user clicks outside
  document.addEventListener("click", (e) => {
    if (e.target !== searchInput) {
      resultsDiv.style.display = "none";
    }
  });
});
