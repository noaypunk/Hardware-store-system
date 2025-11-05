<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>⚙️ Admin Dashboard | Builder's Corner</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>

  <header>
    <h1>⚙️ Builder's Corner — Admin Dashboard</h1>
    <p class="welcome">Welcome, <?php echo $_SESSION['username']; ?> | <a href="logout.php">Logout</a></p>
  </header>
  
  <button class="user-manage" type="submit"><a href="users.php">Manage users</a></button>

  <div class="dashboard-container">
    <div class="card">
<p>Track user and sales performance (Coming Soon).</p>
    </div>
  </div>

  <form action="add_product.php" method="POST" enctype="multipart/form-data">
    <h2>🛠 Add New Product</h2>
    <input type="text" name="title" placeholder="Product Name" required>
    <input type="text" name="description" placeholder="Description" required>
    <input type="number" name="price" placeholder="Price" required>
    <input type="file" name="image_file" accept="image/*" required>
    <button type="submit">Add Product</button>
  </form>

  <h2>📦 Manage Products</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Product</th>
      <th>Description</th>
      <th>Price</th>
      <th>Image</th>
      <th>Actions</th>
    </tr>

    <?php
    $result = $conn->query("SELECT * FROM products");
    while($row = $result->fetch_assoc()) {
      echo "
      <tr>
        <td>{$row['id']}</td>
        <td>{$row['title']}</td>
        <td>{$row['description']}</td>
        <td>₱{$row['price']}</td>
        <td><img src='{$row['image_file']}' width='80' style='border-radius:6px;'></td>
        <td>
          <a href='edit_product.php?id={$row['id']}'>✏️ Edit</a> |
          <a href='delete_product.php?id={$row['id']}'>🗑 Delete</a>
        </td>
      </tr>
      ";
    }
    ?>
  </table>

  <footer>
    © 2025 Builder’s Corner | Futuristic Admin Panel
  </footer>
</body>
</html>
