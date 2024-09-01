
// filterbtn
const filterBtn = document.getElementById("filterBtn");
const filterClose = document.getElementById("fliterClose");
const mobFilter = document.querySelector(".mob-filter");

filterBtn.addEventListener("click", () => {
  mobFilter.classList.remove("d-none");
  mobFilter.classList.add("d-flex");
});

filterClose.addEventListener("click", () => {
  mobFilter.classList.remove("d-flex");
  mobFilter.classList.add("d-none");
});
