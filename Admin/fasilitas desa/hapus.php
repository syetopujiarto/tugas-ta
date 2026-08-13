<?php
require_once '../../config.php';
require_once '../Admin/auth.php';
check_login();

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    mysqli_query($koneksi, "DELETE FROM fasilitas WHERE id_fasilitas = $id");
}
header("Location: index.php?msg=deleted");
exit;
?>