<?php
session_start();
require_once '../config/koneksi.php';

// Jika sudah login, langsung lempar ke dashboard
if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}

$error = false;
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            header("Location: dashboard.php");
            exit;
        }
    }
    $error = true;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DUEVE | Admin Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Helvetica Neue', Arial, sans-serif; }
        body { background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-card { background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; max-width: 380px; text-align: center; }
        .login-card h2 { letter-spacing: 2px; margin-bottom: 20px; text-transform: uppercase; }
        .form-group { margin-bottom: 15px; text-align: left; }
        .form-group label { display: block; font-size: 12px; margin-bottom: 5px; font-weight: bold; letter-spacing: 1px; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; outline: none; }
        .btn-login { width: 100%; padding: 12px; background: #111; color: #fff; border: none; font-weight: bold; cursor: pointer; letter-spacing: 1px; margin-top: 10px; border-radius: 4px; }
        .btn-login:hover { background: #333; }
        .error-msg { color: red; font-size: 13px; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>DUEVE ADMIN</h2>
        <?php if($error): ?>
            <p class="error-msg">Username atau Password salah!</p>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>USERNAME</label>
                <input type="text" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="form-group">
                <label>PASSWORD</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" name="login" class="btn-login">LOGIN</button>
        </form>
    </div>

</body>
</html>