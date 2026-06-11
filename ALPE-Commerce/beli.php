<?php
//session keranjang

session_start();
include 'koneksi.php';

// harus sudah login untuk bisa beli, kalo belum langsung diarahin ke login.php
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_produk = $_GET['id'];

// Cek stok produk di database sebelum dimasukkan ke keranjang apa masik ada
$query_stok = mysqli_query($conn, "SELECT stok FROM produk WHERE id_produk = '$id_produk'");
$produk = mysqli_fetch_assoc($query_stok);

//kalo habis kasik warning
if ($produk['stok'] <= 0) {
    echo "<script>alert('Maaf, produk ini sudah habis!'); window.location.href='index.php';</script>";
    exit;
}

// ngecek apakah variabel session keranjang ada ato blom
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];// buat array kosong kalo blom
}

//kalo produk yang dipilih sudah ada di keranjang, jumlah e ditambah 1
if (isset($_SESSION['keranjang'][$id_produk])) {
    $_SESSION['keranjang'][$id_produk]++;
} else {
    //kalo blom ada baru dimasukin ke keranjang dengan jumlah 1
    $_SESSION['keranjang'][$id_produk] = 1;
}

header("Location: index.php?beli=sukses");
exit;
?>