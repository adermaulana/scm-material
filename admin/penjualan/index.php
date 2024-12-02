<?php

include '../../config/koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){

    session_unset();
    session_destroy();

    header("location:../");
}

if(isset($_GET['hal']) == "hapus"){

  $hapus = mysqli_query($koneksi, "DELETE FROM data_order WHERE id_order = '$_GET[id]'");

  if($hapus){
      echo "<script>
      alert('Hapus data sukses!');
      document.location='index.php';
      </script>";
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../../assets/dashboard.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link href="../DataTables/datatables.min.css" rel="stylesheet">
  <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>

</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Material Bangunan</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="../hapusSession.php">Sign out</a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
  <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="../index.php">
              <span data-feather="home" class="align-text-bottom"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="../material/index.php">
              <span data-feather="box" class="align-text-bottom"></span>
              Material
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../penjualan/index.php">
              <span data-feather="shopping-cart" class="align-text-bottom"></span>
              Penjualan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../pembelian/index.php">
              <span data-feather="shopping-bag" class="align-text-bottom"></span>
              Pembelian
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../pemasok/index.php">
              <span data-feather="users" class="align-text-bottom"></span>
              Pemasok
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../distributor/index.php">
              <span data-feather="users" class="align-text-bottom"></span>
              Distributor
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../return/index.php">
              <span data-feather="users" class="align-text-bottom"></span>
              Barang Return
            </a>
          </li>
        </ul>
      </div>
    </nav>

   <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
    <div class="col-lg-12">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Penjualan</h1>
      </div>

      <div class="table-responsive col-lg-12">
        <!-- <a style="background-color : #3a5a40; color:white;" class="btn btn mb-3" href="tambah.php">Tambah Penjualan</a> -->
        <table id="myTable" class="table table-striped table-sm mt-3">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Pelanggan</th>
              <th scope="col">Email</th>
              <th scope="col">Alamat</th>
              <th scope="col">Telepon</th>
              <th scope="col">Total</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * FROM data_order ORDER BY id_order DESC");
                while($data = mysqli_fetch_array($tampil)):
                ?>
            <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['nama_order']; ?></td>
                    <td><?= $data['email_order']; ?></td>
                    <td><?= $data['alamat_order']; ?></td>
                    <td><?= $data['telepon_order']; ?></td> 
                    <td>Rp. <?= number_format($data['total_order'],0,',','.'); ?></td> 
                    <td>
                    <?php if($data['status_order'] =='Sudah Bayar') { ?>
                      <div class="btn-group" role="group">
                          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $data['id_order'] ?>">
                              <?= $data['status_order'] ?>
                          </button>
                          <button type="button" class="btn btn-primary distributor-pilih" data-id="<?= $data['id_order'] ?>" data-bs-toggle="modal" data-bs-target="#distributorModal<?= $data['id_order'] ?>">
                              Kirim Barang
                          </button>
                      </div>

                      <div class="modal fade" id="distributorModal<?= $data['id_order'] ?>" tabindex="-1" aria-labelledby="distributorModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="distributorModalLabel">Pilih Distributor</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                      <form id="distributorForm<?= $data['id_order'] ?>">
                                          <input type="hidden" name="id_order" value="<?= $data['id_order'] ?>">
                                          <div class="mb-3">
                                              <label for="distributor" class="form-label">Distributor</label>
                                              <select class="form-select" name="id_distributor" required>
                                                  <option value="">Pilih Distributor</option>
                                                  <?php
                                                  // Fetch distributors from database
                                                  $distributor_query = mysqli_query($koneksi, "SELECT * FROM data_distributor");
                                                  while($distributor = mysqli_fetch_array($distributor_query)):
                                                  ?>
                                                  <option value="<?= $distributor['id_distributor'] ?>">
                                                      <?= $distributor['nama_distributor'] ?>
                                                  </option>
                                                  <?php endwhile; ?>
                                              </select>
                                          </div>
                                          <button type="submit" class="btn btn-primary">Kirim Barang</button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>

                    <?php } elseif($data['status_order'] =='Pending') { ?>
                      <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $data['id_order'] ?>">
                      <?= $data['status_order'] ?>
                    </button>
                    <?php } elseif($data['status_order'] =='Proses') { ?>
                      <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $data['id_order'] ?>">
                      <?= $data['status_order'] ?>
                    </button>
                    <?php } elseif($data['status_order'] =='Diantarkan') { ?>
                    <button type="button" class="btn btn-info">
                        <?= $data['status_order'] ?>
                    </button>
                    <?php } elseif($data['status_order'] =='Selesai') { ?>
                    <button type="button" class="btn btn-success">
                        <?= $data['status_order'] ?>
                    </button>
                    <?php } elseif($data['status_order'] =='Return Proses') { ?>
                    <a href="../return/index.php" class="btn btn-secondary">
                        <?= $data['status_order'] ?>
                    </a>
                    <?php } else { ?>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $data['id_order'] ?>">
                      <?= $data['status_order'] ?>
                    </button>
                    <?php } ?>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal<?= $data['id_order'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Pembayaran</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                          <?php
                            $id_penjualan = $data['id_order'];
                            $query_pembayaran = mysqli_query($koneksi, "SELECT * FROM data_pembayaran WHERE id_order = '$id_penjualan'");
                            $data_pembayaran = mysqli_fetch_array($query_pembayaran);
                          ?>
                          
                          <?php if (!empty($data_pembayaran['total_pembayaran'])): ?>
                              <p>Total Bayar: <?= $data_pembayaran['total_pembayaran']; ?></p>
                              <?php if (!empty($data_pembayaran['foto_pembayaran'])): ?>
                                  <img src="../../<?= $data_pembayaran['foto_pembayaran']; ?>" alt="Bukti Pembayaran" style="max-width: 100%;">
                              <?php endif; ?>
                          <?php else: ?>
                              <p>Tidak ada bukti pembayaran.</p>
                          <?php endif; ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $data['id_order'] ?>" id="konfirmasiBtn<?= $data['id_order'] ?>">
                            Konfirmasi
                          </button>
                          <!-- Tombol Tolak -->
                          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $data['id_order'] ?>" id="tolakBtn<?= $data['id_order'] ?>">
                            Tolak
                          </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    </td> 
              <td>
                    <a href="detail.php?hal=detail&id=<?= $data['id_order']?>" class="badge bg-success border-0"><span data-feather="eye"></span></a>
                    <a href="index.php?hal=hapus&id=<?= $data['id_order']?>" class="badge bg-danger border-0" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data?')"><span data-feather="x-circle"></span></a>
              </td>
            </tr>
            <?php
                 endwhile; 
                ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>


<!-- Include jQuery -->
<script src="../DataTables/jQuery-3.7.0/jquery-3.7.0.min.js"></script>

<script>

$(document).ready( function () {
    $('#myTable').DataTable();
} );
  
</script>

<script>

$(document).ready(function () {
    // Handle distributor selection and sending goods
    $('[id^=distributorForm]').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: 'kirim_barang.php',
            type: 'POST',
            data: formData,
            dataType: 'text',
            success: function (response) {
                if (response === 'success') {
                    alert('Barang telah diantarkan oleh distributor!');
                    window.location.reload();
                } else {
                    alert('Terjadi kesalahan: ' + response);
                }
            },
            error: function () {
                alert('Terjadi kesalahan saat mengirim barang.');
            }
        });
    });
});

$(document).ready(function () {
  // Fungsi untuk mengubah status dan menutup modal setelah konfirmasi
  function konfirmasiPembayaran(idOrder) {
    $.ajax({
      url: 'konfirmasi_pembayaran.php',
      type: 'POST',
      data: { id_order: idOrder },
      dataType: 'text',
      success: function (response) {
        if (response === 'success') {
          // Konfirmasi berhasil, ubah status dan tutup modal
          $('#statusBtn' + idOrder)
            .removeClass('btn-info')
            .addClass('btn-success')
            .text('Sudah Bayar');
          $('#exampleModal' + idOrder).modal('hide');

          // Tampilkan alert berhasil
          alert('Pembayaran berhasil dikonfirmasi!');

          window.location.href = 'index.php';
        } else {
          // Tampilkan alert kesalahan
          alert('Terjadi kesalahan saat melakukan konfirmasi pembayaran.');
        }
      },
      error: function () {
        // Tampilkan alert kesalahan
        alert('Terjadi kesalahan saat melakukan konfirmasi pembayaran.');
      }
    });
  }

  // Menangani klik tombol konfirmasi
  $('body').on('click', '[id^=konfirmasiBtn]', function () {
    var idOrder = this.id.replace('konfirmasiBtn', '');
    konfirmasiPembayaran(idOrder);
  });
});

</script>


<script>
$(document).ready(function () {
    // Menangani klik tombol "Tolak"
    $('body').on('click', '[id^=tolakBtn]', function () {
        var idOrder = this.id.replace('tolakBtn', '');
        tolakPembayaran(idOrder);
    });

    // Fungsi untuk menolak pembayaran
    function tolakPembayaran(idOrder) {
        $.ajax({
            url: 'tolak_pembayaran.php', // Sesuaikan dengan path yang sesuai
            type: 'POST',
            data: { id_order: idOrder },
            dataType: 'text',
            success: function (response) {
                if (response === 'success') {
                    // Tolak berhasil, tutup modal
                    $('#tolakModal' + idOrder).modal('hide');

                    // Tampilkan alert berhasil
                    alert('Pembayaran telah ditolak!');

                    // Refresh halaman
                    window.location.href = 'index.php';
                } else {
                    // Tampilkan alert kesalahan
                    alert('Terjadi kesalahan saat menolak pembayaran.');
                }
            },
            error: function () {
                // Tampilkan alert kesalahan
                alert('Terjadi kesalahan saat menolak pembayaran.');
            }
        });
    }
});
</script>


<script src="../DataTables/datatables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="../../assets/dashboard.js"></script>
</body>
</html>