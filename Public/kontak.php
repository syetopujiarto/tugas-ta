<?php
$page_title = "Kontak Kami";

// Naik 1 tingkat keluar folder Admin/, lalu masuk ke Public/
require_once __DIR__ . '/header.php'; // Otomatis sudah ikut memanggil config.php
require_once __DIR__ . '/navbar.php';
?>

// Ambil data kontak dari database
$query_kontak = mysqli_query($koneksi, "SELECT * FROM kontak LIMIT 1");
$kontak = mysqli_fetch_assoc($query_kontak);
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
        <h1 class="fw-bold">Hubungi Kami</h1>
        <p class="text-muted">Kirimkan masukan, pertanyaan, atau kunjungi kantor Desa Pilang</p>
        <div class="mx-auto bg-primary" style="height: 3px; width: 60px; border-radius: 2px;"></div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h4 class="fw-bold mb-4">Informasi Kontak</h4>
                
                <div class="d-flex align-items-start mb-4">
                    <div class="bg-light text-primary p-3 rounded-circle me-3">
                        <i class="fas fa-map-marker-alt fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Alamat Kantor</h6>
                        <p class="text-muted small mb-0"><?= $kontak['alamat'] ?? 'Kecamatan Wonoayu, Kabupaten Sidoarjo'; ?></p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="bg-light text-success p-3 rounded-circle me-3">
                        <i class="fas fa-phone-alt fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Telepon / Whatsapp</h6>
                        <p class="text-muted small mb-0"><?= $kontak['telepon'] ?? '-'; ?></p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="bg-light text-warning p-3 rounded-circle me-3">
                        <i class="fas fa-envelope fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Email Resmi</h6>
                        <p class="text-muted small mb-0"><?= $kontak['email'] ?? '-'; ?></p>
                    </div>
                </div>

                <hr class="my-3">

                <h6 class="fw-bold mb-3">Media Sosial</h6>
                <div class="d-flex gap-2">
                    <?php if (!empty($kontak['facebook'])): ?>
                        <a href="<?= $kontak['facebook']; ?>" target="_blank" class="btn btn-outline-primary rounded-circle"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($kontak['instagram'])): ?>
                        <a href="<?= $kontak['instagram']; ?>" target="_blank" class="btn btn-outline-danger rounded-circle"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($kontak['youtube'])): ?>
                        <a href="<?= $kontak['youtube']; ?>" target="_blank" class="btn btn-outline-danger rounded-circle"><i class="fab fa-youtube"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h4 class="fw-bold mb-3">Kirim Pesan</h4>
                <form action="" method="POST" onsubmit="alert('Pesan berhasil terkirim!'); return false;">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama Anda" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat Email</label>
                        <input type="email" class="form-control" placeholder="contoh@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pesan / Masukan</label>
                        <textarea class="form-control" rows="5" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php if (!empty($kontak['maps'])): ?>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0"><i class="fas fa-map me-2 text-primary"></i> Lokasi Kantor Desa</h5>
            </div>
            <div class="ratio ratio-21x9">
                <?= $kontak['maps']; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>