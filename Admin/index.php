<?php
$page_title = "Kelola Profil Desa";
require_once '../Admin/header.php';
require_once '../Admin/sidebar.php';

$success = '';
$error   = '';

// Ambil data profil desa
$query  = mysqli_query($koneksi, "SELECT * FROM profil_desa LIMIT 1");
$profil = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_desa = mysqli_real_escape_string($koneksi, $_POST['nama_desa']);
    $kecamatan = mysqli_real_escape_string($koneksi, $_POST['kecamatan']);
    $kabupaten = mysqli_real_escape_string($koneksi, $_POST['kabupaten']);
    $provinsi  = mysqli_real_escape_string($koneksi, $_POST['provinsi']);
    $kode_pos  = mysqli_real_escape_string($koneksi, $_POST['kode_pos']);
    $sejarah   = mysqli_real_escape_string($koneksi, $_POST['sejarah']);
    $visi      = mysqli_real_escape_string($koneksi, $_POST['visi']);
    $misi      = mysqli_real_escape_string($koneksi, $_POST['misi']);
    $alamat    = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $telepon   = mysqli_real_escape_string($koneksi, $_POST['telepon']);
    $email     = mysqli_real_escape_string($koneksi, $_POST['email']);

    // Proses Upload Logo baru jika ada
    $logo_name = $profil['logo'] ?? 'logo.png';
    if (!empty($_FILES['logo']['name'])) {
        $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'svg'];
        
        if (in_array($ext, $allowed)) {
            $new_logo = 'logo_' . time() . '.' . $ext;
            $target = '../../assets/images/' . $new_logo;
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $target)) {
                $logo_name = $new_logo;
            }
        } else {
            $error = 'Format logo harus JPG, PNG, atau SVG!';
        }
    }

    if (empty($error)) {
        if ($profil) {
            $sql = "UPDATE profil_desa SET 
                    nama_desa='$nama_desa', kecamatan='$kecamatan', kabupaten='$kabupaten', 
                    provinsi='$provinsi', kode_pos='$kode_pos', sejarah='$sejarah', 
                    visi='$visi', misi='$misi', alamat='$alamat', telepon='$telepon', 
                    email='$email', logo='$logo_name' WHERE id_profil=" . $profil['id_profil'];
        } else {
            $sql = "INSERT INTO profil_desa (nama_desa, kecamatan, kabupaten, provinsi, kode_pos, sejarah, visi, misi, alamat, telepon, email, logo) 
                    VALUES ('$nama_desa', '$kecamatan', '$kabupaten', '$provinsi', '$kode_pos', '$sejarah', '$visi', '$misi', '$alamat', '$telepon', '$email', '$logo_name')";
        }

        if (mysqli_query($koneksi, $sql)) {
            $success = 'Data profil desa berhasil diperbarui!';
            // Refresh data terbaru
            $query  = mysqli_query($koneksi, "SELECT * FROM profil_desa LIMIT 1");
            $profil = mysqli_fetch_assoc($query);
        } else {
            $error = 'Gagal menyimpan perubahan: ' . mysqli_error($koneksi);
        }
    }
}
?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i> <?= $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-1"></i> <?= $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-3 p-4">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold small">Nama Desa</label>
                <input type="text" name="nama_desa" class="form-control" value="<?= $profil['nama_desa'] ?? 'Desa Pilang'; ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold small">Kecamatan</label>
                <input type="text" name="kecamatan" class="form-control" value="<?= $profil['kecamatan'] ?? 'Wonoayu'; ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold small">Kabupaten</label>
                <input type="text" name="kabupaten" class="form-control" value="<?= $profil['kabupaten'] ?? 'Sidoarjo'; ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold small">Provinsi</label>
                <input type="text" name="provinsi" class="form-control" value="<?= $profil['provinsi'] ?? 'Jawa Timur'; ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold small">Kode Pos</label>
                <input type="text" name="kode_pos" class="form-control" value="<?= $profil['kode_pos'] ?? '61261'; ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small">Telepon</label>
                <input type="text" name="telepon" class="form-control" value="<?= $profil['telepon'] ?? ''; ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold small">Email</label>
                <input type="email" name="email" class="form-control" value="<?= $profil['email'] ?? ''; ?>">
            </div>

            <div class="col-12">
                <label class="form-label fw-bold small">Alamat Kantor Desa</label>
                <input type="text" name="alamat" class="form-control" value="<?= $profil['alamat'] ?? ''; ?>">
            </div>

            <div class="col-12">
                <label class="form-label fw-bold small">Sejarah Desa</label>
                <textarea name="sejarah" class="form-control" rows="5"><?= $profil['sejarah'] ?? ''; ?></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small">Visi Desa</label>
                <textarea name="visi" class="form-control" rows="4"><?= $profil['visi'] ?? ''; ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold small">Misi Desa</label>
                <textarea name="misi" class="form-control" rows="4"><?= $profil['misi'] ?? ''; ?></textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold small">Logo Desa (Opsional)</label>
                <input type="file" name="logo" class="form-control">
                <small class="text-muted">Logo saat ini: <?= $profil['logo'] ?? 'logo.png'; ?></small>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>

<?php require_once '../Admin/footer.php'; ?>