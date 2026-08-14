<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar d-flex flex-column justify-content-between py-3">
    <div>
        <div class="px-4 py-3 border-bottom border-secondary mb-3 d-flex align-items-center gap-2">
            <img src="../assets/img/logo.png" height="35" alt="Logo" onerror="this.src='https://via.placeholder.com/35'">
            <div>
                <h6 class="fw-bold mb-0 text-white">Admin Pilang</h6>
                <small class="text-muted" style="font-size: 0.75rem;">Sistem Informasi Desa</small>
            </div>
        </div>
        
        <nav>
            <a href="dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="profil.php" class="<?= $current_page == 'profil.php' ? 'active' : ''; ?>">
                <i class="fas fa-id-card me-2"></i> Profil Desa
            </a>
            <a href="perangkat.php" class="<?= $current_page == 'perangkat.php' ? 'active' : ''; ?>">
                <i class="fas fa-users me-2"></i> Perangkat Desa
            </a>
            <a href="berita.php" class="<?= $current_page == 'berita.php' ? 'active' : ''; ?>">
                <i class="fas fa-newspaper me-2"></i> Berita Desa
            </a>
            <a href="galeri.php" class="<?= $current_page == 'galeri.php' ? 'active' : ''; ?>">
                <i class="fas fa-images me-2"></i> Galeri Foto
            </a>
            <a href="layanan.php" class="<?= $current_page == 'layanan.php' ? 'active' : ''; ?>">
                <i class="fas fa-concierge-bell me-2"></i> Layanan Desa
            </a>
            <a href="karya.php" class="<?= $current_page == 'karya.php' ? 'active' : ''; ?>">
                <i class="fas fa-seedling me-2"></i> Karya Desa
            </a>
            <a href="fasilitas.php" class="<?= $current_page == 'fasilitas.php' ? 'active' : ''; ?>">
                <i class="fas fa-building me-2"></i> Fasilitas
            </a>
            <a href="agenda.php" class="<?= $current_page == 'agenda.php' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-alt me-2"></i> Agenda
            </a>
            <a href="kontak.php" class="<?= $current_page == 'kontak.php' ? 'active' : ''; ?>">
                <i class="fas fa-envelope me-2"></i> Kontak
            </a>
        </nav>
    </div>
    <div class="px-3">
        <a href="logout.php" class="bg-danger text-white text-center"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
    </div>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-3 shadow-sm mb-4">
        <h5 class="fw-bold mb-0 text-dark"><?= isset($page_title) ? $page_title : 'Panel Admin'; ?></h5>
        <div class="d-flex align-items-center gap-2">
            <span class="small text-muted">Halo, <strong><?= $_SESSION['username'] ?? 'Admin'; ?></strong></span>
            <span class="badge bg-primary rounded-pill">Administrator</span>
        </div>
    </div>