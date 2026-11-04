<?php
session_start();

if( !isset($_SESSION['session_login']) ){
    header('Location: login.php');
    exit;
}

require 'function.php';

if( isset($_POST['submit']) ){
    if( tambah_data($_POST) > 0 ){
        echo "<script>
                alert('Reservasi berhasil ditambahkan!');
                document.location.href = 'dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan reservasi!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Reservasi - Ohsure Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-form bg-light">

<div class="container py-5">
    <div class="form-card mx-auto shadow-sm p-4 bg-white rounded-4" style="max-width: 550px;">
        <h3 class="fw-bold mb-4 text-center">Tambah Data Reservasi</h3>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_pemesan" class="form-label fw-bold">Nama Pemesan</label>
                <input type="text" name="nama_pemesan" id="nama_pemesan" class="form-control" placeholder="Contoh: Rian Utama" required>
            </div>

            <div class="mb-3">
                <label for="kategori_area" class="form-label fw-bold">Pilihan Area Kafe</label>
                <select name="kategori_area" id="kategori_area" class="form-select" required>
                    <option value="">-- Pilih Area --</option>
                    <option value="Indoor AC">Indoor AC Area</option>
                    <option value="Outdoor">Outdoor Spot</option>
                    <option value="VIP Room">VIP Room</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="jumlah_orang" class="form-label fw-bold">Jumlah Orang</label>
                <input type="number" name="jumlah_orang" id="jumlah_orang" class="form-control" placeholder="Contoh: 4" min="1" required>
            </div>

            <div class="mb-3">
                <label for="tanggal_reservasi" class="form-label fw-bold">Tanggal Reservasi</label>
                <input type="date" name="tanggal_reservasi" id="tanggal_reservasi" class="form-control" required>
            </div>

            <div class="mb-4">
                <label for="gambar" class="form-label fw-bold">Upload Foto / Bukti</label>
                <input type="file" name="gambar" id="gambar" class="form-control" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" name="submit" class="btn btn-warning text-dark fw-bold w-100">Simpan Reservasi</button>
                <a href="dashboard.php" class="btn btn-secondary w-100">Kembali</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>