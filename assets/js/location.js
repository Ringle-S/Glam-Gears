const url = "https://api.countrystatecity.in/v1/countries";
const key = "SkRNZEZTRlJsMUE5ZVJjSXI1Z2pNblJkTHhOVXc1Tk85NFJXcjMwSA==";

let selectState = document.getElementById("inputState");
let selectCity = document.getElementById("inputCity");
let inputPin = document.getElementById("inputZip");

let pinArr = [];
const selectedState = selectState.value;
const selectedCity = selectCity.value;
async function loadStates() {
  selectState.style.pointerEvents = "auto";
  // selectCity.style.pointerEvents = "none";

  const response = await fetch(`${url}/IN/states`, {
    headers: { "X-CSCAPI-KEY": key },
  });
  const jsonData = await response.json();
  console.log(jsonData);

  jsonData.forEach((state) => {
    const option = document.createElement("option");
    option.value = state.iso2;
    option.textContent = state.name;
    selectState.appendChild(option);
  });
}
loadStates();
window.onload = loadStates;

// async function loadCities() {
//   selectCity.style.pointerEvents = "auto";
//   inputPin.disabled = true;
//   //   alert();

//   console.log(selectedState);

//   const response = await fetch(`${url}/IN/states/${selectedState}/cities`, {
//     headers: { "X-CSCAPI-KEY": key },
//   });
//   const jsonData = await response.json();

//   jsonData.forEach((state) => {
//     const option = document.createElement("option");
//     option.value = state.name;
//     option.textContent = state.name;
//     selectCity.appendChild(option);
//   });
//   inputPin.disabled = false;
// }
// loadCities();
// window.onload = loadStates;
// function loadCities() {
//   selectCity.style.pointerEvents = "auto";

//   const selectedState = selectState.value;
//   console.log(selectedState);

//   fetch(`${url}/IN/states/${selectedState}/cities`, {
//     headers: { "X-CSCAPI-KEY": key },
//   })
//     .then((response) => response.json()) // Parse the response as JSON
//     .then((jsonData) => {
//       jsonData.forEach((state) => {
//         const option = document.createElement("option");
//         option.value = state.iso2;
//         option.textContent = state.name;
//         selectCity.appendChild(option);
//       });
//       inputPin.disabled = false;
//     })
//     .catch((error) => {
//       // Handle any errors during the fetch request
//       console.error("Error fetching cities:", error);
//       // You can display an error message to the user here
//     });
// }
// window.onload = loadStates;
// loadCities();

// window.onload = loadCities;
// postal code
function loadPin() {
  fetch(`https://api.postalpincode.in/postoffice/${selectCity}`)
    .then((response) => response.json()) // Parse the response as JSON
    .then((jsonData) => {
      const pinArr = []; // Initialize an empty array to store pincodes

      jsonData.forEach((city) => {
        const postOffices = city.PostOffice;
        postOffices.forEach((postOffice) => {
          pinArr.push(postOffice.Pincode);
          // console.log(pinArr); // Log pinArr after each push
        });
      });

      // You can potentially use the pinArr for further processing
      // after all pincodes are collected.
    })
    .catch((error) => {
      // Handle any errors during the fetch request
      console.error("Error fetching pincodes:", error);
      // You can display an error message to the user here
    });
}
loadPin();
// window.onload = loadPin;

function restrictInput(event) {
  const input = event.target;
  const inputType = input.type;
  const inputValue = input.value;
  const charCode = event.which ? event.which : event.keyCode;

  // Allow backspace, delete, tab, and escape keys
  if (charCode === 8 || charCode === 46 || charCode === 9 || charCode === 27) {
    return;
  }

  if (inputType === "text") {
    // Allow letters and spaces
    const regex = /^[a-zA-Z\s]+$/;
    if (!regex.test(String.fromCharCode(charCode))) {
      event.preventDefault();
    }
  } else if (inputType === "number") {
    // Allow numbers only
    const regex = /^\d+$/;
    if (!regex.test(String.fromCharCode(charCode))) {
      event.preventDefault();
    }
  } else if (inputType === "tel") {
    // Allow numbers only
    const regex = /^\d+$/;
    if (!regex.test(String.fromCharCode(charCode))) {
      event.preventDefault();
    }
  }
}
document
  .querySelectorAll('input[type="text"], input[type="number"]')
  .forEach((input) => {
    input.addEventListener("keypress", restrictInput);
  });
