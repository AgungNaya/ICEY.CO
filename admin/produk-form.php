<?php 
require_once 'header.php'; 
require_once '../include/koneksi.php';
?>
<?php
    if(isset($_GET['id'])) {
        $sql = "SELECT * FROM produk WHERE id='".$_GET['id']."'";
        $query = mysqli_query($connection, $sql);
        $produk = mysqli_fetch_assoc($query);
    }

?>
                        
<div class="container">
 <div class="col-12 p-5 mt-3">
    <div class="bg-pink p-3">
 <h3 class>Form Produk</h3>
 <form method="post" enctype="multipart/form-data"> 
    <?php 
        if(isset($_GET['id'])) {
            echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
        }
    ?>
    <div class="mb-3">
        <select class="form-select" name="id_kategori" required>
            <option value="">--Pilih Kategori--</option>
            <?php
                $sql_kategori = 'SELECT * FROM kategori';
                $query_kategori = mysqli_query($connection, $sql_kategori);
                while($result_kategori = mysqli_fetch_assoc($query_kategori)){
                    ?>
                    <option value ="<?= $result_kategori['id'] ?>" <?= isset ($_GETC['id']) ? ($result_kategori['id'] == $produk['id_kategori'] ? 'selected' : '') : ''?>><?= $result_kategori['kategori'] ?></option>
                    <?php
                }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <input type="text" name="nama" placeholder="Nama Produk" class="form-control" value="<?= isset($_GET['id']) ? $produk['nama'] : ''; ?>" required>
    </div>
    <div class="mb-3">
        <textarea class="form-control" name="detail" rows="3" placeholder="Detail Produk" required><?= isset($_GET['id']) ? $produk['detail'] : ''; ?></textarea> 
    </div>
    <div class="mb-3">
        <label class="form-label">Gambar Produk</label>
        <?= isset($_GET['id']) ? '<div class="mb-3"><img src="'.$produk['gambar'].'" width="100px"></div>' : ''; ?>
        <input type="file" name="gambar" class="form-control" required>
    </div>
    <a href="produk.php" class="btn btn-success">Kembali</a>
    <button type="submit" class="btn btn-info">Simpan</button>
 </form>
 </div>
</div>
<?php 
    function uploadFile() {
     print_r($_FILES);
     $tmp_dir = $_FILES['gambar']['tmp_name'];
     $target_dir = '../img/'.$_FILES['gambar']['name'];
     move_uploaded_file($tmp_dir, $target_dir);
     return $target_dir;
    }
    if(sizeof($_POST) > 0) {
    if(isset($_POST['id'])) {
        $dir = uploadFile();
        $kategori = mysqli_real_escape_string($connection, $_POST['kategori']);
        $sql = "UPDATE produk SET nama='".$_POST['nama']."', detail='".$_POST['detail']."', gambar='".$dir."', id_kategori='".$_POST['id_kategori']."' WHERE id='".$_POST['id']."'";
    } else {
        $dir = uploadFile();
        $kategori = mysqli_real_escape_string($connection, $_POST['kategori']);
        $sql="INSERT INTO produk VALUES ('','".$_POST['nama']."', '".$_POST['detail']."', '".$dir."', '".$_POST['id_kategori']."')";
    }
        if($query = mysqli_query($connection, $sql)) {
            header('Location: produk.php');
        } else {
            echo '<script>alert("Proses tidak berhasil.");</script>';
        }
    }
?>
<?php require_once 'footer.php'; ?>  
<script type="text/javascript">
  $('.nav-link').removeClass('active');
  $('.menu-produk').addClass('active');

</script>

