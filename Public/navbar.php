<style>
    /* Palet Earthy Wood: Navbar Coklat Muda / Krem Klasik */
    .navbar-desa {
        background: linear-gradient(to right, #f7f4ef 0%, #e8dfd8 100%) !important;
        border-bottom: 2px solid #bcaaa4;
        box-shadow: 0 2px 8px rgba(62, 39, 35, 0.08);
        padding: 0.75rem 1rem;
    }

    .navbar-desa .navbar-brand {
        color: #3e2723 !important;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .navbar-desa .nav-link {
        color: #4e342e !important;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.5rem 0.75rem !important;
        transition: all 0.2s ease-in-out;
        border-radius: 4px;
    }

    .navbar-desa .nav-link:hover {
        color: #3e2723 !important;
        background-color: rgba(121, 85, 72, 0.12);
    }

    .navbar-desa .navbar-toggler {
        border-color: #8d6e63;
    }

    .navbar-desa .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2862, 39, 35, 0.85%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
</style>

<nav class="navbar navbar-expand-lg navbar-desa sticky-top">
    <div class="container d-flex align-items-center justify-content-between">
        
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= BASE_URL; ?>/index.php">
            <img src="<?= BASE_URL; ?>/assets/images/logo.png" 
                 alt="Logo Desa Pilang" 
                 width="40" 
                 height="40" 
                 class="me-1 rounded-circle" 
                 style="object-fit: cover; min-width: 40px; min-height: 40px;"
                 onerror="this.onerror=null; this.src='https://via.placeholder.com/40/3e2723/ffffff?text=DP';">
            <span>Desa Pilang</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPilangMenu" aria-controls="navbarPilangMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarPilangMenu">
            <ul class="navbar-nav ms-auto d-flex flex-column flex-lg-row gap-1 align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/index.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Public/profil.php">Profil Desa</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Public/perangkat.php">Perangkat</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Public/berita.php">Berita</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Public/galeri.php">Galeri</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Public/layanan.php">Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Public/potensi.php">Potensi</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Public/fasilitas.php">Fasilitas</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Public/agenda.php">Agenda</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/Public/kontak.php">Kontak</a></li>
            </ul>
        </div>

    </div>
</nav>