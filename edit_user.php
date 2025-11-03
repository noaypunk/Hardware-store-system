<?php
include('db_connect.php');

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $user_type = $_POST['user_type'];

  if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET username=?, email=?, password=?, user_type=? WHERE id=?");
    $stmt->bind_param("ssssi", $username, $email, $password, $user_type, $id);
  } else {
    $stmt = $conn->prepare("UPDATE users SET username=?, email=?, user_type=? WHERE id=?");
    $stmt->bind_param("sssi", $username, $email, $user_type, $id);
  }
  $stmt->execute();

  echo "<script>alert('✅ User updated successfully!'); window.location='users.php';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit User</title>
  <link rel="stylesheet" href="user_crud.css">
</head>
<body>
  <h2>✏️ Edit User</h2>
  <form method="POST">
    <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
    <input type="password" name="password" placeholder="New password (optional)"><br>
    <select name="user_type">
      <option value="customer" <?php if($user['user_type']=='customer') echo 'selected'; ?>>Customer</option>
      <option value="admin" <?php if($user['user_type']=='admin') echo 'selected'; ?>>Admin</option>
    </select><br>
    <button type="submit">💾 Save Changes</button>
    <a href="users.php">Cancel</a>
  </form>
</body>
</html>
