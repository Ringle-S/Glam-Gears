// const addProductBtn = document.getElementById("addProductBtn");
// const notificationBtns = document.getElementById("notificationBtn");
// const dashAddProduct = document.getElementById("dashAddProduct");
// const dashNavs = document.querySelectorAll(".displayDash");

// addProductBtn.addEventListener("click", () => {
//   // alert();
//   // dashAddProduct.classList.remove("d-none");
//   // dashAddProduct.classList.add("d-flex");
//   // dashNavs.forEach((dashNav) => {
//   //   dashNav.classList.add("d-none");
//   // });
// });
// notificationBtns.addEventListener("click", () => {
//   // alert();
//   // dashAddProduct.classList.remove("d-none");
//   // dashAddProduct.classList.add("d-flex");
//   // dashNavs.forEach((dashNav) => {
//   //   dashNav.classList.add("d-none");
//   // });
// });

const buttons = document.querySelectorAll(".dashBtn");
const containers = document.querySelectorAll(".displayDash");

buttons.forEach((button, index) => {
  // button[index].classList.add("activeDash");
  button.addEventListener("click", () => {
    containers.forEach((container, containerIndex) => {
      if (index === containerIndex) {
        container.classList.remove("d-none");
        // button.classList.remove("activeDash");
      } else {
        container.classList.add("d-none");
        // button.classList.add("activeDash");
      }
    });
  });
});

// profileContainer
const profileEdit = document.getElementById("profileEdit");
const ProfileEditContainer = document.getElementById("ProfileEditContainer");
const ProfileShowContainer = document.getElementById("ProfileShowContainer");
const editClose = document.getElementById("editClose");

profileEdit.addEventListener("click", () => {
  ProfileShowContainer.classList.add("d-none");
  ProfileEditContainer.classList.remove("d-none");
  ProfileEditContainer.classList.add("d-flex");
});

editClose.addEventListener("click", () => {
  ProfileEditContainer.classList.add("d-none");
  ProfileShowContainer.classList.remove("d-none");
  ProfileShowContainer.classList.add("d-flex");
});
