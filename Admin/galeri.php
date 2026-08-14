<?php
session_start();
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit(); }

if (isset($_POST['tambah'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $foto_nama = $_FILES['foto']['name'];
    $foto_tmp  = $_FILES['foto']['tmp_name'];
    
    if (!empty($foto_nama)) {
        $ext = pathinfo($foto_nama, PATHINFO_EXTENSION);
        $foto_baru = time() . '_' . rand(100, 999) . '.' . $ext;
        if (move_uploaded_file($foto_tmp, __DIR__ . '/../Public/uploads/galeri/' . $foto_baru)) {
            mysqli_query($koneksi, "INSERT INTO galeri (judul, foto) VALUES ('$judul', '$foto_baru')");
        }
    }
}

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $get_foto = mysqli_query($koneksi, "SELECT foto FROM galeri WHERE id_galeri = $id");
    $data_foto = mysqli_fetch_assoc($get_foto);
    if ($data_foto) {
        @unlink(__DIR__ . '/../Public/uploads/galeri/' . $data_foto['foto']);
        mysqli_query($koneksi, "DELETE FROM galeri WHERE id_galeri = $id");
        header("Location: galeri.php"); exit();
    }
}

$query_galeri = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY id_galeri DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Galeri - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-images me-2"></i>Kelola Galeri Foto</h2>
        <a href="dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3">Upload Foto</h4>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul / Keterangan Foto</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Foto</label>
                        <input type="file" name="foto" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-primary w-100">Simpan Foto</button>
                </form>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row g-3">
                <?php while ($g = mysqli_fetch_assoc($query_galeri)): ?>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                            <img src="<?= BASE_URL; ?>/Public/uploads/galeri/<?= $g['foto']; ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-2 text-center">
                                <small class="fw-bold text-truncate d-block"><?= $g['judul']; ?></small>
                                <a href="galeri.php?hapus=<?= $g['id_galeri']; ?>" class="btn btn-sm btn-danger mt-2 w-100" onclick="return confirm('Hapus foto ini?');"><i class="fa-solid fa-trash"></i> Hapus</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>