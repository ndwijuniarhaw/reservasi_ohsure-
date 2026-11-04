CREATE DATABASE IF NOT EXISTS db_ohsure_cafe;
USE db_ohsure_cafe;

-- Tabel User untuk Admin Login & Registrasi
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Tabel Reservasi Meja Cafe (Menu Utama 1)
CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pemesan VARCHAR(100) NOT NULL,
    kategori_area VARCHAR(30) NOT NULL, -- Contoh: Indoor AC, Outdoor, VIP Room
    jumlah_orang INT NOT NULL,
    tanggal_reservasi DATE NOT NULL,
    gambar VARCHAR(255) NOT NULL
);

-- Data Dummy Awal
INSERT INTO menu (nama_pemesan, kategori_area, jumlah_orang, tanggal_reservasi, gambar) VALUES
('Rizky Ananda', 'Indoor AC', 4, '2026-11-10', 'contoh.jpg'),
('Siti Rahma', 'Outdoor', 2, '2026-11-11', 'contoh.jpg'),
('Budi Santoso', 'VIP Room', 6, '2026-11-12', 'contoh.jpg');