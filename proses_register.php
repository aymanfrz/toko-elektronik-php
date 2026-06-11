<?php
include 'koneksi.php';

// nangkepin data dari inputan form register
$nama = $_POST['nama_lengkap'];
$email = $_POST['email'];
$password = $_POST['password'];

// Mencegah SQL Injection sederhana
$nama = mysqli_real_escape_string($conn, $nama);
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);

// 1. Cek dulu apakah email sudah pernah didaftarkan
$cek_email = "SELECT * FROM users WHERE email = '$email'";
$hasil_cek = mysqli_query($conn, $cek_email);

if (mysqli_num_rows($hasil_cek) > 0) {
    // Jika email sudah ada, kembalikan dengan pesan error (bisa kamu tangkap nanti pakai $_GET['pesan'])
    echo "<script>alert('Email sudah terdaftar! Silakan gunakan email lain atau login.'); window.location.href='register.php';</script>";
} else {
    // 2. Jika email belum ada, masukkan data ke tabel users
    // Role otomatis di-set sebagai 'customer'
    $query_insert = "INSERT INTO users (nama_lengkap, email, password, role) VALUES ('$nama', '$email', '$password', 'customer')";
    
    if (mysqli_query($conn, $query_insert)) {
        // Jika berhasil, arahkan ke halaman login
        echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location.href='login.php';</script>";
    } else {
        // Jika gagal karena error MySQL
        echo "Error: " . $query_insert . "<br>" . mysqli_error($conn);
    }
}
?>