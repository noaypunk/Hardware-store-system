<?php
session_start();
include('db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Builder's Corner</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
</head>

<body>
  <nav>
    <a href="#" id="accountBtn">
      <?php echo isset($_SESSION['username']) ? "": "My Account"; ?>
    </a>
    <a href="index.php" class="active">Home</a>
    <a href="gallery.php">Shop</a>
    <a href="contactUs.html">Contact Us</a>
    <?php if(isset($_SESSION['username'])): ?>
      <a href="logout.php"> <?php echo "Sign out ".$_SESSION['username']; ?> </a>
    <?php endif; ?>
  </nav>

    <?php include('account_modal.php'); ?>

<footer>
   &copy; (2025) Builder's Corner | Hardware Store Management System
</footer>
  
  <script src="index.js"></script>
</body>
</html>
