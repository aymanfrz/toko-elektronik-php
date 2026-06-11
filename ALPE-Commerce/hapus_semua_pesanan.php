<?php
session_start();
include 'koneksi.php';

// ngecek aj kalo admin yang bisa akses ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// buaat delete karena berelasi (detail_pesanan adalah pivotnya tabel pesanan) hapus semua data di tabel detail_pesanan dulu
$hapus_detail = mysqli_query($conn, "DELETE FROM detail_pesanan");

if ($hapus_detail) {
    // kalo pivot tabel detail_pesanan udah bersih, baru hapus data di tabel pesanan
    $hapus_pesanan = mysqli_query($conn, "DELETE FROM pesanan");

    if ($hapus_pesanan) {
        // baru dihapus bagian pesanan
        mysqli_query($conn, "DELETE FROM pesanan");
        
        echo "<script>alert('Semua data pesanan berhasil dibersihkan!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "Gagal menghapus tabel pesanan: " . mysqli_error($conn);
    }
} else {
    echo "Gagal menghapus detail pesanan: " . mysqli_error($conn);
}
?>