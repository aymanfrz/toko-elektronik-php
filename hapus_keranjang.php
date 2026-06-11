<?php
session_start();
$id_produk = $_GET['id'];

// carik id produk di session keranjang, kalo ada dihapus
if (isset($_SESSION['keranjang'][$id_produk])) {
    unset($_SESSION['keranjang'][$id_produk]);
}

header("Location: keranjang.php");
exit;
?>