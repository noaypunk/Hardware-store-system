<?php
session_start();
include('db_connect.php');

$user_is_logged_in = isset($_SESSION['user_id']) ? 'true' : 'false';

$category_filter = isset($_GET['category']) ? $_GET['category'] : 'all';
$sort_option = isset($_GET['sort']) ? $_GET['sort'] : 'default';

$sql = "SELECT * FROM material WHERE 1 ";
if($category_filter != 'all'){
    $sql .= " AND category = '". $conn->real_escape_string($category_filter) ."' ";
}
if($sort_option == 'price_asc'){
    $sql .= " ORDER BY price ASC ";
}elseif($sort_option == 'price_desc'){
    $sql .= " ORDER BY price DESC ";
}elseif($sort_option == 'popular'){
    $sql .= " ORDER BY popularity DESC "; 
}
$result = $conn->query($sql);

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Builder's Corner - Shop</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="index.css">
<link rel="stylesheet" href="gallery.css">
</head>
<body>

<!-- Navbar -->
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
        <li class="nav-item"><a class="nav-link" href="myProfile.php">Supplier Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Delivery Logs</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Projects</a></li>
        <li class="nav-item"><a class="nav-link <?php if($current_page=='contactUs.php') echo 'current'; ?>" href="contactUs.php">Contact</a></li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#accountModal">My Account</a>
        </li>
      </ul>

      <div class="ms-auto nav-icons d-flex align-items-center">
        <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#productSearchModal">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        <button class="btn-icon position-relative">
          <i class="fa-solid fa-cart-shopping"></i>
          <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
              <?php echo count($_SESSION['cart']); ?>
            </span>
          <?php endif; ?>
        </button>
      </div>
    </div>
  </div>
</nav>

<div class="container mt-4 d-flex align-items-center mb-3">
    <div class="dropdown">
        <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-filter"></i> Filter
        </button>
        <ul class="dropdown-menu p-3" style="min-width: 220px;">
            <form method="GET" id="filterForm">
                <div class="mb-2">
                    <label class="form-label fw-bold">Category:</label>
                    <select name="category" class="form-select form-select-sm">
                        <option value="all" <?php if($category_filter=='all') echo 'selected'; ?>>All Categories</option>
                        <option value="Power Tools" <?php if($category_filter=='Power Tools') echo 'selected'; ?>>Power Tools</option>
                        <option value="Hand Tools" <?php if($category_filter=='Hand Tools') echo 'selected'; ?>>Hand Tools</option>
                        <option value="Safety" <?php if($category_filter=='Safety') echo 'selected'; ?>>Safety</option>
                        <option value="Electrical" <?php if($category_filter=='Electrical') echo 'selected'; ?>>Electrical</option>
                        <option value="Plumbing" <?php if($category_filter=='Plumbing') echo 'selected'; ?>>Plumbing</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label fw-bold">Sort By:</label>
                    <select name="sort" class="form-select form-select-sm">
                        <option value="default" <?php if($sort_option=='default') echo 'selected'; ?>>Default</option>
                        <option value="price_asc" <?php if($sort_option=='price_asc') echo 'selected'; ?>>Price: Low → High</option>
                        <option value="price_desc" <?php if($sort_option=='price_desc') echo 'selected'; ?>>Price: High → Low</option>
                        <option value="popular" <?php if($sort_option=='popular') echo 'selected'; ?>>Popularity</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm w-100">Apply</button>
            </form>
        </ul>
    </div>
</div>

<div class="container mb-5">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
    <?php if($result && $result->num_rows > 0):
        while($row = $result->fetch_assoc()):
            $id = $row['materialID'];
            $title = $row['title'];
            $price = $row['price'];
            $details = $row['details'];
            $img_path = !empty($row['image_file']) ? $row['image_file'] : 'resources/default.jpg';
            $fake_old_price = $price * 1.3;
            $discount_percent = round((($fake_old_price - $price)/$fake_old_price)*100);
    ?>
    <div class="col">
      <div class="card product-card h-100">
        <span class="badge-discount">-<?php echo $discount_percent; ?>%</span>
        <i class="fa-regular fa-heart wishlist-icon"></i>
        <img src="<?php echo htmlspecialchars($img_path); ?>" class="card-img-top product-img" alt="<?php echo htmlspecialchars($title); ?>" data-bs-toggle="modal" data-bs-target="#productModal<?php echo $id; ?>">

        <div class="card-body d-flex flex-column">
          <span class="category-tag">Hardware</span>
          <h5 class="product-title text-truncate"><?php echo htmlspecialchars($title); ?></h5>

          <div class="stars">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star-half-stroke"></i>
            <span class="review-count">(<?php echo rand(50,200); ?>)</span>
          </div>

          <div class="mb-3">
            <span class="current-price">$<?php echo number_format($price,2); ?></span>
            <span class="old-price">$<?php echo number_format($fake_old_price,2); ?></span>
          </div>

          <form method="POST" action="gallery.php" id="form_<?php echo $id; ?>" class="mt-auto">
            <input type="hidden" name="materialID" value="<?php echo $id; ?>">
            <input type="hidden" name="action_type" class="action_input">
            <button type="button" onclick="handleAction(<?php echo $id; ?>)" class="btn btn-add-cart">Add to Cart</button>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="productModal<?php echo $id; ?>" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><?php echo $title; ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <img src="<?php echo $img_path; ?>" class="img-fluid mb-3">
            <p><strong>Details:</strong> <?php echo $details; ?></p>
            <h4 class="text-success">$<?php echo number_format($price,2); ?></h4>
          </div>
        </div>
      </div>
    </div>

    <?php endwhile; else: ?>
      <div class="col-12 text-center text-muted">No products found.</div>
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
