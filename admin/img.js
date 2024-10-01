// img
const selectImage = document.querySelector(".select-image");
const inputFile = document.querySelector("#file");
const imgArea = document.querySelector(".img-area");

selectImage.addEventListener("click", function () {
  inputFile.click();
});

inputFile.addEventListener("change", function () {
  const image = this.files[0];
  if (image.size < 2000000) {
    const reader = new FileReader();
    reader.onload = () => {
      const allImg = imgArea.querySelectorAll("img");
      allImg.forEach((item) => item.remove());
      const imgUrl = reader.result;
      const img = document.createElement("img");
      img.src = imgUrl;
      imgArea.appendChild(img);
      imgArea.classList.add("active");
      imgArea.dataset.img = image.name;
    };
    reader.readAsDataURL(image);
  } else {
    alert("Image size more than 2MB");
  }
});

const container = document.getElementById("navlinks");
const moveButton = document.getElementById("mobmenubtn");
let isMoving = false;
let startX = 0;

moveButton.addEventListener("click", () => {
  isMoving = !isMoving;

  if (isMoving) {
    container.style.transition = "transform 0.5s ease-in-out";
    container.style.transform = "translateX(-100%)";
  } else {
    container.style.transform = "translateX(-15px)";
  }
});
