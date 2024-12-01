// Define a powerful sorting function
function sortTable(columnIndex, ascending) {
    const table = document.querySelector(".table");
    const rows = Array.from(table.querySelectorAll("tbody tr"));

    rows.sort((rowA, rowB) => {
        const cellA = rowA.cells[columnIndex].textContent.trim();
        const cellB = rowB.cells[columnIndex].textContent.trim();
    
        // Handle Date Columns
        if (!isNaN(Date.parse(cellA)) && !isNaN(Date.parse(cellB))) {
            return ascending
                ? new Date(cellA) - new Date(cellB)
                : new Date(cellB) - new Date(cellA);
        }
        
        // Handle Numeric Columns with Possible "N/A" or Non-Numeric Values
        const normalizedCellA = cellA === "N/A" ? -Infinity : parseFloat(cellA) || 0;
        const normalizedCellB = cellB === "N/A" ? -Infinity : parseFloat(cellB) || 0;
        if (!isNaN(normalizedCellA) && !isNaN(normalizedCellB)) {
            return ascending
                ? normalizedCellA - normalizedCellB
                : normalizedCellB - normalizedCellA;
        }
    
        // Handle Text Columns (Including Mixed Data Types)
        return ascending
            ? cellA.localeCompare(cellB, undefined, { numeric: true, sensitivity: "base" })
            : cellB.localeCompare(cellA, undefined, { numeric: true, sensitivity: "base" });
    });
    

    // Re-append sorted rows to the table
    const tbody = table.querySelector("tbody");
    tbody.innerHTML = "";
    rows.forEach((row) => tbody.appendChild(row));
}

// Attach sorting functionality to table headers
document.addEventListener("DOMContentLoaded", () => {
    const headers = document.querySelectorAll("th");
    headers.forEach((header, index) => {
        if (header.textContent.trim() !== "Actions") {
            let ascending = true;

            // Add click listener to each header
            header.addEventListener("click", () => {
                sortTable(index, ascending);
                ascending = !ascending;

                // Update header visuals (e.g., add a sort arrow indicator)
                headers.forEach((h) => h.classList.remove("sorted-asc", "sorted-desc"));
                header.classList.add(ascending ? "sorted-asc" : "sorted-desc");
            });
        }
    });
});
