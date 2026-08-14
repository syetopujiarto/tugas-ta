<?php
session_start();
require_once __DIR__ . '/../config.php';

// Proteksi Session Login Admin
if (!isset($_SESSION['login'])) { 
    header("Location: login.php"); 
    exit(); 
}

$pesan = ''; 
$pesan_error = '';

// 1. PROSES TAMBAH KARYA DESA
if (isset($_POST['tambah'])) {
    $judul     = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pembuat   = mysqli_real_escape_string($koneksi, $_POST['pembuat']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    $foto_nama = $_FILES['gambar']['name'];
    $foto_tmp  = $_FILES['gambar']['tmp_name'];
    
    if (!empty($foto_nama)) {
        $ext = pathinfo($foto_nama, PATHINFO_EXTENSION);
        $foto_baru = time() . '_' . rand(100, 999) . '.' . $ext;
        $target_dir = __DIR__ . '/../Public/uploads/karya/' . $foto_baru;

        if (move_uploaded_file($foto_tmp, $target_dir)) {
            $query = "INSERT INTO karya (judul, pembuat, deskripsi, gambar) 
                      VALUES ('$judul', '$pembuat', '$deskripsi', '$foto_baru')";
            if (mysqli_query($koneksi, $query)) {
                $pesan = "Karya desa berhasil ditambahkan!";
            } else {
                $pesan_error = "Gagal menyimpan ke database: " . mysqli_error($koneksi);
            }
        } else {
            $pesan_error = "Gagal mengunggah foto. Pastikan folder Public/uploads/karya/ sudah ada.";
        }
    } else {
        $pesan_error = "Wajib mengunggah foto karya.";
    }
}

// 2. PROSES HAPUS KARYA DESA
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $get_foto = mysqli_query($koneksi, "SELECT gambar FROM karya WHERE id_karya = $id");
    $data_foto = mysqli_fetch_assoc($get_foto);

    if ($data_foto) {
        @unlink(__DIR__ . '/../Public/uploads/karya/' . $data_foto['gambar']);
        mysqli_query($koneksi, "DELETE FROM karya WHERE id_karya = $id");
        header("Location: karya.php"); 
        exit();
    }
}

// Ambil Seluruh Data Karya Desa
$query_karya = mysqli_query($koneksi, "SELECT * FROM karya ORDER BY id_karya DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Karya Desa - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-palette me-2"></i>Kelola Karya Desa</h2>
        <a href="dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
    </div>

    <?php if ($pesan): ?>
        <div class="alert alert-success alert-dismissible fade show"><?= $pesan; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <?php if ($pesan_error): ?>
        <div class="alert alert-danger alert-dismissible fade show"><?= $pesan_error; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3"><i class="fa-solid fa-plus me-2 text-primary"></i>Tambah Karya Baru</h4>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama / Judul Karya</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Kerajinan Ukiran Kayu" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pembuat / Kreator</label>
                        <input type="text" name="pembuat" class="form-control" placeholder="Contoh: Kelompok Tani / Nama Warga">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Karya</label>
                        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan secara singkat mengenai karya ini..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Karya</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-primary w-100">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Karya
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3"><i class="fa-solid fa-list me-2 text-primary"></i>Daftar Karya Desa</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Gambar</th>
                                <th>Judul & Pembuat</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($query_karya) > 0): ?>
                                <?php while ($k = mysqli_fetch_assoc($query_karya)): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= BASE_URL; ?>/Public/uploads/karya/<?= $k['gambar']; ?>" 
                                                 width="60" height="60" class="rounded object-fit-cover"
                                                 onerror="this.src='https://via.placeholder.com/60?text=No+Img';">
                                        </td>
                                        <td>
                                            <strong class="d-block"><?= $k['judul']; ?></strong>
                                            <small class="text-muted"><i class="fa-solid fa-user me-1"></i><?= $k['pembuat'] ?: 'Warga Desa'; ?></small>
                                        </td>
                                        <td class="small text-secondary"><?= substr($k['deskripsi'], 0, 80); ?>...</td>
                                        <td>
                                            <a href="karya.php?hapus=<?= $k['id_karya']; ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus karya ini?');">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada karya desa yang ditambahkan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>