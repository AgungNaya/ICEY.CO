<?php
require_once '../include/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'] ?? 0;
  $update = mysqli_query($connection, "UPDATE transaksi SET status='Selesai' WHERE id='$id'");

  if ($update) {
    echo "<script>alert('Status berhasil diubah.'); window.location.href='transaksi.php';</script>";
  } else {
    echo "<script>alert('Gagal mengubah status.'); window.location.href='transaksi.php';</script>";
  }
} else {
  header("Location: transaksi.php");
  exit;
}
