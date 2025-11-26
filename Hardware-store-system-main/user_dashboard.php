<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM customer WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if (!$customer) {
    echo "Customer not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard - Builder's Corner</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="user_dashboard.css">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
    color: #333;
}

.navbar {
    background-color: #fff !important;
    border-bottom: 1px solid #e0e0e0;
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
    color: #007bff !important;
}

.nav-link.active {
    font-weight: 600;
    color: #007bff !important;
}

.card.product-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    background-color: #fff;
}

.card.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.card h3 {
    font-size: 1.4rem;
    font-weight: 600;
    border-bottom: 1px solid #e0e0e0;
    padding-bottom: 0.5rem;
    margin-bottom: 1rem;
}

img.img-fluid {
    border-radius: 6px;
}

footer {
    font-size: 0.9rem;
    color: #777;
}

@media (max-width: 768px) {
    .navbar-nav {
        text-align: center;
    }
    .navbar-nav .nav-item {
        margin-bottom: 0.5rem;
    }
}
</style>

</head>
<body>

<nav class="navbar navbar-expand-lg shadow-sm py-3 px-4">
    <a class="navbar-brand" href="index.php"><i class="fa-solid fa-hammer"></i> Builder's Corner</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a class="nav-link active" href="user_dashboard.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                    <?php echo htmlspecialchars($customer['username']); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="myProfile.php">Edit Profile</a></li>
                    <li><a class="dropdown-item text-danger" href="logout.php">Sign Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <div class="row g-4">

        <div class="col-12 col-lg-6">
            <div class="card product-card p-4">
                <h3>Profile Information</h3>
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($customer['full_name']); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($customer['username']); ?></p>
                <p><strong>Mobile:</strong> <?php echo htmlspecialchars($customer['mobile']); ?></p>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card product-card p-4">
                <h3>Your Cart</h3>
                <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                    <div class="row g-3">
                        <?php 
                        foreach($_SESSION['cart'] as $product_id => $quantity):
                            $sql = "SELECT * FROM material WHERE materialID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $product_id);
                            $stmt->execute();
                            $product = $stmt->get_result()->fetch_assoc();
                            if(!$product) continue;

                            $current_price = $product['price'];
                            $total_price = $current_price * $quantity;
                            $img_path = !empty($product['image_file']) ? $product['image_file'] : 'resources/default.jpg';
                        ?>
                        <div class="col-12 d-flex align-items-center">
                            <img src="<?php echo htmlspecialchars($img_path); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="img-fluid me-3" style="width:60px;height:60px;object-fit:contain;">
                            <div>
                                <h6 class="mb-1"><?php echo htmlspecialchars($product['title']); ?></h6>
                                <small class="text-muted">Qty: <?php echo $quantity; ?> | $<?php echo number_format($total_price,2); ?></small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="checkout.php" class="btn btn-primary mt-3">Proceed to Checkout</a>
                <?php else: ?>
                    <p class="text-muted">Your cart is empty.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<div class="container mt-5">
    <div class="card product-card p-4">
        <h3>Order History</h3>
        <p class="text-muted">You have no past orders.</p>
    </div>
</div>

<footer class="mt-5 py-3 bg-white text-center border-top">
    &copy; 2025 Builder's Corner | Hardware Store Management System
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
