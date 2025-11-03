<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $user_type = $_POST['user_type'];

  $stmt = $conn->prepare("INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $username, $email, $password, $user_type);
  $stmt->execute();

  echo "<script>alert('✅ User added successfully!'); window.location='users.php';</script>";
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
  <h2>➕ Add User</h2>
  <form method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="user_type" required>
      <option value="customer">Customer</option>
      <option value="admin">Admin</option>
    </select><br>
    <button type="submit">💾 Save</button>
    <a href="users.php">Cancel</a>
  </form>
</body>
</html>
