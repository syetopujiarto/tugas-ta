<?php
$page_title = "Kelola Agenda Kegiatan";
require_once '../Admin/header.php';
require_once '../Admin/sidebar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Daftar Agenda Kegiatan</h5>
    <a href="tambah.php" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Tambah Agenda</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] == 'added'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">Agenda berhasil ditambahkan!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php elseif ($_GET['msg'] == 'updated'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">Agenda berhasil diperbarui!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php elseif ($_GET['msg'] == 'deleted'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">Agenda berhasil dihapus!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Nama Agenda</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM agenda ORDER BY tanggal DESC");
                    if (mysqli_num_rows($query) > 0):
                        while ($row = mysqli_fetch_assoc($query)):
                    ?>
                        <tr>
                            <td class="ps-3"><?= $no++; ?></td>
                            <td class="fw-bold"><?= $row['nama_agenda']; ?></td>
                            <td><span class="badge bg-light text-primary border"><i class="far fa-calendar-alt me-1"></i> <?= date('d M Y', strtotime($row['tanggal'])); ?></span></td>
                            <td><?= $row['lokasi']; ?></td>
                            <td><?= substr($row['deskripsi'], 0, 40) . '...'; ?></td>
                            <td class="text-center">
                                <a href="edit.php?id=<?= $row['id_agenda']; ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                <a href="hapus.php?id=<?= $row['id_agenda']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin menghapus agenda ini?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php 
                        endwhile;
                    else:
                    ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada agenda kegiatan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../Admin/footer.php'; ?>