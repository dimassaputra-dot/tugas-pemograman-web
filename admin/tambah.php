<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $nama      = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga     = (int) str_replace('.', '', $_POST['harga']);
    $stok      = (int) $_POST['stok'];
    $ukuran    = mysqli_real_escape_string($koneksi, $_POST['ukuran']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $gambar    = 'banner1.jpg';

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], '../assets/uploads/' . $gambar);
    }

    $sql = "INSERT INTO products (nama_produk, harga, stok, ukuran, deskripsi, gambar) 
            VALUES ('$nama', '$harga', '$stok', '$ukuran', '$deskripsi', '$gambar')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - DUEVE</title>
    <style>
        body { font-family: sans-serif; padding: 30px; background: #f8f9fa; }
        .form-box { max-width: 480px; margin: auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        label { display: block; font-weight: bold; margin: 14px 0 6px; font-size: 14px; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 9px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { margin-top: 20px; width: 100%; padding: 11px; background: #28a745; color: #fff; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>
<div class="form-box">
    <h2>Tambah Produk Baru</h2>
    <a href="dashboard.php" style="text-decoration: none; color: #555; font-size: 14px;">← Batal</a>

    <form method="POST" enctype="multipart/form-data">
        <label>Nama Produk:</label>
        <input type="text" name="nama_produk" placeholder="Contoh: DUEVE JACKET" required>

        <label>Harga (contoh: 450 atau 450000):</label>
        <input type="text" name="harga" placeholder="450" required>

        <label>Stok:</label>
        <input type="number" name="stok" value="10" required>

        <label>Ukuran / Size (pisahkan dengan koma):</label>
        <input type="text" name="ukuran" value="S, M, L, XL" required>

        <label>Deskripsi:</label>
        <textarea name="deskripsi" rows="4" placeholder="Deskripsi singkat produk..."></textarea>

        <label>Foto Produk:</label>
        <input type="file" name="gambar" required>

        <button type="submit" name="simpan">Simpan Produk</button>
    </form>
</div>
</body>
</html>