<?php require_once 'header.php'; ?>
<div class="col-12 p-5 mt-3">
    <div class="bg-pink p-3">
        <h3>Kategori</h3>
        <?php
            require_once "../include/koneksi.php";
            $sql='SELECT * FROM kategori';
            $query = mysqli_query($connection, $sql);
        ?>
<a href="kategori-form.php" class="btn btn-info mb-3">Tambah Data</a>
<table class="table table-bordered">
    <thread>
        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Kategori</th>
            <th class="text-center">Option</th>
        </tr>
</thread>
<tbody>
    <?php
    while($result = mysqli_fetch_assoc($query)){
        echo '<tr>';
            echo '<td class="text-center">' .$result['id']. '</td>';
            echo '<td>' .$result['kategori']. '</td>';
            echo '<td class="text-center"> 
            <a href="kategori-form.php?id='.$result['id'].'" class="btn btn-warning btn-sm">Edit</a>
            <a href="kategori-delete.php?id='.$result['id'].'" class="btn btn-danger btn-sm" onclick="return confirmAction()">Delete</a>
             </td>';
        echo '</tr>';
    }
    ?>
    </tbody>
</table>
</div>
</div>
<?php require_once 'footer.php'; ?>
<script>
function confirmAction() {
    var userConfirmed = confirm('Apakah anda yakin ingin menghapus data ini?');
    if (userConfirmed) {
        return true;
    } else {
        console.log('Penghapusan dibatalkan oleh pengguna.');
        return false;
    }
}
</script>
<script type="text/javascript">
  $('.nav-link').removeClass('active');
  $('.menu-kategori').addClass('active');

</script>

