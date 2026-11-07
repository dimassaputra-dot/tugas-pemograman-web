<?php
require_once 'config/koneksi.php';

// Ambil data produk dari database
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DUEVE WEARHOUSE</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Header Melayang -->
    <header>
        <div class="nav-left">
            <span>&#9776;</span>
        </div>
        
        <div class="logo">DUEVE</div>

        <div class="nav-right">
            <span>IDR</span>
            <a href="#">🔍</a>
            <a href="#">🛍️</a>
            <a href="admin/login.php">👤</a>
        </div>
    </header>

    <!-- Slider Fullscreen -->
    <div class="slider-container">
        <div class="slide active">
            <img src="img/banner1.jpg" alt="Collection 1">
            <div class="slide-content">
                <div class="slide-title">CH18 - AFTER CLASS</div>
                <a href="#catalogue" class="btn-shop">SHOP NOW</a>
            </div>
        </div>
        </div>

        <div class="slide">
            <img src="img/banner2.jpg" alt="Collection 2">
            <div class="slide-content">
                <div class="slide-title">ESSENTIAL MODERN APPAREL</div>
                <a href="#catalogue" class="btn-shop">EXPLORE</a>
            </div>
        </div>

        <div class="slide">
            <img src="img/banner3.jpg" alt="Collection 3">
            <div class="slide-content">
                <div class="slide-title">NEW SEASON 2026</div>
                <a href="#catalogue" class="btn-shop">VIEW MORE</a>
            </div>
        </div>

        <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
        <a class="next" onclick="changeSlide(1)">&#10095;</a>
    </div>

    <!-- Katalog Produk -->
    <section class="catalog-container" id="catalogue">
        <!-- isi katalog -->
    </section>

    <script src="js/script.js"></script>
</body>
</html>

    