////////zooom
let imageZoom = document.getElementById("imageZoom");
imageZoom.addEventListener("mousemove", (event) => {
  imageZoom.style.setProperty("--display", "block");
  let pointer = {
    x: (event.offsetX * 100) / imageZoom.offsetWidth,
    y: (event.offsetY * 100) / imageZoom.offsetHeight,
  };
  imageZoom.style.setProperty("--zoom-x", pointer.x + "%");
  imageZoom.style.setProperty("--zoom-y", pointer.y + "%");
});
imageZoom.addEventListener("mouseout", () => {
  imageZoom.style.setProperty("--display", "none");
});
