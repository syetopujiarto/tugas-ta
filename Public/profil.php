

<?php
// Tampilkan semua error PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$page_title = "Profil Desa";
require_once __DIR__ . '/header.php';
// ... kode sisanya

<?php
$page_title = "Profil Desa";

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/navbar.php';

// Ambil data profil desa dari database
$query_profil = mysqli_query($koneksi, "SELECT * FROM profil_desa LIMIT 1");
$profil = mysqli_fetch_assoc($query_profil);

// Atur logo (jika di DB kosong, pakai default logo.png)
$logo_desa = !empty($profil['logo']) ? $profil['logo'] : 'logo.png';
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Profil <?= $profil['nama_desa'] ?? 'Desa Pilang'; ?></h1>
        <p class="text-muted">Mengenal lebih dekat sejarah, visi, dan identitas desa</p>
        <div class="mx-auto bg-primary" style="height: 3px; width: 60px; border-radius: 2px;"></div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                <div class="mb-3">
                    <img src="<?= BASE_URL; ?>/assets/images/<?= $logo_desa; ?>" 
                         alt="Logo Desa" height="120" class="img-fluid object-fit-contain" 
                         onerror="this.src='https://via.placeholder.com/120?text=Logo+Desa'">
                </div>
                <h4 class="fw-bold mb-1"><?= $profil['nama_desa'] ?? 'Desa Pilang'; ?></h4>
                <p class="text-muted small mb-3">Kecamatan <?= $profil['kecamatan'] ?? 'Wonoayu'; ?></p>
                <hr>
                <div class="text-start small text-muted">
                    <p class="mb-2"><i class="fas fa-map-marker-alt text-primary me-2"></i> <strong>Alamat:</strong> <?= $profil['alamat'] ?? '-'; ?></p>
                    <p class="mb-2"><i class="fas fa-map-marked-alt text-primary me-2"></i> <strong>Kabupaten:</strong> <?= $profil['kabupaten'] ?? 'Sidoarjo'; ?></p>
                    <p class="mb-2"><i class="fas fa-landmark text-primary me-2"></i> <strong>Provinsi:</strong> <?= $profil['provinsi'] ?? 'Jawa Timur'; ?></p>
                    <p class="mb-2"><i class="fas fa-mail-bulk text-primary me-2"></i> <strong>Kode Pos:</strong> <?= $profil['kode_pos'] ?? '61261'; ?></p>
                    <p class="mb-2"><i class="fas fa-envelope text-primary me-2"></i> <strong>Email:</strong> <?= $profil['email'] ?? '-'; ?></p>
                    <p class="mb-0"><i class="fas fa-phone text-primary me-2"></i> <strong>Telepon:</strong> <?= $profil['telepon'] ?? '-'; ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h4 class="fw-bold mb-3"><i class="fas fa-history text-primary me-2"></i>Sejarah Desa</h4>
                <p class="text-muted lh-lg mb-0">
                    <?= nl2br($profil['sejarah'] ?? 'Data sejarah desa belum diisi.'); ?>
                </p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 border-start border-primary border-4">
                <h4 class="fw-bold mb-3"><i class="fas fa-eye text-primary me-2"></i>Visi</h4>
                <p class="text-muted lh-lg mb-0"><?= nl2br($profil['visi'] ?? 'Data visi desa belum diisi.'); ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 border-start border-success border-4">
                <h4 class="fw-bold mb-3"><i class="fas fa-bullseye text-success me-2"></i>Misi</h4>
                <p class="text-muted lh-lg mb-0"><?= nl2br($profil['misi'] ?? 'Data misi desa belum diisi.'); ?></p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>