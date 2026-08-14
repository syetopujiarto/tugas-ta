<?php
// 1. Tampilkan Error untuk Debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Load Config & Session
require_once __DIR__ . '/../config.php';

// 3. Proteksi Session Login Admin
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$pesan = '';
$pesan_error = '';

// 4. Proses Simpan / Update Data Profil
if (isset($_POST['simpan'])) {
    $nama_desa = mysqli_real_escape_string($koneksi, $_POST['nama_desa']);
    $kecamatan = mysqli_real_escape_string($koneksi, $_POST['kecamatan']);
    $kabupaten = mysqli_real_escape_string($koneksi, $_POST['kabupaten']);
    $provinsi  = mysqli_real_escape_string($koneksi, $_POST['provinsi']);
    $kode_pos  = mysqli_real_escape_string($koneksi, $_POST['kode_pos']);
    $alamat    = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $telepon   = mysqli_real_escape_string($koneksi, $_POST['telepon']);
    $email     = mysqli_real_escape_string($koneksi, $_POST['email']);
    $sejarah   = mysqli_real_escape_string($koneksi, $_POST['sejarah']);
    $visi      = mysqli_real_escape_string($koneksi, $_POST['visi']);
    $misi      = mysqli_real_escape_string($koneksi, $_POST['misi']);

    // Cek apakah data sudah ada di database
    $cek = mysqli_query($koneksi, "SELECT * FROM profil_desa LIMIT 1");
    if ($cek && mysqli_num_rows($cek) > 0) {
        $query = "UPDATE profil_desa SET 
                    nama_desa = '$nama_desa',
                    kecamatan = '$kecamatan',
                    kabupaten = '$kabupaten',
                    provinsi  = '$provinsi',
                    kode_pos  = '$kode_pos',
                    alamat    = '$alamat',
                    telepon   = '$telepon',
                    email     = '$email',
                    sejarah   = '$sejarah',
                    visi      = '$visi',
                    misi      = '$misi'
                  WHERE id_profil = 1";
    } else {
        $query = "INSERT INTO profil_desa (id_profil, nama_desa, kecamatan, kabupaten, provinsi, kode_pos, alamat, telepon, email, sejarah, visi, misi, logo) 
                  VALUES (1, '$nama_desa', '$kecamatan', '$kabupaten', '$provinsi', '$kode_pos', '$alamat', '$telepon', '$email', '$sejarah', '$visi', '$misi', 'logo.png')";
    }

    if (mysqli_query($koneksi, $query)) {
        $pesan = "Data Profil Desa berhasil diperbarui!";
    } else {
        $pesan_error = "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}

// 5. Ambil data profil dari DB
$query_profil = mysqli_query($koneksi, "SELECT * FROM profil_desa LIMIT 1");
$data = $query_profil ? mysqli_fetch_assoc($query_profil) : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Profil Desa - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-id-card me-2 text-primary"></i>Kelola Profil Desa</h2>
        <a href="dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard</a>
    </div>

    <?php if ($pesan): ?>
        <div class="alert alert-success alert-dismissible fade show"><?= $pesan; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <?php if ($pesan_error): ?>
        <div class="alert alert-danger alert-dismissible fade show"><?= $pesan_error; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h4 class="fw-bold mb-3 text-primary"><i class="fa-solid fa-building me-2"></i>Identitas Desa</h4>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Nama Desa</label>
                    <input type="text" name="nama_desa" class="form-control" value="<?= $data['nama_desa'] ?? 'Desa Pilang'; ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control" value="<?= $data['kecamatan'] ?? 'Wonoayu'; ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Kabupaten</label>
                    <input type="text" name="kabupaten" class="form-control" value="<?= $data['kabupaten'] ?? 'Sidoarjo'; ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Provinsi</label>
                    <input type="text" name="provinsi" class="form-control" value="<?= $data['provinsi'] ?? 'Jawa Timur'; ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Kode Pos</label>
                    <input type="text" name="kode_pos" class="form-control" value="<?= $data['kode_pos'] ?? '61261'; ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="<?= $data['telepon'] ?? ''; ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Email Desa</label>
                    <input type="email" name="email" class="form-control" value="<?= $data['email'] ?? ''; ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Alamat Kantor Desa</label>
                    <input type="text" name="alamat" class="form-control" value="<?= $data['alamat'] ?? ''; ?>" placeholder="Contoh: Jl. Raya Pilang No. 01">
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h4 class="fw-bold mb-3 text-primary"><i class="fa-solid fa-file-lines me-2"></i>Sejarah, Visi & Misi</h4>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Sejarah Desa</label>
                <textarea name="sejarah" class="form-control" rows="5" placeholder="Tuliskan sejarah desa..."><?= $data['sejarah'] ?? ''; ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Visi Desa</label>
                <textarea name="visi" class="form-control" rows="3" placeholder="Tuliskan Visi desa..."><?= $data['visi'] ?? ''; ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Misi Desa</label>
                <textarea name="misi" class="form-control" rows="5" placeholder="Tuliskan Misi desa..."><?= $data['misi'] ?? ''; ?></textarea>
            </div>

            <button type="submit" name="simpan" class="btn btn-primary px-4 py-2">
                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan Profil
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>