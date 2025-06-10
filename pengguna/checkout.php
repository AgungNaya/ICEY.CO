<?php require_once 'header.php'; ?>
<div class="container py-5 mt-5">
  <h2 class="text-center mb-4">Checkout</h2>
  <form action="proses_checkout.php" method="post" class="col-md-6 mx-auto">
    <div class="mb-3">
      <label for="nama" class="form-label">Nama Pembeli</label>
      <input type="text" class="form-control" id="nama" name="nama" required>
    </div>
    <div class="mb-3">
      <label for="metode" class="form-label">Metode Pembayaran</label>
      <select name="metode" id="metode" class="form-select" required>
        <option value="">-- Pilih Metode --</option>
        <option value="Transfer">Transfer</option>
        <option value="QRIS">QRIS</option>
        <option value="Bayar di Toko">Bayar di Toko</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary w-100">Proses Checkout</button>
  </form>
</div>
<?php require_once 'footer.php'; ?>
