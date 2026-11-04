<?php
session_start();

require 'function.php';

// kalau sudah login, langsung ke dashboard
if( isset($_SESSION['session_login']) ){
    header('Location: dashboard.php');
    exit;
}

if( isset($_POST['login']) ){

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // cek username
    if( mysqli_num_rows($result) === 1 ){

        // cek password
        $row = mysqli_fetch_assoc($result);
        if( password_verify($password, $row['password']) ){
            // set session
            $_SESSION['session_login'] = true;
            $_SESSION['username'] = $row['username'];

            header('Location: dashboard.php');
            exit;
        } else {
            echo "<script>
                alert('Password yang kamu masukkan salah!');
                </script>";
        }
    } else {
        echo "<script>
            alert('Username yang kamu masukkan salah atau tidak ditemukan!');
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Ohsure Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-register bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="container" style="max-width: 450px;">
        <div class="form-card shadow-sm p-4 bg-white rounded-4 border-0">
            <h3 class="text-center fw-bold mb-4 text-dark"><i class="bi bi-cup-hot-fill text-warning me-2"></i>Login Admin Ohsure Coffee</h3>

            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username admin" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" name="login" class="btn btn-warning text-dark fw-bold py-2">Login</button>
                    <a href="registrasi.php" class="btn btn-outline-dark py-2">Belum punya akun? Registrasi</a>
                    <a href="index.php" class="btn btn-light text-muted btn-sm mt-2">← Kembali ke Beranda</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html> 