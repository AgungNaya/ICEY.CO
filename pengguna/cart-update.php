<?php
session_start();


if (isset($_GET['key']) && isset($_GET['action'])) {
  $key = $_GET['key'];
  $action = $_GET['action'];

  if (isset($_SESSION['cart'][$key])) {
    if ($action === 'plus') {
      $_SESSION['cart'][$key]['qty'] += 1;
    } elseif ($action === 'minus') {
      $_SESSION['cart'][$key]['qty'] -= 1;

      if ($_SESSION['cart'][$key]['qty'] <= 0) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reset index
      }
    }
  }
}


header("Location: cart.php");
exit;
