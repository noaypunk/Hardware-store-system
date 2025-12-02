<?php
session_start();
include 'db_connect.php';

$message = "";

// Handle delivery creation
if (isset($_POST['add_delivery'])) {
    $delivery_date = $_POST['delivery_date'];
    $status = $_POST['status'];
    $purchase_order_id = $_POST['purchase_order_id'];

    // Fetch projectID and customerID from purchase order
    $po_res = $conn->query("SELECT ProjectID, CustomerID FROM purchaseorder WHERE PurchaseOrderID='$purchase_order_id'");
    if($po_res->num_rows > 0) {
        $po = $po_res->fetch_assoc();
        $project_id = $po['ProjectID'];
        $customer_id = $po['CustomerID'];

        $sql = "INSERT INTO delivery (DeliveryDate, DeliveryStatus, PurchaseOrderID, ProjectID, CustomerID)
                VALUES ('$delivery_date', '$status', '$purchase_order_id', '$project_id', '$customer_id')";

        if($conn->query($sql) === TRUE){
            $message = "<div class='alert alert-success'>Delivery added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: ".$conn->error."</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Purchase Order not found.</div>";
    }
}

// Fetch purchase orders for dropdown
$orders = $conn->query("SELECT p.PurchaseOrderID, c.full_name FROM purchaseorder p
                        LEFT JOIN customer c ON p.CustomerID=c.customerID
                        ORDER BY p.PurchaseOrderID DESC");

// Fetch deliveries
$deliveries = $conn->query("SELECT d.*, c.full_name, p.ProjectName, po.Status AS po_status 
                            FROM delivery d
                            LEFT JOIN customer c ON d.CustomerID=c.customerID
                            LEFT JOIN project p ON d.ProjectID=p.ProjectID
                            LEFT JOIN purchaseorder po ON d.PurchaseOrderID=po.PurchaseOrderID
                            ORDER BY d.DeliveryID DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Deliveries</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container">
    <h2>Manage Deliveries</h2>
    <?php echo $message; ?>

    <form method="POST" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <input type="date" name="delivery_date" class="form-control" required>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select" required>
                    <option value="Pending">Pending</option>
                    <option value="Delivered">Delivered</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="purchase_order_id" class="form-select" required>
                    <option value="">Select Purchase Order</option>
                    <?php while($o = $orders->fetch_assoc()): ?>
                        <option value="<?= $o['PurchaseOrderID'] ?>">PO#<?= $o['PurchaseOrderID'] ?> - <?= htmlspecialchars($o['full_name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" name="add_delivery" class="btn btn-success">Add Delivery</button>
            </div>
        </div>
    </form>

    <h4>Existing Deliveries</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Delivery Date</th>
                <th>Status</th>
                <th>Purchase Order</th>
                <th>Project</th>
                <th>Customer</th>
            </tr>
        </thead>
        <tbody>
            <?php while($d = $deliveries->fetch_assoc()): ?>
                <tr>
                    <td><?= $d['DeliveryID'] ?></td>
                    <td><?= $d['DeliveryDate'] ?></td>
                    <td><?= $d['DeliveryStatus'] ?></td>
                    <td><?= $d['PurchaseOrderID'] ?> (<?= $d['po_status'] ?>)</td>
                    <td><?= htmlspecialchars($d['ProjectName']) ?></td>
                    <td><?= htmlspecialchars($d['full_name']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
