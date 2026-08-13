<?php
/**
 * File Koneksi Database Panel Admin
 * Desa Pilang, Kecamatan Wonoayu, Kabupaten Sidoarjo
 */

$host     = "localhost";
$username = "root";
$password = "";
$database = "desa_pilang";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi Database Admin Gagal: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8");
?>