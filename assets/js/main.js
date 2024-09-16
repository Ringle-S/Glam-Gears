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

// timer
function countdownTimer(endDate) {
  const Days = document.getElementById("days");
  const Hours = document.getElementById("hours");
  const Minutes = document.getElementById("minutes");
  const Seconds = document.getElementById("seconds");
  const endDateString = endDate; // Replace with your desired end date string

  const updateTimer = () => {
    const endTime = new Date(endDateString);
    const now = new Date();
    const difference = endTime - now;

    const seconds = Math.floor((difference / 1000) % 60);
    const minutes = Math.floor((difference / (1000 * 60)) % 60);
    const hours = Math.floor((difference / (1000 * 60 * 60)) % 24);
    const days = Math.floor(difference / (1000 * 60 * 60 * 24));

    Days.innerHTML = `${days}<span class="mx-2">&#58;</span>`;
    Hours.innerHTML = ` ${hours}<span class="mx-2">&#58;</span>`;
    Minutes.innerHTML = ` ${minutes}<span class="mx-2">&#58;</span>`;
    Seconds.innerHTML = `${seconds}`;
  };

  updateTimer();
  // setInterval(updateTimer, 1000);
}
countdownTimer("2024-11-24");



// playButton.addEventListener("mouseover", function () {
//   vid.play();
//   playButton.classList.add("d-none");
//   pauseButton.classList.add("d-none");
// });
// pauseButton.addEventListener("mouseleave", function () {
//   vid.pause();
//   playButton.classList.add("d-none");
//   pauseButton.classList.add("d-none");
// });
