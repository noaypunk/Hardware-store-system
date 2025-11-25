<?php
session_start();
include('db_connect.php');

// limit 5 products to match the single row layout in the design
$sql = "SELECT materialID, title, price, image_file FROM material LIMIT 5";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Builder's Corner</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <link rel="stylesheet" href="index.css">

</head>

<body>

  <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <i class="fa-solid fa-hammer"></i> Builder's Corner
      </a>
       
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- T1 navigation bar section -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="gallery.php">Shop</a></li>
          <li class="nav-item"><a class="nav-link" href="contactUs.php">Contact</a></li>
          
          <?php if(isset($_SESSION['username'])): ?>
             <li class="nav-item"><a class="nav-link" href="#">My Account</a></li>
          <?php else: ?>
             <li class="nav-item">
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#accountModal">My Account</a>
             </li>
          <?php endif; ?>

          <li class="nav-item"><a class="nav-link" href="myProfile.php">My Profile</a></li>
        </ul>
<!-- T1 ends here --> 

              <!-- T2 searchbox & add to cart section -->
         <div class="ms-auto nav-icons d-flex align-items-center">

        <!--  Magnifying Glass Button (opens modal) -->
        <a><button class="btn-icon" data-bs-toggle="modal" data-bs-target="#productSearchModal">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button></a>

        <!-- Cart Icon -->
        <button class="btn-icon position-relative">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                <span class="visually-hidden">New alerts</span>
            </span>
        </button>

    </div>
<!-- T2 ends here -->

      </div>
    </div>
  </nav>

  <div class="container mt-5 mb-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 style="font-weight: 800; color: #222;">Featured Products</h2>
          <a href="gallery.php" class="view-all-link">View All &rarr;</a>
      </div>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
          
          <?php 
          if ($result && $result->num_rows > 0):
              while($row = $result->fetch_assoc()): 
                
             
                $current_price = $row['price'];
                $fake_old_price = $current_price * 1.3; 
                
                $discount_percent = round((($fake_old_price - $current_price) / $fake_old_price) * 100);
                
                $img_path = !empty($row['image_file']) ? $row['image_file'] : 'resources/default.jpg';
          ?>
          
          <div class="col">
              <div class="card product-card h-100">
                  <span class="badge-discount">-<?php echo $discount_percent; ?>%</span>
                  
                  <i class="fa-regular fa-heart wishlist-icon"></i>
                  
                  <img src="<?php echo htmlspecialchars($img_path); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                  
                  <div class="card-body d-flex flex-column">
                      <div>
                          <span class="category-tag">Hardware</span>
                      </div>
                      
                      <h5 class="product-title text-truncate" title="<?php echo htmlspecialchars($row['title']); ?>">
                          <?php echo htmlspecialchars($row['title']); ?>
                      </h5>
                      
                      <div class="stars">
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star-half-stroke"></i>
                          <span class="review-count">(<?php echo rand(50, 200); ?>)</span>
                      </div>
                      
                      <div class="mb-3">
                          <span class="current-price">$<?php echo number_format($current_price, 2); ?></span>
                          <span class="old-price">$<?php echo number_format($fake_old_price, 2); ?></span>
                      </div>
                      
                      <form action="add_to_cart.php" method="POST" class="mt-auto">
                          <input type="hidden" name="product_id" value="<?php echo $row['materialID']; ?>">
                          <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['title']); ?>">
                          <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                          <button type="submit" class="btn btn-primary btn-add-cart">Add to Cart</button>
                      </form>
                  </div>
              </div>
          </div>

          <?php 
              endwhile; 
          else: 
          ?>
            <div class="col-12">
                <p class="text-center text-muted">No products found in the database.</p>
            </div>
          <?php endif; ?>

      </div>
  </div>

 

  <footer>
     &copy; 2025 Builder's Corner | Hardware Store Management System
  </footer>

<?php include 'modal_product_search.php'; ?>

<script>
document.getElementById("searchBtn").addEventListener("click", function() {
    let searchValue = document.getElementById("productSearchInput").value;

    fetch("search_api.php?search=" + searchValue)
        .then(response => response.text())
        .then(data => {
            document.getElementById("searchResults").innerHTML = data;
        });
});
</script>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
