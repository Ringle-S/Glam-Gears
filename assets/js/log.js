const menuBtn = document.getElementById("menuBtn");
const Menu = document.getElementById("profileMenu");

menuBtn.addEventListener("click", () => {
  Menu.classList.toggle("d-none");
});

