<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../Admin/auth.php';
check_login();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' - ' : ''; ?>Admin Desa Pilang</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; }
        .sidebar { width: 250px; position: fixed; top: 0; left: 0; height: 100vh; background: #2D3748; color: #fff; z-index: 100; }
        .sidebar a { color: #CBD5E0; text-decoration: none; padding: 12px 20px; display: block; font-size: 0.9rem; border-radius: 8px; margin: 4px 10px; transition: all 0.2s; }
        .sidebar a:hover, .sidebar a.active { background: #4F8EF7; color: #fff; }
        .main-content { margin-left: 250px; padding: 20px 30px; }
    </style>
</head>
<body></body>