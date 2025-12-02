<?php
session_start();
include('db_connect.php');

$sql = "SELECT materialID, title, price, image_file, details FROM material LIMIT 14";
$result = $conn->query($sql);

$user_is_logged_in = isset($_SESSION['user_id']) ? 'true' : 'false';
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

<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <i class="fa-solid fa-hammer"></i> Builder's Corner
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link <?php if($current_page=='index.php') echo 'current'; ?>" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link <?php if($current_page=='gallery.php') echo 'current'; ?>" href="gallery.php">Shop</a></li>
        <li class="nav-item"><a class="nav-link" <?php if($current_page=='myProfile.php') echo 'current'; ?>" href="myProfile.php">User Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" <?php if($current_page=='delivery.php') echo 'current'; ?>" href="delivery.php">Delivery Logs</a></li>
        <li class="nav-item"><a class="nav-link" <?php if($current_page=='project.php') echo 'current'; ?>" href="project.php">Projects</a></li>
        <li class="nav-item"><a class="nav-link <?php if($current_page=='contactUs.php') echo 'current'; ?>" href="contactUs.php">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#accountModal">My Account</a></li>
      </ul>

      <div class="ms-auto nav-icons d-flex align-items-center">
        <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#productSearchModal">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        <button class="btn-icon position-relative">
          <a href="checkout.php" class="position-relative">
          <i class="fa-solid fa-cart-shopping"></i>
          <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
              <?php echo count($_SESSION['cart']); ?>
            </span>
          <?php endif; ?>
          </a>
        </button>
      </div>
    </div>
  </div>
</nav>

<div class="container mt-5 mb-4">
    <h2 class="section-title">Popular Categories</h2>
    <div class="categories">
        <a href="#" class="category-card">Power Tools</a>
        <a href="#" class="category-card">Hand Tools</a>
        <a href="#" class="category-card">Safety</a>
        <a href="#" class="category-card">Electrical</a>
        <a href="#" class="category-card">Plumbing</a>
    </div>
</div>

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Featured Products</h2>
        <a href="gallery.php" class="view-all-link">View All &rarr;</a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
        <?php if ($result && $result->num_rows > 0):
            while($row = $result->fetch_assoc()):
              $current_price = $row['price'];
              $fake_old_price = $current_price * 1.3;
              $discount_percent = round((($fake_old_price - $current_price)/$fake_old_price)*100);
              $img_path = !empty($row['image_file']) ? $row['image_file'] : 'resources/default.jpg';
              $details = !empty($row['details']) ? $row['details'] : 'No details available.';
        ?>
        <div class="col">
            <div class="card product-card h-100">
                <span class="badge-discount">-<?php echo $discount_percent; ?>%</span>
                <i class="fa-regular fa-heart wishlist-icon"></i>
                <img src="<?php echo htmlspecialchars($img_path); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>"
                     data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $row['materialID']; ?>">
                
                <div class="card-body d-flex flex-column">
                    <span class="category-tag">Hardware</span>
                    <h5 class="product-title text-truncate"><?php echo htmlspecialchars($row['title']); ?></h5>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <span class="review-count">(<?php echo rand(50,200); ?>)</span>
                    </div>
                    <div class="mb-3">
                        <span class="current-price">$<?php echo number_format($current_price,2); ?></span>
                        <span class="old-price">$<?php echo number_format($fake_old_price,2); ?></span>
                    </div>
                    <form method="POST" action="index.php" id="form_<?php echo $row['materialID']; ?>" class="mt-auto">
                        <input type="hidden" name="product_id" value="<?php echo $row['materialID']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['title']); ?>">
                        <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                        <input type="hidden" name="action_type" class="action_input">
                        <button type="button" onclick="handleAction(<?php echo $row['materialID']; ?>)" class="btn btn-add-cart">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="imageModal<?php echo $row['materialID']; ?>" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body text-center">
                <img src="<?php echo htmlspecialchars($img_path); ?>" class="img-fluid mb-3">
                <p><strong>Details:</strong> <?php echo htmlspecialchars($details); ?></p>
                <h4 class="text-success">$<?php echo number_format($current_price,2); ?></h4>
              </div>
            </div>
          </div>
        </div>

        <?php endwhile; else: ?>
            <div class="col-12 text-center text-muted">No products found in the database.</div>
        <?php endif; ?>
    </div>
</div>

<footer>
   &copy; 2025 Builder's Corner | Hardware Store Management System
</footer>

<?php include 'modal_product_search.php'; ?>
<?php include 'account_modal.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const isLoggedIn = <?php echo $user_is_logged_in; ?>;
function handleAction(productId) {
    if(!isLoggedIn) {
        new bootstrap.Modal(document.getElementById('accountModal')).show();
    } else {
        let form = document.getElementById('form_' + productId);
        form.querySelector('.action_input').value = 'add_cart';
        let btn = document.createElement('button');
        btn.type = 'submit';
        btn.style.display = 'none';
        form.appendChild(btn);
        btn.click();
    }
}
</script>

</body>
</html>
