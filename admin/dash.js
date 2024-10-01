const buttons = document.querySelectorAll(".dashBtn");
const containers = document.querySelectorAll(".displayDash");

buttons.forEach((button, index) => {
  // button[index].classList.add("activeDash");
  button.addEventListener("click", () => {
    containers.forEach((container, containerIndex) => {
      if (index === containerIndex) {
        container.classList.remove("d-none");
        // button[containerIndex].classList.add("activeDash");
        // button.classList.add(index);
        // button.classList.add(containerIndex);
        // alert(containerIndex);
      } else {
        // button.classList.remove(index);
        // button.classList.remove("activeDash");
        container.classList.add("d-none");
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

