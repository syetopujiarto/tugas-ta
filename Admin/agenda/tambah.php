<?php
$page_title = "Tambah Agenda";
require_once '../Admin/header.php';
require_once '../Admin/sidebar.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_agenda = mysqli_real_escape_string($koneksi, $_POST['nama_agenda']);
    $tanggal     = $_POST['tanggal'];
    $lokasi      = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $deskripsi   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    $sql = "INSERT INTO agenda (nama_agenda, tanggal, lokasi, deskripsi) VALUES ('$nama_agenda', '$tanggal', '$lokasi', '$deskripsi')";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: index.php?msg=added");
        exit;
    } else {
        $error = 'Gagal menyimpan agenda: ' . mysqli_error($koneksi);
    }
}
?>

<div class="card border-0 shadow-sm rounded-3 p-4">
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-bold small">Nama Agenda / Kegiatan</label>
                <input type="text" name="nama_agenda" class="form-control" placeholder="Contoh: Musyawarah Desa Pilang" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold small">Tanggal Pelaksanaan</label>
                <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold small">Lokasi / Tempat</label>
                <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Balai Desa Pilang" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold small">Deskripsi Kegiatan</label>
                <textarea name="deskripsi" class="form-control" rows="4"></textarea>
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Agenda</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </form>
</div>

<?php require_once '../Admin/footer.php'; ?>