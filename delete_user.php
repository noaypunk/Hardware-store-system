<?php
include('db_connect.php');

$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id=$id");

echo "<script>alert('🗑️ User deleted successfully!'); window.location='users.php';</script>";
exit();
?>
