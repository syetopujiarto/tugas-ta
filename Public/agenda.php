<?php
$page_title = "Agenda Desa";
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
        <h1 class="fw-bold">Agenda & Kegiatan Desa</h1>
        <p class="text-muted">Jadwal agenda mendatang dan program kerja Desa Pilang</p>
        <div class="mx-auto bg-primary" style="height: 3px; width: 60px; border-radius: 2px;"></div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <?php
            $query_agenda = mysqli_query($koneksi, "SELECT * FROM agenda ORDER BY tanggal DESC");
            if (mysqli_num_rows($query_agenda) > 0):
            ?>
                <div class="timeline">
                    <?php while ($a = mysqli_fetch_assoc($query_agenda)): ?>
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="far fa-calendar-check fs-6"></i>
                            </div>
                            <div class="card border-0 shadow-sm rounded-4 p-4">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                                    <h5 class="fw-bold mb-1 text-primary"><?= $a['nama_agenda']; ?></h5>
                                    <span class="badge bg-light text-dark border">
                                        <i class="far fa-clock me-1 text-primary"></i> <?= date('d M Y', strtotime($a['tanggal'])); ?>
                                    </span>
                                </div>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-map-marker-alt text-danger me-1"></i> <strong>Lokasi:</strong> <?= $a['lokasi']; ?>
                                </p>
                                <p class="text-secondary small mb-0 lh-base">
                                    <?= nl2br($a['deskripsi']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center text-muted py-5">
                    <i class="far fa-calendar-times fa-3x mb-3 text-secondary"></i>
                    <p>Belum ada agenda kegiatan dalam waktu dekat.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../Public/footer.php'; ?>