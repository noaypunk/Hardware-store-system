<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
  header("Location: index.php");
  exit();
}

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Users</title>
  <link rel="stylesheet" href="user_crud.css">
</head>
<body>
  <h2>👥 User Management</h2>
  <a href="add_user.php" class="btn">➕ Add User</a>
  <a href="index.php" class="btn">🏠 Back to Home</a>

  <table>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Email</th>
      <th>User Type</th>
      <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['username']); ?></td>
        <td><?php echo htmlspecialchars($row['mobile']); ?></td>
        <td><?php echo htmlspecialchars($row['user_type']); ?></td>
        <td>
          <a href="edit_user.php?id=<?php echo $row['id']; ?>">✏️ Edit</a> |
          <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this user?')">🗑️ Delete</a>
        </td>
      </tr>
    <?php } ?>
  </table>
</body>
</html>
