<?php
session_start();
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit(); }

if (isset($_POST['tambah'])) {
    $nama      = mysqli_real_escape_string($koneksi, $_POST['nama_layanan']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $persyaratan = mysqli_real_escape_string($koneksi, $_POST['persyaratan']);

    mysqli_query($koneksi, "INSERT INTO layanan (nama_layanan, deskripsi, persyaratan) VALUES ('$nama', '$deskripsi', '$persyaratan')");
}

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM layanan WHERE id_layanan = $id");
    header("Location: layanan.php"); exit();
}

$query_layanan = mysqli_query($koneksi, "SELECT * FROM layanan ORDER BY id_layanan DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Layanan - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-handshake me-2"></i>Kelola Layanan Desa</h2>
        <a href="dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3">Tambah Layanan</h4>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Layanan / Surat</label>
                        <input type="text" name="nama_layanan" class="form-control" placeholder="Contoh: Surat Keterangan Domisili" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Syarat & Berkas</label>
                        <textarea name="persyaratan" class="form-control" rows="4" placeholder="1. Fotokopi KTP&#10;2. Fotokopi KK"></textarea>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-primary w-100">Simpan Layanan</button>
                </form>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3">Daftar Layanan Publik</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead><tr><th>Layanan</th><th>Syarat</th><th>Aksi</th></tr></thead>
                        <tbody>
                            <?php while ($l = mysqli_fetch_assoc($query_layanan)): ?>
                                <tr>
                                    <td class="fw-bold"><?= $l['nama_layanan']; ?><br><small class="text-muted fw-normal"><?= $l['deskripsi']; ?></small></td>
                                    <td class="small"><?= nl2br($l['persyaratan']); ?></td>
                                    <td>
                                        <a href="layanan.php?hapus=<?= $l['id_layanan']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus layanan ini?');"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>