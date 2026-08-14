<?php
session_start();
require_once __DIR__ . '/../config.php';

// Proteksi Login
if (!isset($_SESSION['login'])) { 
    header("Location: login.php"); 
    exit(); 
}

$pesan = '';
$pesan_error = '';

// 1. PROSES SIMPAN / UPDATE
if (isset($_POST['simpan'])) {
    $alamat    = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $telepon   = mysqli_real_escape_string($koneksi, $_POST['telepon']);
    $email     = mysqli_real_escape_string($koneksi, $_POST['email']);
    $facebook  = mysqli_real_escape_string($koneksi, $_POST['facebook']);
    $instagram = mysqli_real_escape_string($koneksi, $_POST['instagram']);
    $youtube   = mysqli_real_escape_string($koneksi, $_POST['youtube']);
    $maps      = mysqli_real_escape_string($koneksi, $_POST['maps']);

    $cek = mysqli_query($koneksi, "SELECT * FROM kontak WHERE id_kontak=1");
    if ($cek && mysqli_num_rows($cek) > 0) {
        $query = "UPDATE kontak SET alamat='$alamat', telepon='$telepon', email='$email', facebook='$facebook', instagram='$instagram', youtube='$youtube', maps='$maps' WHERE id_kontak=1";
    } else {
        $query = "INSERT INTO kontak (id_kontak, alamat, telepon, email, facebook, instagram, youtube, maps) VALUES (1, '$alamat', '$telepon', '$email', '$facebook', '$instagram', '$youtube', '$maps')";
    }

    if (mysqli_query($koneksi, $query)) {
        $pesan = "Informasi kontak berhasil diperbarui!";
    } else {
        $pesan_error = "Gagal menyimpan: " . mysqli_error($koneksi);
    }
}

// 2. AMBIL DATA KONTAK
$query_kontak = mysqli_query($koneksi, "SELECT * FROM kontak WHERE id_kontak=1");
$k = ($query_kontak) ? mysqli_fetch_assoc($query_kontak) : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kontak - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-address-book me-2"></i>Kelola Informasi Kontak</h2>
        <a href="dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
    </div>

    <?php if ($pesan): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa-solid fa-circle-check me-2"></i><?= $pesan; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($pesan_error): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fa-solid fa-triangle-exclamation me-2"></i><?= $pesan_error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <form action="" method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Alamat Kantor Desa</label>
                    <input type="text" name="alamat" class="form-control" value="<?= $k['alamat'] ?? ''; ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Telepon / Whatsapp</label>
                    <input type="text" name="telepon" class="form-control" value="<?= $k['telepon'] ?? ''; ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Email Resmi</label>
                    <input type="email" name="email" class="form-control" value="<?= $k['email'] ?? ''; ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Link Facebook</label>
                    <input type="url" name="facebook" class="form-control" value="<?= $k['facebook'] ?? ''; ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Link Instagram</label>
                    <input type="url" name="instagram" class="form-control" value="<?= $k['instagram'] ?? ''; ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Link Youtube</label>
                    <input type="url" name="youtube" class="form-control" value="<?= $k['youtube'] ?? ''; ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Embed Google Maps (Iframe)</label>
                    <textarea name="maps" class="form-control" rows="4" placeholder='Tempelkan kode <iframe ...></iframe> di sini'><?= htmlspecialchars($k['maps'] ?? ''); ?></textarea>
                </div>
            </div>

            <button type="submit" name="simpan" class="btn btn-primary mt-4 px-4"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>