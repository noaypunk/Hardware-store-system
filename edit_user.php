<?php
include('db_connect.php');

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM customer WHERE customerID=$id");
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = $_POST['full_name'];
  $mobile = $_POST['mobile'];
  $username = $_POST['username'];
  $user_type = $_POST['user_type'];

  if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE customer SET full_name=?, mobile=?, username=?, password=?, user_type=? WHERE customerID=?");
    $stmt->bind_param("sssssi", $full_name, $mobile, $username, $password, $user_type, $id);
  } else {
    $stmt = $conn->prepare("UPDATE customer SET full_name=?, mobile=?, username=?, user_type=? WHERE customerID=?");
    $stmt->bind_param("ssssi", $full_name, $mobile, $username, $user_type, $id);
  }

  if ($stmt->execute()) {
    echo "<script>alert('User data updated successfully!'); window.location='users.php';</script>";
  } else {
    echo "<script>alert('Error updating user: " . $stmt->error . "');</script>";
  }

  $stmt->close();
  $conn->close();
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
  <h2>------- Edit User -------</h2>
  <form method="POST">
    <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" placeholder="Full Name" required><br>
    <input type="text" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" placeholder="Mobile Number" required><br>
    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="New Password (optional)"><br>
    <select name="user_type" required>
      <option value="Guest" <?php if($user['user_type']=='Guest') echo 'selected'; ?>>Customer</option>
      <option value="Contractor" <?php if($user['user_type']=='Contractor') echo 'selected'; ?>>Contractor</option>
    </select><br>
    <button type="submit">Save Changes</button>
    <a class="btn" href="users.php">Cancel</a>
  </form>
<br><br>
<footer>
  &copy; (2025) Builder's Corner | Hardware Store Management System
</footer>

</body>
</html>