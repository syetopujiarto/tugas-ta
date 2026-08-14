<?php
session_start();
require_once __DIR__ . '/../config.php';

// Proteksi Session Login Admin
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$pesan = '';
$pesan_error = '';$page_title = "Kelola Berita Desa";

// 1. PROSES TAMBAH BERITA
if (isset($_POST['tambah'])) {
    $judul   = mysqli_real_escape_string($koneksi, $_POST['judul']);$penulis = mysqli_real_escape_string($koneksi,$_POST['penulis']);
    $isi     = mysqli_real_escape_string($koneksi, $_POST['isi']);$tanggal = date('Y-m-d H:i:s');

    // Proses Upload Gambar Berita
    $gambar_nama =$_FILES['gambar']['name'];
    $gambar_tmp  =$_FILES['gambar']['tmp_name'];
    
    if (!empty($gambar_nama)) {$target_folder = __DIR__ . '/../assets/img/';
        
        if (!file_exists($target_folder)) {
            mkdir($target_folder, 0777, true);
        }

        $ext = pathinfo($gambar_nama, PATHINFO_EXTENSION);$gambar_baru = 'berita_' . time() . '_' . rand(100, 999) . '.' . strtolower($ext);$target_dir = $target_folder .$gambar_baru;

        if (move_uploaded_file($gambar_tmp, $target_dir)) {$query = "INSERT INTO berita (judul, isi, penulis, tanggal, gambar) 
                      VALUES ('$judul', '$isi', '$penulis', '$tanggal', '$gambar_baru')";
            if (mysqli_query($koneksi, $query)) {$pesan = "Berita berhasil diterbitkan!";
            } else {
                $pesan_error = "Gagal menyimpan berita: " . mysqli_error($koneksi);
            }
        } else {
            $pesan_error = "Gagal mengupload gambar berita ke folder assets/img/.";
        }
    } else {
        $pesan_error = "Wajib mengunggah gambar header berita.";
    }
}

// 2. PROSES HAPUS BERITA
if (isset($_GET['hapus'])) {
    $id_berita = (int)$_GET['hapus'];
    
    $get_gambar = mysqli_query($koneksi, "SELECT gambar FROM berita WHERE id_berita = $id_berita");
    $data_gambar = mysqli_fetch_assoc($get_gambar);
    
    if ($data_gambar) {
        $path_gambar = __DIR__ . '/../assets/img/' .$data_gambar['gambar'];
        if (file_exists($path_gambar) && !empty($data_gambar['gambar'])) {
            unlink($path_gambar);
        }
        
        mysqli_query($koneksi, "DELETE FROM berita WHERE id_berita = $id_berita");
        header("Location: berita.php?pesan=dihapus");
        exit();
    }
}

// Ambil Seluruh Data Berita
$query_berita = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id_berita DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title; ?> - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; }
    </style>
</head>
<body>

<?php 
// Panggil Sidebar & Topbar Admin
include 'sidebar.php'; 
?>

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

    <?php if (isset($_GET['pesan']) &&$_GET['pesan'] == 'dihapus'): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-info me-2"></i>Berita berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="fa-solid fa-pen-to-square me-2"></i>Tambah Berita Baru</h5>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Berita</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Kerja Bakti Massal Sambut HUT RI" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Penulis / Admin</label>
                        <input type="text" name="penulis" class="form-control" value="<?= htmlspecialchars($_SESSION['username'] ?? 'Admin Desa'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Header</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Isi Berita</label>
                        <textarea name="isi" class="form-control" rows="6" placeholder="Tuliskan isi berita selengkapnya..." required></textarea>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-primary w-100">
                        <i class="fa-solid fa