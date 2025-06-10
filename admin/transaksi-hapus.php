<?php
require_once '../include/koneksi.php';

$id = $_GET['id'] ?? 0;


mysqli_query($connection, "DELETE FROM detail_transaksi WHERE id_transaksi = '$id'");
$hapus = mysqli_query($connection, "DELETE FROM transaksi WHERE id = '$id'");

if ($hapus) {
  echo "<script>alert('Transaksi berhasil dihapus'); window.location.href='transaksi.php';</script>";
} else {
  echo "<script>alert('Gagal menghapus transaksi'); window.location.href='transaksi.php';</script>";
}
