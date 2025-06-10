<?php
session_start();
require_once 'header.php';
require_once '../include/koneksi.php';

$histori = $_SESSION['histori'] ?? [];
?>

<div class="container py-5 mt-5">
  <h2 class="mb-4 text-center">Pesanan Sedang Diproses</h2>

  <?php if (empty($histori)): ?>
    <div class="alert alert-info text-center">Belum ada pesanan aktif.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Detail</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($histori as $key => $h) {
            $id = $h['id_transaksi'];
            $q = mysqli_query($connection, "SELECT * FROM transaksi WHERE id=$id");
            $row = mysqli_fetch_assoc($q);

            // Hapus jika data tidak ditemukan atau status sudah selesai
            if (!$row || $row['status'] === 'Selesai') {
              unset($_SESSION['histori'][$key]);
              continue;
            }
          ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_pembeli'] ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td><span class="badge bg-warning"><?= $row['status'] ?></span></td>
            <td><a href="detail_transaksi.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">Lihat</a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>
