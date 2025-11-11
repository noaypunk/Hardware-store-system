<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
  header("Location: index.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $details = $_POST['details'];
  $price = $_POST['price'];

  if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $image_name = basename($_FILES["image_file"]["name"]);
    $target_file = $target_dir . time() . "_" . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (in_array($imageFileType, $allowed_types)) {
      move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file);
      $image_file = $target_file;
    } else {
      echo "<script>alert('Invalid image type! Only JPG, PNG, GIF allowed.'); history.back();</script>";
      exit();
    }
  } else {
    $image_file = $_POST['existing_image'];
  }

  $stmt = $conn->prepare("UPDATE material SET title=?, 	details=?, price=?, image_file=? WHERE materialID=?");
  $stmt->bind_param("ssdsi", $title, $details, $price, $image_file, $id);
  $stmt->execute();

  echo "<script>alert('Product updated successfully!'); window.location='admin_dashboard.php';</script>";
  exit();
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM material WHERE materialID=$id");
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Product</title>
  <link rel="stylesheet" href="edit_product.css">
</head>
<body>
  <h2 style="text-align:center;">Edit Product</h2>

  <form action="edit_product.php" method="POST" enctype="multipart/form-data" style="text-align:center;">
    <input type="hidden" name="id" value="<?php echo $product['materialID']; ?>">
    <input type="hidden" name="existing_image" value="<?php echo $product['image_file']; ?>">

    <input type="text" name="title" value="<?php echo htmlspecialchars($product['title']); ?>" required><br><br>
    <textarea name="details" required><?php echo htmlspecialchars($product['details']); ?></textarea><br><br>
    <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required><br><br>

    <p>Current Image:</p>
    <?php if (!empty($product['image_file'])): ?>
      <img src="<?php echo $product['image_file']; ?>" alt="Product Image" width="150"><br><br>
    <?php endif; ?>

    <input type="file" name="image_file" accept="image/*"><br><br>

    <button type="submit">Save Changes</button>
    <a href="admin_dashboard.php">Cancel</a>

  </form>
  <br>
  <footer>
  &copy; (2025) Builder's Corner | Hardware Store Management System
</footer>

</body>
</html>
