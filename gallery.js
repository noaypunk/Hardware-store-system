const modal = document.getElementById("productModal");
const modalImg = document.getElementById("modalImg");
const modalTitle = document.getElementById("modalTitle");
const modalPrice = document.getElementById("modalPrice");
const modalDesc = document.getElementById("modalDesc");

let selectedProduct = null;

function openModal(title, desc, price, image) {
  modal.style.display = "flex";
  modalImg.src = image;
  modalTitle.textContent = title;
  modalPrice.textContent = `₱${parseFloat(price).toFixed(2)}`;
  modalDesc.textContent = desc;

  selectedProduct = { title, desc, price: parseFloat(price), image };
}

function closeModal() {
  modal.style.display = "none";
}

window.onclick = function (event) {
  if (event.target === modal) {
    closeModal();
  }
};

function handleAddToCart() {
  const loggedIn = document.body.dataset.loggedin === "true";

  if (!loggedIn) {
    const loginModal = document.getElementById("accountModal");
    if (loginModal) loginModal.style.display = "block";
    closeModal();
    return;
  }

  if (!selectedProduct) return;

  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  const existing = cart.find(item => item.title === selectedProduct.title);
  if (existing) {
    existing.quantity += 1;
  } else {
    cart.push({
      title: selectedProduct.title,
      desc: selectedProduct.desc,
      price: selectedProduct.price,
      imgSrc: selectedProduct.image,
      quantity: 1
    });
  }

  localStorage.setItem("cart", JSON.stringify(cart));

  setTimeout(() => {
    alert(`${selectedProduct.title} has been added to your cart.`);
  }, 200);
  
}

function handleBuyNow() {
  handleAddToCart();
  setTimeout(() => {
    window.location.href = "checkout.php";
  }, 300);
}
