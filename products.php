<?php
require_once 'config/koneksi.php';
$query = mysqli_query($koneksi, "SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Produk - DUEVE</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <header class="navbar">
        <div class="nav-left" style="flex: 1;">&nbsp;</div>
        <div class="logo" style="flex: 1; text-align: center;">
            <a href="index.php"><h1>DUEVE</h1></a>
        </div>
        <div class="nav-right" style="flex: 1; display: flex; justify-content: flex-end; gap: 15px;">
            <a href="index.php"><i class="fas fa-home"></i></a>
            <a href="admin/login.php"><i class="fas fa-user"></i></a>
        </div>
    </header>

    <main class="products-page">
        <div class="products-header">
            <h2>Semua Produk</h2>
        </div>

        <div class="product-grid">
        <?php
            if (mysqli_num_rows($query) > 0) :
                while ($p = mysqli_fetch_assoc($query)) :
                    $gambar = !empty($p['gambar']) ? $p['gambar'] : 'banner1.jpg';
        ?>
            <a href="product_detail.php?id=<?= $p['id']; ?>" style="text-decoration: none; color: inherit; display: block;">
                <div class="product-card">
                    <div class="img-box">
                        <img src="assets/uploads/<?= $gambar; ?>" alt="<?= $p['nama_produk']; ?>">
                    </div>
                    <h3><?= strtoupper($p['nama_produk']); ?></h3>
                    <p class="price">Rp <?= number_format($p['harga'] * (strlen($p['harga']) <= 3 ? 1000 : 1), 0, ',', '.'); ?></p>

                    <?php if ($p['stok'] > 0) : ?>
                        <span class="badge">STOK TERSEDIA</span>
                    <?php else : ?>
                        <span class="badge badge-empty">STOK HABIS</span>
                    <?php endif; ?>
                </div>
            </a>
        <?php
                endwhile;
            else :
        ?>
            <p class="no-data">Belum ada produk yang tersedia.</p>
        <?php endif; ?>
        </div>
    </main>

</body>
</html>