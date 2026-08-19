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
$page_title = "Kelola Perangkat Desa";

// 1. PROSES TAMBAH DATA PERANGKAT DESA
if (isset($_POST['tambah'])) {
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $no_hp   = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $email   = mysqli_real_escape_string($koneksi, $_POST['email']);

    // Proses Upload Foto
    $foto_nama = $_FILES['foto']['name'];
    $foto_tmp  = $_FILES['foto']['tmp_name'];
    
    if (!empty($foto_nama)) {
        $target_folder = __DIR__ . '/../assets/img/';
        
        if (!file_exists($target_folder)) {
            mkdir($target_folder, 0777, true);
        }

        $ext = pathinfo($foto_nama, PATHINFO_EXTENSION);
        $foto_baru = time() . '_' . rand(100, 999) . '.' . strtolower($ext);
        $target_dir = $target_folder . $foto_baru;

        if (move_uploaded_file($foto_tmp, $target_dir)) {
            $query = "INSERT INTO perangkat_desa (nama, jabatan, no_hp, email, foto) 
                      VALUES ('$nama', '$jabatan', '$no_hp', '$email', '$foto_baru')";
            if (mysqli_query($koneksi, $query)) {
                $pesan = "Data Perangkat Desa berhasil ditambahkan!";
            } else {
                $pesan_error = "Gagal menyimpan ke database: " . mysqli_error($koneksi);
            }
        } else {
            $pesan_error = "Gagal mengupload foto ke folder assets/img/. Cek izin folder.";
        }
    } else {
        $pesan_error = "Wajib mengunggah foto perangkat desa.";
    }
}

// 2. PROSES HAPUS DATA PERANGKAT DESA
if (isset($_GET['hapus'])) {
    $id_perangkat = (int)$_GET['hapus'];
    
    $get_foto = mysqli_query($koneksi, "SELECT foto FROM perangkat_desa WHERE id_perangkat = $id_perangkat");
    $data_foto = mysqli_fetch_assoc($get_foto);
    
    if ($data_foto) {
        $path_foto = __DIR__ . '/../assets/img/' . $data_foto['foto'];
        if (file_exists($path_foto) && !empty($data_foto['foto'])) {
            unlink($path_foto);
        }
        
        mysqli_query($koneksi, "DELETE FROM perangkat_desa WHERE id_perangkat = $id_perangkat");
        header("Location: perangkat.php?pesan=dihapus");
        exit();
    }
}

// Ambil Seluruh Data Perangkat Desa
$query_perangkat = mysqli_query($koneksi, "SELECT * FROM perangkat_desa ORDER BY id_perangkat DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title; ?> - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; }
        .preview-card {
            border: 2px dashed #3b82f6;
            background-color: #ffffff;
            border-radius: 16px;
        }
        .avatar-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #e2e8f0;
        }
    </style>
</head>
<body>

<?php 
// Panggil Sidebar & Topbar Admin
include 'sidebar.php'; 
?>

<div class="container-fluid py-4">
    <?php if ($pesan): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i><?= $pesan; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($pesan_error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i><?= $pesan_error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'dihapus'): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-info me-2"></i>Data perangkat desa berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- FORM INPUT DATA -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="fa-solid fa-user-plus me-2"></i>Tambah Perangkat</h5>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" id="inputNama" name="nama" class="form-control" placeholder="" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jabatan</label>
                        <input type="text" id="inputJabatan" name="jabatan" class="form-control" placeholder="" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nomor Telepon/WA</label>
                        <input type="text" id="inputHp" name="no_hp" class="form-control" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Formal</label>
                        <input type="file" id="inputFoto" name="foto" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-primary w-100">
                        <i class="fa-solid fa-plus me-1"></i> Simpan Perangkat
                    </button>
                </form>
            </div>

            <!-- LIVE PREVIEW TAMPILAN PUBLIC -->
            <div class="preview-card p-4 text-center">
                <span class="badge bg-primary mb-3">Live Preview Tampilan Public</span>
                <div class="d-flex justify-content-center mb-3">
                    <img id="previewImg" src="https://via.placeholder.com/120?text=Foto" class="avatar-preview shadow-sm" alt="Preview Foto">
                </div>
                <h6 class="fw-bold mb-1 text-dark" id="previewNama">-</h6>
                <p class="text-primary fw-medium small mb-3" id="previewJabatan">-</p>
                <div class="text-start border-top pt-3 small text-muted">
                    <div class="mb-1"><i class="fa-solid fa-phone me-2 text-success"></i><span id="previewHp">-</span></div>
                    <div><i class="fa-solid fa-envelope me-2 text-danger"></i><span id="previewEmail">-</span></div>
                </div>
            </div>
        </div>

        <!-- TABEL KELOLA & PRIVIU DATA -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-users me-2"></i>Daftar Perangkat Desa</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama & Jabatan</th>
                                <th>Kontak</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($query_perangkat) > 0): ?>
                                <?php $no = 1; while ($row = mysqli_fetch_assoc($query_perangkat)): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td>
                                            <img src="<?= BASE_URL; ?>/assets/img/<?= $row['foto']; ?>" 
                                                 class="rounded-circle" 
                                                 style="width: 50px; height: 50px; object-fit: cover;"
                                                 onerror="this.src='https://via.placeholder.com/50';">
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= $row['nama']; ?></div>
                                            <small class="text-primary"><?= $row['jabatan']; ?></small>
                                        </td>
                                        <td>
                                            <div class="small"><i class="fa-solid fa-phone text-muted me-1"></i><?= $row['no_hp'] ?: '-'; ?></div>
                                            <div class="small"><i class="fa-solid fa-envelope text-muted me-1"></i><?= $row['email'] ?: '-'; ?></div>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" 
                                               class="btn btn-outline-danger btn-sm rounded-circle" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#modalHapus<?= $row['id_perangkat']; ?>"
                                               title="Hapus Data">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>

                                            <!-- MODAL KONFIRMASI HAPUS -->
                                            <div class="modal fade" id="modalHapus<?= $row['id_perangkat']; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 rounded-4">
                                                        <div class="modal-body text-center p-4">
                                                            <i class="fa-solid fa-circle-exclamation text-warning display-4 mb-3"></i>
                                                            <h5 class="fw-bold">Konfirmasi Hapus</h5>
                                                            <p class="text-muted">Apakah Anda yakin ingin menghapus <strong><?= $row['nama']; ?></strong>?</p>
                                                            <div class="d-flex justify-content-center gap-2 mt-4">
                                                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                                                <a href="perangkat.php?hapus=<?= $row['id_perangkat']; ?>" class="btn btn-danger px-4">Hapus</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada data perangkat desa.</td>
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
<script>
    // Live Preview Script
    const inputNama = document.getElementById('inputNama');
    const inputJabatan = document.getElementById('inputJabatan');
    const inputHp = document.getElementById('inputHp');
    const inputEmail = document.getElementById('inputEmail');
    const inputFoto = document.getElementById('inputFoto');

    inputNama.addEventListener('input', (e) => {
        document.getElementById('previewNama').textContent = e.target.value || '-';
    });

    inputJabatan.addEventListener('input', (e) => {
        document.getElementById('previewJabatan').textContent = e.target.value || '-';
    });

    inputHp.addEventListener('input', (e) => {
        document.getElementById('previewHp').textContent = e.target.value || '-';
    });

    inputEmail.addEventListener('input', (e) => {
        document.getElementById('previewEmail').textContent = e.target.value || '-';
    });

    inputFoto.addEventListener('change', function() {
        const [file] = this.files;
        if (file) {
            document.getElementById('previewImg').src = URL.createObjectURL(file);
        }
    });
</script>
</body>
</html>