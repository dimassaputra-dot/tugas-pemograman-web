<?php
require_once 'config/koneksi.php';
$query = mysqli_query($koneksi, "SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DUEVE | Official Store</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Helvetica Neue', Arial, sans-serif; }
        body { background-color: #ffffff; color: #111111; padding: 20px 40px; }
        header { display: flex; justify-content: space-between; align-items: center; padding: 20px 0; border-bottom: 1px solid #eeeeee; }
        .logo { font-size: 26px; font-weight: 900; letter-spacing: 4px; text-transform: uppercase; }
        nav a { text-decoration: none; color: #111111; margin-left: 25px; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        .hero { margin: 40px 0; text-align: center; background: #f8f8f8; padding: 70px 20px; border-radius: 4px; }
        .hero h1 { font-size: 40px; letter-spacing: 5px; margin-bottom: 10px; font-weight: 800; }
        .hero p { font-size: 14px; letter-spacing: 2px; color: #666; text-transform: uppercase; }
        .catalog-title { font-size: 20px; letter-spacing: 2px; margin-bottom: 25px; border-left: 4px solid #111; padding-left: 10px; }
        .catalog { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 30px; }
        .card { border: 1px solid #efefef; padding: 15px; text-align: center; transition: 0.3s; }
        .card:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
        .card img { width: 100%; height: 320px; object-fit: cover; }
        .card h3 { font-size: 15px; margin: 15px 0 5px; letter-spacing: 1px; text-transform: uppercase; }
        .card p { font-size: 14px; font-weight: bold; color: #333; }
    </style>
</head>
<body>

    <header>
        <div class="logo">DUEVE</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="#shop">Shop</a>
            <a href="admin/login.php">Admin Login</a>
        </nav>
    </header>

    <section class="hero">
        <h1>DUEVE WEARHOUSE</h1>
        <p>Essential Modern Apparel 2026</p>
    </section>

    <main id="shop">
        <h2 class="catalog-title">CATALOGUE</h2>
        <div class="catalog">
            <?php if (mysqli_num_rows($query) > 0) : ?>
                <?php while($row = mysqli_fetch_assoc($query)) : ?>
                    <div class="card">
                        <img src="assets/uploads/<?= $row['gambar']; ?>" alt="<?= $row['nama_produk']; ?>">
                        <h3><?= htmlspecialchars($row['nama_produk']); ?></h3>
                        <p>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p style="grid-column: 1/-1; text-align:center; color:#888;">Belum ada produk yang diunggah.</p>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>