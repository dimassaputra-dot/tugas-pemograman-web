<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once '../config/koneksi.php';

if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    $query = "INSERT INTO products (nama_produk, harga, deskripsi) VALUES ('$nama', '$harga', '$deskripsi')";
    if (mysqli_query($koneksi, $query)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Gagal menambah data produk.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - DUEVE</title>
</head>
<body>
    <h2>Tambah Produk Baru</h2>
    <a href="dashboard.php">← Kembali ke Dashboard</a>
    
    <?php if (isset($error)) : ?>
        <p style="color: red;"><?= $error; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <div>
            <label>Nama Produk:</label><br>
            <input type="text" name="nama_produk" required>
        </div>
        <div>
            <label>Harga:</label><br>
            <input type="number" name="harga" required>
        </div>
        <div>
            <label>Deskripsi:</label><br>
            <textarea name="deskripsi" rows="4" required></textarea>
        </div>
        <br>
        <button type="submit" name="tambah">Simpan Produk</button>
    </form>
</body>
</html>