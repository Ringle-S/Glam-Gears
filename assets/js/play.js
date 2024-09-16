// video
const playButton = document.getElementById("playButton");
const pauseButton = document.getElementById("pauseButton");
const vid = document.getElementById("myVideo");

playButton.addEventListener("click", () => {
  alert();
  vid.play();
  //   playButton.classList.add("d-none");
  //   pauseButton.classList.remove("d-none");
});

pauseButton.addEventListener("click", () => {
  alert();
  vid.pause();
  //   playButton.classList.remove("d-none");
  //   pauseButton.classList.add("d-none");
});
