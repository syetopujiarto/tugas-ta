<?php
$page_title = "Potensi Desa";
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
        <h1 class="fw-bold">Potensi Desa Pilang</h1>
        <p class="text-muted">Kekayaan UMKM, Pertanian, Kesenian, dan Produk Lokal Desa</p>
        <div class="mx-auto bg-primary" style="height: 3px; width: 60px; border-radius: 2px;"></div>
    </div>

    <div class="row g-4">
        <?php
        $query_potensi = mysqli_query($koneksi, "SELECT * FROM potensi_desa ORDER BY id_potensi DESC");
        if (mysqli_num_rows($query_potensi) > 0):
            while ($p = mysqli_fetch_assoc($query_potensi)):
        ?>
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <img src="uploads/potensi/<?= $p['gambar']; ?>" 
                         class="card-img-top" 
                         alt="<?= $p['nama_potensi']; ?>" 
                         style="height: 220px; object-fit: cover;"
                         onerror="this.src='assets/images/potensi1.jpg'">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-light text-primary border"><?= $p['kategori']; ?></span>
                        </div>
                        <h5 class="card-title fw-bold mb-3"><?= $p['nama_potensi']; ?></h5>
                        <p class="card-text text-muted small lh-base mb-0">
                            <?= nl2br($p['deskripsi']); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php 
            endwhile;
        else:
        ?>
            <div class="col-12 text-center text-muted py-5">
                <i class="fas fa-store-slash fa-3x mb-3 text-secondary"></i>
                <p>Belum ada data potensi desa yang terdaftar.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../Public/footer.php'; ?>