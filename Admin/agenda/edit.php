<?php
$page_title = "Edit Agenda";
require_once '../Admin/header.php';
require_once '../Admin/sidebar.php';

$id = intval($_GET['id'] ?? 0);
$query = mysqli_query($koneksi, "SELECT * FROM agenda WHERE id_agenda = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_agenda = mysqli_real_escape_string($koneksi, $_POST['nama_agenda']);
    $tanggal     = $_POST['tanggal'];
    $lokasi      = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $deskripsi   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    $sql = "UPDATE agenda SET nama_agenda='$nama_agenda', tanggal='$tanggal', lokasi='$lokasi', deskripsi='$deskripsi' WHERE id_agenda=$id";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: index.php?msg=updated");
        exit;
    } else {
        $error = 'Gagal memperbarui agenda: ' . mysqli_error($koneksi);
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
                <input type="text" name="nama_agenda" class="form-control" value="<?= $data['nama_agenda']; ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold small">Tanggal Pelaksanaan</label>
                <input type="date" name="tanggal" class="form-control" value="<?= $data['tanggal']; ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold small">Lokasi / Tempat</label>
                <input type="text" name="lokasi" class="form-control" value="<?= $data['lokasi']; ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold small">Deskripsi Kegiatan</label>
                <textarea name="deskripsi" class="form-control" rows="4"><?= $data['deskripsi']; ?></textarea>
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Agenda</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </form>
</div>

<?php require_once '../Admin/footer.php'; ?>