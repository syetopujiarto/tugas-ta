<?php
$page_title = "Berita Desa";
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
        <h1 class="fw-bold">Berita Desa Pilang</h1>
        <p class="text-muted">Informasi terbaru seputar kegiatan, pembangunan, dan acara desa</p>
        <div class="mx-auto bg-primary" style="height: 3px; width: 60px; border-radius: 2px;"></div>
    </div>

    <div class="row g-4">
        <?php
        $query_berita = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY tanggal DESC");
        if (mysqli_num_rows($query_berita) > 0):
            while ($b = mysqli_fetch_assoc($query_berita)):
        ?>
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <img src="uploads/berita/<?= $b['gambar']; ?>" 
                         class="card-img-top" 
                         alt="<?= $b['judul']; ?>" 
                         style="height: 220px; object-fit: cover;"
                         onerror="this.src='assets/images/berita1.jpg'">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="text-muted small mb-2">
                            <i class="far fa-calendar-alt me-1 text-primary"></i> <?= date('d M Y', strtotime($b['tanggal'])); ?>
                        </div>
                        <h5 class="card-title fw-bold mb-3"><?= $b['judul']; ?></h5>
                        <p class="card-text text-muted small mb-4 flex-grow-1">
                            <?= substr(strip_tags($b['isi']), 0, 120) . '...'; ?>
                        </p>
                        <a href="berita_detail.php?id=<?= $b['id_berita']; ?>" class="btn btn-outline-primary rounded-pill btn-sm mt-auto">
                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php 
            endwhile;
        else:
        ?>
            <div class="col-12 text-center text-muted py-5">
                <i class="fas fa-newspaper fa-3x mb-3 text-secondary"></i>
                <p>Belum ada berita yang dipublikasikan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../Public/footer.php'; ?>