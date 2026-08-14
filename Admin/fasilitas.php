<?php
session_start();
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit(); }

if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_fasilitas']);
    $lokasi = mysqli_real_escape_string($koneksi, $_POST['lokasi']);

    $foto_nama = $_FILES['gambar']['name'];
    $foto_tmp  = $_FILES['gambar']['tmp_name'];
    
    if (!empty($foto_nama)) {
        $ext = pathinfo($foto_nama, PATHINFO_EXTENSION);
        $foto_baru = time() . '_' . rand(100, 999) . '.' . $ext;
        if (move_uploaded_file($foto_tmp, __DIR__ . '/../Public/uploads/fasilitas/' . $foto_baru)) {
            mysqli_query($koneksi, "INSERT INTO fasilitas (nama_fasilitas, lokasi, gambar) VALUES ('$nama', '$lokasi', '$foto_baru')");
        }
    }
}

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $get_foto = mysqli_query($koneksi, "SELECT gambar FROM fasilitas WHERE id_fasilitas = $id");
    $data_foto = mysqli_fetch_assoc($get_foto);
    if ($data_foto) {
        @unlink(__DIR__ . '/../Public/uploads/fasilitas/' . $data_foto['gambar']);
        mysqli_query($koneksi, "DELETE FROM fasilitas WHERE id_fasilitas = $id");
        header("Location: fasilitas.php"); exit();
    }
}

$query_fasilitas = mysqli_query($koneksi, "SELECT * FROM fasilitas ORDER BY id_fasilitas DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
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

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3">Tambah Fasilitas</h4>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Fasilitas</label>
                        <input type="text" name="nama_fasilitas" class="form-control" placeholder="Contoh: Balai Desa / Lapangan Olahraga" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi / Alamat</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="Contoh: RT 02 / RW 01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Fasilitas</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-primary w-100">Simpan Fasilitas</button>
                </form>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3">Daftar Fasilitas Publik</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead><tr><th>Foto</th><th>Fasilitas</th><th>Lokasi</th><th>Aksi</th></tr></thead>
                        <tbody>
                            <?php while ($f = mysqli_fetch_assoc($query_fasilitas)): ?>
                                <tr>
                                    <td><img src="<?= BASE_URL; ?>/Public/uploads/fasilitas/<?= $f['gambar']; ?>" width="60" class="rounded"></td>
                                    <td class="fw-bold"><?= $f['nama_fasilitas']; ?></td>
                                    <td><?= $f['lokasi']; ?></td>
                                    <td>
                                        <a href="fasilitas.php?hapus=<?= $f['id_fasilitas']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus fasilitas ini?');"><i class="fa-solid fa-trash"></i></a>
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