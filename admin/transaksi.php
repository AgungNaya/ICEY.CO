<?php require_once 'header.php'; ?>
<?php require_once '../include/koneksi.php'; ?>

<?php
$status_filter = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM transaksi WHERE 1";

if ($status_filter === 'Diproses' || $status_filter === 'Selesai') {
  $sql .= " AND status='$status_filter'";
}

if (!empty($search)) {
  $sql .= " AND nama_pembeli LIKE '%$search%'";
}

$sql .= " ORDER BY tanggal DESC";
$query = mysqli_query($connection, $sql);
?>

<div class="container py-5 mt-5">
  <h2 class="mb-4">Daftar Transaksi</h2>
  <form method="get" class="row g-3 align-items-end mb-4">
    <div class="col-md-3">
      <label class="form-label">Filter Status</label>
      <select name="status" class="form-select" onchange="this.form.submit()">
        <option value="">-- Semua Status --</option>
        <option value="Diproses" <?= ($status_filter === 'Diproses') ? 'selected' : '' ?>>Diproses</option>
        <option value="Selesai" <?= ($status_filter === 'Selesai') ? 'selected' : '' ?>>Selesai</option>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Cari Nama Pembeli</label>
      <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($search) ?>" placeholder="Contoh: Naya">
    </div>
    <div class="col-md-5 d-flex gap-2">
      <button type="submit" class="btn btn-primary mt-4">Terapkan</button>
      <a href="transaksi.php" class="btn btn-secondary mt-4">Reset</a>
      <a href="export-transaksi.php" class="btn btn-outline-success mt-4">Export Excel</a>
      <button onclick="window.print()" type="button" class="btn btn-outline-info mt-4">Cetak</button>
    </div>
  </form>


  <?php if (mysqli_num_rows($query) == 0): ?>
    <div class="alert alert-info text-center">Data transaksi tidak ditemukan.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Metode</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Detail</th>
            <th>Hapus</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_pembeli'] ?></td>
            <td><?= $row['metode_pembayaran'] ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td>
              <span class="badge bg-<?= $row['status'] === 'Selesai' ? 'success' : 'warning' ?>">
                <?= $row['status'] ?>
              </span>
            </td>
            <td>
              <a href="transaksi-detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">Lihat</a>
            </td>
            <td>
              <a href="transaksi-hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus transaksi ini?')">Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>

<script>
  $('.nav-link').removeClass('active');
  $('.menu-transaksi').addClass('active');
</script>
