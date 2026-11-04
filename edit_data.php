<?php
session_start();

if( !isset($_SESSION['session_login']) ){
    header('Location: login.php');
    exit;
}

require 'function.php';

if( !isset($_GET['id']) ){
    header("Location: dashboard.php");
    exit;
}

$id = (int) $_GET['id'];
$hasil = query_db("SELECT * FROM menu WHERE id = $id");

if( count($hasil) === 0 ){
    header("Location: dashboard.php");
    exit;
}
$reservasi = $hasil[0];

if( isset($_POST["submit"]) ){
    if( edit_data($_POST) > 0 ){
        echo "<script>
                alert('Data reservasi berhasil diubah!');
                document.location.href = 'dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal diubah atau tidak ada perubahan!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Reservasi - Ohsure Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-form bg-light">

<div class="container py-5">
    <div class="form-card mx-auto shadow-sm p-4 bg-white rounded-4" style="max-width: 550px;">
        <h3 class="fw-bold mb-4 text-center">Ubah Data Reservasi</h3>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $reservasi["id"]; ?>">
            <input type="hidden" name="gambar_lama" value="<?php echo $reservasi["gambar"]; ?>">

            <div class="mb-3">
                <label for="nama_pemesan" class="form-label fw-bold">Nama Pemesan</label>
                <input type="text" name="nama_pemesan" id="nama_pemesan" class="form-control" value="<?php echo htmlspecialchars($reservasi["nama_pemesan"]); ?>" required>
            </div>

            <div class="mb-3">
                <label for="kategori_area" class="form-label fw-bold">Pilihan Area Kafe</label>
                <select name="kategori_area" id="kategori_area" class="form-select" required>
                    <?php foreach(['Indoor AC', 'Outdoor', 'VIP Room'] as $k): ?>
                        <option value="<?php echo $k; ?>" <?php if($reservasi["kategori_area"] == $k) echo "selected"; ?>>
                            <?php echo $k; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="jumlah_orang" class="form-label fw-bold">Jumlah Orang</label>
                <input type="number" name="jumlah_orang" id="jumlah_orang" class="form-control" value="<?php echo $reservasi["jumlah_orang"]; ?>" min="1" required>
            </div>

            <div class="mb-3">
                <label for="tanggal_reservasi" class="form-label fw-bold">Tanggal Reservasi</label>
                <input type="date" name="tanggal_reservasi" id="tanggal_reservasi" class="form-control" value="<?php echo $reservasi["tanggal_reservasi"]; ?>" required>
            </div>

            <div class="mb-4">
                <label for="gambar" class="form-label fw-bold">Foto / Bukti (Kosongkan jika tidak diganti)</label>
                <input type="file" name="gambar" id="gambar" class="form-control mb-2">
                <img src="img/<?php echo $reservasi["gambar"]; ?>" alt="Preview" width="80" height="80" class="rounded object-fit-cover shadow-sm">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" name="submit" class="btn btn-warning text-dark fw-bold w-100">Ubah Data</button>
                <a href="dashboard.php" class="btn btn-secondary w-100">Kembali</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>