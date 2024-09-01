const cartIncrements = document.querySelectorAll(".cartItemIncre");
const cartDecrements = document.querySelectorAll(".cartItemDecre");
const cartCounts = document.querySelectorAll(".cartCount");

cartIncrements.forEach((incre, index) => {
  incre.addEventListener("click", () => {
    const countElement = cartCounts[index];
    let count = parseInt(countElement.value, 10);
    count++;
    countElement.value = count;

    const productId = countElement.dataset.productId;
    console.log(productId);
    // Assuming productId is in a data attribute
    updateCartQuantity(index, count);
  });
});

cartDecrements.forEach((decre, index) => {
  decre.addEventListener("click", () => {
    const countElement = cartCounts[index];
    let count = parseInt(countElement.value, 10);
    if (count > 1) {
      count--;
      countElement.value = count;

      const productId = countElement.dataset.productId;
      console.log(productId);

      updateCartQuantity(index, count);
    }
  });
});

function updateCartQuantity(index, count) {
  // Get product ID from the cart item (assuming you have a data attribute)
  const productId = cartCounts[index].dataset.productId;

  // AJAX request to update the cart quantity in the database
  fetch("update_cart_quantity.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ productId: productId, quantity: count }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Handle successful update
        console.log("Cart quantity updated successfully");
      } else {
        // Handle update error
        console.error("Error updating cart quantity");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
