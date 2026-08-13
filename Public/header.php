<?php
// Manggil koneksi database dari folder root (naik 1 level dari Public/)
require_once __DIR__ . '/../config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Resmi Desa Pilang</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }

        /* NAVBAR RESPONSIF FLEXBOX ALA DESA */
        .navbar-desa {
            background: linear-gradient(135deg, #0d9488 0%, #16a34a 100%);
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.2);
            padding: 10px 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: #ffffff !important;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
        }

        /* Desain Tombol Garis 3 (Toggler) */
        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.6);
            padding: 4px 10px;
            border-radius: 8px;
            outline: none;
            box-shadow: none !important;
        }

        .navbar-toggler-icon {
            /* Mengubah icon bawaan jadi garis 3 putih terang */
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2.5' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.95) !important;
            font-weight: 500;
            padding: 8px 12px !important;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.2);
        }

        /* Penyesuaian Khusus Tampilan Layar HP (Mobile) */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(13, 148, 136, 0.98);
                margin-top: 10px;
                padding: 15px;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }

            .nav-link {
                padding: 10px 15px !important;
                margin-bottom: 4px;
            }
        }

        /* HERO SECTION */
        .hero-section {
            position: relative;
            min-height: 80vh;
            background: url('asset/img/balaiDesaPilang.jpeg') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #ffffff;
            padding: 40px 20px;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.5) 0%, rgba(15, 23, 42, 0.7) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
        }

        .hero-title {
            font-size: clamp(2.2rem, 5vw, 3.5rem); /* Ukuran teks otomatis fleksibel mengikuti HP/PC */
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 3px 10px rgba(0,0,0,0.5);
            margin-bottom: 10px;
        }

        .hero-subtitle {
            font-size: clamp(1rem, 2.5vw, 1.25rem);
            font-weight: 400;
            margin-bottom: 25px;
            color: #f1f5f9;
        }

        .btn-desa-primary {
            background-color: #2563eb;
            color: #ffffff;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 50px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-desa-success {
            background-color: #22c55e;
            color: #ffffff;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 50px;
            border: none;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>