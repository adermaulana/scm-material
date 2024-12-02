<?php
include '../../config/koneksi.php';

if (isset($_POST['id_order'])) {
    $idPenjualan = $_POST['id_order'];

    // Lakukan update status penjualan menjadi "Sudah Bayar"
    $updateStatus = mysqli_query($koneksi, "UPDATE data_order SET status_order = 'Sudah Bayar' WHERE id_order = '$idPenjualan'");

    if ($updateStatus) {
        echo 'success'; // Berhasil melakukan konfirmasi
    } else {
        echo 'error'; // Gagal melakukan konfirmasi
    }
}
?>
