<?php
// tolak_pembayaran.php

include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_order'])) {
  $idOrder = $_POST['id_order'];

  // Ubah status menjadi 'Tolak' di database
  $updateStatus = mysqli_query($koneksi, "UPDATE data_order SET status_order = 'Ditolak' WHERE id_order = '$idOrder'");

  if ($updateStatus) {
    echo 'success';
  } else {
    echo 'error';
  }
} else {
  echo 'error';
}
?>
