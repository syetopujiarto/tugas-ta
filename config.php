<?php
/**
 * File Koneksi Database & Konfigurasi Website
 * Desa Pilang, Kecamatan Wonoayu, Kabupaten Sidoarjo
 */

// 1. SETTING BASE URL (URL Utama Website)
// Sesuaikan "tugas_ta" dengan nama folder utama kamu yang ada di xampp/htdocs!
define('BASE_URL', 'http://localhost/Tugas_TA');

// 2. KONEKSI DATABASE
$host     = "localhost";
$username = "root";
$password = "";
$database = "desa_pilang";

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $username, $password, $database);

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

// Set charset UTF-8
mysqli_set_charset($koneksi, "utf8");
?>