<?php 
require_once 'header.php'; 
require_once '../include/koneksi.php';

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM produk WHERE id='" . $_GET['id'] . "'";
    $query = mysqli_query($connection, $sql);
    $produk = mysqli_fetch_assoc($query);
}
?>

<div class="container">
  <div class="col-12 p-5 mt-3">
    <div class="bg-pink p-3">
      <h3>Form Produk</h3>
      <form method="post" enctype="multipart/form-data">
        <?php 
          if (isset($_GET['id'])) {
              echo '<input type="hidden" name="id" value="'.$produk['id'].'">';
              echo '<input type="hidden" name="gambar_lama" value="'.$produk['gambar'].'">';
          }
        ?>

        <div class="mb-3">
          <select class="form-select" name="id_kategori" required>
            <option value="">--Pilih Kategori--</option>
            <?php
              $sql_kategori = 'SELECT * FROM kategori';
              $query_kategori = mysqli_query($connection, $sql_kategori);
              while ($result_kategori = mysqli_fetch_assoc($query_kategori)) {
                $selected = (isset($produk['id_kategori']) && $result_kategori['id'] == $produk['id_kategori']) ? 'selected' : '';
                echo '<option value="'.$result_kategori['id'].'" '.$selected.'>'.$result_kategori['kategori'].'</option>';
              }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <input type="text" name="nama" placeholder="Nama Produk" class="form-control"
            value="<?= isset($produk['nama']) ? $produk['nama'] : '' ?>" required>
        </div>

        <div class="mb-3">
          <input type="number" name="harga" placeholder="Harga Produk" class="form-control"
            value="<?= isset($produk['harga']) ? $produk['harga'] : '' ?>" required>
        </div>

        <div class="mb-3">
          <textarea class="form-control" name="detail" rows="3" placeholder="Detail Produk" required><?= isset($produk['detail']) ? $produk['detail'] : '' ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Gambar Produk</label>
          <?php if (isset($produk['gambar'])): ?>
            <div class="mb-2">
              <img src="<?= $produk['gambar'] ?>" width="100px">
              <p class="text-muted">* Kosongkan jika tidak ingin mengganti gambar</p>
            </div>
          <?php endif; ?>
          <input type="file" name="gambar" class="form-control">
        </div>

        <a href="produk.php" class="btn btn-success">Kembali</a>
        <button type="submit" class="btn btn-info">Simpan</button>
      </form>
    </div>
  </div>
</div>

<?php 
function uploadFile($oldFile = '') {
  if ($_FILES['gambar']['error'] === 4) {
    return $oldFile;
  } else {
    $tmp_dir = $_FILES['gambar']['tmp_name'];
    $target_dir = '../img/' . $_FILES['gambar']['name'];
    move_uploaded_file($tmp_dir, $target_dir);
    return $target_dir;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $dir = uploadFile(isset($_POST['gambar_lama']) ? $_POST['gambar_lama'] : '');
  $id_kategori = mysqli_real_escape_string($connection, $_POST['id_kategori']);
  $nama = mysqli_real_escape_string($connection, $_POST['nama']);
  $detail = mysqli_real_escape_string($connection, $_POST['detail']);
  $harga = mysqli_real_escape_string($connection, $_POST['harga']);

  if (isset($_POST['id'])) {
    $sql = "UPDATE produk SET 
              nama='$nama', 
              detail='$detail', 
              harga='$harga',
              gambar='$dir', 
              id_kategori='$id_kategori' 
            WHERE id='" . $_POST['id'] . "'";
  } else {
    $sql = "INSERT INTO produk (nama, detail, harga, gambar, id_kategori) 
            VALUES ('$nama', '$detail', '$harga', '$dir', '$id_kategori')";
  }

  if (mysqli_query($connection, $sql)) {
    header('Location: produk.php');
    exit;
  } else {
    echo '<script>alert("Proses tidak berhasil.");</script>';
  }
}
?>

<?php require_once 'footer.php'; ?>  
<script>
  $('.nav-link').removeClass('active');
  $('.menu-produk').addClass('active');
</script>
