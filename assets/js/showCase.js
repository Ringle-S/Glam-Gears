// image shower
const imgs = document.querySelectorAll(".img-select a");
const imgBtns = [...imgs];
// const imageZoom = document.getElementById("imageZoom");
let imgId = 1;

imgBtns.forEach((imgItem) => {
  imgItem.addEventListener("click", (event) => {
    event.preventDefault();
    console.log(imgItem.children);

    imgId = imgItem.dataset.id;
    slideImage();
  });
});

function slideImage() {
  const displayWidth = document.querySelector(
    ".img-showcase img:first-child"
  ).clientWidth;

  document.querySelector(".img-showcase").style.transform = `translateX(${
    -(imgId - 1) * displayWidth
  }px)`;
}

window.addEventListener("resize", slideImage);

// quantity
function increment() {
  const counter = document.getElementById("counter");
  let count = parseInt(counter.value);
  count++;
  counter.value = count;
}

function decrement() {
  const counter = document.getElementById("counter");
  let count = parseInt(counter.value);
  if (count > 1) {
    count--;
    counter.value = count;
  }
}

// accordian function

const accordianItem = document.querySelectorAll(".accordian-item");

accordianItem.forEach((accItem) => {
  accItem.addEventListener("click", () => {
    accordianItem.forEach((otherItem) => {
      otherItem.classList.remove("active");
    });

    accItem.classList.toggle("active");
  });
});

