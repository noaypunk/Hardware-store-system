<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
  header("Location: index.php");
  exit();
}

$id = $_GET['customerID'];
unset($_SESSION['cart'][$id]);

header("Location: cart.php");
exit();
?>
