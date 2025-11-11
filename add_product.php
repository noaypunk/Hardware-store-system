<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $details = $_POST['details'];
    $price = $_POST['price'];
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image_file"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
         
            $stmt = $conn->prepare("INSERT INTO material (title, details, price, image_file) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssds", $title, $details, $price, $target_file);
            $stmt->execute();
            echo "<script>alert('Product added successfully!'); window.location='admin_dashboard.php';</script>";
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
