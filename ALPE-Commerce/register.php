<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
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
            <h2>Daftar Akun Baru</h2>

            <form action="proses_register.php" method="POST">
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" required placeholder="Masukkan nama lengkap...">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Masukkan email aktif...">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Buat password...">
                </div>
                <button type="submit" class="btn-login" style="background-color: #00568F; color: white;">Daftar Sekarang</button>
            </form>

            <div style="text-align: center; margin-top: 15px;">
                Sudah punya akun? <a href="login.php" style="color: #00568F;">Login di sini</a>
            </div>
        </div>
    </main>

    <footer>Contact:<br>081234567890</footer>

</body>
</html>