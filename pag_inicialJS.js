function toggleDropdown() {
    const dropdown = document.getElementById("menuDropdown");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}
document.addEventListener("click", function(event) {
    const dropdown = document.getElementById("menuDropdown");
    const icon = document.getElementById("login_icon");
    if (dropdown.style.display === "block" && !icon.contains(event.target)) {
        dropdown.style.display = "none";
    }
});