<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once '../config/koneksi.php';

// Ambil semua data produk dari database
$result = mysqli_query($koneksi, "SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - DUEVE Store</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 4px; color: white; display: inline-block; }
        .btn-tambah { background-color: #28a745; margin-bottom: 10px; }
        .btn-edit { background-color: #ffc107; color: black; }
        .btn-hapus { background-color: #dc3545; }
        .btn-logout { background-color: #6c757d; float: right; }
    </style>
</head>
<body>
    <h2>Dashboard Panel Admin - DUEVE Store</h2>
    <a href="logout.php" class="btn btn-logout">Logout</a>
    <a href="tambah.php" class="btn btn-tambah">+ Tambah Produk Baru</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if (mysqli_num_rows($result) > 0) :
                while ($row = mysqli_fetch_assoc($result)) : 
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']); ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                    </td>
                </tr>
            <?php 
                endwhile;
            else : 
            ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada data produk.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>