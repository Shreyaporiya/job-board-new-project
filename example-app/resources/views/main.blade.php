<?php
$baseUrl = '/Shreya/CRUD/public/index.php?';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Admin Dashboard' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    @vite(['resources/css/login.css'])
    <style>
        
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <h4 class="text-white ps-2  "> Admin panel </h4>
        <div class="sidebar-sticky">
            <ul class="nav flex-column pt-4">
                <li class="nav-item">
                    <a class="nav-link" href="/message">
                        <i class="fa-solid fa-globe me-2"></i>
                        Countries
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/contact">
                        <i class="fa-solid fa-map me-2"></i>
                        States
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/Shreya/CRUD/public/index.php?url=City/index">
                        <i class="bi bi-building me-2"></i>
                        Cities
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/login">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main content -->
    <main class="main-content">
        
    </main>
</body>
</html> 



