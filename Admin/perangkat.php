<?php
session_start();
require_once __DIR__ . '/../config.php';

// Proteksi Session Login Admin
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$pesan = '';
$pesan_error = '';$page_title = "Kelola Perangkat Desa";

// 1. PROSES TAMBAH DATA PERANGKAT DESA
if (isset($_POST['tambah'])) {
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama']);$jabatan = mysqli_real_escape_string($koneksi,$_POST['jabatan']);
    $no_hp   = mysqli_real_escape_string($koneksi, $_POST['no_hp']);$email   = mysqli_real_escape_string($koneksi,$_POST['email']);

    // Proses Upload Foto
    $foto_nama =$_FILES['foto']['name'];
    $foto_tmp  =$_FILES['foto']['tmp_name'];
    
    if (!empty($foto_nama)) {
        // Folder penyimpanan foto
        $target_folder = __DIR__ . '/../assets/img/';
        
        if (!file_exists($target_folder)) {
            mkdir($target_folder, 0777, true);
        }

        // Penamaan unik file gambar
        $ext = pathinfo($foto_nama, PATHINFO_EXTENSION);$foto_baru = time() . '_' . rand(100, 999) . '.' . strtolower($ext);$target_dir = $target_folder .$foto_baru;

        if (move_uploaded_file($foto_tmp, $target_dir)) {$query = "INSERT INTO perangkat_desa (nama, jabatan, no_hp, email, foto) 
                      VALUES ('$nama', '$jabatan', '$no_hp', '$email', '$foto_baru')";
            if (mysqli_query($koneksi, $query)) {$pesan = "Data Perangkat Desa berhasil ditambahkan!";
            } else {
                $pesan_error = "Gagal menyimpan ke database: " . mysqli_error($koneksi);
            }
        } else {
            $pesan_error = "Gagal mengupload foto ke folder assets/img/. Cek izin folder.";
        }
    } else {
        $pesan_error = "Wajib mengunggah foto perangkat desa.";
    }
}

// 2. PROSES HAPUS DATA PERANGKAT DESA
if (isset($_GET['hapus'])) {
    $id_perangkat = (int)$_GET['hapus'];
    
    $get_foto = mysqli_query($koneksi, "SELECT foto FROM perangkat_desa WHERE id_perangkat = $id_perangkat");
    $data_foto = mysqli_fetch_assoc($get_foto);
    
    if ($data_foto) {
        $path_foto = __DIR__ . '/../assets/img/' .$data_foto['foto'];
        if (file_exists($path_foto) && !empty($data_foto['foto'])) {
            unlink($path_foto);
        }
        
        mysqli_query($koneksi, "DELETE FROM perangkat_desa WHERE id_perangkat = $id_perangkat");
        header("Location: perangkat.php?pesan=dihapus");
        exit();
    }
}

// Ambil Seluruh Data Perangkat Desa
$query_perangkat = mysqli_query($koneksi, "SELECT * FROM perangkat_desa ORDER BY id_perangkat ASC");
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
            <i class="fa-solid fa-circle-info me-2"></i>Data perangkat desa berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="fa-solid fa-user-plus me-2"></i>Tambah Perangkat</h5>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso, S.STP" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Kepala Desa / Sekretaris Desa" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nomor Telepon/WA</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="08123456789">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="budi@desapilang.id">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Formal</label>
                        <input type="file" name="foto" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-primary w-100">
                        <i class="fa-solid fa-plus me-1"></i> Simpan Perangkat
                    </button>
                </form>
            </div>
        </div>