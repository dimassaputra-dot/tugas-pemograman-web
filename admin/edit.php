<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once '../config/koneksi.php';

$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM products WHERE id = '$id'");
$data = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    $query = "UPDATE products SET nama_produk='$nama', harga='$harga', deskripsi='$deskripsi' WHERE id='$id'";
    if (mysqli_query($koneksi, $query)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Gagal memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk - DUEVE</title>
</head>
<body>
    <h2>Edit Produk</h2>
    <a href="dashboard.php">← Batal</a>

    <?php if (isset($error)) : ?>
        <p style="color: red;"><?= $error; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <div>
            <label>Nama Produk:</label><br>
            <input type="text" name="nama_produk" value="<?= htmlspecialchars($data['nama_produk']); ?>" required>
        </div>
        <div>
            <label>Harga:</label><br>
            <input type="number" name="harga" value="<?= htmlspecialchars($data['harga']); ?>" required>
        </div>
        <div>
            <label>Deskripsi:</label><br>
            <textarea name="deskripsi" rows="4" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>
        </div>
        <br>
        <button type="submit" name="update">Update Produk</button>
    </form>
</body>
</html>