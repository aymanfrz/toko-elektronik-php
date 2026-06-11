<?php
include 'koneksi.php';

$id = $_GET['id'];

// hapos berdasarkan id produk
$query_hapus = "DELETE FROM produk WHERE id_produk = '$id'";

if(mysqli_query($conn, $query_hapus)){
    echo "<script>alert('Produk berhasil dihapus!'); window.location.href='admin_dashboard.php';</script>";
} else {
    echo "Gagal menghapus produk: " . mysqli_error($conn);
}
?>