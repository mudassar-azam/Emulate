// Get sidebar and overlay elements
const cartSidebar = document.getElementById("cartSidebar");
const overlay = document.getElementById("overlay");
const cartButton = document.getElementById("cartButton");
const closeSidebar = document.getElementById("closeSidebar");
const popup = document.querySelectorAll(".popup");

// const filterSidebar = document.getElementById("filterSidebar");
// const openFilterbar = document.querySelector(".open-filterbar");
// const closeFilterbar = document.getElementById("filter-close-btn");

// Open sidebar and show overlay when cart button is clicked
cartButton.addEventListener("click", () => {
  cartSidebar.style.right = "0";
  overlay.style.display = "block";
});

closeSidebar.addEventListener("click", () => {
  cartSidebar.style.right = "-100%";
  overlay.style.display = "none";

  // Trigger the SVG reverse animation
  const reverseAnimation = document.getElementById("reverse");
  reverseAnimation.beginElement();
});


// Hide sidebar when clicking on overlay
overlay.addEventListener("click", () => {
  cartSidebar.style.right = "-100%";
  overlay.style.display = "none";
  // closePopup('signin');
  popup.forEach((item) => {
    item.classList.remove("open");
  });

  // Trigger the SVG reverse animation
  const reverseAnimation = document.getElementById("reverse");
  reverseAnimation.beginElement();
});


function toggleDropdownUnique() {
  const dropdown = document.getElementById("dropdown-unique");
  dropdown.style.display =
    dropdown.style.display === "block" ? "none" : "block";
}

window.onclick = function (event) {
  // Check if the clicked target is not the profile image
  if (!event.target.matches(".profile-image-unique")) {
    const dropdown = document.getElementById("dropdown-unique");
    // Only proceed if the dropdown element exists
    if (dropdown && dropdown.style.display === "block") {
      dropdown.style.display = "none";
    }
  }
};

