<?php
include 'config/koneksi.php';

$pesan = "";
if (isset($_POST['register'])) {
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $username     = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password     = mysqli_real_escape_string($koneksi, $_POST['password']);
    $konfirmasi   = mysqli_real_escape_string($koneksi, $_POST['konfirmasi_password']);

    // Cek apakah username sudah terdaftar
    $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        $pesan = "<div class='alert error'>Username sudah digunakan! Pilih username lain.</div>";
    } elseif ($password !== $konfirmasi) {
        $pesan = "<div class='alert error'>Konfirmasi password tidak cocok!</div>";
    } else {
        // Simpan ke tabel users sesuai kolom: username, password, nama_lengkap
        // Ubah bagian query INSERT di register.php menjadi seperti ini:
            $query = "INSERT INTO users (username, password, nama_lengkap, role) VALUES ('$username', '$password', '$nama_lengkap', 'user')";        
        if (mysqli_query($koneksi, $query)) {
            $pesan = "<div class='alert success'>Pendaftaran berhasil! Silakan <a href='admin/login.php'>Login di sini</a>.</div>";
        } else {
            $pesan = "<div class='alert error'>Gagal mendaftar: " . mysqli_error($koneksi) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - DUEVE Wearhouse</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .register-box {
            background: #ffffff;
            padding: 35px 30px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 380px;
        }
        .register-box h2 {
            margin: 0 0 8px;
            text-align: center;
            letter-spacing: 1px;
            color: #111;
        }
        .register-box p.subtitle {
            text-align: center;
            color: #666;
            font-size: 13px;
            margin-bottom: 24px;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .form-group input:focus {
            outline: none;
            border-color: #111;
        }
        .btn-register {
            width: 100%;
            padding: 12px;
            background-color: #111;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 1px;
            cursor: pointer;
            margin-top: 8px;
        }
        .btn-register:hover {
            background-color: #333;
        }
        .links {
            margin-top: 18px;
            text-align: center;
            font-size: 13px;
        }
        .links a {
            color: #111;
            font-weight: bold;
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
        .alert {
            padding: 10px 12px;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 16px;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>

<div class="register-box">
    <h2>DUEVE WEARHOUSE</h2>
    <p class="subtitle">Buat akun baru untuk melanjutkan</p>

    <?= $pesan; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Buat password" required>
        </div>
        <div class="form-group">
            <label for="konfirmasi_password">Konfirmasi Password</label>
            <input type="password" id="konfirmasi_password" name="konfirmasi_password" placeholder="Ulangi password" required>
        </div>
        <button type="submit" name="register" class="btn-register">DAFTAR SEKARANG</button>
    </form>

    <div class="links">
        Sudah punya akun? <a href="admin/login.php">Login di sini</a><br><br>
        <a href="index.php" style="color: #666; font-weight: normal;">← Kembali ke Beranda</a>
    </div>
</div>

</body>
</html>