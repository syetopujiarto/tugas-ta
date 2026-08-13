<?php
$page_title = "Kelola Informasi Kontak Desa";
require_once '../Admin/header.php';
require_once '../Admin/sidebar.php';

$success = '';
$error   = '';

$query  = mysqli_query($koneksi, "SELECT * FROM kontak LIMIT 1");
$kontak = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alamat    = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $telepon   = mysqli_real_escape_string($koneksi, $_POST['telepon']);
    $email     = mysqli_real_escape_string($koneksi, $_POST['email']);
    $facebook  = mysqli_real_escape_string($koneksi, $_POST['facebook']);
    $instagram = mysqli_real_escape_string($koneksi, $_POST['instagram']);
    $youtube   = mysqli_real_escape_string($koneksi, $_POST['youtube']);
    $maps      = mysqli_real_escape_string($koneksi, $_POST['maps']);

    if ($kontak) {
        $sql = "UPDATE kontak SET alamat='$alamat', telepon='$telepon', email='$email', facebook='$facebook', instagram='$instagram', youtube='$youtube', maps='$maps' WHERE id_kontak=" . $kontak['id_kontak'];
    } else {
        $sql = "INSERT INTO kontak (alamat, telepon, email, facebook, instagram, youtube, maps) VALUES ('$alamat', '$telepon', '$email', '$facebook', '$instagram', '$youtube', '$maps')";
    }

    if (mysqli_query($koneksi, $sql)) {
        $success = 'Informasi kontak berhasil diperbarui!';
        $query  = mysqli_query($koneksi, "SELECT * FROM kontak LIMIT 1");
        $kontak = mysqli_fetch_assoc($query);
    } else {
        $error = 'Gagal menyimpan perubahan: ' . mysqli_error($koneksi);
    }
}
?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i> <?= $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-1"></i> <?= $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-3 p-4">
    <form action="" method="POST">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-bold small">Alamat Lengkap Kantor Desa</label>
                <textarea name="alamat" class="form-control" rows="3" required><?= $kontak['alamat'] ?? ''; ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold small">Nomor Telepon / WhatsApp</label>
                <input type="text" name="telepon" class="form-control" value="<?= $kontak['telepon'] ?? ''; ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold small">Email Resmi Desa</label>
                <input type="email" name="email" class="form-control" value="<?= $kontak['email'] ?? ''; ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold small">Link Facebook</label>
                <input type="text" name="facebook" class="form-control" value="<?= $kontak['facebook'] ?? ''; ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold small">Link Instagram</label>
                <input type="text" name="instagram" class="form-control" value="<?= $kontak['instagram'] ?? ''; ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold small">Link YouTube</label>
                <input type="text" name="youtube" class="form-control" value="<?= $kontak['youtube'] ?? ''; ?>">
            </div>

            <div class="col-12">
                <label class="form-label fw-bold small">Embed Google Maps (iFrame Code)</label>
                <textarea name="maps" class="form-control" rows="4"><?= $kontak['maps'] ?? ''; ?></textarea>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Simpan Kontak</button>
            </div>
        </div>
    </form>
    
</div>

<?php require_once '../Admin/footer.php'; ?>