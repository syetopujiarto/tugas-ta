<?php
session_start(); // <--- INI KUNCI UTAMA YANG TADI HILANG!

require_once __DIR__ . '/../config.php';

// Proteksi Sesi Login (Pastikan Session Aktif)
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

// Cek Safety Query Database (Agar tidak error jika tabel belum ada)
function hitung_total($koneksi, $tabel) {
    $q = @mysqli_query($koneksi, "SELECT * FROM $tabel");
    return $q ? mysqli_num_rows($q) : 0;
}

// Mengambil data statistik untuk counter
$total_berita     = hitung_total($koneksi, "berita");
$total_galeri     = hitung_total($koneksi, "galeri");
$total_perangkat  = hitung_total($koneksi, "perangkat_desa");
$total_agenda     = hitung_total($koneksi, "agenda");
$total_pengunjung = hitung_total($koneksi, "pengunjung");

// Data dummy 7 hari terakhir untuk Chart.js
$chart_labels = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
$chart_data   = [12, 19, 15, 25, 22, 30, $total_pengunjung];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Desa Pilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; }
        .sidebar { width: 250px; position: fixed; top: 0; left: 0; height: 100vh; background: #2D3748; color: #fff; z-index: 100; transition: all 0.3s; }
        .sidebar a { color: #CBD5E0; text-decoration: none; padding: 12px 20px; display: block; font-size: 0.9rem; border-radius: 8px; margin: 4px 10px; }
        .sidebar a:hover, .sidebar a.active { background: #4F8EF7; color: #fff; }
        .main-content { margin-left: 250px; padding: 20px 30px; }
        .card-stat { border: none; border-radius: 12px; transition: transform 0.2s; }
        .card-stat:hover { transform: translateY(-3px); }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column justify-content-between py-3">
    <div>
        <div class="px-4 py-3 border-bottom border-secondary mb-3 d-flex align-items-center gap-2">
            <img src="../assets/images/logo.png" height="35" alt="Logo" onerror="this.src='https://via.placeholder.com/35'">
            <div>
                <h6 class="fw-bold mb-0 text-white">Admin Pilang</h6>
                <small class="text-white" style="font-size: 0.75rem;">Sistem Informasi Desa</small>
            </div>
        </div>
        <nav>
            <a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="profil.php"><i class="fas fa-id-card me-2"></i> Profil Desa</a>
            <a href="perangkat.php"><i class="fas fa-users me-2"></i> Perangkat Desa</a>
            <a href="berita.php"><i class="fas fa-newspaper me-2"></i> Berita Desa</a>
            <a href="galeri.php"><i class="fas fa-images me-2"></i> Galeri Foto</a>
            <a href="layanan.php"><i class="fas fa-concierge-bell me-2"></i> Layanan Desa</a>
            <a href="karya.php"><i class="fas fa-seedling me-2"></i> Karya Desa</a>
            <a href="fasilitas.php"><i class="fas fa-building me-2"></i> Fasilitas</a>
            <a href="agenda.php"><i class="fas fa-calendar-alt me-2"></i> Agenda</a>
            <a href="kontak.php"><i class="fas fa-envelope me-2"></i> Kontak</a>
        </nav>
    </div>
    <div class="px-3">
        <a href="logout.php" class="bg-danger text-white text-center"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
    </div>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-3 shadow-sm mb-4">
        <h5 class="fw-bold mb-0 text-dark">Dashboard Ringkasan</h5>
        <div class="d-flex align-items-center gap-2">
            <span class="small text-muted">Selamat datang, <strong><?= $_SESSION['username'] ?? 'Admin'; ?></strong></span>
            <span class="badge bg-primary rounded-pill">Administrator</span>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-2 col-sm-6">
            <div class="card card-stat bg-primary text-white p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50">Total Berita</small>
                        <h3 class="fw-bold mb-0 mt-1"><?= $total_berita; ?></h3>
                    </div>
                    <i class="fas fa-newspaper fa-2x text-white-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-6">
            <div class="card card-stat bg-success text-white p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50">Total Galeri</small>
                        <h3 class="fw-bold mb-0 mt-1"><?= $total_galeri; ?></h3>
                    </div>
                    <i class="fas fa-images fa-2x text-white-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card card-stat bg-warning text-white p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50">Perangkat Desa</small>
                        <h3 class="fw-bold mb-0 mt-1"><?= $total_perangkat; ?></h3>
                    </div>
                    <i class="fas fa-users fa-2x text-white-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-6">
            <div class="card card-stat bg-info text-white p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50">Total Agenda</small>
                        <h3 class="fw-bold mb-0 mt-1"><?= $total_agenda; ?></h3>
                    </div>
                    <i class="fas fa-calendar-alt fa-2x text-white-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card card-stat bg-dark text-white p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50">Total Pengunjung</small>
                        <h3 class="fw-bold mb-0 mt-1"><?= $total_pengunjung; ?></h3>
                    </div>
                    <i class="fas fa-chart-line fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-chart-area text-primary me-2"></i>Grafik Kunjungan Website (Minggu Ini)</h6>
        <div style="height: 300px;">
            <canvas id="visitorChart"></canvas>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('visitorChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($chart_labels); ?>,
        datasets: [{
            label: 'Jumlah Pengunjung',
            data: <?= json_encode($chart_data); ?>,
            borderColor: '#4F8EF7',
            backgroundColor: 'rgba(79, 142, 247, 0.1)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>
</body>
</html>