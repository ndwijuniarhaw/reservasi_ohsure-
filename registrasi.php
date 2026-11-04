<?php
require 'function.php';

if( isset($_POST["register"]) ){

    if( registrasi($_POST) > 0 ){
        echo "<script>
                alert('User admin baru berhasil ditambahkan! Silakan login.');
                document.location.href = 'login.php';
              </script>";
    } else {
        echo mysqli_error($conn);
    }

}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin - Ohsure Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-register bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="container" style="max-width: 450px;">
        <div class="form-card shadow-sm p-4 bg-white rounded-4 border-0">
            <h3 class="text-center fw-bold mb-4 text-dark"><i class="bi bi-cup-hot-fill text-warning me-2"></i>Registrasi Admin Ohsure Coffee</h3>

            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Buat username baru" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Buat password" required>
                </div>

                <div class="mb-4">
                    <label for="konfirmasi_password" class="form-label fw-bold">Konfirmasi Password</label>
                    <input type="password" name="konfirmasi_password" class="form-control" placeholder="Ulangi password" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" name="register" class="btn btn-warning text-dark fw-bold py-2">Daftar Sekarang</button>
                    <a href="login.php" class="btn btn-outline-dark py-2">Sudah punya akun? Login</a>
                    <a href="index.php" class="btn btn-light text-muted btn-sm mt-2">← Kembali ke Beranda</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>