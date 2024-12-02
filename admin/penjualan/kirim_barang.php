<?php
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_order = mysqli_real_escape_string($koneksi, $_POST['id_order']);
    $id_distributor = mysqli_real_escape_string($koneksi, $_POST['id_distributor']);

    // Start a transaction to ensure data integrity
    mysqli_begin_transaction($koneksi);

    try {
        // Update order status and assign distributor
        $update_query = "UPDATE data_order 
                         SET status_order = 'Diantarkan', 
                             id_distributor = '$id_distributor' 
                         WHERE id_order = '$id_order'";
        
        if (!mysqli_query($koneksi, $update_query)) {
            throw new Exception("Failed to update order status");
        }

        // Commit the transaction
        mysqli_commit($koneksi);
        echo 'success';
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        mysqli_rollback($koneksi);
        echo 'error: ' . $e->getMessage();
    }
    
    exit();
}
?>