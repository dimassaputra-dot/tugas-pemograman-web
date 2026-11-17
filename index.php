<?php
require_once 'config/koneksi.php';

$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DUEVE WEARHOUSE</title>
    <link rel="stylesheet" href="css/style.css?v=2">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>


    <header>
    <div class="nav-left">
        <div class="currency">
            <img src="https://flagcdn.com/w20/id.png" alt="ID Flag" class="flag-icon">
            <span>IDR</span>
        </div>
    </div>

    <div class="logo">
    </div>


    <div class="nav-right">
        <a href="#" class="nav-icon"><i class="fa-solid fa-magnifying-glass"></i></a>
        <a href="#" class="nav-icon"><i class="fa-solid fa-bag-shopping"></i></a>
        <a href="account.php" class="nav-icon" title="Akun Saya"><i class="fa-regular fa-user"></i></a>
    </div>>
</header>

    <div class="slider-container">
        <div class="slide active">
            <img src="img/banner1.jpg?v=1" alt="Collection 1">
            <div class="slide-content">
                <div class="slide-title">CH18 - AFTER CLASS</div>
                <a href="products.php" class="btn-shop">SHOP NOW</a>
            </div>
        </div>

        <div class="slide">
            <img src="img/banner2.jpg?v=1" alt="Collection 2">
            <div class="slide-content">
                <div class="slide-title">ESSENTIAL MODERN APPAREL</div>
                <a href="products.php" class="btn-shop">SHOP NOW</a>
            </div>
        </div>

        <div class="slide">
            <img src="img/banner3.jpg?v=1" alt="Collection 3">
            <div class="slide-content">
                <div class="slide-title">NEW SEASON 2026</div>
                <a href="products.php" class="btn-shop">SHOP NOW</a>
            </div>
        </div>
        
        <!-- Tombol Panah Kiri & Kanan -->
        <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
        <a class="next" onclick="changeSlide(1)">&#10095;</a>
    </div>

    <!-- Katalog Produk -->
<section class="catalog-container" id="catalogue">
    <h2 style="text-align: center; margin-bottom: 30px;">SEMUA PRODUK</h2>
    
    <div class="product-grid">
        <?php
        require_once 'config/koneksi.php';
        $query = mysqli_query($koneksi, "SELECT * FROM products ORDER BY id DESC");
        
        if (mysqli_num_rows($query) > 0) :
            while ($p = mysqli_fetch_assoc($query)) :
                // Jika kolom gambar di database kosong, gunakan gambar default
                $gambar = !empty($p['gambar']) ? $p['gambar'] : 'banner1.jpg';
        ?>
        <a href="product_detail.php?id=<?= $p['id']; ?>" style="text-decoration: none; color: inherit; display: block;">
            <div class="product-card">
                <div class="img-box">
                    <img src="assets/uploads/<?= $gambar; ?>" alt="<?= $p['nama_produk']; ?>">
                </div>
                <h3><?= strtoupper($p['nama_produk']); ?></h3>
                <p class="price">Rp <?= number_format($p['harga'] * 1000, 0, ',', '.'); ?></p>

                <?php if ($p['stok'] > 0) : ?>
                    <span class="badge">STOK TERSEDIA</span>
                <?php else : ?>
                    <span class="badge" style="background-color: #e74c3c;">STOK HABIS</span>
                <?php endif; ?>
            </div>
        </a>
    <?php
            endwhile;
        else :
        ?>
            <p style="text-align: center; width: 100%;">Belum ada produk yang ditambahkan.</p>
        <?php endif; ?>
    </div>
</section>

<script src="js/script.js"></script>