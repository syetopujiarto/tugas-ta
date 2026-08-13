<?php
require_once '/../config.php';

// Ambil ID dari URL
$id_berita = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query detail berita dengan Prepared Statement
$stmt = mysqli_prepare($koneksi, "SELECT b.*, a.nama AS nama_admin FROM berita b LEFT JOIN admin a ON b.id_admin = a.id_admin WHERE b.id_berita = ?");
mysqli_stmt_bind_param($stmt, "i", $id_berita);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$berita = mysqli_fetch_assoc($result);

// Redirect jika data tidak ditemukan
if (!$berita) {
    header("Location: berita.php");
    exit;
}

$page_title = $berita['judul'];
require_once '../Public/header.php';
require_once '../Public/navbar.php';
?>

<style>
    .navbar-custom {
        background-color: #ffffff !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }
    .navbar-custom .nav-link {
        color: var(--dark-color) !important;
    }
    .navbar-brand-text {
        color: var(--dark-color) !important;
    }
</style>

<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="berita.php" class="text-decoration-none">Berita</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Berita</li>
                </ol>
            </nav>

            <h1 class="fw-bold mb-3"><?= $berita['judul']; ?></h1>
            
            <div class="d-flex align-items-center gap-3 text-muted small mb-4 pb-3 border-bottom">
                <span><i class="far fa-user me-1 text-primary"></i> Oleh: <?= $berita['nama_admin'] ?? 'Admin Desa'; ?></span>
                <span><i class="far fa-calendar-alt me-1 text-primary"></i> <?= date('d F Y', strtotime($berita['tanggal'])); ?></span>
            </div>

            <div class="mb-4">
                <img src="uploads/berita/<?= $berita['gambar']; ?>" 
                     class="img-fluid rounded-4 w-100 shadow-sm" 
                     alt="<?= $berita['judul']; ?>" 
                     style="max-height: 450px; object-fit: cover;"
                     onerror="this.src='assets/images/berita1.jpg'">
            </div>

            <div class="lh-lg text-secondary mb-5 fs-6">
                <?= nl2br($berita['isi']); ?>
            </div>

            <div class="border-top pt-4">
                <a href="berita.php" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Berita
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../Public/footer.php'; ?>