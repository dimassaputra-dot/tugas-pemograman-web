<?php
require_once 'config/koneksi.php';

// Ambil data produk dari database
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DUEVE WEARHOUSE</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Font Awesome CDN untuk Ikon Line Minimalis -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Header Melayang -->
    <header>
        <div class="nav-right">
    <!-- Bendera Indonesia + Teks IDR -->
    <div class="currency">
        <img src="https://flagcdn.com/w20/id.png" alt="ID Flag" class="flag-icon">
        <span>IDR</span>
    </div>
    
    <!-- Ikon Search, Cart, & Profile bergaya Line/Outline -->
    <a href="#" class="nav-icon"><i class="fa-solid fa-magnifying-glass"></i></a>
    <a href="#" class="nav-icon"><i class="fa-solid fa-bag-shopping"></i></a>
    <a href="admin/login.php" class="nav-icon"><i class="fa-regular fa-user"></i></a>
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

    