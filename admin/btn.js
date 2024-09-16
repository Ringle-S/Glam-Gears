let btnDashs1 = document.getElementById("btnDash1");
let btnDashs2 = document.getElementById("btnDash2");
let btnDashs3 = document.getElementById("btnDash3");
let btnDashs4 = document.getElementById("btnDash4");
let btnDashs5 = document.getElementById("btnDash5");
let btnDashs6 = document.getElementById("btnDash6");
let btnDashs7 = document.getElementById("btnDash7");

btnDashs1.addEventListener("click", () => {
  btnDashs1.classList.add("activeDash");
  btnDashs2.classList.remove("activeDash");
  btnDashs3.classList.remove("activeDash");
  btnDashs4.classList.remove("activeDash");
  btnDashs5.classList.remove("activeDash");
  btnDashs6.classList.remove("activeDash");
  btnDashs7.classList.remove("activeDash");
});

btnDashs2.addEventListener("click", () => {
  btnDashs1.classList.remove("activeDash");
  btnDashs2.classList.add("activeDash");
  btnDashs3.classList.remove("activeDash");
  btnDashs4.classList.remove("activeDash");
  btnDashs5.classList.remove("activeDash");
  btnDashs6.classList.remove("activeDash");
  btnDashs7.classList.remove("activeDash");
});
btnDashs3.addEventListener("click", () => {
  btnDashs1.classList.remove("activeDash");
  btnDashs2.classList.remove("activeDash");
  btnDashs3.classList.add("activeDash");
  btnDashs4.classList.remove("activeDash");
  btnDashs5.classList.remove("activeDash");
  btnDashs6.classList.remove("activeDash");
  btnDashs7.classList.remove("activeDash");
});
btnDashs4.addEventListener("click", () => {
  btnDashs1.classList.remove("activeDash");
  btnDashs2.classList.remove("activeDash");
  btnDashs3.classList.remove("activeDash");
  btnDashs4.classList.add("activeDash");
  btnDashs5.classList.remove("activeDash");
  btnDashs6.classList.remove("activeDash");
  btnDashs7.classList.remove("activeDash");
});
btnDashs5.addEventListener("click", () => {
  btnDashs1.classList.remove("activeDash");
  btnDashs2.classList.remove("activeDash");
  btnDashs3.classList.remove("activeDash");
  btnDashs4.classList.remove("activeDash");
  btnDashs5.classList.add("activeDash");
  btnDashs6.classList.remove("activeDash");
  btnDashs7.classList.remove("activeDash");
});
btnDashs6.addEventListener("click", () => {
  btnDashs1.classList.remove("activeDash");
  btnDashs2.classList.remove("activeDash");
  btnDashs3.classList.remove("activeDash");
  btnDashs4.classList.remove("activeDash");
  btnDashs5.classList.remove("activeDash");
  btnDashs6.classList.add("activeDash");
  btnDashs7.classList.remove("activeDash");
});
btnDashs7.addEventListener("click", () => {
  btnDashs1.classList.remove("activeDash");
  btnDashs2.classList.remove("activeDash");
  btnDashs3.classList.remove("activeDash");
  btnDashs4.classList.remove("activeDash");
  btnDashs5.classList.remove("activeDash");
  btnDashs6.classList.remove("activeDash");
  btnDashs7.classList.add("activeDash");
});
