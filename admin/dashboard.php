<?php
session_start();
include '../config/koneksi.php';

// Ambil semua data produk dari database
$result = mysqli_query($koneksi, "SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - DUEVE Store</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn-tambah { background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; }
        .btn-edit { background: #ffc107; color: black; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-hapus { background: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-logout { background: #6c757d; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px; float: right; }
    </style>
</head>
<body>

    <a href="logout.php" class="btn-logout">Logout</a>
    <h2>Dashboard Panel Admin - DUEVE Store</h2>
    <br>
    <a href="tambah.php" class="btn-tambah">+ Tambah Produk Baru</a>
    <br><br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Gambar</th>
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
                <td><?= $row['stok']; ?></td>
                <td><?= htmlspecialchars($row['gambar']); ?></td>
                <td><?= htmlspecialchars($row['deskripsi']); ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn-edit">Edit</a>
                    <a href="hapus.php?id=<?= $row['id']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                </td>
            </tr>
            <?php 
                endwhile;
            else : 
            ?>
            <tr>
                <td colspan="7" style="text-align: center;">Belum ada produk.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>