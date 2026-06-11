<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Tambah Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard Admin</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <main class="container">
        <div class="login-box" style="max-width: 500px;">
            <h2>Tambah Produk Baru</h2>
            // multi part biar bisa baca file gambar
            <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_produk" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="id_kategori" style="width:100%; padding:10px; border:1px solid #ccc; background:white;" required>
                        <option value="1">Laptop</option>
                        <option value="2">Smartphone</option>
                        <option value="3">Aksesoris</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" name="deskripsi" required>
                </div>
                <div class="form-group">
                    <label>Harga (Rupiah)</label>
                    <input type="number" name="harga" required>
                </div>
                <div class="form-group">
                    <label>Stok Awal</label>
                    <input type="number" name="stok" required>
                </div>
                <div class="form-group">
                    <label>Upload Gambar Produk</label>
                    <input type="file" name="gambar" accept="image/*" required>
                </div>
                <button type="submit" class="btn-login">Simpan Produk</button>
            </form>
        </div>
    </main>
</body>
</html>