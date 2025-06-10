<?php
session_start();
require_once 'header.php';
require_once '../include/koneksi.php';

if (!isset($_GET['id'])) {
  echo "<script>alert('ID transaksi tidak ditemukan.'); window.location.href='histori.php';</script>";
  exit;
}

$id = $_GET['id'];


$q_transaksi = mysqli_query($connection, "SELECT * FROM transaksi WHERE id = '$id'");
$transaksi = mysqli_fetch_assoc($q_transaksi);

if (!$transaksi) {
  echo "<script>alert('Transaksi tidak ditemukan.'); window.location.href='histori.php';</script>";
  exit;
}


$q_detail = mysqli_query($connection, "SELECT * FROM detail_transaksi WHERE id_transaksi = '$id'");
?>

<div class="container py-5 mt-5">
  <h2 class="text-center mb-4">Detail Transaksi</h2>
  <div class="card p-4 shadow">
    <p><strong>Nama Pembeli:</strong> <?= $transaksi['nama_pembeli'] ?></p>
    <p><strong>Tanggal:</strong> <?= $transaksi['tanggal'] ?></p>
    <p><strong>Metode Pembayaran:</strong> <?= $transaksi['metode_pembayaran'] ?></p>
    <p><strong>Status:</strong>
      <span class="badge bg-<?= $transaksi['status'] === 'Selesai' ? 'success' : 'warning' ?>">
        <?= $transaksi['status'] ?>
      </span>
    </p>

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

    <div class="text-end mt-3">
      <a href="histori.php" class="btn btn-secondary">Kembali</a>
    </div>
  </div>
</div>

<?php require_once 'footer.php'; ?>
