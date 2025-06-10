<?php require_once 'header.php'; ?>
<div class="row">
  <div class="col-12 p-5">
    <?php
      require_once '../include/koneksi.php';
      if (isset($_GET['kategori'])) {
        $id_kategori = $_GET['kategori'];
        $sql_kategori = "SELECT kategori FROM kategori WHERE id='$id_kategori'";
        $query_kategori = mysqli_query($connection, $sql_kategori);
        $result_kategori = mysqli_fetch_assoc($query_kategori);
    } else {
        echo "<script>alert('Kategori tidak ditemukan.'); window.location.href='index.php';</script>";
        exit;
    }
    ?>
    <h1 class="display-4 mb-3 text-center p-5">Ice Cream - <?= $result_kategori['kategori']?></h1>

    <div class="row g-3">
      <?php
        $sql = "SELECT a.*, b.kategori FROM produk a JOIN kategori b ON a.id_kategori = b.id WHERE a.id_kategori = '".$_GET['kategori']."'";
        $query = mysqli_query($connection, $sql);
        while ($result = mysqli_fetch_assoc($query)) {
      ?>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card card-item h-100">
          <img class="card-img-top" src="<?= $result['gambar']; ?>" alt="Gambar Produk">
          <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title mt-2 text-center"><?= $result['nama']; ?></h5>
            <p class="card-text mt-2 text-center fw-bold">Rp<?= number_format($result['harga'], 0, ',', '.'); ?></p>

           
            <button class="btn btn-info btn-sm" 
              data-nama="<?= $result['nama'] ?>" 
              data-detail="<?= $result['detail'] ?>" 
              data-img="<?= $result['gambar'] ?>" 
              data-kategori="<?= $result['kategori'] ?>">
              Detail
            </button>

            
            <form action="cart-action.php" method="post" class="mt-2 text-center">
              <input type="hidden" name="id" value="<?= $result['id']; ?>">
              <input type="hidden" name="nama" value="<?= $result['nama']; ?>">
              <input type="hidden" name="harga" value="<?= $result['harga']; ?>">
              <input type="hidden" name="gambar" value="<?= $result['gambar']; ?>">
              <button type="submit" class="btn btn-success btn-sm">Add to Cart</button>
            </form>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>

<?php require_once 'footer.php'; ?>

<!-- Modal Detail Produk -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Detail Ice Cream</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img id="modal-img" class="img-fluid">
        <h5 class="text-center mt-3" id="modal-nama"></h5>
        <div class="text-center" id="modal-detail"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $('.btn-info').click(function() {
    $('#modal-img').attr('src', $(this).data('img'));
    $('#modal-nama').html($(this).data('nama'));
    $('#modal-detail').html($(this).data('detail'));
    $('#modalDetail').modal('show');
  });
});
</script>
