<?php
include 'koneksi.php';

// admbil data dari input admin
$nama = $_POST['nama_produk'];
$kategori = $_POST['id_kategori'];
$deskripsi = $_POST['deskripsi'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];

// ambil data file gambar yang pakek variabel global $_files jadi bisa memasukkan tiap jenis file gambar
$nama_gambar = $_FILES['gambar']['name'];//ambil nama file gambarnya
$tmp_gambar = $_FILES['gambar']['tmp_name'];//ambil lokasi 

// ini fungsinya buat mindahin file dari memori komputer ke folder projekt, jadi nanti gambarnya bisa disimpan di folder projek sama dipanggil di halaman web
if(move_uploaded_file($tmp_gambar, $nama_gambar)){
    // kalo file gambar berhasil dipindah, simpen nama filenya ke database pakek teks
    $query = "INSERT INTO produk (id_kategori, nama_produk, deskripsi, harga, stok, gambar) 
            VALUES ('$kategori', '$nama', '$deskripsi', '$harga', '$stok', '$nama_gambar')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Produk baru berhasil ditambahkan!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "Gagal memasukkan data ke DB: " . mysqli_error($conn);
    }
} else {
    echo "Gagal mengunggah file gambar fisik. Cek hak akses folder!";
}
?>