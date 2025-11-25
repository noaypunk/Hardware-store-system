<?php
session_start(); 
include 'db_connect.php';

$user_is_logged_in = isset($_SESSION['user_id']) ? 'true' : 'false';

if (isset($_POST['add_to_cart']) && isset($_SESSION['user_id'])) {
    $product_id = $_POST['materialID'];
    $quantity = $_POST['quantity'];
    $action = $_POST['action_type']; 

    if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = []; }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    if ($action == 'buy_now') {
        header("Location: checkout.php");
        exit();
    } else {
        echo "<script>alert('Item added to cart!'); window.location.href='gallery.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Shop Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card { margin-bottom: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .product-img { height: 200px; object-fit: cover; cursor: pointer; }
        .card-title { font-weight: bold; }
        .price-tag { color: #28a745; font-size: 1.2em; font-weight: bold; }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Hardware Materials</h2>
    
    <div class="text-end mb-3">
        <a href="landing.php" class="btn btn-primary">Home</a>
        <a href="checkout.php" class="btn btn-primary position-relative">
            Go to Cart (Checkout)
            <?php if(isset($_SESSION['cart'])): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php echo count($_SESSION['cart']); ?>
                </span>
            <?php endif; ?>
        </a>
    </div>

    <div class="row">
        <?php
        $sql = "SELECT * FROM material";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $id = $row['materialID'];
                $title = $row['title'];
                $price = $row['price'];
                $details = $row['details'];
                $imagePath = $row['image_file']; 
                ?>

                <div class="col-md-3 col-sm-6">
                    <div class="card product-card">
                        <img src="<?php echo $imagePath; ?>" class="card-img-top product-img" alt="<?php echo $title; ?>" data-bs-toggle="modal" data-bs-target="#productModal<?php echo $id; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $title; ?></h5>
                            <p class="price-tag">$<?php echo number_format($price, 2); ?></p>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="productModal<?php echo $id; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo $title; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="<?php echo $imagePath; ?>" class="img-fluid mb-3" style="width:100%">
                                <p><strong>Details:</strong> <?php echo $details; ?></p>
                                <h4 class="text-success">$<?php echo number_format($price, 2); ?></h4>
                                
                                <form method="POST" action="gallery.php" id="form_<?php echo $id; ?>">
                                    <input type="hidden" name="materialID" value="<?php echo $id; ?>">
                                    <input type="hidden" name="action_type" class="action_input"> <div class="mb-3">
                                        <label>Quantity:</label>
                                        <input type="number" name="quantity" value="1" min="1" class="form-control" style="width: 80px;">
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="button" onclick="handleAction(<?php echo $id; ?>, 'add_cart')" class="btn btn-secondary">Add to Cart</button>
                                        <button type="button" onclick="handleAction(<?php echo $id; ?>, 'buy_now')" class="btn btn-success">Buy Now</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>

<?php include 'account_modal.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const isLoggedIn = <?php echo $user_is_logged_in; ?>;

    function handleAction(productId, actionType) {
        if (!isLoggedIn) {
            var productModalEl = document.getElementById('productModal' + productId);
            var productModal = bootstrap.Modal.getInstance(productModalEl);
            productModal.hide();
            var loginModal = new bootstrap.Modal(document.getElementById('accountModal'));
            loginModal.show();
            
        } else {
            var form = document.getElementById('form_' + productId);
            form.querySelector('.action_input').value = actionType;
            var submitBtn = document.createElement("button");
            submitBtn.type = "submit";
            submitBtn.name = "add_to_cart";
            submitBtn.style.display = "none";
            form.appendChild(submitBtn);
            submitBtn.click();
        }
    }
</script>

</body>
</html>