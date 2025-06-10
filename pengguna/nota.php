<?php
session_start();
require_once 'header.php';
require_once '../include/koneksi.php';

if (!isset($_SESSION['nota']['id_transaksi'])) {
  echo "<script>alert('Tidak ada transaksi ditemukan.'); window.location.href='index.php';</script>";
  exit;
}

$id = $_SESSION['nota']['id_transaksi'];
$q_transaksi = mysqli_query($connection, "SELECT * FROM transaksi WHERE id = '$id'");
$transaksi = mysqli_fetch_assoc($q_transaksi);

if (!$transaksi) {
  echo "<script>alert('Transaksi tidak ditemukan.'); window.location.href='index.php';</script>";
  exit;
}

$q_detail = mysqli_query($connection, "SELECT * FROM detail_transaksi WHERE id_transaksi = '$id'");

$bukti_tersimpan = '';
$upload_error = '';
$upload_dir = 'bukti-nota/';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['bukti']) && $transaksi['metode_pembayaran'] !== 'Bayar di Toko') {
  $file = $_FILES['bukti'];
  $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];
  $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
  $nama_file = 'bukti_' . time() . '.' . $ext;
  $target_file = $upload_dir . $nama_file;

  if (in_array($ext, $allowed_ext)) {
    if ($file['size'] < 2 * 1024 * 1024) {
      if (move_uploaded_file($file['tmp_name'], $target_file)) {
        mysqli_query($connection, "UPDATE transaksi SET bukti='$target_file' WHERE id='$id'");
        $bukti_tersimpan = $target_file;
        $transaksi['bukti'] = $target_file; // refresh
      } else {
        $upload_error = 'Gagal mengunggah file.';
      }
    } else {
      $upload_error = 'Ukuran file terlalu besar. Maks 2MB.';
    }
  } else {
    $upload_error = 'Format file tidak diizinkan.';
  }
}
?>

<div class="container py-5 mt-5">
  <h2 class="text-center mb-4">Nota Transaksi</h2>
  <div class="card p-4 shadow">
    <p><strong>Nama Pembeli:</strong> <?= $transaksi['nama_pembeli'] ?></p>
    <p><strong>Tanggal:</strong> <?= $transaksi['tanggal'] ?></p>
    <p><strong>Metode Pembayaran:</strong> <?= $transaksi['metode_pembayaran'] ?></p>


    <?php if ($transaksi['metode_pembayaran'] === 'Transfer'): ?>
      <div class="alert alert-warning mt-3">
        <strong>Transfer ke:</strong><br>
        BCA - 1234567890 a.n Toko ICEY<br>
        <small>Upload bukti pembayaran di bawah ini.</small>
      </div>

    <?php elseif ($transaksi['metode_pembayaran'] === 'QRIS'): ?>
      <div class="alert alert-info mt-3">
        <strong>Pembayaran via QRIS:</strong><br>
        Scan QR berikut:<br><br>
        <img src="../img/qris.jpg" width="200"><br>
        <small>Upload bukti setelah pembayaran.</small>
      </div>

    <?php elseif ($transaksi['metode_pembayaran'] === 'Bayar di Toko'): ?>
      <div class="alert alert-secondary mt-3">
        <strong>Silakan lakukan pembayaran langsung di toko.</strong><br>
        Tunjukkan nota ini kepada kasir.
      </div>
    <?php endif; ?>


    <?php if ($transaksi['metode_pembayaran'] !== 'Bayar di Toko'): ?>
      <?php if ($transaksi['bukti']): ?>
        <div class="alert alert-success mt-3">Bukti pembayaran telah diunggah:</div>
        <img src="<?= $transaksi['bukti'] ?>" class="img-fluid mb-3" style="max-width: 400px;">
      <?php else: ?>
        <?php if ($upload_error): ?>
          <div class="alert alert-danger mt-3"><?= $upload_error ?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data" class="mt-3">
          <div class="mb-3">
            <label for="bukti" class="form-label">Upload Bukti Pembayaran (jpg, png, pdf – maks 2MB):</label>
            <input type="file" name="bukti" id="bukti" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-success">Kirim Bukti</button>
        </form>
      <?php endif; ?>
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
  </div>
</div>

<?php require_once 'footer.php'; ?>
