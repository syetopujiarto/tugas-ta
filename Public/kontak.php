<?php
$page_title = "Kontak Kami";

// Load Header & Navbar
require_once __DIR__ . '/header.php'; // Otomatis sudah memanggil config.php
require_once __DIR__ . '/navbar.php';

// Ambil data kontak dari database
$query_kontak = mysqli_query($koneksi, "SELECT * FROM kontak LIMIT 1");
$kontak       = ($query_kontak && mysqli_num_rows($query_kontak) > 0) ? mysqli_fetch_assoc($query_kontak) : [];

// Proses simpan pesan masuk jika form dikirimkan
$pesan_status = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kirim_pesan'])) {
    $nama   = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $email  = mysqli_real_escape_string($koneksi, trim($_POST['email']));
    $pesan  = mysqli_real_escape_string($koneksi, trim($_POST['pesan']));
    $tanggal = date('Y-m-d H:i:s');

    $insert = mysqli_query($koneksi, "INSERT INTO pesan (nama, email, isi_pesan, tanggal) VALUES ('$nama', '$email', '$pesan', '$tanggal')");
    
    if ($insert) {
        $pesan_status = '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i> Terima kasih! Pesan Anda telah berhasil dikirim.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                         </div>';
    } else {
        $pesan_status = '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> Maaf, pesan gagal dikirim. Silakan coba lagi.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                         </div>';
    }
}
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

    <!-- Menampilkan status pengiriman pesan -->
    <?= $pesan_status; ?>

    <div class="row g-4 mb-5">
        <!-- Panel Informasi Kontak -->
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

        <!-- Panel Form Kirim Pesan -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h4 class="fw-bold mb-3">Kirim Pesan</h4>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pesan / Masukan</label>
                        <textarea name="pesan" class="form-control" rows="5" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                    </div>
                    <button type="submit" name="kirim_pesan" class="btn btn-primary w-100 py-2 rounded-3">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Peta Google Maps -->
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