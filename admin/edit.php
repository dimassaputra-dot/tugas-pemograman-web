<?php
include '../config/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM products WHERE id='$id'");
$data = mysqli_fetch_array($query);

if (isset($_POST['update'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
    $deskripsi   = $_POST['deskripsi'];
    $gambar      = $_POST['gambar'];

    $update = mysqli_query($koneksi, "UPDATE products SET 
        nama_produk='$nama_produk', 
        harga='$harga', 
        stok='$stok', 
        deskripsi='$deskripsi', 
        gambar='$gambar' 
        WHERE id='$id'");

    if ($update) {
        header("Location: dashboard.php");
    } else {
        echo "Gagal update data!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk - DUEVE</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea { width: 300px; padding: 8px; }
    </style>
</head>
<body>
    <h2>Edit Produk</h2>
    <a href="dashboard.php">&larr; Batal</a><br><br>

    <form action="" method="POST">
        <div class="form-group">
            <label>Nama Produk:</label>
            <input type="text" name="nama_produk" value="<?= $data['nama_produk']; ?>" required>
        </div>

        <div class="form-group">
            <label>Harga:</label>
            <input type="number" name="harga" value="<?= $data['harga']; ?>" required>
        </div>

        <div class="form-group">
            <label>Stok:</label>
            <input type="number" name="stok" value="<?= $data['stok']; ?>" required>
        </div>

        <div class="form-group">
            <label>Deskripsi:</label>
            <textarea name="deskripsi" rows="4"><?= $data['deskripsi']; ?></textarea>
        </div>

        <div class="form-group">
            <label>Nama File Gambar (misal: hoodie-black.jpg):</label>
            <input type="text" name="gambar" value="<?= $data['gambar']; ?>" placeholder="nama-file.jpg" required>
        </div>

        <button type="submit" name="update">Update Produk</button>
    </form>
</body>
</html>