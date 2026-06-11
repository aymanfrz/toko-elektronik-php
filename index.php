<?php
session_start();
include 'koneksi.php';

// ambil id kategori kalo user milih filter kategori
$filter = isset($_GET['kategori']) ? $_GET['kategori'] : 'all';

// query buat menampilkan produk berdasarkan filter kategori
// pakek join biar nama kategori sama idnya muncul
if ($filter == 'all') {
    //dari awalnya kalo user blom milih filter, semua produk ditampilin
    $query_produk = "SELECT produk.*, kategori.nama_kategori FROM produk JOIN kategori ON produk.id_kategori = kategori.id_kategori";
} else {
    // kalo user milih filter, ambil produk yang id kategorinya sama dengan yang dipilih
    $query_produk = "SELECT produk.*, kategori.nama_kategori FROM produk JOIN kategori ON produk.id_kategori = kategori.id_kategori WHERE produk.id_kategori = '$filter'";
}
//ngelakuin query diatas
$tampil_produk = mysqli_query($conn, $query_produk);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Toko Elektronik</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php if(isset($_GET['beli']) && $_GET['beli'] == 'sukses'): ?>
        <script>alert('Barang berhasil dimasukkan ke keranjang!'); window.location.href='index.php';</script>
    <?php endif; ?>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="keranjang.php">Keranjang</a></li>
            <?php if(isset($_SESSION['id_user'])): ?>
                <li><a href="logout.php" style="color: #ffcccc;">Logout (<?= $_SESSION['nama']; ?>)</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <main class="container">
        <h1>Selamat datang!</h1>

        <div class="filter-section">
            <label for="kategori-select">Katalog</label>
            <select id="kategori-select" onchange="location='index.php?kategori='+this.value;">
                <option value="all">Semua Kategori</option>
                <?php
                // ngambil semua nama kategori dari database untuk dijadikan pilihan
                $q_kat = mysqli_query($conn, "SELECT * FROM kategori");
                while($k = mysqli_fetch_assoc($q_kat)) {
                    //pilihan yang kalo diklik tetep terpilih
                    $selected = ($filter == $k['id_kategori']) ? 'selected' : '';
                    echo "<option value='".$k['id_kategori']."' $selected>".$k['nama_kategori']."</option>";
                }
                ?>
            </select>
        </div>

        <div class="product-list">
            <?php
            // cek kalo produknya ada atau lebih dari 0
            if(mysqli_num_rows($tampil_produk) > 0): ?>
                <?php 
                // Looping (perulangan) untuk mencetak kartu produk sebanyak data di database
                while($row = mysqli_fetch_assoc($tampil_produk)): 
                ?>
                    <div class="product-card">
                        <div class="product-image-box" style="background:none;">
                            <img src="<?= $row['gambar']; ?>" alt="<?= $row['nama_produk']; ?>" style="width:100%; height:100%; object-fit:contain;">
                        </div>
                        <div class="product-details">
                            <div><strong>Nama:</strong> <?= $row['nama_produk']; ?></div>
                            <div><strong>Deskripsi:</strong> <?= $row['deskripsi']; ?></div>
                            <div><strong>Kategori:</strong> <?= $row['nama_kategori']; ?></div>
                            <div><strong>Harga:</strong> Rp <?= number_format($row['harga'], 0, ',', '.'); ?></div>
                        </div>
                        <div class="product-action">
                            <span class="stok-text">Stok: <?= $row['stok']; ?></span>
                            
                            <?php if($row['stok'] > 0): ?>
                                <a href="beli.php?id=<?= $row['id_produk']; ?>"><button class="btn-buy">Buy</button></a>
                            <?php else: ?>
                                <button class="btn-buy" style="background-color: #95a5a6; cursor: not-allowed;" disabled>Habis</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align:center; padding: 20px;">Produk tidak ditemukan.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>Contact:<br>081234567890</footer>
</body>
</html>