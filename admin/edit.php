<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$id    = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = mysqli_query($koneksi, "SELECT * FROM products WHERE id = $id");
$data  = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['update'])) {
    $nama      = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga     = (int) str_replace('.', '', $_POST['harga']);
    $stok      = (int) $_POST['stok'];
    $ukuran    = mysqli_real_escape_string($koneksi, $_POST['ukuran']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $gambar    = mysqli_real_escape_string($koneksi, $_POST['gambar_lama']);

    if (!empty($_FILES['gambar_baru']['name'])) {
        $gambar = $_FILES['gambar_baru']['name'];
        move_uploaded_file($_FILES['gambar_baru']['tmp_name'], '../assets/uploads/' . $gambar);
    }

    $sql = "UPDATE products SET 
            nama_produk = '$nama', 
            harga = '$harga', 
            stok = '$stok', 
            ukuran = '$ukuran', 
            deskripsi = '$deskripsi', 
            gambar = '$gambar' 
            WHERE id = $id";

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
    <title>Edit Produk - DUEVE</title>
    <style>
        body { font-family: sans-serif; padding: 30px; background: #f8f9fa; }
        .form-box { max-width: 480px; margin: auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        label { display: block; font-weight: bold; margin: 14px 0 6px; font-size: 14px; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 9px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { margin-top: 20px; width: 100%; padding: 11px; background: #111; color: #fff; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; }
        button:hover { background: #333; }
    </style>
</head>
<body>
<div class="form-box">
    <h2>Edit Produk</h2>
    <a href="dashboard.php" style="text-decoration: none; color: #555; font-size: 14px;">← Batal</a>

    <form method="POST" enctype="multipart/form-data">
        <label>Nama Produk:</label>
        <input type="text" name="nama_produk" value="<?= htmlspecialchars($data['nama_produk']); ?>" required>

        <label>Harga (contoh: 450 atau 450000):</label>
        <input type="text" name="harga" value="<?= $data['harga']; ?>" required>

        <label>Stok:</label>
        <input type="number" name="stok" value="<?= $data['stok']; ?>" required>

        <label>Ukuran / Size (pisahkan dengan koma, misal: S, M, L, XL):</label>
        <input type="text" name="ukuran" value="<?= htmlspecialchars($data['ukuran'] ?? 'S, M, L, XL'); ?>" required>

        <label>Deskripsi:</label>
        <textarea name="deskripsi" rows="4"><?= htmlspecialchars($data['deskripsi']); ?></textarea>

        <label>Nama File Gambar Saat Ini:</label>
        <input type="text" name="gambar_lama" value="<?= htmlspecialchars($data['gambar']); ?>">

        <label>Atau Upload Gambar Baru (Opsional):</label>
        <input type="file" name="gambar_baru">

        <button type="submit" name="update">Update Produk</button>
    </form>
</div>
</body>
</html>