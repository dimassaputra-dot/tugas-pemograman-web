<?php
session_start();
include 'config/koneksi.php';

$sudah_login = isset($_SESSION['username']) || isset($_SESSION['login']);
$nama_user   = $_SESSION['nama_lengkap'] ?? $_SESSION['username'] ?? 'Member';
$role_user   = $_SESSION['role'] ?? 'user';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Saya - DUEVE Wearhouse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #111;
        }

        /* Navbar Utama */
        .navbar {
            background: #fff;
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eaeaea;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-left-group {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .menu-trigger {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #111;
            padding: 4px;
        }
        .navbar a.brand {
            font-size: 22px;
            font-weight: 900;
            letter-spacing: 1px;
            color: #d90429;
            text-decoration: none;
        }
        .nav-right-group {
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .nav-right-group a {
            color: #111;
            text-decoration: none;
            font-size: 16px;
        }

        /* Sidebar Menu Samping ala Preface (Home & Shop) */
        .side-drawer {
            position: fixed;
            top: 0;
            left: -340px;
            width: 320px;
            height: 100vh;
            background: #fff;
            box-shadow: 4px 0 20px rgba(0,0,0,0.12);
            z-index: 999;
            transition: left 0.3s ease;
            padding: 24px 30px;
            box-sizing: border-box;
        }
        .side-drawer.open {
            left: 0;
        }
        .drawer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }
        .drawer-close {
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: #111;
        }
        .drawer-links {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }
        .drawer-links a {
            text-decoration: none;
            color: #111;
            font-size: 17px;
            font-weight: 500;
            transition: color 0.2s;
        }
        .drawer-links a:hover {
            color: #d90429;
        }
        .drawer-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.35);
            z-index: 998;
        }
        .drawer-overlay.show {
            display: block;
        }

        /* Container Konten */
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .page-header h1 {
            font-size: 26px;
            margin: 0;
        }
        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 24px 28px;
            margin-bottom: 20px;
        }
        .auth-banner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .auth-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .btn-outline-red {
            padding: 10px 22px;
            border: 1px solid #e63946;
            color: #e63946;
            background: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
        .btn-solid-red {
            padding: 10px 22px;
            border: 1px solid #e63946;
            color: #fff;
            background: #e63946;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
        .btn-dark {
            padding: 10px 22px;
            background: #111;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- Overlay & Menu Samping (Home & Shop) -->
<div class="drawer-overlay" id="drawerOverlay" onclick="toggleDrawer()"></div>
<div class="side-drawer" id="sideDrawer">
    <div class="drawer-header">
        <a href="products.php" style="color: #111; font-size: 18px;"><i class="fa-solid fa-magnifying-glass"></i></a>
        <button class="drawer-close" onclick="toggleDrawer()">&times;</button>
    </div>
    <div class="drawer-links">
        <a href="index.php">Home</a>
        <a href="products.php">Shop</a>
        <?php if ($sudah_login && $role_user === 'admin') : ?>
            <a href="admin/dashboard.php">Dashboard Admin</a>
        <?php endif; ?>
    </div>
</div>

<!-- Navbar Atas -->
<nav class="navbar">
    <div class="nav-left-group">
        <button class="menu-trigger" onclick="toggleDrawer()" title="Menu">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <a href="index.php" class="brand">DUEVE</a>

    <div class="nav-right-group">
        <a href="products.php" title="Cari Produk"><i class="fa-solid fa-magnifying-glass"></i></a>
        <a href="products.php" title="Belanja"><i class="fa-solid fa-bag-shopping"></i></a>
        <a href="account.php" title="Akun Saya"><i class="fa-regular fa-user"></i></a>
    </div>
</nav>

<div class="container">
    <?php if (!$sudah_login) : ?>
        <div class="page-header">
            <h1>Akun Saya</h1>
        </div>

        <div class="card auth-banner">
            <div>
                <h3 style="margin: 0 0 6px;">Nikmati Diskon Spesial dan Pantau Pesanan Kamu</h3>
                <p style="margin: 0; color: #6b7280; font-size: 14px;">Masuk atau daftar akun baru untuk mulai berbelanja di DUEVE Wearhouse.</p>
            </div>
            <div class="auth-buttons">
                <a href="admin/login.php" class="btn-outline-red">Login</a>
                <a href="register.php" class="btn-solid-red">Daftar</a>
            </div>
        </div>

    <?php else : ?>
        <div class="page-header">
            <h1>Hai, <?= htmlspecialchars($nama_user); ?></h1>
            <div class="auth-buttons">
                <a href="index.php" class="btn-dark">Ke Home</a>
                <a href="products.php" class="btn-solid-red">Ke Shop</a>
                <?php if ($role_user === 'admin') : ?>
                    <a href="admin/dashboard.php" class="btn-dark">Dashboard Admin</a>
                <?php endif; ?>
                <a href="admin/logout.php" class="btn-outline-red">Logout</a>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-top: 0;">Navigasi Cepat</h3>
            <p style="color: #555; font-size: 14px; margin-bottom: 18px;">
                Selamat datang kembali, <strong><?= htmlspecialchars($nama_user); ?></strong>! Silakan pilih halaman tujuan Anda:
            </p>
            <div class="auth-buttons">
                <a href="index.php" class="btn-dark">Beranda (Home)</a>
                <a href="products.php" class="btn-solid-red">Katalog Produk (Shop)</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function toggleDrawer() {
    document.getElementById('sideDrawer').classList.toggle('open');
    document.getElementById('drawerOverlay').classList.toggle('show');
}
</script>

</body>
</html>