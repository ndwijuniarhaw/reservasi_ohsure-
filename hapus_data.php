<?php
session_start();

if( !isset($_SESSION['session_login']) ){
    header('Location: login.php');
    exit;
}

require 'function.php';

// Ambil id dari URL
$id = $_GET["id"];

// Jalankan fungsi hapus
if( hapus($id) > 0 ) {
    echo "
        <script>
            alert('Data reservasi berhasil dihapus!');
            document.location.href = 'dashboard.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Data reservasi gagal dihapus!');
            document.location.href = 'dashboard.php';
        </script>
    ";
}
?>