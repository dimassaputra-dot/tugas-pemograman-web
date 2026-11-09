<?php
include '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
    $deskripsi   = $_POST['deskripsi'];
    $gambar      = $_POST['gambar'];

    $simpan = mysqli_query($koneksi, "INSERT INTO products (nama_produk, harga, stok, deskripsi, gambar) 
        VALUES ('$nama_produk', '$harga', '$stok', '$deskripsi', '$gambar')");

    if ($simpan) {
        header("Location: dashboard.php");
    } else {
        echo "Gagal tambah data!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk Baru - DUEVE</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea { width: 300px; padding: 8px; }
    </style>
</head>
<body>
    <h2>Tambah Produk Baru</h2>
    <a href="dashboard.php">&larr; Batal</a><br><br>

    <form action="" method="POST">
        <div class="form-group">
            <label>Nama Produk:</label>
            <input type="text" name="nama_produk" required>
        </div>

        <div class="form-group">
            <label>Harga:</label>
            <input type="number" name="harga" required>
        </div>

        <div class="form-group">
            <label>Stok:</label>
            <input type="number" name="stok" value="10" required>
        </div>

        <div class="form-group">
            <label>Deskripsi:</label>
            <textarea name="deskripsi" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label>Nama File Gambar (misal: hoodie-black.jpg):</label>
            <input type="text" name="gambar" placeholder="contoh: hoodie.jpg" required>
        </div>

        <button type="submit" name="simpan">Simpan Produk</button>
    </form>
</body>
</html>