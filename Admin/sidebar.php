<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<style>
    /* Styling Sidebar Lengkap & Anti-Terpotong */
    .sidebar { 
        width: 250px; 
        position: fixed; 
        top: 0; 
        left: 0; 
        height: 100vh; 
        background: #2D3748; 
        color: #fff; 
        z-index: 1000; 
        display: flex;
        flex-direction: column;
    }
    
    /* Area Menu yang Bisa Di-scroll Jika Layar Pendek */
    .sidebar-menu {
        flex: 1;
        overflow-y: auto;
        padding-bottom: 15px;
    }

    /* Custom Scrollbar Tipis Agar Rapi */
    .sidebar-menu::-webkit-scrollbar {
        width: 5px;
    }
    .sidebar-menu::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.2);
        border-radius: 10px;
    }
    
    .sidebar a.nav-link-custom { 
        color: #CBD5E0; 
        text-decoration: none; 
        padding: 10px 18px; 
        display: block; 
        font-size: 0.88rem; 
        border-radius: 8px; 
        margin: 3px 12px; 
        transition: all 0.2s ease;
    }
    .sidebar a.nav-link-custom:hover, 
    .sidebar a.nav-link-custom.active { 
        background: #4F8EF7; 
        color: #fff; 
        font-weight: 500;
    }
    
    .main-content { 
        margin-left: 250px; 
        padding: 20px 30px; 
    }
</style>

<div class="sidebar">
    <div class="px-4 py-3 border-bottom border-secondary d-flex align-items-center gap-2">
        <img src="../assets/img/logo.png" height="35" alt="Logo" onerror="this.src='https://via.placeholder.com/35'">
        <div>
            <h6 class="fw-bold mb-0 text-white">Admin Pilang</h6>
            <small class="text-muted" style="font-size: 0.75rem;">Sistem Informasi Desa</small>
        </div>
    </div>
    
    <div class="sidebar-menu mt-2">
        <nav>
            <a href="dashboard.php" class="nav-link-custom <?= $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="profil.php" class="nav-link-custom <?= $current_page == 'profil.php' ? 'active' : ''; ?>">
                <i class="fas fa-id-card me-2"></i> Profil Desa
            </a>
            <a href="perangkat.php" class="nav-link-custom <?= $current_page == 'perangkat.php' ? 'active' : ''; ?>">
                <i class="fas fa-users me-2"></i> Perangkat Desa
            </a>
            <a href="berita.php" class="nav-link-custom <?= $current_page == 'berita.php' ? 'active' : ''; ?>">
                <i class="fas fa-newspaper me-2"></i> Berita Desa
            </a>
            <a href="galeri.php" class="nav-link-custom <?= $current_page == 'galeri.php' ? 'active' : ''; ?>">
                <i class="fas fa-images me-2"></i> Galeri Foto
            </a>
            <a href="layanan.php" class="nav-link-custom <?= $current_page == 'layanan.php' ? 'active' : ''; ?>">
                <i class="fas fa-concierge-bell me-2"></i> Layanan Desa
            </a>
            <a href="karya.php" class="nav-link-custom <?= $current_page == 'karya.php' ? 'active' : ''; ?>">
                <i class="fas fa-seedling me-2"></i> Karya Desa
            </a>
            <a href="fasilitas.php" class="nav-link-custom <?= $current_page == 'fasilitas.php' ? 'active' : ''; ?>">
                <i class="fas fa-building me-2"></i> Fasilitas
            </a>
            <a href="agenda.php" class="nav-link-custom <?= $current_page == 'agenda.php' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-alt me-2"></i> Agenda
            </a>
            <a href="kontak.php" class="nav-link-custom <?= $current_page == 'kontak.php' ? 'active' : ''; ?>">
                <i class="fas fa-envelope me-2"></i> Kontak
            </a>
        </nav>
    </div>

    <div class="p-3 border-top border-secondary bg-dark">
        <a href="logout.php" class="btn btn-danger w-100 text-white d-block text-center py-2">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
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
