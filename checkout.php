<?php
session_start();
include 'db_connect.php';


$current_userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

$message = "";

if (isset($_GET['remove'])) {
    $id_to_remove = $_GET['remove'];
    if (isset($_SESSION['cart'][$id_to_remove])) {
        unset($_SESSION['cart'][$id_to_remove]);
    }
   
    header("Location: checkout.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    if (isset($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $pid => $pqty) {
            $pqty = intval($pqty);
            if ($pqty < 1) {
                unset($_SESSION['cart'][$pid]); 
            } else {
                $_SESSION['cart'][$pid] = $pqty; 
            }
        }
    }

    if (isset($_POST['update_cart'])) {
        $message = "<div class='alert alert-info'>Cart quantities updated!</div>";
    }

    if (isset($_POST['place_order'])) {
        
        if ($current_userID == 0) {
            echo "<script>alert('Please login to complete your purchase.'); window.location.href='index.php';</script>";
            exit();
        }

        if (!empty($_POST['selected_items'])) {
            $selected_ids = $_POST['selected_items'];
            $total_amount = 0;

            foreach ($selected_ids as $id) {
                if(isset($_SESSION['cart'][$id])) {
                    $qty = $_SESSION['cart'][$id];
                    $price = $_POST['price_' . $id]; 
                    $total_amount += ($qty * $price);
                }
            }

            $date = date('Y-m-d');
            $status = 'Pending';
            $sql_order = "INSERT INTO purchaseorder (orderDate, totalAmount, Status, customerID) 
                          VALUES ('$date', '$total_amount', '$status', '$current_userID')";

            if ($conn->query($sql_order) === TRUE) {
                $new_order_id = $conn->insert_id;
                $sql_items = "INSERT INTO purchaseorder_material (purchaseOrderID, materialID, quantity, unitPrice, subtotal) VALUES ";
                $values = [];

                foreach ($selected_ids as $id) {
                    if(isset($_SESSION['cart'][$id])) {
                        $qty = $_SESSION['cart'][$id];
                        $price = $_POST['price_' . $id];
                        $subtotal = $qty * $price;
                        $values[] = "('$new_order_id', '$id', '$qty', '$price', '$subtotal')";
                        
     
                        unset($_SESSION['cart'][$id]);
                    }
                }

                if(!empty($values)) {
                    $sql_items .= implode(", ", $values);
                    $conn->query($sql_items);
                    $message = "<div class='alert alert-success'>Order placed successfully! Order ID: #$new_order_id</div>";
                }
            } else {
                $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        } else {
            $message = "<div class='alert alert-warning'>Please select at least one item to checkout.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cart - Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">My Cart / Checkout</h2>
    <?php echo $message; ?>
    
    <form action="checkout.php" method="POST">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">Select</th> 
                            <th width="10%">Image</th>
                            <th>Material Name</th>
                            <th>Price</th>
                            <th width="15%">Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                            
                            $ids = implode(",", array_keys($_SESSION['cart']));
                            $sql = "SELECT * FROM material WHERE materialID IN ($ids)";
                            $result = $conn->query($sql);
                            
                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['materialID'];
                                    $qty = $_SESSION['cart'][$id];
                                    $price = $row['price'];
                                    $subtotal = $price * $qty;
                                    $image = $row['image_file'];
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected_items[]" value="<?php echo $id; ?>" checked class="form-check-input">
                                            <input type="hidden" name="price_<?php echo $id; ?>" value="<?php echo $price; ?>">
                                        </td>
                                        <td><img src="<?php echo $image; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius:5px;"></td>
                                        <td><?php echo $row['title']; ?></td>
                                        <td>$<?php echo number_format($price, 2); ?></td>
                                        
                                        <td>
                                            <input type="number" name="quantities[<?php echo $id; ?>]" value="<?php echo $qty; ?>" min="1" class="form-control text-center">
                                        </td>
                                        
                                        <td class="fw-bold">$<?php echo number_format($subtotal, 2); ?></td>
                                        
                                        <td>
                                            <a href="checkout.php?remove=<?php echo $id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this item?');">
                                                <i class="fas fa-trash"></i> Remove
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center py-4'><h5>Your cart is empty.</h5><a href='gallery.php' class='btn btn-primary mt-2'>Go Shopping</a></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-end">
                <a href="gallery.php" class="btn btn-secondary me-2">Continue Shopping</a>
                
                <button type="submit" name="update_cart" class="btn btn-info me-2 text-white">Update Cart</button>
                
                <button type="submit" name="place_order" class="btn btn-success btn-lg">Place Order</button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>