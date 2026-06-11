<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="keranjang.php">Keranjang</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <main class="container">
        <div class="login-box">
            <h2>Form Login</h2>

            <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
                <div class="alert-gagal">Email atau Password salah!</div>
            <?php endif; ?>

            <form action="proses_login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Masukkan email...">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Masukkan password...">
                </div>
                <button type="submit" class="btn-login">Login</button>
            </form> <div style="text-align: center; margin-top: 15px;">
                Belum punya akun? <a href="register.php" style="color: #00568F;">Daftar di sini</a>
            </div>
        </div>
    </main>

    <footer>Contact:<br>081234567890</footer>

</body>
</html>