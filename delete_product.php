<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
  header("Location: index.php");
  exit();
}

$id = $_GET['id'];
$conn->query("DELETE FROM products WHERE id=$id");

echo "<script>alert('🗑️ Product deleted successfully!'); window.location='admin_dashboard.php';</script>";
?>
