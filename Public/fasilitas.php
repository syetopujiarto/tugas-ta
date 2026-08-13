<?php
$page_title = "Fasilitas Desa";
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
        <h1 class="fw-bold">Fasilitas Desa Pilang</h1>
        <p class="text-muted">Sarana dan prasarana umum untuk menunjang aktivitas warga</p>
        <div class="mx-auto bg-primary" style="height: 3px; width: 60px; border-radius: 2px;"></div>
    </div>

    <div class="row g-4">
        <?php
        $query_fasilitas = mysqli_query($koneksi, "SELECT * FROM fasilitas ORDER BY id_fasilitas DESC");
        if (mysqli_num_rows($query_fasilitas) > 0):
            while ($f = mysqli_fetch_assoc($query_fasilitas)):
        ?>
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <img src="uploads/fasilitas/<?= $f['foto']; ?>" 
                         class="card-img-top" 
                         alt="<?= $f['nama_fasilitas']; ?>" 
                         style="height: 220px; object-fit: cover;"
                         onerror="this.src='assets/images/fasilitas1.jpg'">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-light text-success border"><?= $f['kategori']; ?></span>
                        </div>
                        <h5 class="card-title fw-bold mb-3"><?= $f['nama_fasilitas']; ?></h5>
                        <p class="card-text text-muted small mt-auto mb-0">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i> <?= $f['alamat']; ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php 
            endwhile;
        else:
        ?>
            <div class="col-12 text-center text-muted py-5">
                <i class="fas fa-building-circle-xmark fa-3x mb-3 text-secondary"></i>
                <p>Belum ada data fasilitas yang ditambahkan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../Public/footer.php'; ?>