<?php
require_once '../include/koneksi.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=transaksi-export.xls");

echo "<table border='1'>";
echo "<tr><th>No</th><th>Nama</th><th>Metode</th><th>Tanggal</th><th>Status</th></tr>";

$query = mysqli_query($connection, "SELECT * FROM transaksi ORDER BY tanggal DESC");
$no = 1;

while ($row = mysqli_fetch_assoc($query)) {
  echo "<tr>";
  echo "<td>".$no++."</td>";
  echo "<td>".$row['nama_pembeli']."</td>";
  echo "<td>".$row['metode_pembayaran']."</td>";
  echo "<td>".$row['tanggal']."</td>";
  echo "<td>".$row['status']."</td>";
  echo "</tr>";
}

echo "</table>";
