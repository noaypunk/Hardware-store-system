<?php
session_start();
include('db_connect.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM customer WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($password === $user['password'] || password_verify($password, $user['password'])) {
            
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['user_id'] = $user['customerID'];

            if ($user['user_type'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }

        } else {
            echo "<script>alert('Invalid password'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('User not found'); window.location.href='index.php';</script>";
    }
}
?>
