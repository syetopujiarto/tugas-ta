<?php
$page_title = "Karya Desa";
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
        <h1 class="fw-bold">Karya Desa Pilang</h1>
        <p class="text-muted">Hasil karya, produk inovatif, dan potensi kreasi warga Desa Pilang</p>
        <div class="mx-auto bg-primary" style="height: 3px; width: 60px; border-radius: 2px;"></div>
    </div>

    <div class="row g-4">
        <?php
        // Mengambil data dari tabel karya
        $query_karya = mysqli_query($koneksi, "SELECT * FROM karya ORDER BY id_karya DESC");
        if ($query_karya && mysqli_num_rows($query_karya) > 0):
            while ($k = mysqli_fetch_assoc($query_karya)):
                // Penanganan nama kolom dinamis
                $judul     = $k['judul_karya'] ?? $k['nama_karya'] ?? $k['judul'] ?? $k['nama'] ?? 'Karya Desa';
                $deskripsi = $k['deskripsi'] ?? $k['keterangan'] ?? $k['isi'] ?? '-';
                $gambar    = $k['gambar'] ?? $k['foto'] ?? '';
                $kategori  = $k['kategori'] ?? 'Karya';
        ?>
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <img src="uploads/karya/<?= $gambar; ?>" 
                         class="card-img-top" 
                         alt="<?= $judul; ?>" 
                         style="height: 220px; object-fit: cover;"
                         onerror="this.src='https://via.placeholder.com/400x200'">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-light text-primary border"><?= $kategori; ?></span>
                        </div>
                        <h5 class="card-title fw-bold mb-3"><?= $judul; ?></h5>
                        <p class="card-text text-muted small lh-base mb-0">
                            <?= nl2br($deskripsi); ?>
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
                <p>Belum ada data karya desa yang terdaftar.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>