<?php
session_start();
include('db_connect.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Builder's Corner</title>
  

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


  <style>
      body {
          font-family: 'Poppins', sans-serif;
          display: flex;
          flex-direction: column;
          min-height: 100vh;
      }
      .navbar-brand {
          font-weight: 600;
          color: #0078d7 !important;
      }
      .nav-link {
          font-weight: 500;
      }
      .hero-section {
          background: #f8f9fa;
          flex: 1; 
          display: flex;
          align-items: center;
          justify-content: center;
          text-align: center;
      }
      footer {
          background-color: #343a40;
          color: white;
          padding: 15px 0;
          text-align: center;
          margin-top: auto;
      }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="index.php">Builder's Corner</a>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="gallery.php">Shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contactUs.html">Contact Us</a>
          </li>
          

          <?php if(isset($_SESSION['username'])): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="logout.php">Sign Out</a></li>
                </ul>
            </li>
          <?php else: ?>
            <li class="nav-item">
                <a class="nav-link text-primary fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#accountModal">
                    My Account
                </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="hero-section">
      <div class="container">
          <h1 class="display-4">Welcome to Builder's Corner</h1>
          <p class="lead">Your one-stop shop for all hardware needs.</p>
          <a href="gallery.php" class="btn btn-primary btn-lg mt-3">Browse Shop</a>
      </div>
  </div>

  <?php include('account_modal.php'); ?>

  <footer>
     &copy; 2025 Builder's Corner | Hardware Store Management System
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>