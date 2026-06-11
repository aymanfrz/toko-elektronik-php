<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

//ambil id produk yang diedit
$id = $_GET['id'];

//ngambil 1 baris data produk dari database
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = '$id'");
//$data isinya produk lama
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Edit Produk</title>
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
            <h2>Edit Produk</h2>
            <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_produk" value="<?= $data['id_produk']; ?>">
                <input type="hidden" name="gambar_lama" value="<?= $data['gambar']; ?>">

                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_produk" value="<?= $data['nama_produk']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="id_kategori" style="width:100%; padding:10px; border:1px solid #ccc; background:white;" required>
                        <option value="1" <?= ($data['id_kategori'] == 1) ? 'selected' : ''; ?>>Laptop</option>
                        <option value="2" <?= ($data['id_kategori'] == 2) ? 'selected' : ''; ?>>Smartphone</option>
                        <option value="3" <?= ($data['id_kategori'] == 3) ? 'selected' : ''; ?>>Aksesoris</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" name="deskripsi" value="<?= $data['deskripsi']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Harga (Rupiah)</label>
                    <input type="number" name="harga" value="<?= $data['harga']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" value="<?= $data['stok']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Ganti Gambar *(Kosongkan jika tidak ingin diubah)</label>
                    <input type="file" name="gambar" accept="image/*">
                    <small style="color:gray;">Gambar saat ini: <?= $data['gambar']; ?></small>
                </div>
                <button type="submit" class="btn-login" style="background-color: #f1c40f; color: black;">Simpan Perubahan</button>
            </form>
        </div>
    </main>
</body>
</html>