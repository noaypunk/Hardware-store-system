<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT full_name, mobile, user_type, username FROM customer WHERE customerID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $full_name = trim($_POST['full_name']);
    $mobile = trim($_POST['mobile']);
    $user_type = trim($_POST['user_type']);
    $username = trim($_POST['username']);
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($full_name) || empty($mobile) || empty($user_type) || empty($username)) {
        echo "<script>alert('Please fill in all required fields.');</script>";
    } elseif (!empty($new_password) && $new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        $stmt = $conn->prepare("SELECT customerID FROM customer WHERE username = ? AND customerID != ?");
        $stmt->bind_param("si", $username, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo "<script>alert('Username already taken by another user.');</script>";
        } else {
            if (!empty($new_password)) {
                $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE customer SET full_name=?, mobile=?, user_type=?, username=?, password=? WHERE customerID=?");
                $stmt->bind_param("sssssi", $full_name, $mobile, $user_type, $username, $hashedPassword, $user_id);
            } else {
                $stmt = $conn->prepare("UPDATE customer SET full_name=?, mobile=?, user_type=?, username=? WHERE customerID=?");
                $stmt->bind_param("ssssi", $full_name, $mobile, $user_type, $username, $user_id);
            }

            if ($stmt->execute()) {
                echo "<script>alert('Profile updated successfully!'); window.location='myProfile.php';</script>";
                exit();
            } else {
                echo "<script>alert('Failed to update profile.');</script>";
            }
            $stmt->close();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Builder's Corner - My Profile</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body { 
    background-color: #e5f0ff; 
    font-family: 'Poppins', sans-serif;
}
.profile-container { 
    max-width: 800px; 
    margin: 50px auto; 
    background: #fff; 
    padding: 30px; 
    border-radius: 10px; 
    box-shadow: 0 8px 25px rgba(0,0,0,0.1); 
}
.profile-header { 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    margin-bottom: 25px; 
    border-bottom: 1px solid #dee2e6; 
    padding-bottom: 10px;
}
.profile-field { 
    margin-bottom: 20px; 
}
.profile-label { 
    font-weight: 600; 
    color: #1e3a8a; 
}
.profile-value { 
    font-size: 1.1em; 
    color: #0f172a;
    padding: 10px; 
    background-color: #f0f5ff; 
    border-radius: 5px; 
    border: 1px solid #c7d2fe;
}
.btn-edit { float: right; }
.modal-header .btn-close { margin: -1rem -1rem -1rem auto; }
.navbar-brand i { margin-right: 8px; color: #1e3a8a; }
.navbar-nav .nav-link { color: #1e3a8a; font-weight: 500; }
.navbar-nav .nav-link:hover { color: #3b82f6; }
.btn-primary { background-color: #3b82f6; border-color: #3b82f6; }
.btn-primary:hover { background-color: #2563eb; border-color: #2563eb; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fa-solid fa-hammer"></i> Builder's Corner
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="gallery.php">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="contactUs.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="myProfile.php">My Profile</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="profile-container">
    <div class="profile-header">
        <h3>My Profile</h3>
        <button class="btn btn-primary btn-edit" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
    </div>

    <div class="profile-field">
        <span class="profile-label">Full Name:</span>
        <div class="profile-value"><?php echo htmlspecialchars($user['full_name']); ?></div>
    </div>

    <div class="profile-field">
        <span class="profile-label">Mobile Number:</span>
        <div class="profile-value"><?php echo htmlspecialchars($user['mobile']); ?></div>
    </div>

    <div class="profile-field">
        <span class="profile-label">User Type:</span>
        <div class="profile-value"><?php echo htmlspecialchars($user['user_type']); ?></div>
    </div>

    <div class="profile-field">
        <span class="profile-label">Username:</span>
        <div class="profile-value"><?php echo htmlspecialchars($user['username']); ?></div>
    </div>
</div>

<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="update_profile" value="1">

                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control mb-2" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>

                    <label class="form-label">Mobile Number</label>
                    <input type="text" name="mobile" class="form-control mb-2" value="<?php echo htmlspecialchars($user['mobile']); ?>" required>

                    <label class="form-label">User Type</label>
                    <select name="user_type" class="form-select mb-2" required>
                        <option value="Customer" <?php echo ($user['user_type']=='Customer')?'selected':''; ?>>Customer</option>
                        <option value="Contractor" <?php echo ($user['user_type']=='Contractor')?'selected':''; ?>>Contractor</option>
                    </select>

                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control mb-2" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control mb-2" placeholder="Enter new password (leave blank to keep current)">

                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control mb-2" placeholder="Confirm new password">
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update_profile" class="btn btn-primary w-100">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
