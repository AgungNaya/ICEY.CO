<?php
session_start();
require_once '../include/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama   = $_POST['nama'];
  $metode = $_POST['metode'];
  $cart   = $_SESSION['cart'] ?? [];

  if (empty($nama) || empty($metode) || empty($cart)) {
    echo "<script>alert('Data checkout tidak lengkap.'); window.location.href='checkout.php';</script>";
    exit;
  }


  $tanggal = date('Y-m-d H:i:s');
  $insert_transaksi = "INSERT INTO transaksi (nama_pembeli, metode_pembayaran, tanggal) 
                       VALUES ('$nama', '$metode', '$tanggal')";
  $result = mysqli_query($connection, $insert_transaksi);

  if (!$result) {
    echo "<script>alert('Gagal menyimpan transaksi.'); window.location.href='checkout.php';</script>";
    exit;
  }

  $id_transaksi = mysqli_insert_id($connection); // ID transaksi yang baru dibuat

 
  foreach ($cart as $item) {
    $nama_produk = mysqli_real_escape_string($connection, $item['nama']);
    $harga = $item['harga'];
    $qty   = $item['qty'];

    mysqli_query($connection, "INSERT INTO detail_transaksi (id_transaksi, nama_produk, harga, qty) 
                               VALUES ('$id_transaksi', '$nama_produk', '$harga', '$qty')");
  }


  $_SESSION['nota'] = [
    'id_transaksi' => $id_transaksi,
    'nama'         => $nama,
    'metode'       => $metode,
    'tanggal'      => $tanggal
  ];

 
  if (!isset($_SESSION['histori'])) {
    $_SESSION['histori'] = [];
  }
  $_SESSION['histori'][] = [
    'id_transaksi' => $id_transaksi,
    'status'       => 'Diproses'
  ];


  unset($_SESSION['cart']);


  header("Location: nota.php");
  exit;
} else {
  header("Location: checkout.php");
  exit;
}
