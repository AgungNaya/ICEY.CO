<?php
session_start();


$id     = $_POST['id'];
$nama   = $_POST['nama'];
$harga  = $_POST['harga'];
$gambar = $_POST['gambar'];


$item = [
  'id'     => $id,
  'nama'   => $nama,
  'harga'  => $harga,
  'gambar' => $gambar,
  'qty'    => 1
];


if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}


$found = false;
foreach ($_SESSION['cart'] as $key => $cartItem) {
  if ($cartItem['id'] == $id) {
    $_SESSION['cart'][$key]['qty'] += 1;
    $found = true;
    break;
  }
}

if (!$found) {
  $_SESSION['cart'][] = $item;
}


header("Location: cart.php");
exit;
