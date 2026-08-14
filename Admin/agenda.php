<?php
session_start();
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit(); }

if (isset($_POST['tambah'])) {
    $judul   = mysqli_real_escape_string($koneksi, $_POST['nama_kegiatan']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $jam     = mysqli_real_escape_string($koneksi, $_POST['jam']);
    $lokasi  = mysqli_real_escape_string($koneksi, $_POST['lokasi']);

    mysqli_query($koneksi, "INSERT INTO agenda (nama_kegiatan, tanggal, jam, lokasi) VALUES ('$judul', '$tanggal', '$jam', '$lokasi')");
}

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM agenda WHERE id_agenda = $id");
    header("Location: agenda.php"); exit();
}

$query_agenda = mysqli_query($koneksi, "SELECT * FROM agenda ORDER BY tanggal ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Agenda - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-calendar-days me-2"></i>Kelola Agenda Kegiatan</h2>
        <a href="dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3">Tambah Agenda</h4>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" placeholder="Contoh: Kerja Bakti Desa" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jam / Waktu</label>
                        <input type="time" name="jam" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Balai Desa" required>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-primary w-100">Simpan Agenda</button>
                </form>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3">Jadwal Agenda Desa</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead><tr><th>Kegiatan</th><th>Waktu</th><th>Lokasi</th><th>Aksi</th></tr></thead>
                        <tbody>
                            <?php while ($a = mysqli_fetch_assoc($query_agenda)): ?>
                                <tr>
                                    <td class="fw-bold"><?= $a['nama_kegiatan']; ?></td>
                                    <td><small class="badge bg-primary"><?= $a['tanggal']; ?> @ <?= $a['jam']; ?></small></td>
                                    <td><?= $a['lokasi']; ?></td>
                                    <td>
                                        <a href="agenda.php?hapus=<?= $a['id_agenda']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus agenda ini?');"><i class="fa-solid fa-trash"></i></a>
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