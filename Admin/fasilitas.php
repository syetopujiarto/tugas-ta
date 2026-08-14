<?php
session_start();
require_once __DIR__ . '/../config.php';

// Proteksi Login
if (!isset($_SESSION['login'])) { 
    header("Location: login.php"); 
    exit(); 
}

$pesan = '';$pesan_error = '';

// 1. PROSES TAMBAH FASILITAS
if (isset($_POST['tambah'])) {
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama_fasilitas']);$lokasi = mysqli_real_escape_string($koneksi,$_POST['lokasi']);

    $foto_nama =$_FILES['gambar']['name'];
    $foto_tmp  =$_FILES['gambar']['tmp_name'];
    
    if (!empty($foto_nama)) {
        $ext = strtolower(pathinfo($foto_nama, PATHINFO_EXTENSION));
        $foto_baru = time() . '_' . rand(100, 999) . '.' . $ext;
        
        // Path direktori penyimpanan foto (Sensitif huruf besar/kecil)
        $target_dir = __DIR__ . '/../public/uploads/fasilitas/';

        // Buat folder jika belum ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($foto_tmp,$target_dir . $foto_baru)) {$query = "INSERT INTO fasilitas (nama_fasilitas, lokasi, gambar) VALUES ('$nama', '$lokasi', '$foto_baru')";
            if (mysqli_query($koneksi, $query)) {$_SESSION['pesan_sukses'] = "Fasilitas berhasil ditambahkan!";
                header("Location: fasilitas.php");
                exit();
            } else {
                $pesan_error = "Gagal menyimpan ke database: " . mysqli_error($koneksi);
            }
        } else {
            $pesan_error = "Gagal mengunggah foto fasilitas. Pastikan folder uploads diizinkan untuk diisi file.";
        }
    }
}

// 2. PROSES HAPUS FASILITAS
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $get_foto = mysqli_query($koneksi, "SELECT gambar FROM fasilitas WHERE id_fasilitas = $id");
    
    if ($get_foto && mysqli_num_rows($get_foto) > 0) {
        $data_foto = mysqli_fetch_assoc($get_foto);
        
        // Hapus file dari folder public dan Public (mencegah error nama folder)
        @unlink(__DIR__ . '/../public/uploads/fasilitas/' . $data_foto['gambar']);
        @unlink(__DIR__ . '/../Public/uploads/fasilitas/' . $data_foto['gambar']);
        
        mysqli_query($koneksi, "DELETE FROM fasilitas WHERE id_fasilitas = $id");
        $_SESSION['pesan_sukses'] = "Fasilitas berhasil dihapus!";
    }
    header("Location: fasilitas.php"); 
    exit();
}

// Ambil Pesan Sukses dari Session Redirect
if (isset($_SESSION['pesan_sukses'])) {
    $pesan =$_SESSION['pesan_sukses'];
    unset($_SESSION['pesan_sukses']);
}

// 3. AMBIL DATA FASILITAS (Dengan Anti-Crash Query)
try {
    $query_fasilitas = mysqli_query($koneksi, "SELECT * FROM fasilitas ORDER BY id_fasilitas DESC");
} catch (mysqli_sql_exception $e) {$pesan_error = "Tabel 'fasilitas' belum ada di database! Silakan buat tabelnya terlebih dahulu.";
    $query_fasilitas = false;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Fasilitas - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-building me-2"></i>Kelola Fasilitas Desa</h2>
        <a href="dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
    </div>

    <?php if ($pesan): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i><?= $pesan; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($pesan_error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i><?= $pesan_error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3">Tambah Fasilitas</h4>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Fasilitas</label>
                        <input type="text" name="nama_fasilitas" class="form-control" placeholder="Contoh: Balai Desa / Lapangan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi / Alamat</label>