<?php
session_start();
require_once 'config/koneksi.php';

$id     = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['product_id'] ?? 0);
$ukuran = isset($_GET['ukuran']) ? $_GET['ukuran'] : ($_POST['ukuran'] ?? 'All Size');
$jumlah = isset($_GET['jumlah']) ? (int)$_GET['jumlah'] : (int)($_POST['jumlah'] ?? 1);

$query  = mysqli_query($koneksi, "SELECT * FROM products WHERE id = $id");
$produk = mysqli_fetch_assoc($query);

if (!$produk) {
    header("Location: products.php");
    exit;
}

$harga_satuan = ($produk['harga'] < 10000) ? $produk['harga'] * 1000 : $produk['harga'];
$subtotal     = $harga_satuan * $jumlah;
$gambar       = !empty($produk['gambar']) ? $produk['gambar'] : 'banner1.jpg';
$sukses       = false;
$error_msg    = "";

if (isset($_POST['pesan_sekarang'])) {
    $user_id           = $_SESSION['id_user'] ?? 0;
    $email_penerima    = mysqli_real_escape_string($koneksi, $_POST['email_penerima']);
    $nama_penerima     = mysqli_real_escape_string($koneksi, $_POST['nama_penerima']);
    $no_hp             = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $kota_kecamatan    = mysqli_real_escape_string($koneksi, $_POST['kota_kecamatan']);
    $alamat_lengkap    = mysqli_real_escape_string($koneksi, $_POST['alamat_lengkap']);
    $kode_pos          = mysqli_real_escape_string($koneksi, $_POST['kode_pos']);
    $catatan           = mysqli_real_escape_string($koneksi, $_POST['catatan']);
    $kurir             = mysqli_real_escape_string($koneksi, $_POST['kurir']);
    $metode_pembayaran = mysqli_real_escape_string($koneksi, $_POST['metode_pembayaran']);
    $ukuran_post       = mysqli_real_escape_string($koneksi, $_POST['ukuran']);
    $jumlah_post       = (int)$_POST['jumlah'];

    $ongkir = 15000;
    if ($kurir === 'JNE Express') $ongkir = 20000;
    if ($kurir === 'Instant / Same Day') $ongkir = 35000;

    $total_bayar = ($harga_satuan * $jumlah_post) + $ongkir;

    if ($jumlah_post > $produk['stok']) {
        $error_msg = "Maaf, stok produk tidak mencukupi.";
    } else {
        $sql = "INSERT INTO orders (user_id, product_id, ukuran, jumlah, total_harga, nama_penerima, no_hp, email_penerima, kota_kecamatan, alamat_lengkap, kode_pos, catatan, kurir, ongkir, metode_pembayaran) 
                VALUES ('$user_id', '$id', '$ukuran_post', '$jumlah_post', '$total_bayar', '$nama_penerima', '$no_hp', '$email_penerima', '$kota_kecamatan', '$alamat_lengkap', '$kode_pos', '$catatan', '$kurir', '$ongkir', '$metode_pembayaran')";

        if (mysqli_query($koneksi, $sql)) {
            $stok_baru = $produk['stok'] - $jumlah_post;
            mysqli_query($koneksi, "UPDATE products SET stok = $stok_baru WHERE id = $id");
            $sukses = true;
        } else {
            $error_msg = "Gagal menyimpan pesanan: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - DUEVE Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background: #fafafa; color: #111; }
        .navbar { background: #fff; padding: 18px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; }
        .navbar a.brand { font-size: 24px; font-weight: 900; color: #d90429; text-decoration: none; letter-spacing: 1px; }

        .checkout-container { max-width: 1120px; margin: 35px auto; padding: 0 24px; display: grid; grid-template-columns: 1.35fr 0.85fr; gap: 36px; align-items: start; }
        .card { background: #fff; border: 1px solid #ebebeb; border-radius: 10px; padding: 26px; margin-bottom: 22px; }
        .card h3 { margin: 0 0 18px; font-size: 18px; font-weight: 700; }

        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-size: 13px; color: #555; margin-bottom: 6px; font-weight: 500; }
        .form-control { width: 100%; padding: 12px 14px; border: 1px solid #dcdcdc; border-radius: 8px; font-size: 14px; outline: none; }
        .form-control:focus { border-color: #111; }
        textarea.form-control { resize: vertical; min-height: 85px; }
        .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        .item-summary { display: flex; gap: 14px; align-items: center; padding-bottom: 18px; border-bottom: 1px solid #eee; margin-bottom: 16px; }
        .item-summary img { width: 64px; height: 78px; object-fit: cover; border-radius: 6px; background: #f3f3f3; }
        .item-info { flex: 1; }
        .item-info h4 { margin: 0 0 4px; font-size: 14px; text-transform: uppercase; }
        .item-info span { font-size: 13px; color: #666; display: block; }
        .item-price { font-weight: 600; font-size: 14px; }

        .price-row { display: flex; justify-content: space-between; font-size: 14px; color: #555; margin-bottom: 10px; }
        .price-total { display: flex; justify-content: space-between; font-size: 17px; font-weight: 700; color: #111; border-top: 1px solid #eee; padding-top: 14px; margin-top: 10px; }

        .btn-order { width: 100%; padding: 15px; background: #111; color: #fff; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; margin-top: 18px; }
        .btn-order:hover { background: #333; }
        .note-tax { font-size: 12px; color: #777; text-align: center; background: #f5f5f5; padding: 10px; border-radius: 6px; margin-top: 12px; }
        .success-box { max-width: 560px; margin: 70px auto; background: #fff; padding: 40px; border-radius: 12px; text-align: center; border: 1px solid #e5e7eb; }
        .success-box i { font-size: 52px; color: #16a34a; margin-bottom: 16px; }

        @media (max-width: 820px) { .checkout-container { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="product_detail.php?id=<?= $id; ?>" style="text-decoration: none; color: #111; font-size: 14px;">← Kembali ke Produk</a>
    <a href="index.php" class="brand">DUEVE</a>
    <span style="font-size: 13px; color: #666;"><i class="fa-solid fa-lock"></i> Checkout Aman</span>
</nav>

<?php if ($sukses) : ?>
    <div class="success-box">
        <i class="fa-solid fa-circle-check"></i>
        <h2>Pesanan Berhasil Dibuat!</h2>
        <p style="color: #555; line-height: 1.6;">
            Terima kasih <strong><?= htmlspecialchars($nama_penerima); ?></strong>, pesanan kamu untuk <strong><?= htmlspecialchars($produk['nama_produk']); ?></strong> (Size: <?= htmlspecialchars($ukuran_post); ?>, <?= $jumlah_post; ?> pcs) sedang diproses.
        </p>
        <div style="background: #f9fafb; padding: 16px; border-radius: 8px; margin: 20px 0; text-align: left; font-size: 14px; line-height: 1.8;">
            <strong>Alamat Pengiriman:</strong><br>
            <?= htmlspecialchars($alamat_lengkap); ?>, <?= htmlspecialchars($kota_kecamatan); ?> (<?= htmlspecialchars($kode_pos); ?>)<br>
            <strong>Kurir:</strong> <?= htmlspecialchars($kurir); ?><br>
            <strong>Metode Pembayaran:</strong> <?= htmlspecialchars($metode_pembayaran); ?><br>
            <strong>Total Pembayaran:</strong> Rp <?= number_format($total_bayar, 0, ',', '.'); ?>
        </div>
        <a href="products.php" style="display: inline-block; padding: 12px 26px; background: #111; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 600;">Lanjut Belanja</a>
    </div>
<?php else : ?>

<form method="POST" action="">
    <input type="hidden" name="product_id" value="<?= $id; ?>">
    <input type="hidden" name="ukuran" value="<?= htmlspecialchars($ukuran); ?>">
    <input type="hidden" name="jumlah" value="<?= $jumlah; ?>">

    <div class="checkout-container">
        <div>
            <?php if ($error_msg) : ?>
                <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 16px;"><?= $error_msg; ?></div>
            <?php endif; ?>

            <div class="card">
                <h3>Rincian Alamat</h3>
                <div class="form-group">
                    <label>Alamat Email (Opsional)</label>
                    <input type="email" name="email_penerima" class="form-control" placeholder="contoh@email.com">
                </div>
                <div class="row-2">
                    <div class="form-group">
                        <label>Nama Lengkap Penerima *</label>
                        <input type="text" name="nama_penerima" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon Penerima *</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Kecamatan, Distrik, Kota *</label>
                    <input type="text" name="kota_kecamatan" class="form-control" placeholder="Contoh: Cikarang Barat, Kab. Bekasi, Jawa Barat" required>
                </div>
                <div class="form-group">
                    <label>Rincian Alamat *</label>
                    <textarea name="alamat_lengkap" class="form-control" placeholder="Nama jalan, nomor rumah, RT/RW, patokan..." required></textarea>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label>Kode Pos *</label>
                    <input type="text" name="kode_pos" class="form-control" placeholder="Contoh: 17530" required>
                </div>
            </div>

            <div class="card">
                <h3>Metode Pengiriman</h3>
                <select name="kurir" id="kurirSelect" class="form-control" onchange="hitungTotal()" required>
                    <option value="J&T Express" data-ongkir="15000">J&T Express — Rp 15.000</option>
                    <option value="JNE Express" data-ongkir="20000">JNE Express — Rp 20.000</option>
                    <option value="Instant / Same Day" data-ongkir="35000">Instant / Same Day — Rp 35.000</option>
                </select>
            </div>

            <div class="card">
                <h3>Metode Pembayaran</h3>
                <select name="metode_pembayaran" class="form-control" required>
                    <option value="Transfer Bank Mandiri">Transfer Bank Mandiri (Virtual Account)</option>
                    <option value="Transfer Bank BCA">Transfer Bank BCA (Virtual Account)</option>
                    <option value="QRIS (GoPay / OVO / Dana / ShopeePay)">QRIS (GoPay / OVO / Dana / ShopeePay)</option>
                    <option value="COD (Bayar di Tempat)">COD (Bayar di Tempat)</option>
                </select>
            </div>
        </div>

        <div class="card" style="position: sticky; top: 24px;">
            <div class="item-summary">
                <img src="assets/uploads/<?= htmlspecialchars($gambar); ?>" alt="">
                <div class="item-info">
                    <h4><?= htmlspecialchars($produk['nama_produk']); ?></h4>
                    <span>Ukuran: <strong><?= htmlspecialchars($ukuran); ?></strong></span>
                    <span>Jumlah: <?= $jumlah; ?></span>
                </div>
                <div class="item-price">Rp <?= number_format($subtotal, 0, ',', '.'); ?></div>
            </div>

            <div class="form-group">
                <input type="text" name="catatan" class="form-control" placeholder="Tinggalkan pesan untuk pengiriman (Opsional)">
            </div>

            <div class="price-row">
                <span>Subtotal • <?= $jumlah; ?> item</span>
                <span>Rp <?= number_format($subtotal, 0, ',', '.'); ?></span>
            </div>
            <div class="price-row">
                <span>Pengiriman</span>
                <span id="ongkirText">Rp 15.000</span>
            </div>

            <div class="price-total">
                <span>Total Pembayaran</span>
                <span id="totalText">Rp <?= number_format($subtotal + 15000, 0, ',', '.'); ?></span>
            </div>

            <div class="note-tax">Pastikan rincian alamat dan ukuran sudah sesuai sebelum menekan tombol pesanan.</div>
            <button type="submit" name="pesan_sekarang" class="btn-order">Pesan Sekarang</button>
        </div>
    </div>
</form>

<script>
const subtotal = <?= $subtotal; ?>;
function hitungTotal() {
    const select = document.getElementById('kurirSelect');
    const ongkir = parseInt(select.options[select.selectedIndex].getAttribute('data-ongkir'));
    const total  = subtotal + ongkir;
    document.getElementById('ongkirText').innerText = 'Rp ' + ongkir.toLocaleString('id-ID');
    document.getElementById('totalText').innerText  = 'Rp ' + total.toLocaleString('id-ID');
}
</script>
<?php endif; ?>

</body>
</html>