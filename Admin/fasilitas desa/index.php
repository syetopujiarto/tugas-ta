<?php
$page_title = "Kelola Fasilitas Desa";
require_once '../Admin/header.php';
require_once '../Admin/sidebar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Daftar Fasilitas Desa</h5>
    <a href="tambah.php" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Tambah Fasilitas</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] == 'added'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">Fasilitas berhasil ditambahkan!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php elseif ($_GET['msg'] == 'updated'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">Fasilitas berhasil diperbarui!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php elseif ($_GET['msg'] == 'deleted'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">Fasilitas berhasil dihapus!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Foto</th>
                        <th>Nama Fasilitas</th>
                        <th>Kategori</th>
                        <th>Alamat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM fasilitas ORDER BY id_fasilitas DESC");
                    if (mysqli_num_rows($query) > 0):
                        while ($row = mysqli_fetch_assoc($query)):
                    ?>
                        <tr>
                            <td class="ps-3"><?= $no++; ?></td>
                            <td>
                                <img src="../../uploads/fasilitas/<?= $row['foto']; ?>" height="45" width="60" class="rounded object-fit-cover" onerror="this.src='../../assets/images/fasilitas1.jpg'">
                            </td>
                            <td class="fw-bold"><?= $row['nama_fasilitas']; ?></td>
                            <td><span class="badge bg-light text-success border"><?= $row['kategori']; ?></span></td>
                            <td><?= $row['alamat']; ?></td>
                            <td class="text-center">
                                <a href="edit.php?id=<?= $row['id_fasilitas']; ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                <a href="hapus.php?id=<?= $row['id_fasilitas']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin menghapus fasilitas ini?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php 
                        endwhile;
                    else:
                    ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada fasilitas desa.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../Admin/footer.php'; ?>