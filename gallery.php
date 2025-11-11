<?php
include('db_connect.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Builder's Corner | Shop</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="gallery.css">
</head>

<body data-loggedin="<?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>">

  <nav>
    <a href="index.php">Home</a>
    <a href="gallery.php" class="Active">Shop</a>
    <a href="checkout.php" class="cart-link">🛒 View Cart</a>
    <a href="contactUs.php">Contact Us</a>
     <?php if(isset($_SESSION['username'])): ?>
      <a href="logout.php"> <?php echo "Sign out ".$_SESSION['username']; ?> </a>
    <?php endif; ?>
  </nav>

  <section class="gallery">
    <div class="gallery-container">
      <?php
        $query = "SELECT * FROM material";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $title = htmlspecialchars($row['title']);
            $desc = htmlspecialchars($row['description']);
            $price = number_format($row['price'], 2);
            $image = htmlspecialchars($row['image_file']);

            echo "
            <div class='item' 
              onclick=\"openModal('$title', '$desc', $price, '$image')\">
              <img src='$image' alt='$title'>
              <p>$title</p>
            </div>";
          }
        } else {
          echo "<p class='no-products'>No products available yet. Please check back later!</p>";
        }
      ?>
    </div>
  </section>

    <div id="productModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <img id="modalImg" src="" alt="Product Image" class="modal-img">

    <div class="title-price">
      <h2 id="modalTitle"></h2>
      <span id="modalPrice" class="price"></span>
    </div>

    <p id="modalDesc" class="modal-desc"></p>

    <div class="modal-buttons">
      <button onclick="handleAddToCart()" class="add-btn">🛒 Add to Cart</button>
      <button onclick="handleBuyNow()" class="buy-btn">💳 Buy Now</button>
    </div>
  </div>
</div>


  <footer>
    &copy; 2025 Hardware Management System
  </footer>


  <script src="gallery.js"></script>
  
  <?php include('account_modal.php'); ?>

</body>
</html>

