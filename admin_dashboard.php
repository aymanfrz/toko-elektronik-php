<?php
session_start();

//ngecegahin customer aj biar ngga masok ke halaman admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

//ngambil data pesanan yang digabung sama nama pembelinya dari tabel users
$query_invoice = "SELECT pesanan.*, users.nama_lengkap FROM pesanan JOIN users ON pesanan.id_user = users.id_user ORDER BY pesanan.id_pesanan DESC";
$tampil_invoice = mysqli_query($conn, $query_invoice);

//ngambil semua data produk biar admin bisa crud
$tampil_produk = mysqli_query($conn, "SELECT produk.*, kategori.nama_kategori FROM produk JOIN kategori ON produk.id_kategori = kategori.id_kategori");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard Admin</a></li>
            <li><a href="logout.php" style="color: #ffcccc;">Logout (<?= $_SESSION['nama']; ?>)</a></li>
        </ul>
    </nav>

    <main class="container">
        <h1>Dashboard Manajemen Toko</h1>
        
        <div style="background-color: #EFEFEF; padding: 20px; margin-bottom: 40px; border-radius: 4px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0;">Pesanan Masuk</h2>
                <a href="hapus_semua_pesanan.php" onclick="return confirm('PERINGATAN MERAH: Yakin ingin menghapus SEMUA riwayat transaksi? Data tidak bisa dikembalikan!')">
                    <button style="background-color: #c0392b; color: white; border: none; padding: 8px 15px; cursor: pointer; font-weight: bold; border-radius: 2px;">Hapus Semua Pesanan</button>
                </a>
            </div>
            <hr style="margin: 15px 0 10px 0; border: 0.5px solid #ccc;">
            
            <?php 
            if(mysqli_num_rows($tampil_invoice) > 0): 
            ?>
                <table border="1" cellpadding="10" cellspacing="0" style="width:100%; background: white; border-collapse: collapse;">
                    <tr style="background:#00568F; color:white;">
                        <th>ID</th>
                        <th>Nama Pembeli</th>
                        <th>Rincian Barang Yang Dibeli</th>
                        <th>Tanggal Transaksi</th>
                        <th>Total Bayar</th>
                    </tr>
                    <?php 
                    while($inv = mysqli_fetch_assoc($tampil_invoice)): 
                    ?>
                    <tr align="center">
                        <td>#00<?= $inv['id_pesanan']; ?></td>
                        <td><?= $inv['nama_lengkap']; ?></td>
                        <td align="left">
                            <ul>
                            <?php 
                            // ambil id Pesanan dari loop pesanan, terus ambil data detail pesanan yang digabung sama nama produk dari tabel produk, berdasarkan id pesanan yang sama
                            $id_p = $inv['id_pesanan'];

                            // carik rincian barangnya di tabel anak (detail_pesanan) khusus untuk ID Pesanan ini saja
                            $q_item = mysqli_query($conn, "SELECT detail_pesanan.*, produk.nama_produk FROM detail_pesanan JOIN produk ON detail_pesanan.id_produk = produk.id_produk WHERE detail_pesanan.id_pesanan = '$id_p'");
                            // looping buat ngeecetak rincian barangnya dalam bentuk list
                            while($item = mysqli_fetch_assoc($q_item)) {
                                echo "<li>" . $item['nama_produk'] . " <strong>(" . $item['jumlah'] . " pcs)</strong></li>";
                            }
                            ?>
                            </ul>
                        </td>
                        <td><?= $inv['tanggal_pesan']; ?></td>
                        <td>Rp <?= number_format($inv['total_bayar'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p><i>Belum ada pesanan masuk.</i></p>
            <?php endif; ?>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Manajemen Produk Toko</h2>
            <a href="tambah_produk.php"><button class="btn-buy" style="padding: 8px 20px; font-size: 16px;">+ Tambah Produk Baru</button></a>
        </div>

        <div class="product-list">
            <?php while($prod = mysqli_fetch_assoc($tampil_produk)): ?>
                <div class="product-card">
                    <div class="product-image-box" style="background:none;">
                        <img src="<?= $prod['gambar']; ?>" alt="" style="width:100%; height:100%; object-fit:contain;">
                    </div>
                    <div class="product-details">
                        <div><strong>Nama:</strong> <?= $prod['nama_produk']; ?></div>
                        <div><strong>Deskripsi:</strong> <?= $prod['deskripsi']; ?></div>
                        <div><strong>Kategori:</strong> <?= $prod['nama_kategori']; ?></div>
                        <div><strong>Harga:</strong> Rp <?= number_format($prod['harga'], 0, ',', '.'); ?></div>
                    </div>
                    <div class="product-action">
                        <span class="stok-text" style="display:block; margin-bottom:10px;">Stok: <?= $prod['stok']; ?></span>
                        
                        <div style="display: flex; gap: 5px; justify-content: center;">
                            <a href="edit_produk.php?id=<?= $prod['id_produk']; ?>">
                                <button style="background-color: #f1c40f; color:black; border:none; padding: 8px 12px; cursor:pointer; font-weight:bold; border-radius:2px;">Edit</button>
                            </a>
                            <a href="hapus_produk.php?id=<?= $prod['id_produk']; ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                <button style="background-color: #e74c3c; color:white; border:none; padding: 8px 12px; cursor:pointer; font-weight:bold; border-radius:2px;">Hapus</button>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <footer>Contact:<br>081234567890</footer>
</body>
</html>