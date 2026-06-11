<?php
session_start();
include 'koneksi.php';

// kalo blom login, dipaksa langsung ke halaman login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="keranjang.php">Keranjang</a></li>
            <li><a href="logout.php" style="color: #ffcccc;">Logout (<?= $_SESSION['nama']; ?>)</a></li>
        </ul>
    </nav>

    <main class="container">
        <h1>Keranjang Belanja Anda</h1>

        <div class="product-list">
            <?php 
            $total_bayar = 0;

            // cekin buat tau apakah keranjangnya ada isinya dan tidak kosong
            if (!empty($_SESSION['keranjang'])): 
                // ngebongkar isi session keranjang. idproduk jadi ID, jumlah buat kuantitas barangnya
                foreach ($_SESSION['keranjang'] as $id_produk => $jumlah):
                    // ambil nama, harga, sama gambar dari database berdasarkan id yang ada di memori keranjang
                    $q_ambil = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
                    $p = mysqli_fetch_assoc($q_ambil);
                    // Hitung subtotal, jadi harga satuan dikali jumlah barang
                    $subtotal = $p['harga'] * $jumlah;
                    //tambahin subtotal ke total bayar
                    $total_bayar += $subtotal;
            ?>
                    <div class="product-card">
                        <div class="product-image-box" style="background:none;">
                            <img src="<?= $p['gambar']; ?>" alt="" style="width:100%; height:100%; object-fit:contain;">
                        </div>
                        <div class="product-details">
                            <div><strong>Nama:</strong> <?= $p['nama_produk']; ?></div>
                            <div><strong>Jumlah:</strong> <?= $jumlah; ?> pcs</div>
                            <div><strong>Subtotal:</strong> Rp <?= number_format($subtotal, 0, ',', '.'); ?></div>
                        </div>
                        <div class="product-action">
                            <a href="hapus_keranjang.php?id=<?= $id_produk; ?>">
                                <button style="background-color: #e74c3c; color:white; border:none; padding: 10px 15px; cursor:pointer; font-weight:bold; border-radius:2px;">Hapus</button>
                            </a>
                        </div>
                    </div>
            <?php 
                endforeach; 
            else:
            ?>
                <p style="text-align: center; padding: 40px; background: #EFEFEF;">Keranjang kosong. Yuk belanja dulu!</p>
            <?php endif; ?>
        </div>

        <?php if (!empty($_SESSION['keranjang'])): ?>
            <div style="text-align: right; margin-top: 30px;">
                <h2 style="margin-bottom: 15px;">Total Akhir: Rp <?= number_format($total_bayar, 0, ',', '.'); ?></h2>
                <a href="proses_checkout.php?total=<?= $total_bayar; ?>"><button class="btn-buy" style="padding: 12px 40px;">Checkout Sekarang</button></a>
            </div>
        <?php endif; ?>
    </main>

    <footer>Contact:<br>081234567890</footer>
</body>
</html>