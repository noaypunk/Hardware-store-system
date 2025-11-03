<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: index.php");
  exit();
}

$id = $_GET['id'];
unset($_SESSION['cart'][$id]);

header("Location: cart.php");
exit();
?>
