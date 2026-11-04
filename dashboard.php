<?php
session_start();

if( !isset($_SESSION['session_login']) ){
    header('Location: login.php');
    exit;
}

require 'function.php';

// filter area yang diklik dari index.php
$filterArea = isset($_GET["area"]) ? $_GET["area"] : "";

// kata kunci pencarian  
$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";

// Buat kondisi WHERE untuk database
if ($filterArea !== "") {
    $where = "WHERE kategori_area LIKE '%$filterArea%'";
} else {
    $where = "WHERE (nama_pemesan LIKE '%$keyword%' OR kategori_area LIKE '%$keyword%')";
}

// pagination config
$jumlahDataPerHalaman = 5;
$jumlahData = count(query_db("SELECT * FROM menu $where"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = isset($_GET["halaman"]) ? (int) $_GET["halaman"] : 1;
if( $halamanAktif < 1 ) $halamanAktif = 1;

$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

// ambil data reservasi
$menu = query_db("SELECT * FROM menu $where ORDER BY id DESC LIMIT $awalData, $jumlahDataPerHalaman");

// data ringkasan kartu
$totalReservasi = query_db("SELECT COUNT(*) AS total FROM menu")[0]['total'];
$totalIndoor = query_db("SELECT COUNT(*) AS total FROM menu WHERE kategori_area LIKE '%Indoor%'")[0]['total'];
$totalOutdoor = query_db("SELECT COUNT(*) AS total FROM menu WHERE kategori_area LIKE '%Outdoor%'")[0]['total'];
$totalVIP = query_db("SELECT COUNT(*) AS total FROM menu WHERE kategori_area LIKE '%VIP%'")[0]['total'];

$keywordUrl = urlencode($keyword);
$areaUrl = urlencode($filterArea);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ohsure Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar Admin -->
    <nav class="navbar navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="dashboard.php"><i class="bi bi-cup-hot-fill me-2"></i>Admin Ohsure Coffee</a>
            <div class="text-white">
                <i class="bi bi-person-circle me-1"></i><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; ?>
                <a href="index.php" class="btn btn-outline-warning btn-sm ms-3">Lihat Website</a>
                <a href="logout.php" class="btn btn-outline-light btn-sm ms-1" onclick="return confirm('Yakin ingin keluar?')">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Kartu Ringkasan -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3"><a href="dashboard.php" class="text-decoration-none"><div class="card text-bg-dark shadow-sm border-warning h-100"><div class="card-body"><small class="text-light">Total Reservasi</small><h2 class="mb-0 text-warning"><?php echo $totalReservasi; ?></h2></div></div></a></div>
            <div class="col-6 col-md-3"><a href="dashboard.php?area=Indoor" class="text-decoration-none"><div class="card text-bg-warning shadow-sm h-100"><div class="card-body"><small class="text-dark fw-bold">Indoor AC</small><h2 class="mb-0 text-dark"><?php echo $totalIndoor; ?></h2></div></div></a></div>
            <div class="col-6 col-md-3"><a href="dashboard.php?area=Outdoor" class="text-decoration-none"><div class="card text-bg-secondary shadow-sm h-100"><div class="card-body"><small class="text-light">Outdoor</small><h2 class="mb-0 text-white"><?php echo $totalOutdoor; ?></h2></div></div></a></div>
            <div class="col-6 col-md-3"><a href="dashboard.php?area=VIP" class="text-decoration-none"><div class="card text-bg-danger shadow-sm h-100"><div class="card-body"><small class="text-light">VIP Room</small><h2 class="mb-0 text-white"><?php echo $totalVIP; ?></h2></div></div></a></div>
        </div>

        <!-- Alert jika sedang memfilter area khusus dari index -->
        <?php if ($filterArea !== ""): ?>
            <div class="alert alert-warning d-flex justify-content-between align-items-center mb-3 shadow-sm">
                <span>Menampilkan reservasi khusus area: <strong><?php echo $filterArea; ?></strong></span>
                <a href="dashboard.php" class="btn btn-dark btn-sm">Tampilkan Semua Data</a>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Manajemen Reservasi Meja</h3>
            <a href="tambah_data.php" class="btn btn-warning fw-bold text-dark"><i class="bi bi-plus-lg me-1"></i> Tambah Reservasi</a>
        </div>

        <!-- Form Pencarian -->
        <form method="get" class="row g-2 mb-3">
            <div class="col-9 col-md-10">
                <input type="text" name="keyword" class="form-control" placeholder="Cari nama pemesan atau area..." value="<?php echo $keyword; ?>">
            </div>
            <div class="col-3 col-md-2"><button type="submit" class="btn btn-dark w-100">Cari</button></div>
        </form>

        <div class="card shadow-sm mb-4 border-0">
            <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Bukti/Foto</th>
                        <th>Nama Pemesan</th>
                        <th>Area Kafe</th>
                        <th>Jumlah Orang</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1; ?>
                    <?php foreach($menu as $data): ?>
                    <tr>
                        <td><?php echo $nomor; ?></td>
                        <td><img src="img/<?php echo $data['gambar']; ?>" width="60" height="60" class="rounded object-fit-cover shadow-sm" alt=""></td>
                        <td class="fw-bold"><?php echo $data['nama_pemesan']; ?></td>
                        <td><span class="badge bg-warning text-dark"><?php echo $data['kategori_area']; ?></span></td>
                        <td><?php echo $data['jumlah_orang']; ?> Orang</td>
                        <td><?php echo date('d M Y', strtotime($data['tanggal_reservasi'])); ?></td>
                        <td class="text-center">
                            <a href="edit_data.php?id=<?php echo $data['id']; ?>" class="btn btn-warning btn-sm text-dark"><i class="bi bi-pencil"></i></a>
                            <a href="hapus_data.php?id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data reservasi ini?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php $nomor++; ?>
                    <?php endforeach; ?>
                    <?php if( count($menu) === 0 ): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data reservasi ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3">
                <small class="text-muted">Total Data: <?php echo $jumlahData; ?></small>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item <?php if($halamanAktif <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?halaman=<?php echo $halamanAktif - 1; ?>&keyword=<?php echo $keywordUrl; ?>&area=<?php echo $areaUrl; ?>">&larr; Prev</a>
                    </li>
                    <?php for($i = 1; $i <= $jumlahHalaman; $i++): ?>
                    <li class="page-item <?php if($i == $halamanAktif) echo 'active'; ?>">
                        <a class="page-link" href="?halaman=<?php echo $i; ?>&keyword=<?php echo $keywordUrl; ?>&area=<?php echo $areaUrl; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if($halamanAktif >= $jumlahHalaman) echo 'disabled'; ?>">
                        <a class="page-link" href="?halaman=<?php echo $halamanAktif + 1; ?>&keyword=<?php echo $keywordUrl; ?>&area=<?php echo $areaUrl; ?>">Next &rarr;</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>