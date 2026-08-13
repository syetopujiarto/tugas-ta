<?php
// Ambil data profil & kontak untuk footer
$query_profil_ft = mysqli_query($koneksi, "SELECT * FROM profil_desa LIMIT 1");
$profil_ft = mysqli_fetch_assoc($query_profil_ft);

$query_kontak_ft = mysqli_query($koneksi, "SELECT * FROM kontak LIMIT 1");
$kontak_ft = mysqli_fetch_assoc($query_kontak_ft);
?>

<footer class="bg-dark text-white pt-5 pb-4 mt-auto">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <img src="assets/images/logo.png" alt="Logo Desa Pilang" height="40" class="me-2" onerror="this.src='https://via.placeholder.com/40'">
                    <h5 class="fw-bold mb-0 text-white">Desa Pilang</h5>
                </div>
                <p class="text-white-50 small">
                    Website resmi Pemerintah Desa Pilang, Kecamatan Wonoayu, Kabupaten Sidoarjo. Media informasi dan pelayanan publik bagi seluruh warga desa.
                </p>
                <div class="d-flex gap-2 mt-3">
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
                    <li class="mb-2"><a href="profil.php" class="text-white-50 text-decoration-none">Profil Desa</a></li>
                    <li class="mb-2"><a href="perangkat.php" class="text-white-50 text-decoration-none">Perangkat Desa</a></li>
                    <li class="mb-2"><a href="berita.php" class="text-white-50 text-decoration-none">Berita Terkini</a></li>
                    <li class="mb-2"><a href="layanan.php" class="text-white-50 text-decoration-none">Layanan Desa</a></li>
                    <li class="mb-2"><a href="potensi.php" class="text-white-50 text-decoration-none">Potensi Desa</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-white mb-3">Kontak Kami</h6>
                <ul class="list-unstyled small text-white-50">
                    <li class="mb-2 d-flex align-items-start gap-2">
                        <i class="fas fa-map-marker-alt text-primary mt-1"></i>
                        <span><?= $kontak_ft['alamat'] ?? 'Kecamatan Wonoayu, Kabupaten Sidoarjo'; ?></span>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="fas fa-phone text-primary"></i>
                        <span><?= $kontak_ft['telepon'] ?? '-'; ?></span>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="fas fa-envelope text-primary"></i>
                        <span><?= $kontak_ft['email'] ?? '-'; ?></span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-white mb-3">Pelayanan Kantor</h6>
                <p class="text-white-50 small mb-1"><i class="far fa-clock me-1 text-primary"></i> Senin - Kamis: 08.00 - 15.00 WIB</p>
                <p class="text-white-50 small mb-3"><i class="far fa-clock me-1 text-primary"></i> Jumat: 08.00 - 11.30 WIB</p>
                <span class="badge bg-success">Pelayanan Aktif</span>
            </div>
        </div>

        <hr class="my-4 border-secondary">

        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <p class="small text-white-50 mb-0">
                    &copy; 2026 Pemerintah Desa Pilang, Kecamatan Wonoayu, Kabupaten Sidoarjo.
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>