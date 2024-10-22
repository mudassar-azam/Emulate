// Get sidebar and overlay elements
const cartSidebar = document.getElementById("cartSidebar");
const menuSidebar = document.getElementById("menuSidebar");
const overlay = document.getElementById("overlay");
const cartButton = document.getElementById("cartButton");
const closeSidebar = document.getElementById("closeSidebar");
const svgElement = document.querySelector(".hb");
const popup = document.querySelectorAll(".popup");

const filterSidebar = document.getElementById("filterSidebar");
const openFilterbar = document.querySelector(".open-filterbar");
const closeFilterbar = document.getElementById("filter-close-btn");

// Open sidebar and show overlay when cart button is clicked
cartButton.addEventListener("click", () => {
  cartSidebar.style.right = "0";
  overlay.style.display = "block";
});

// Open sidebar and show overlay when menu button is clicked
svgElement.addEventListener("click", () => {
  // Check the current position of the sidebar
  if (menuSidebar.style.right === "0px") {
    // Close the sidebar and hide the overlay
    menuSidebar.style.right = "-100%";
    overlay.style.display = "none";

    // Trigger the SVG reverse animation
    const reverseAnimation = document.getElementById("reverse");
    reverseAnimation.beginElement();
  } else {
    // Open the sidebar and show the overlay
    menuSidebar.style.right = "0";
    overlay.style.display = "block";

    // Trigger the SVG opening animation
    const startAnimation = document.getElementById("start");
    startAnimation.beginElement();
  }
});

// Close sidebar and hide overlay when close button in cart-sidebar is clicked
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

// Popups for Sign In and Sign Up
function openPopup(type) {
  document.getElementById(`${type}-popup`).classList.add("open");
  overlay.style.display = "block";
}

function closePopup(type) {
  document.getElementById(`${type}-popup`).classList.remove("open");
  overlay.style.display = "none";
}

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

function scrollSlider(direction) {
  const slider = document.getElementById("uniqueProductSlider");
  const scrollAmount = direction * 220; // Adjust for item width + margin
  slider.scrollBy({ left: scrollAmount, behavior: "smooth" });
}

function toggleFaq(faq) {
  faq.classList.toggle("open");
}