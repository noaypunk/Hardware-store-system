<?php
session_start();
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {

    $full_name = trim($_POST['full_name']);
    $mobile = trim($_POST['mobile']);
    $user_type = trim($_POST['user_type']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($full_name) || empty($mobile) || empty($user_type) || empty($username) || empty($password)) {
        echo "<script>alert('Please fill in all fields.'); window.location='index.php';</script>";
        exit();
    }

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $checkUser = $conn->prepare("SELECT username FROM customer WHERE username = ?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists! Please try a different one.'); window.location='index.php';</script>";
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO customer (full_name, mobile, user_type, username, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $full_name, $mobile, $user_type, $username, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Registration successful! You can now log in.'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('❌ Registration failed. Please try again.'); window.location='index.php';</script>";
    }

    $stmt->close();
    $checkUser->close();
    $conn->close();
}
?>
