<?php
session_start();
require_once 'header.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<div class="container py-5 mt-5">
  <h2 class="text-center mb-4">Keranjang Belanja</h2>

  <?php if (empty($cart)) : ?>
    <div class="alert alert-info text-center">Keranjang kamu masih kosong 😢</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered text-center align-middle">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          $grandTotal = 0;
          foreach ($cart as $key => $item) {
            $total = $item['harga'] * $item['qty'];
            $grandTotal += $total;
          ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><img src="<?= $item['gambar']; ?>" width="70"></td>
              <td><?= $item['nama']; ?></td>
              <td>Rp<?= number_format($item['harga'], 0, ',', '.'); ?></td>
              <td>
                <div class="d-flex justify-content-center gap-2">
                  <a href="cart-update.php?key=<?= $key ?>&action=minus" class="btn btn-outline-warning btn-sm">−</a>
                  <span class="pt-1"><?= $item['qty']; ?></span>
                  <a href="cart-update.php?key=<?= $key ?>&action=plus" class="btn btn-outline-success btn-sm">+</a>
                </div>
              </td>
              <td>Rp<?= number_format($total, 0, ',', '.'); ?></td>
              <td>
                <a href="cart-delete.php?key=<?= $key ?>" class="btn btn-danger btn-sm">Hapus</a>
              </td>
            </tr>
          <?php } ?>
          <tr>
            <th colspan="5">Grand Total</th>
            <th colspan="2">Rp<?= number_format($grandTotal, 0, ',', '.'); ?></th>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="text-end mt-4">
      <a href="checkout.php" class="btn btn-primary">Checkout</a>
    </div>
  <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>
