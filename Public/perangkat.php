<?php
$page_title = "Perangkat Desa";

// Pemanggilan Header dan Navbar (Satu folder di Public)
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

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Perangkat Desa Pilang</h1>
        <p class="text-muted">Aparatur Pemerintah Desa yang siap melayani masyarakat</p>
        <div class="mx-auto bg-primary" style="height: 3px; width: 60px; border-radius: 2px;"></div>
    </div>

    <div class="row g-4">
        <?php
        $query_perangkat = mysqli_query($koneksi, "SELECT * FROM perangkat_desa ORDER BY id_perangkat ASC");
        if ($query_perangkat && mysqli_num_rows($query_perangkat) > 0):
            while ($p = mysqli_fetch_assoc($query_perangkat)):
        ?>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 position-relative overflow-hidden">
                    <div class="mb-3 mt-2">
                        <img src="<?= BASE_URL; ?>/Public/uploads/perangkat/<?= $p['foto']; ?>" 
                             class="rounded-circle img-thumbnail shadow-sm" 
                             alt="<?= $p['nama']; ?>" 
                             style="width: 140px; height: 140px; object-fit: cover;"
                             onerror="this.src='https://via.placeholder.com/140?text=No+Image';">
                    </div>
                    <div class="card-body p-2 d-flex flex-column">
                        <h5 class="fw-bold mb-1"><?= $p['nama']; ?></h5>
                        <span class="badge bg-light text-primary mb-3 align-self-center border"><?= $p['jabatan']; ?></span>
                        
                        <div class="mt-auto text-start border-top pt-3 small text-muted">
                            <p class="mb-2"><i class="fas fa-phone text-success me-2"></i> <?= !empty($p['no_hp']) ? $p['no_hp'] : '-'; ?></p>
                            <p class="mb-0"><i class="fas fa-envelope text-primary me-2"></i> <?= !empty($p['email']) ? $p['email'] : '-'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            endwhile;
        else:
        ?>
            <div class="col-12 text-center text-muted py-5">
                <i class="fas fa-user-slash fa-3x mb-3 text-secondary"></i>
                <p>Belum ada data perangkat desa yang ditambahkan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>