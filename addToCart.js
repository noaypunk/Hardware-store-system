let currentProduct = {};

function openModal(title, desc, price, imgSrc) {
  currentProduct = { title, desc, price, imgSrc };
  document.getElementById("modalTitle").innerText = title;
  document.getElementById("modalDesc").innerText = desc;
  document.getElementById("modalPrice").innerText = "$" + price.toFixed(2);
  document.getElementById("modalImg").src = imgSrc;
  document.getElementById("productModal").style.display = "flex";
}

function closeModal() {
  document.getElementById("productModal").style.display = "none";
}


function addToCart() {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart.push(currentProduct);
  localStorage.setItem("cart", JSON.stringify(cart));
  alert(`${currentProduct.title} added to your cart!`);
  closeModal();
}

window.onclick = function(event) {
  const modal = document.getElementById("productModal");
  if (event.target === modal) closeModal();
};
