<?php include 'partials/header.php';

if (!isset($_SESSION['username_pelanggan'])) {
    // Jika tidak, redirect ke halaman login dengan pesan alert
    echo "<script>
    alert('Anda harus login terlebih dahulu!');
    document.location='login_pelanggan.php';
    </script>";
    exit;
}

?>

    <div class="col">
        <div>
            <h4 class="mb-3">Pembayaranku</h4>
            <?php

                $pelanggan = $_SESSION['id_pelanggan'];

                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * FROM data_order WHERE id_pelanggan = $pelanggan ORDER BY id_order DESC");
                while($data = mysqli_fetch_array($tampil)):
                ?>
			      		<div id="container-booking-list">
                            <div id="no-data-row" class="card mb-3 nodata">						 
                                <div class="no-gutters">						    					    
                                        <div class="">						      
                                        <div class="card-header ">							  	
                                            <div class="row">								    
                                                <div class="col text-left text-muted">ID Order : <strong>
                                                    <?= $data['id_order'] ?>
                                                </strong>
                                            </div>								    
                                            <div style="text-align:right;" class="col text">
                                                <strong class="bayar"  ><?= "Rp " . number_format($data['total_order'], 0, ',', '.') ?>
                                            </strong>
                                            </div>							    
                                        </div>
                                        							  
                                        </div>
                                        <div class="card-body"><p class="card-text"><?= $data['nama_order'] ?></p></div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col text-end action-right">
                                                    <?php if($data['status_order'] =='Proses') { ?>
                                                        <span class="badge bg-info"><?= $data['status_order'] ?></span>
                                                    <?php } elseif($data['status_order'] =='Sudah Bayar') { ?>
                                                        <span class="badge bg-success"><?= $data['status_order'] ?></span>
                                                    <?php } elseif($data['status_order'] =='Ditolak') { ?>
                                                        <span class="badge bg-danger"><?= $data['status_order'] ?></span>
                                                    <?php } elseif($data['status_order'] =='Return Proses') { ?>
                                                        <span class="badge bg-primary"><?= $data['status_order'] ?></span>
                                                    <?php } elseif($data['status_order'] =='Diantarkan') { ?>
                                                        <span class="badge bg-secondary"><?= $data['status_order'] ?></span>
                                                        <a href="return_produk.php?id=<?= $data['id_order'] ?>" class="btn btn-warning btn-sm return-produk">Return Produk</a>
                                                    <?php } else { ?>
                                                        <a href="konfirmasi_pembayaran.php?hal=konfirmasi&id=<?= $data['id_order'] ?>" class="btn-link disabled">Konfirmasi Pembayaran</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
			            </div>
        <?php
                 endwhile; 
                ?>
    </div>
        </div>
 
<?php include 'partials/footer.php'; ?>

