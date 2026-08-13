<?php
$page_title = "Galeri Desa";
require_once __DIR__ . '/header.php'; // Otomatis sudah ikut memanggil config.php
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
    .gallery-img-container {
        overflow: hidden;
        border-radius: 16px;
        cursor: pointer;
        position: relative;
    }
    .gallery-img-container img {
        transition: transform 0.3s ease;
    }
    .gallery-img-container:hover img {
        transform: scale(1.05);
    }
</style>

<div class="container py-5 mt-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Galeri Desa Pilang</h1>
        <p class="text-muted">Dokumentasi kegiatan dan momen penting di Desa Pilang</p>
        <div class="mx-auto bg-primary" style="height: 3px; width: 60px; border-radius: 2px;"></div>
    </div>

    <div class="row g-4">
        <?php
        $query_galeri = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY tanggal DESC");
        if (mysqli_num_rows($query_galeri) > 0):
            while ($g = mysqli_fetch_assoc($query_galeri)):
        ?>
            <div class="col-lg-4 col-md-6">
                <div class="gallery-img-container shadow-sm border" data-bs-toggle="modal" data-bs-target="#modalGaleri<?= $g['id_galeri']; ?>">
                    <img src="uploads/galeri/<?= $g['foto']; ?>" 
                         class="img-fluid w-100" 
                         alt="<?= $g['judul']; ?>" 
                         style="height: 250px; object-fit: cover;"
                         onerror="this.src='assets/images/galeri1.jpg'">
                    <div class="p-3 bg-white">
                        <h6 class="fw-bold mb-1 text-dark text-truncate"><?= $g['judul']; ?></h6>
                        <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> <?= date('d M Y', strtotime($g['tanggal'])); ?></small>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalGaleri<?= $g['id_galeri']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content rounded-4 border-0">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-header-title fw-bold"><?= $g['judul']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="uploads/galeri/<?= $g['foto']; ?>" 
                                 class="img-fluid rounded-3 mb-3" 
                                 alt="<?= $g['judul']; ?>"
                                 onerror="this.src='assets/images/galeri1.jpg'">
                            <p class="text-muted small text-start mb-0"><?= nl2br($g['keterangan']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            endwhile;
        else:
        ?>
            <div class="col-12 text-center text-muted py-5">
                <i class="fas fa-images fa-3x mb-3 text-secondary"></i>
                <p>Belum ada foto galeri yang diunggah.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../Public/footer.php'; ?>