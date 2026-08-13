<?php
$page_title = "Edit Fasilitas Desa";
require_once '../Admin/header.php';
require_once '../Admin/sidebar.php';

$id = intval($_GET['id'] ?? 0);
$query = mysqli_query($koneksi, "SELECT * FROM fasilitas WHERE id_fasilitas = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_fasilitas = mysqli_real_escape_string($koneksi, $_POST['nama_fasilitas']);
    $kategori       = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $alamat         = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $foto_name = $data['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];
        if (in_array($ext, $allowed)) {
            $foto_name = 'fasilitas_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], '../../uploads/fasilitas/' . $foto_name);
        } else {
            $error = 'Format foto harus JPG, JPEG, atau PNG!';
        }
    }

    if (empty($error)) {
        $sql = "UPDATE fasilitas SET nama_fasilitas='$nama_fasilitas', kategori='$kategori', alamat='$alamat', foto='$foto_name' WHERE id_fasilitas=$id";
        if (mysqli_query($koneksi, $sql)) {
            header("Location: index.php?msg=updated");
            exit;
        } else {
            $error = 'Gagal mengupdate fasilitas: ' . mysqli_error($koneksi);
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
                <label class="form-label fw-bold small">Nama Fasilitas / Sarana</label>
                <input type="text" name="nama_fasilitas" class="form-control" value="<?= $data['nama_fasilitas']; ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold small">Kategori</label>
                <input type="text" name="kategori" class="form-control" value="<?= $data['kategori']; ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold small">Alamat / Lokasi</label>
                <input type="text" name="alamat" class="form-control" value="<?= $data['alamat']; ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold small">Ganti Foto (Opsional)</label>
                <input type="file" name="foto" class="form-control">
                <small class="text-muted">Foto saat ini: <?= $data['foto']; ?></small>
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Fasilitas</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </form>
</div>

<?php require_once '../Admin/footer.php'; ?>