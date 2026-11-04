<?php
session_start();

// Hapus semua variabel session
$_SESSION = [];
session_unset();
session_destroy();

// Arahkan kembali ke halaman utama Ohsure Coffee
header("Location: index.php");
exit;
?>