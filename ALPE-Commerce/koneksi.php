<?php
$host = "localhost";
$username = "root"; // username default dari xampp
$password = "";
$database = "toko_elektronik";

// ngekoneksiin PHP dengan server database sql
$conn = mysqli_connect($host, $username, $password, $database);

// ngecek koneksi kalo gagal, tampilin pesan eror
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>