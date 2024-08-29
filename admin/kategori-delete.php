<?php 
    require_once '../include/koneksi.php';
    $sql = "DELETE FROM kategori WHERE id='".$_GET['id']."'";
    $query = mysqli_query($connection, $sql);
    if($query) {
        header('Location: kategori.php');
    }
?>