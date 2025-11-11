<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = $_POST['full_name'];
  $mobile = $_POST['mobile'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $user_type = $_POST['user_type'];

  $stmt = $conn->prepare("INSERT INTO customer (full_name, mobile, username, password, user_type) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $full_name, $mobile, $username, $password, $user_type);

  if ($stmt->execute()) {
    echo "<script>alert('New Customer added successfully!'); window.location='users.php';</script>";
  } else {
    echo "<script>alert('Error: " . $stmt->error . "');</script>";
  }

  $stmt->close();
  $conn->close();
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add User</title>
  <link rel="stylesheet" href="user_crud.css">
</head>
<body>
  <h2>------- Add Customer -------</h2>
  <form method="POST">
    <input type="text" name="full_name" placeholder="Full Name" required><br>
    <input type="text" name="mobile" placeholder="Mobile Number" required><br>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="user_type" required>
      <option value="Guest">Register as</option>
      <option value="Guest">Customer</option>
      <option value="Contractor">Contractor</option>
    </select><br>

    <button type="submit"> Add User</button>
    <a class="btn" href="users.php">Cancel</a>
  </form>

  <br><br>
<footer>
  &copy; (2025) Builder's Corner | Hardware Store Management System
</footer>

</body>
</html>
