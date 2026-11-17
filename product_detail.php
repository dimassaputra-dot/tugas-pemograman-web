<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'config/koneksi.php';

// Otomatis deteksi variabel koneksi ($koneksi atau $conn)
$db = $koneksi ?? ($conn ?? null);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = mysqli_query($db, "SELECT * FROM products WHERE id = $id");
$produk = mysqli_fetch_assoc($query);

if (!$produk) {
    header("Location: products.php");
    exit;
}

$harga_tampil  = ($produk['harga'] < 10000) ? $produk['harga'] * 1000 : $produk['harga'];
$gambar        = !empty($produk['gambar']) ? $produk['gambar'] : 'banner1.jpg';
$ukuran_str    = !empty($produk['ukuran']) ? $produk['ukuran'] : 'S, M, L, XL';
$daftar_ukuran = array_map('trim', explode(',', $ukuran_str));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produk['nama_produk']); ?> - DUEVE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background: #fff; color: #111; }
        .navbar { padding: 18px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; }
        .navbar a.brand { font-size: 24px; font-weight: 900; color: #d90429; text-decoration: none; letter-spacing: 1px; }
        .nav-icons { display: flex; gap: 18px; font-size: 18px; }
        .nav-icons a { color: #111; text-decoration: none; }

        .detail-container { max-width: 1120px; margin: 45px auto; padding: 0 24px; display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: start; }
        .product-image img { width: 100%; border-radius: 8px; object-fit: cover; background: #f5f5f5; }

        .badges { display: flex; gap: 8px; margin-bottom: 14px; }
        .badge-dark { background: #111; color: #fff; font-size: 11px; font-weight: 600; padding: 5px 10px; border-radius: 4px; }
        .badge-red { background: #e63946; color: #fff; font-size: 11px; font-weight: 600; padding: 5px 10px; border-radius: 4px; }

        .product-title { font-size: 26px; font-weight: 800; margin: 0 0 8px; text-transform: uppercase; }
        .product-price { font-size: 20px; font-weight: 600; margin: 0 0 22px; color: #222; }

        .stock-box { border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px 18px; margin-bottom: 22px; }
        .stock-box strong { display: block; font-size: 13px; margin-bottom: 4px; }
        .stock-row { display: flex; justify-content: space-between; font-size: 13px; color: #666; }

        .label-section { display: block; font-size: 13px; font-weight: 600; margin-bottom: 10px; }
        .size-options { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 22px; }
        .size-radio { display: none; }
        .size-label { padding: 10px 22px; border: 1px solid #d1d5db; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: 0.2s; }
        .size-radio:checked + .size-label { background: #111; color: #fff; border-color: #111; }

        .qty-box { display: inline-flex; align-items: center; border: 1px solid #d1d5db; border-radius: 6px; overflow: hidden; margin-bottom: 26px; }
        .qty-btn { width: 38px; height: 38px; border: none; background: #fff; font-size: 16px; cursor: pointer; }
        .qty-input { width: 46px; height: 38px; border: none; text-align: center; font-weight: 600; font-size: 14px; outline: none; }

        .btn-buy { width: 100%; padding: 15px; background: #111; color: #fff; border: none; border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; transition: 0.2s; }
        .btn-buy:hover { background: #333; }
        .btn-buy:disabled { background: #9ca3af; cursor: not-allowed; }
        .desc-text { margin-top: 24px; font-size: 14px; color: #555; line-height: 1.6; border-top: 1px solid #eee; padding-top: 18px; }

        @media (max-width: 768px) { .detail-container { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="products.php" style="text-decoration: none; color: #111; font-size: 14px;">← Semua Produk</a>
    <a href="index.php" class="brand">DUEVE</a>
    <div class="nav-icons">
        <a href="index.php"><i class="fas fa-home"></i></a>
        <a href="admin/login.php"><i class="far fa-user"></i></a>
    </div>
</nav>

<div class="detail-container">
    <div class="product-image">
        <img src="assets/uploads/<?= htmlspecialchars($gambar); ?>" alt="<?= htmlspecialchars($produk['nama_produk']); ?>">
    </div>

    <div>
        <div class="badges">
            <span class="badge-dark"><?= ($produk['stok'] > 0) ? 'Stok Tersedia' : 'Stok Habis'; ?></span>
            <span class="badge-red">DUEVE Collection</span>
        </div>

        <h1 class="product-title"><?= htmlspecialchars($produk['nama_produk']); ?></h1>
        <p class="product-price">Rp <?= number_format($harga_tampil, 0, ',', '.'); ?></p>

        <div class="stock-box">
            <strong>Informasi Jumlah</strong>
            <div class="stock-row">
                <span>Jumlah Maksimal:</span>
                <strong style="color: #111;"><?= $produk['stok']; ?></strong>
            </div>
        </div>

        <form method="GET" action="checkout.php">
            <input type="hidden" name="id" value="<?= $produk['id']; ?>">

            <?php if (!empty($produk['ukuran']) && $produk['ukuran'] !== '-') : ?>
                <span class="label-section">Ukuran</span>
                <div class="size-options">
                    <?php foreach ($daftar_ukuran as $idx => $sz) : ?>
                        <input type="radio" name="ukuran" id="sz_<?= $idx; ?>" value="<?= htmlspecialchars($sz); ?>" class="size-radio" <?= ($idx === 0) ? 'checked' : ''; ?> required>
                        <label for="sz_<?= $idx; ?>" class="size-label"><?= htmlspecialchars($sz); ?></label>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <input type="hidden" name="ukuran" value="All Size">
            <?php endif; ?>

            <span class="label-section">Jumlah</span>
            <div class="qty-box">
                <button type="button" class="qty-btn" onclick="ubahQty(-1)">−</button>
                <input type="number" name="jumlah" id="qtyInput" value="1" min="1" max="<?= max(1, $produk['stok']); ?>" class="qty-input" readonly>
                <button type="button" class="qty-btn" onclick="ubahQty(1)">+</button>
            </div>

            <?php if ($produk['stok'] > 0) : ?>
                <button type="submit" class="btn-buy">Beli Sekarang</button>
            <?php else : ?>
                <button type="button" class="btn-buy" disabled>Stok Habis</button>
            <?php endif; ?>
        </form>

        <?php if (!empty($produk['deskripsi'])) : ?>
            <div class="desc-text"><?= nl2br(htmlspecialchars($produk['deskripsi'])); ?></div>
        <?php endif; ?>
    </div>
</div>

<script>
const maxStok = <?= max(1, (int)$produk['stok']); ?>;
function ubahQty(delta) {
    const input = document.getElementById('qtyInput');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > maxStok) val = maxStok;
    input.value = val;
}
</script>

</body>
</html>