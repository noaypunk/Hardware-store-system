<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Hardware Store</title>
  <link rel="stylesheet" href="checkout.css">
</head>
<body>
  <header>
    <h1>🛒 Checkout</h1>
    <a href="gallery.php" class="back-btn">← Back to Shop</a>
  </header>

  <main>
    <section id="cart-items"></section>

    <div class="summary">
      <h2>Order Summary</h2>
      <p><strong>Total:</strong> <span id="totalPrice">$0.00</span></p>
      <button id="checkoutBtn">Proceed to Payment</button>
    </div>
  </main>

  <div id="checkoutModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>Enter Payment Details</h2>
      <form id="paymentForm" onsubmit="return processPayment()">
        <label for="name">Full Name</label>
        <input type="text" id="name" required>

        <label for="address">Address</label>
        <input type="text" id="address" required>

        <label for="card">Card Number</label>
        <input type="text" id="card" maxlength="16" required>

        <button type="submit">Confirm Payment</button>
      </form>
    </div>
  </div>

  <script src="checkout.js"></script>
</body>
</html>
