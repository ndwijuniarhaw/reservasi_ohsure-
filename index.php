<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ohsure Coffee - Reservasi Meja & Area</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="index.php"><i class="bi bi-cup-hot-fill me-2"></i>Ohsure Coffee</a>
            <div>
                <?php if (isset($_SESSION['session_login'])): ?>
                    <a href="dashboard.php" class="btn btn-warning btn-sm me-2 fw-bold text-dark">Dashboard Admin</a>
                    <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-warning btn-sm me-2 fw-bold text-dark">Login Admin</a>
                    <a href="registrasi.php" class="btn btn-outline-light btn-sm">Registrasi</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container my-5">
        <div class="row align-items-center py-4">
            <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3 text-dark">Welcome to Ohsure Coffee</h1>
                <p class="lead text-muted mb-4">
                    Yes we have a coffee | Jam Operational 10.00 - 00.00 WIB.
                </p>
                <?php if (isset($_SESSION['session_login'])): ?>
                    <a href="dashboard.php" class="btn btn-warning btn-lg px-4 text-dark fw-bold shadow-sm"><i class="bi bi-speedometer2 me-2"></i>Buka Dashboard</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-warning btn-lg px-4 me-2 text-dark fw-bold shadow-sm"><i class="bi bi-box-arrow-in-right me-2"></i>Login Admin</a>
                    <a href="registrasi.php" class="btn btn-outline-dark btn-lg px-4 shadow-sm"><i class="bi bi-person-plus me-2"></i>Daftar Akun</a>
                <?php endif; ?>
            </div>
            
            <!-- Card Area Favorit Interaktif -->
<div class="col-lg-6">
    <div class="card shadow-lg border-0 rounded-4 p-4 bg-white">
        <h4 class="fw-bold mb-2 text-center">Area Favorit Kafe</h4>
        <p class="text-muted small text-center mb-4">Pilih area favoritmu! (Klik untuk melihat data reservasi area terkait)</p>
        
        <div class="d-flex justify-content-center gap-2 flex-wrap">
            <a href="dashboard.php?area=Indoor AC" class="btn btn-warning text-dark fw-bold px-3 py-2 shadow-sm">
                <i class="bi bi-house-door-fill me-1"></i> Indoor AC Area
            </a>
            <a href="dashboard.php?area=Outdoor" class="btn btn-dark text-white px-3 py-2 shadow-sm">
                <i class="bi bi-tree-fill me-1"></i> Outdoor Spot
            </a>
            <a href="dashboard.php?area=VIP Room" class="btn btn-secondary text-white px-3 py-2 shadow-sm">
                <i class="bi bi-star-fill me-1"></i> VIP Room
            </a>
        </div>
    </div>
</div>

        <!-- Section Galeri Foto & Menu PDF -->
        <div class="row mt-5 pt-4">
            <div class="col-12 text-center mb-4">
                <h2 class="fw-bold">Area & Menu</h2>
                <p class="text-muted">Area dan daftar menu lengkap Ohsure Coffee</p>
            </div>
            
            <!-- Foto 1: Indoor -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <img src="img/indoor.jpeg" height="220" class="w-100 object-fit-cover" alt="Indoor Area">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">Indoor AC Area</h5>
                        <p class="text-muted small mb-0">Super cozy & quiet AC area dengan colokan & sofa empuk. Low-key perfect buat nugas, deep work, atau WFH.</p>
                    </div>
                </div>
            </div>

            <!-- Foto 2: Outdoor -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <img src="img/outdoor.jpeg" height="220" class="w-100 object-fit-cover" alt="Outdoor Area">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">Outdoor Spot</h5>
                        <p class="text-muted small mb-0">Open-air chill spot dengan aesthetic evening view. Warm vibe yang pas banget buat catch up bareng bestie & unwinding.</p>
                    </div>
                </div>
            </div>

            <!-- Foto 3: Menu & Tombol PDF -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <img src="img/menu.jpeg" height="220" class="w-100 object-fit-cover" alt="Menu Ohsure">
                    <div class="card-body text-center bg-white">
                        <h5 class="fw-bold">Our Menu Ohsure</h5>
                        <p class="text-muted small mb-3">Literally your daily mood booster. Tap tombol di bawah buat liat full menu and find your go-to order!.</p>
                        <a href="img/menu.pdf" target="_blank" class="btn btn-warning text-dark fw-bold btn-sm w-100 shadow-sm">
                            <i class="bi bi-file-earmark-pdf-fill me-1"></i> Lihat Menu & harga
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 bg-dark text-white-50 mt-5">
        <small>&copy; 2026 Ohsure! Coffee | Purwakarta Kec. Bungursari Cikopo.</small>
    </footer>

</body>
</html>