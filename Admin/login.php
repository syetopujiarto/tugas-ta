<?php
session_start();
require_once __DIR__ . '/../config.php';

// Jika sudah login, redirect langsung ke dashboard
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Prepared Statement untuk mencegah SQL Injection
        // Mengecek tabel 'admin' (atau 'users' sesuaikan dengan nama tabel di DB kamu)
        $stmt = mysqli_prepare($koneksi, "SELECT id_admin, nama, username, password, level FROM admin WHERE username = ? LIMIT 1");
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($data = mysqli_fetch_assoc($result)) {
                // Verifikasi Password Hash / Plain text
                if (password_verify($password, $data['password']) || $password === $data['password']) {
                    
                    // KUNCI UTAMA: Gunakan key session $_SESSION['login'] agar sinkron dengan seluruh halaman admin
                    $_SESSION['login']          = true;
                    $_SESSION['admin_logged_in'] = true; // Tambahan untuk kompatibilitas
                    $_SESSION['admin_id']        = $data['id_admin'];
                    $_SESSION['admin_nama']      = $data['nama'];
                    $_SESSION['username']        = $data['username'];
                    $_SESSION['admin_level']     = $data['level'];

                    header("Location: dashboard.php");
                    exit;
                } else {
                    $error = 'Password yang Anda masukkan salah!';
                }
            } else {
                $error = 'Username tidak ditemukan!';
            }
        } else {
            $error = 'Terjadi kesalahan pada query database.';
        }
    } else {
        $error = 'Silakan isi username dan password!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Desa Pilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .btn-primary-custom {
            background-color: #4F8EF7;
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .btn-primary-custom:hover {
            background-color: #3b76d8;
        }
    </style>
</head>
<body>

<div class="card login-card p-4 bg-white">
    <div class="text-center mb-4">
        <img src="../assets/img/logo.png" alt="Logo Desa Pilang" height="70" class="mb-2" onerror="this.src='https://via.placeholder.com/70'">
        <h5 class="fw-bold text-dark mb-1">Panel Admin Desa Pilang</h5>
        <p class="text-muted small">Masukan username dan password untuk login</p>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'pls_login'): ?>
        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
            Silakan login terlebih dahulu untuk mengakses admin!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show small" role="alert">
            <?= $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label small fw-bold text-muted">Username</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control bg-light" placeholder="Username" required autofocus>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label small fw-bold text-muted">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control bg-light" placeholder="Password" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 rounded-3 text-white mb-3">
            Login ke Dashboard <i class="fas fa-sign-in-alt ms-1"></i>
        </button>
    </form>

    <div class="text-center text-muted small mt-2">
        &copy; 2026 Desa Pilang Wonoayu
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>