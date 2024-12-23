<!-- 
 Title: functions
 Created by: Orlando Caetano
 Date: 07/10/2024 
 Updated: 15/10/2025
 Discription: This file was taken from the homepage.html to provide consistent structure across different pages of the SurfSphere website. 
              It includes dynamic title functionality for different pages and a navigation bar with links to the Home, About, and Login pages. 
              The page also includes a search form that allows users to search for other members.
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->

<?php

// Set a default title if no specific title is provided
$pageTitle = isset($pageTitle) ? $pageTitle : "SurfSphere";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../resources/CSS/styles.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
</head>

<body class="d-flex flex-column min-vh-100">
        <header>
            <!-- Navigation Bar -->
            <nav class="navbar navbar-expand-sm bg-light">
                <div class="container-fluid">
                    <!-- Logo -->
                    <a class="navbar-brand" href="#">
                        <img src="../resources/images/logo.png" alt="SurfSphere Logo" class="logo-image">
                    </a>
            <h1 class="navbar-brand"><span>S</span>urf<span>S</span>phere</h1>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Collapsible Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['roleName']) && $_SESSION['roleName'] === 'admin'): ?>
                    <!-- Show links for Admin user -->
                    <li class="nav-item">
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" style="font-size: 28px;" href="../public/logout.php">Logout</a> 
                        </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" style="font-size: 28px;" href="../public/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" style="font-size: 28px;" href="../public/about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" style="font-size: 28px;" href="../public/login.php">Login</a>
                    </li>
                    <?php endif; ?>
                    
                    <!-- Search form for user profile search -->
                    <li class="nav-item">
                        <form class="form-inline d-flex ms-4" action="../public/search.php" method="GET">
                            <input type="text" name="query" placeholder="Search..." class="form-control search-bar me-2">
                            <button class="btn btn-primary search-button" type="submit">Search</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
        