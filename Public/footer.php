<?php
$query_profil_ft = mysqli_query($koneksi, "SELECT * FROM profil_desa LIMIT 1");
$profil_ft = $query_profil_ft ? mysqli_fetch_assoc($query_profil_ft) : [];

$query_kontak_ft = mysqli_query($koneksi, "SELECT * FROM kontak LIMIT 1");
$kontak_ft = $query_kontak_ft ? mysqli_fetch_assoc($query_kontak_ft) : [];
?>

<style>
    /* Palet Earthy Wood: Footer Coklat Kayu Solid Pekat */
    .footer-earthy {
        background-color: #3e2723 !important;
        color: #f5f2eb;
        border-top: 3px solid #8d6e63;
    }

    .footer-credit-badge {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 6px;
    }

    .footer-link-item {
        color: #d7ccc8 !important;
        transition: all 0.2s ease;
    }

    .footer-link-item:hover {
        color: #ffffff !important;
        padding-left: 4px;
    }
</style>

<footer class="footer-earthy pt-5 pb-4 mt-auto">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <img src="<?= BASE_URL; ?>/assets/images/logo.png" 
                         alt="Logo Desa Pilang" 
                         width="40" 
                         height="40" 
                         class="me-2 rounded-circle" 
                         style="object-fit: cover; min-width: 40px; min-height: 40px;"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/40/8d6e63/ffffff?text=DP';">
                    <h5 class="fw-bold mb-0 text-white">Desa Pilang</h5>
                </div>
                <p class="small mb-3" style="color: #d7ccc8;">
                    Website resmi Pemerintah Desa Pilang, Kecamatan Wonoayu, Kabupaten Sidoarjo. Media informasi dan pelayanan publik bagi seluruh warga desa.
                </p>
                
                <div class="footer-credit-badge p-2 px-3 d-inline-flex align-items-center mb-3">
                    <i class="fas fa-code text-warning me-2 fs-6"></i>
                    <small class="text-white mb-0">
                        Pengembang: <strong>SMK Krian 1 Sidoarjo</strong>
                    </small>
                </div>

                <div class="d-flex gap-2">
                    <?php if (!empty($kontak_ft['facebook'])): ?>
                        <a href="<?= $kontak_ft['facebook']; ?>" target="_blank" class="btn btn-outline-light btn-sm rounded-circle"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($kontak_ft['instagram'])): ?>
                        <a href="<?= $kontak_ft['instagram']; ?>" target="_blank" class="btn btn-outline-light btn-sm rounded-circle"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($kontak_ft['youtube'])): ?>
                        <a href="<?= $kontak_ft['youtube']; ?>" target="_blank" class="btn btn-outline-light btn-sm rounded-circle"><i class="fab fa-youtube"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-white mb-3">Tautan Cepat</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="profil.php" class="text-decoration-none footer-link-item">Profil Desa</a></li>
                    <li class="mb-2"><a href="perangkat.php" class="text-decoration-none footer-link-item">Perangkat Desa</a></li>
                    <li class="mb-2"><a href="berita.php" class="text-decoration-none footer-link-item">Berita Terkini</a></li>
                    <li class="mb-2"><a href="layanan.php" class="text-decoration-none footer-link-item">Layanan Desa</a></li>
                    <li class="mb-2"><a href="potensi.php" class="text-decoration-none footer-link-item">Potensi Desa</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-white mb-3">Kontak Kami</h6>
                <ul class="list-unstyled small" style="color: #d7ccc8;">
                    <li class="mb-2 d-flex align-items-start gap-2">
                        <i class="fas fa-map-marker-alt text-warning mt-1"></i>
                        <span><?= $kontak_ft['alamat'] ?? 'Kecamatan Wonoayu, Kabupaten Sidoarjo'; ?></span>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="fas fa-phone text-warning"></i>
                        <span><?= $kontak_ft['telepon'] ?? '-'; ?></span>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="fas fa-envelope text-warning"></i>
                        <span><?= $kontak_ft['email'] ?? '-'; ?></span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-white mb-3">Pelayanan Kantor</h6>
                <p class="small mb-1" style="color: #d7ccc8;"><i class="far fa-clock me-1 text-warning"></i> Senin - Kamis: 08.00 - 15.00 WIB</p>
                <p class="small mb-3" style="color: #d7ccc8;"><i class="far fa-clock me-1 text-warning"></i> Jumat: 08.00 - 11.30 WIB</p>
                <span class="badge px-3 py-2 rounded-pill" style="background-color: #5d4037; color: #fff;">
                    <i class="fas fa-circle me-1 small text-warning"></i> Pelayanan Aktif
                </span>
            </div>
        </div>

        <hr class="my-4" style="border-color: rgba(255, 255, 255, 0.15);">

        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <p class="small mb-0" style="color: #bcaaa4;">
                    &copy; 2026 Pemerintah Desa Pilang. All Rights Reserved.
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>