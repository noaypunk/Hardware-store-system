<?php
include 'db_connect.php';

$search = $_GET['search'] ?? '';

$stmt = $conn->prepare("SELECT * FROM material WHERE title LIKE ?");
if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$param = "%$search%";
$stmt->bind_param("s", $param);
$stmt->execute();
$result = $stmt->get_result();

$output = "<table class='table table-bordered'><tr>
<th>Name</th><th>Price</th><th>Image</th></tr>";

while ($row = $result->fetch_assoc()) {
    $output .= "<tr>
        <td>{$row['title']}</td>
        <td>₱{$row['price']}</td>
        <td><img src='uploads/{$row['image_file']}' width='60'></td>
    </tr>";
}

$output .= "</table>";

echo $output;
?>
