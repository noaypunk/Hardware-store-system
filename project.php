<?php
session_start();
include 'db_connect.php';

$message = "";

// Handle project creation
if (isset($_POST['add_project'])) {
    $project_name = $_POST['project_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];
    $customer_id = $_POST['customer_id'];

    $sql = "INSERT INTO project (ProjectName, StartDate, EndDate, Status, CustomerID)
            VALUES ('$project_name', '$start_date', '$end_date', '$status', '$customer_id')";

    if ($conn->query($sql) === TRUE) {
        $message = "<div class='alert alert-success'>Project added successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: ".$conn->error."</div>";
    }
}

// Fetch customers for dropdown
$customers = $conn->query("SELECT customerID, full_name FROM customer ORDER BY full_name ASC");

// Fetch existing projects
$projects = $conn->query("SELECT p.*, c.full_name FROM project p
                          LEFT JOIN customer c ON p.CustomerID = c.customerID
                          ORDER BY p.ProjectID DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Projects</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container">
    <h2>Manage Projects</h2>
    <?php echo $message; ?>

    <form method="POST" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="project_name" class="form-control" placeholder="Project Name" required>
            </div>
            <div class="col-md-2">
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select" required>
                    <option value="Pending">Pending</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="customer_id" class="form-select" required>
                    <option value="">Select Customer</option>
                    <?php while($c = $customers->fetch_assoc()): ?>
                        <option value="<?= $c['customerID'] ?>"><?= htmlspecialchars($c['full_name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" name="add_project" class="btn btn-success">Add Project</button>
        </div>
    </form>

    <h4>Existing Projects</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Project Name</th>
                <th>Customer</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while($p = $projects->fetch_assoc()): ?>
                <tr>
                    <td><?= $p['ProjectID'] ?></td>
                    <td><?= htmlspecialchars($p['ProjectName']) ?></td>
                    <td><?= htmlspecialchars($p['full_name']) ?></td>
                    <td><?= $p['StartDate'] ?></td>
                    <td><?= $p['EndDate'] ?></td>
                    <td><?= $p['Status'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
