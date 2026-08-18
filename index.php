<?php
$page_title = "Beranda";

// 1. Load Header & Navbar
require_once 'Public/header.php';
require_once 'Public/navbar.php';

// 2. Ambil Data Profil Desa
$query_profil = mysqli_query($koneksi, "SELECT * FROM profil_desa LIMIT 1");
$profil       = ($query_profil && mysqli_num_rows($query_profil) > 0) ? mysqli_fetch_assoc($query_profil) : [];

// 3. Catat Pengunjung Sederhana (Visitor Counter)
$ip               = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$browser          = mysqli_real_escape_string($koneksi, $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown');
$tanggal_hari_ini = date('Y-m-d');

$check_visitor = mysqli_query($koneksi, "SELECT id_pengunjung FROM pengunjung WHERE ip_address = '$ip' AND tanggal = '$tanggal_hari_ini'");
if ($check_visitor && mysqli_num_rows($check_visitor) == 0) {
    mysqli_query($koneksi, "INSERT INTO pengunjung (ip_address, browser, tanggal) VALUES ('$ip', '$browser', '$tanggal_hari_ini')");
}
?>

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">DESA PILANG</h1>
        <p class="hero-subtitle">Kecamatan Wonoayu, Kabupaten Sidoarjo, Jawa Timur</p>
        
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?= BASE_URL; ?>/Public/profil.php" class="btn btn-desa-primary">
                <i class="fa-solid fa-circle-info me-1"></i> Profil Desa
            </a>
            <a href="<?= BASE_URL; ?>/Public/layanan.php" class="btn btn-desa-success">
                <i class="fa-solid fa-handshake me-1"></i> Layanan Desa
            </a>
        </div>
    </div>
</section>

<!-- SECTION TENTANG DESA -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <img src="assets/images/gambar.jpg" class="img-fluid rounded-4 shadow-sm" alt="Tentang Desa" onerror="this.src='https://via.placeholder.com/600x400'">
            </div>
            <div class="col-lg-6">
                <span class="text-primary fw-bold text-uppercase small">Tentang Desa</span>
                <h2 class="fw-bold mb-3">Selamat Datang di Portal Resmi Desa Pilang</h2>
                <p class="text-muted">
                    <?= substr($profil['sejarah'] ?? 'Desa Pilang merupakan salah satu desa yang berlokasi di Kecamatan Wonoayu, Kabupaten Sidoarjo. Desa ini terus berkembang dalam meningkatkan pelayanan publik dan kesejahteraan masyarakat.', 0, 300) . '...'; ?>
                </p>
                <a href="profil.php" class="btn btn-outline-primary rounded-pill px-4">Selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- SECTION VISI & MISI -->
<section class="py-5" style="background-color: #F8FAFC;">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Visi & Misi</h2>
            <p class="text-muted">Pedoman pembangunan Desa Pilang</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 p-4 rounded-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white p-3 rounded-circle me-3">
                            <i class="fas fa-eye fa-lg"></i>
                        </div>
                        <h4 class="fw-bold mb-0">Visi Desa</h4>
                    </div>
                    <p class="text-muted mb-0"><?= nl2br($profil['visi'] ?? 'Mewujudkan Desa Pilang yang Maju, Sejahtera, dan Berbudaya.'); ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 p-4 rounded-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success text-white p-3 rounded-circle me-3">
                            <i class="fas fa-bullseye fa-lg"></i>
                        </div>
                        <h4 class="fw-bold mb-0">Misi Desa</h4>
                    </div>
                    <p class="text-muted mb-0"><?= nl2br($profil['misi'] ?? "1. Meningkatkan kualitas pelayanan publik.\n2. Mendorong potensi ekonomi lokal."); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION KARYA DESA -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-0">Karya Desa</h2>
                <p class="text-muted mb-0">Hasil karya dan produk inovatif warga Desa Pilang</p>
            </div>
            <a href="karya.php" class="btn btn-link text-decoration-none">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="row g-4">
            <?php
            $query_karya = mysqli_query($koneksi, "SELECT * FROM karya ORDER BY id_karya DESC LIMIT 3");
            if ($query_karya && mysqli_num_rows($query_karya) > 0):
                while ($k = mysqli_fetch_assoc($query_karya)):
                    $judul     = $k['judul_karya'] ?? $k['nama_karya'] ?? $k['judul'] ?? 'Karya Desa';
                    $deskripsi = $k['deskripsi'] ?? $k['keterangan'] ?? '';
                    $gambar    = $k['gambar'] ?? $k['foto'] ?? '';
                    $kategori  = $k['kategori'] ?? 'Karya';
            ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                        <img src="uploads/karya/<?= $gambar; ?>" class="card-img-top" alt="<?= $judul; ?>" style="height: 200px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/400x200'">
                        <div class="card-body">
                            <span class="badge bg-light text-primary mb-2"><?= $kategori; ?></span>
                            <h5 class="card-title fw-bold"><?= $judul; ?></h5>
                            <p class="card-text text-muted small"><?= substr(strip_tags($deskripsi), 0, 100) . '...'; ?></p>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile;
            else:
            ?>
                <div class="col-12 text-center text-muted"><p>Belum ada data karya dipublikasikan.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- SECTION FASILITAS DESA -->
<section class="py-5" style="background-color: #F8FAFC;">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-0">Fasilitas Desa</h2>
                <p class="text-muted mb-0">Sarana publik yang tersedia</p>
            </div>
            <a href="fasilitas.php" class="btn btn-link text-decoration-none">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="row g-4">
            <?php
            $query_fasilitas = mysqli_query($koneksi, "SELECT * FROM fasilitas ORDER BY id_fasilitas DESC LIMIT 3");
            if ($query_fasilitas && mysqli_num_rows($query_fasilitas) > 0):
                while ($f = mysqli_fetch_assoc($query_fasilitas)):
            ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                        <img src="uploads/fasilitas/<?= $f['foto']; ?>" class="card-img-top" alt="<?= $f['nama_fasilitas']; ?>" style="height: 200px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/400x200'">
                        <div class="card-body">
                            <span class="badge bg-light text-success mb-2"><?= $f['kategori']; ?></span>
                            <h5 class="card-title fw-bold"><?= $f['nama_fasilitas']; ?></h5>
                            <p class="card-text text-muted small"><i class="fas fa-map-marker-alt me-1 text-danger"></i> <?= $f['alamat']; ?></p>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile;
            else:
            ?>
                <div class="col-12 text-center text-muted"><p>Belum ada data fasilitas.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- SECTION BERITA TERBARU -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-0">Berita Terbaru</h2>
                <p class="text-muted mb-0">Kabar terkini seputar kegiatan Desa Pilang</p>
            </div>
            <a href="berita.php" class="btn btn-link text-decoration-none">Lihat Semua Berita <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="row g-4">
            <?php
            $query_berita = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 3");
            if ($query_berita && mysqli_num_rows($query_berita) > 0):
                while ($b = mysqli_fetch_assoc($query_berita)):
            ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                        <img src="uploads/berita/<?= $b['gambar']; ?>" class="card-img-top" alt="<?= $b['judul']; ?>" style="height: 200px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/400x200'">
                        <div class="card-body d-flex flex-column">
                            <span class="text-muted small mb-2"><i class="far fa-calendar-alt me-1"></i> <?= date('d M Y', strtotime($b['tanggal'])); ?></span>
                            <h5 class="card-title fw-bold mb-3"><?= $b['judul']; ?></h5>
                            <p class="card-text text-muted small mb-4 flex-grow-1"><?= substr(strip_tags($b['isi']), 0, 100) . '...'; ?></p>
                            <a href="berita_detail.php?id=<?= $b['id_berita']; ?>" class="btn btn-outline-primary btn-sm rounded-pill mt-auto">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile;
            else:
            ?>
                <div class="col-12 text-center text-muted"><p>Belum ada berita dipublikasikan.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- SECTION STATISTIK PENGUNJUNG -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, #4F8EF7, #2D3748);">
    <div class="container py-4">
        <div class="text-center mb-4">
            <h3 class="fw-bold">Statistik Pengunjung</h3>
            <p class="text-white-50">Aktivitas kunjungan warga di portal desa</p>
        </div>
        <div class="row text-center g-4">
            <?php
            $res_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pengunjung");
            $total_pengunjung = ($res_total) ? mysqli_fetch_assoc($res_total)['total'] : 0;

            $res_hari_ini = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pengunjung WHERE tanggal = '$tanggal_hari_ini'");
            $hari_ini = ($res_hari_ini) ? mysqli_fetch_assoc($res_hari_ini)['total'] : 0;
            ?>
            <div class="col-md-6">
                <div class="p-4 bg-white bg-opacity-10 rounded-4">
                    <h2 class="fw-bold display-5 mb-0"><?= number_format($hari_ini); ?></h2>
                    <p class="text-white-50 mb-0">Pengunjung Hari Ini</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 bg-white bg-opacity-10 rounded-4">
                    <h2 class="fw-bold display-5 mb-0"><?= number_format($total_pengunjung); ?></h2>
                    <p class="text-white-50 mb-0">Total Pengunjung</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'Public/footer.php'; ?>