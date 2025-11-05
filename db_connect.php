<?php
$servername = getenv("MYSQLHOST") ?: "127.0.0.1";
$username   = getenv("MYSQLUSER") ?: "root";
$password   = getenv("MYSQLPASSWORD") ?: "";
$database   = getenv("MYSQLDATABASE") ?: "hardware_db";
$port       = getenv("MYSQLPORT") ?: 3306;

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?>
