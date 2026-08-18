<?php
$page_title = "Layanan Desa";
require_once __DIR__ . '/header.php'; 
require_once __DIR__ . '/navbar.php';
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
    <div class="text-center mb-5">
        <h1 class="fw-bold">Layanan Desa Pilang</h1>
        <p class="text-muted">Panduan dan persyaratan administrasi pelayanan publik bagi warga desa</p>
        <div class="mx-auto bg-primary" style="height: 3px; width: 60px; border-radius: 2px;"></div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="accordion accordion-flush shadow-sm rounded-4 overflow-hidden border" id="accordionLayanan">
                <?php
                // Mengecek query ke tabel layanan_desa atau fallback ke tabel layanan
                $query_layanan = mysqli_query($koneksi, "SELECT * FROM layanan_desa ORDER BY id_layanan ASC");
                if (!$query_layanan) {
                    $query_layanan = mysqli_query($koneksi, "SELECT * FROM layanan");
                }

                if ($query_layanan && mysqli_num_rows($query_layanan) > 0):
                    $no = 0;
                    while ($l = mysqli_fetch_assoc($query_layanan)):
                        $no++;
                        $id_layanan = $l['id_layanan'] ?? $l['id'] ?? $no;
                        $collapse_id = "collapse" . $id_layanan;
                        $heading_id = "heading" . $id_layanan;

                        // Penanganan variabel dinamis
                        $nama_layanan    = $l['nama_layanan'] ?? $l['judul'] ?? $l['nama'] ?? 'Layanan Desa';
                        $persyaratan     = $l['persyaratan'] ?? $l['syarat'] ?? '-';
                        $prosedur        = $l['prosedur'] ?? $l['keterangan'] ?? '-';
                        $waktu_pelayanan = $l['waktu_pelayanan'] ?? $l['waktu'] ?? $l['durasi'] ?? '1 Hari Kerja';
                ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="<?= $heading_id; ?>">
                            <button class="accordion-button <?= $no !== 1 ? 'collapsed' : ''; ?> fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapse_id; ?>" aria-expanded="<?= $no === 1 ? 'true' : 'false'; ?>" aria-controls="<?= $collapse_id; ?>">
                                <i class="fas fa-file-alt text-primary me-3 fs-5"></i> <?= $nama_layanan; ?>
                            </button>
                        </h2>
                        <div id="<?= $collapse_id; ?>" class="accordion-collapse collapse <?= $no === 1 ? 'show' : ''; ?>" aria-labelledby="<?= $heading_id; ?>" data-bs-parent="#accordionLayanan">
                            <div class="accordion-body p-4 bg-light">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="bg-white p-3 rounded-3 shadow-sm h-100">
                                            <h6 class="fw-bold text-primary mb-2"><i class="fas fa-list-check me-2"></i>Persyaratan</h6>
                                            <p class="text-secondary small mb-0"><?= nl2br($persyaratan); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="bg-white p-3 rounded-3 shadow-sm h-100">
                                            <h6 class="fw-bold text-success mb-2"><i class="fas fa-tasks me-2"></i>Prosedur</h6>
                                            <p class="text-secondary small mb-0"><?= nl2br($prosedur); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="bg-white p-3 rounded-3 shadow-sm d-flex align-items-center gap-2">
                                            <i class="far fa-clock text-warning fs-5"></i>
                                            <div>
                                                <strong class="small d-block text-dark">Waktu Pelayanan / Selesai:</strong>
                                                <span class="text-muted small"><?= $waktu_pelayanan; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                    endwhile;
                else:
                ?>
                    <div class="p-5 text-center text-muted">
                        <i class="fas fa-folder-open fa-3x mb-3 text-secondary"></i>
                        <p class="mb-0">Belum ada data layanan desa yang tersedia.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>