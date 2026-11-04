<?php

// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_ohsure_cafe");

function query_db($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah_data($data) {
    global $conn;

    $nama_pemesan = mysqli_real_escape_string($conn, $data['nama_pemesan']);
    $kategori_area = mysqli_real_escape_string($conn, $data['kategori_area']);
    $jumlah_orang = (int) $data['jumlah_orang'];
    $tanggal_reservasi = mysqli_real_escape_string($conn, $data['tanggal_reservasi']);

    // Upload gambar bukti/pendukung
    $gambar = upload_gambar($nama_pemesan);
    if( !$gambar ){
        return false;
    }

    $query = "INSERT INTO menu(nama_pemesan, kategori_area, jumlah_orang, tanggal_reservasi, gambar)
              VALUES ('$nama_pemesan', '$kategori_area', $jumlah_orang, '$tanggal_reservasi', '$gambar')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function edit_data($data) {
    global $conn;

    $id = (int) $data['id'];
    $nama_pemesan = mysqli_real_escape_string($conn, $data['nama_pemesan']);
    $kategori_area = mysqli_real_escape_string($conn, $data['kategori_area']);
    $jumlah_orang = (int) $data['jumlah_orang'];
    $tanggal_reservasi = mysqli_real_escape_string($conn, $data['tanggal_reservasi']);
    $gambarLama = $data['gambar_lama'];

    if( $_FILES['gambar']['error'] === 4 ){
        $gambar = $gambarLama;
    } else {
        $gambar = upload_gambar($nama_pemesan);
        if( !$gambar ){
            return false;
        }
    }

    $query = "UPDATE menu SET
                nama_pemesan = '$nama_pemesan',
                kategori_area = '$kategori_area',
                jumlah_orang = $jumlah_orang,
                tanggal_reservasi = '$tanggal_reservasi',
                gambar = '$gambar'
              WHERE id = $id";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus_data($id){
    global $conn;
    $id = (int) $id;

    $query = "DELETE FROM menu WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function upload_gambar($nama){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if( $error === 4) {
        echo "<script>alert('Silakan upload gambar/bukti terlebih dahulu!');</script>";
        return false;
    }

    $ekstensiValid = ['jpg', 'png', 'jpeg'];
    
    // PERBAIKAN DI SINI (dipecah menjadi variabel agar tidak notice):
    $ekstensi = explode('.', $namaFile);
    $ekstensi = strtolower(end($ekstensi));

    if( !in_array($ekstensi, $ekstensiValid) ){
        echo "<script>alert('Format file harus jpg, png, atau jpeg!');</script>";
        return false;
    }

    if( $ukuranFile > 5000000 ){
        echo "<script>alert('Ukuran file terlalu besar (maks 5MB)!');</script>";
        return false;
    }

    $namaBaru = str_replace(' ', '_', strtolower($nama)) . "_" . time() . '.' . $ekstensi;
    move_uploaded_file($tmpName, 'img/' . $namaBaru);

    return $namaBaru;
}

function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $konfirmasi = mysqli_real_escape_string($conn, $data["konfirmasi_password"]);

    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if( mysqli_fetch_assoc($result) ){
        echo "<script>alert('Username sudah terdaftar!');</script>";
        return false;
    }

    if( $password !== $konfirmasi ){
        echo "<script>alert('Konfirmasi password tidak sesuai!');</script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO user(username, password) VALUES('$username', '$password')");
    return mysqli_affected_rows($conn);
}

function hapus($id) {
    global $conn;
    
    // Mengambil nama file gambar agar bisa ikut terhapus dari folder img/
    $result = mysqli_query($conn, "SELECT gambar FROM menu WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    if ($row && file_exists('img/' . $row['gambar'])) {
        unlink('img/' . $row['gambar']);
    }

    // Menghapus data dari database
    mysqli_query($conn, "DELETE FROM menu WHERE id = $id");

    return mysqli_affected_rows($conn);
}
?>