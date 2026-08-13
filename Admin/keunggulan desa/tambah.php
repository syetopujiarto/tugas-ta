<?php
$page_title = "Tambah Potensi Desa";
require_once '../Admin/header.php';
require_once '../Admin/sidebar.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_potensi = mysqli_real_escape_string($koneksi, $_POST['nama_potensi']);
    $kategori     = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $deskripsi    = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    $gambar_name = 'potensi1.jpg';
    if (!empty($_FILES['gambar']['name'])) {
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];
        if (in_array($ext, $allowed)) {
            $gambar_name = 'potensi_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['gambar']['tmp_name'], '../../uploads/potensi/' . $gambar_name);
        } else {
            $error = 'Format gambar harus JPG, JPEG, atau PNG!';
        }
    }

    if (empty($error)) {
        $sql = "INSERT INTO potensi_desa (nama_potensi, kategori, deskripsi, gambar) VALUES ('$nama_potensi', '$kategori', '$deskripsi', '$gambar_name')";
        if (mysqli_query($koneksi, $sql)) {
            header("Location: index.php?msg=added");
            exit;
        } else {
            $error = 'Gagal menyimpan data: ' . mysqli_error($koneksi);
        }
    }
}
?>

<div class="card border-0 shadow-sm rounded-3 p-4">
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-bold small">Nama Potensi / Produk</label>
                <input type="text" name="nama_potensi" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold small">Kategori</label>
                <input type="text" name="kategori" class="form-control" placeholder="Contoh: Pertanian, UMKM, Wisata" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold small">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="5" required></textarea>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold small">Gambar Potensi</label>
                <input type="file" name="gambar" class="form-control">
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Potensi</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </form>
</div>

<?php require_once '../Admin/footer.php'; ?>