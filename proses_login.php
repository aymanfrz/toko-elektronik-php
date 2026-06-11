<?php
// Memulai session PHP
session_start();

// ngehubungin ke file koneksi database
include 'koneksi.php';

// nangkepin data yang diketik dari form login
$email = $_POST['email'];
$password = $_POST['password'];

// cegahin sql injection biar aman
// dengan cara keluarin karakter2
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);

// query untuk mencari user berdasarkan email
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);

// buat ceking kalo email ditemukan atau tidak
if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    // cek cocok apa ngga passwordnya
    if ($password == $row['password']) {

        // kalo cocok, buat session untuk menyimpan data login user
        $_SESSION['id_user']   = $row['id_user'];
        $_SESSION['nama']      = $row['nama_lengkap'];
        $_SESSION['role']      = $row['role'];

        // ngalihan halaman berdasarkan role
        if ($row['role'] == 'admin') {
            header("Location: admin_dashboard.php");
            exit;
        } else if ($row['role'] == 'customer') {
            header("Location: index.php");
            exit;
        }
    } 
}

// kalo inputan salah dari email ato pass, user dibailiin ke login.php
header("Location: login.php?pesan=gagal");
exit;
