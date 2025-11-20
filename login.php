<?php
session_start();
include 'db_connect.php';

if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM customer WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];

        if ($password === $stored_password) {
            loginSuccess($row);
        } 
        elseif (password_verify($password, $stored_password)) {
            loginSuccess($row);
        } 
        else {
            echo "<script>alert('Invalid Password!'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Username not found!'); window.location.href='index.php';</script>";
    }
}

function loginSuccess($userRow) {
    $_SESSION['user_id'] = $userRow['customerID'];
    $_SESSION['username'] = $userRow['username'];
    $_SESSION['user_type'] = $userRow['user_type'];

    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
  header("Location: admin_dashboard.php");
  exit();
}
else{
    echo "<script>alert('Login Successful!'); window.location.href='gallery.php';</script>";
    exit();
    }
}
?>