<?php require_once 'header.php'; ?>
<?php require_once '../include/koneksi.php'; ?>

<?php
$id = $_GET['id'] ?? 0;
$q_transaksi = mysqli_query($connection, "SELECT * FROM transaksi WHERE id='$id'");
$transaksi = mysqli_fetch_assoc($q_transaksi);

if (!$transaksi) {
  echo "<script>alert('Data tidak ditemukan'); window.location.href='transaksi.php';</script>";
  exit;
}

$q_detail = mysqli_query($connection, "SELECT * FROM detail_transaksi WHERE id_transaksi='$id'");
?>

<div class="container py-5 mt-5">
  <h2 class="mb-4">Detail Transaksi</h2>
  <div class="card p-4 shadow">
    <p><strong>Nama Pembeli:</strong> <?= $transaksi['nama_pembeli'] ?></p>
    <p><strong>Tanggal:</strong> <?= $transaksi['tanggal'] ?></p>
    <p><strong>Metode Pembayaran:</strong> <?= $transaksi['metode_pembayaran'] ?></p>
    <p><strong>Status:</strong>
      <span class="badge bg-<?= $transaksi['status'] === 'Selesai' ? 'success' : 'warning' ?>">
        <?= $transaksi['status'] ?>
      </span>
    </p>

    <?php if ($transaksi['metode_pembayaran'] === 'Bayar di Toko'): ?>
      <div class="alert alert-secondary">Pembayaran dilakukan langsung di toko. Tidak perlu bukti pembayaran.</div>
    <?php elseif ($transaksi['bukti']): ?>
      <div class="mt-3">
        <strong>Bukti Pembayaran:</strong><br>
        <img src="../pengguna/<?= $transaksi['bukti'] ?>" class="img-fluid mt-2" style="max-width: 400px;">
      </div>
    <?php else: ?>
      <div class="alert alert-danger">Belum ada bukti pembayaran yang diunggah.</div>
    <?php endif; ?>

    <table class="table table-bordered text-center mt-4">
      <thead class="table-light">
        <tr>
          <th>No</th>
          <th>Produk</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $grandTotal = 0;
        while ($item = mysqli_fetch_assoc($q_detail)) {
          $total = $item['harga'] * $item['qty'];
          $grandTotal += $total;
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $item['nama_produk'] ?></td>
          <td>Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
          <td><?= $item['qty'] ?></td>
          <td>Rp<?= number_format($total, 0, ',', '.') ?></td>
        </tr>
        <?php } ?>
        <tr>
          <th colspan="4">Grand Total</th>
          <th>Rp<?= number_format($grandTotal, 0, ',', '.') ?></th>
        </tr>
      </tbody>
    </table>

  
    <?php if ($transaksi['status'] !== 'Selesai'): ?>
      <form action="ubah-status.php" method="post" class="mt-4 text-end">
        <input type="hidden" name="id" value="<?= $transaksi['id'] ?>">
        <button type="submit" class="btn btn-success" onclick="return confirm('Ubah status menjadi Selesai?')">Tandai sebagai Selesai</button>
      </form>
    <?php endif; ?>

    <a href="transaksi.php" class="btn btn-secondary mt-3">Kembali</a>
  </div>
</div>

<?php require_once 'footer.php'; ?>
