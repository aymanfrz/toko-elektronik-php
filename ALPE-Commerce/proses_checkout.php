<?php
session_start();
include 'koneksi.php';

// buat mastiin user dah login ato blom
if (!isset($_SESSION['id_user']) || empty($_SESSION['keranjang'])) {
    header("Location: index.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$total_bayar = $_GET['total'];
$tanggal = date('Y-m-d H:i:s');

// bagian pertama itu disimpen ke tabel pesanan
$query_pesanan = "INSERT INTO pesanan (id_user, tanggal_pesan, total_bayar) VALUES ('$id_user', '$tanggal', '$total_bayar')";
mysqli_query($conn, $query_pesanan);

// ambil id pesanan barusan yang baru aj dibuat untuk dijadikan referensi di tabel detail_pesanan
$id_pesanan_baru = mysqli_insert_id($conn);

// baru di bagian ke2 Loop semua isi session keranjang buat dipindah ke tabel detail_pesanan
foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
    // carik harga sama stok produk di database
    $q_prod = mysqli_query($conn, "SELECT harga, stok FROM produk WHERE id_produk = '$id_produk'");
    $p = mysqli_fetch_assoc($q_prod);
    $subtotal = $p['harga'] * $jumlah;

    // masukkin datanya ke tabel detail_pesanan
    $query_detail = "INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, harga_subtotal) 
                    VALUES ('$id_pesanan_baru', '$id_produk', '$jumlah', '$subtotal')";
    mysqli_query($conn, $query_detail);

    // ngurangin stok produk di database sesuai jumlah inputan user yang dibeli
    $stok_baru = $p['stok'] - $jumlah;
    mysqli_query($conn, "UPDATE produk SET stok = '$stok_baru' WHERE id_produk = '$id_produk'");
}

// akhirnya unset untuk kosongin keranjang
unset($_SESSION['keranjang']);

echo "<script>alert('Terima kasih! Pesanan Anda berhasil diproses.'); window.location.href='index.php';</script>";
exit;
?>