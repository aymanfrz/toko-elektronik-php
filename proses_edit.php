<?php
include 'koneksi.php';

$id = $_POST['id_produk'];
$nama = $_POST['nama_produk'];
$kategori = $_POST['id_kategori'];
$deskripsi = $_POST['deskripsi'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];
$gambar_lama = $_POST['gambar_lama'];

$nama_gambar = $_FILES['gambar']['name'];
$tmp_gambar = $_FILES['gambar']['tmp_name'];

// bagian ngecek kalo admin admin beneran mau ganti gambar baru ato tidak
if (!empty($nama_gambar)) {
    // kalo iya gambar baru, pindahin filenya ke folder projek (yang sebelumnya filenya dari pc dipindah ke folder prjek)
    move_uploaded_file($tmp_gambar, $nama_gambar);
    $gambar_final = $nama_gambar;
} else {
    // kalo ngga ganti gambar, tetep pakek file lama
    $gambar_final = $gambar_lama;
}

// updatate ke database pakek id produk sebagai referensi buat update data yang mana
$query = "UPDATE produk SET 
        id_kategori = '$kategori', 
        nama_produk = '$nama', 
        deskripsi = '$deskripsi', 
        harga = '$harga', 
        stok = '$stok', 
        gambar = '$gambar_final' 
        WHERE id_produk = '$id'";

if(mysqli_query($conn, $query)){
    echo "<script>alert('Data produk berhasil diperbarui!'); window.location.href='admin_dashboard.php';</script>";
} else {
    echo "Gagal memperbarui data: " . mysqli_error($conn);
}
?>