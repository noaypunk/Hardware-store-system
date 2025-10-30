function loadCart() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const cartContainer = document.getElementById("cart-items");
  cartContainer.innerHTML = "";

  if (cart.length === 0) {
    cartContainer.innerHTML = "<p>Your cart is empty.</p>";
    document.getElementById("totalPrice").innerText = "$0.00";
    return;
  }

  cart.forEach((item, index) => {
    const div = document.createElement("div");
    div.classList.add("item");
    div.innerHTML = `
      <input type="checkbox" class="item-check" data-index="${index}" checked>
      <img src="${item.imgSrc}" alt="${item.title}">
      <div>
        <h4>${item.title}</h4>
        <p>$${item.price.toFixed(2)} × ${item.quantity}</p>
      </div>
      <button onclick="removeItem(${index})">🗑️</button>
    `;
    cartContainer.appendChild(div);
  });

  updateTotal();
}

function updateTotal() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const checks = document.querySelectorAll(".item-check");
  let total = 0;

  checks.forEach(check => {
    if (check.checked) {
      const index = check.dataset.index;
      const item = cart[index];
      total += item.price * item.quantity;
    }
  });

  document.getElementById("totalPrice").innerText = `$${total.toFixed(2)}`;
}

function removeItem(index) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart.splice(index, 1);
  localStorage.setItem("cart", JSON.stringify(cart));
  loadCart();
}

function openModal() {
  const selectedItems = getSelectedItems();
  if (selectedItems.length === 0) {
    alert("Please select at least one item to purchase.");
    return;
  }
  document.getElementById("checkoutModal").style.display = "flex";
}

function closeModal() {
  document.getElementById("checkoutModal").style.display = "none";
}

function getSelectedItems() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const checks = document.querySelectorAll(".item-check");
  return Array.from(checks)
    .filter(c => c.checked)
    .map(c => cart[c.dataset.index]);
}

function processPayment() {
  const selected = getSelectedItems();
  if (selected.length === 0) {
    alert("No items selected for checkout.");
    return false;
  }

  alert(`✅ Payment successful for ${selected.length} item(s)! Thank you.`);
  const remaining = JSON.parse(localStorage.getItem("cart")).filter((_, i) => 
    !document.querySelectorAll(".item-check")[i].checked
  );
  localStorage.setItem("cart", JSON.stringify(remaining));
  closeModal();
  loadCart();
  return false;
}

document.getElementById("checkoutBtn").addEventListener("click", openModal);
document.addEventListener("change", e => {
  if (e.target.classList.contains("item-check")) updateTotal();
});

window.onload = loadCart;
