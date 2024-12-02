<?php

include '../../config/koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){

    session_unset();
    session_destroy();

    header("location:../");
}

if(isset($_GET['hal']) == "hapus"){

  $hapus = mysqli_query($koneksi, "DELETE FROM data_pembelian WHERE id_pembelian = '$_GET[id]'");

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
            <a class="nav-link " href="../penjualan/index.php">
              <span data-feather="shopping-cart" class="align-text-bottom"></span>
              Penjualan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../pembelian/index.php">
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

   <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="col-lg-12">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Pembelian</h1>
      </div>

      <div class="table-responsive col-lg-10">
        <a style="background-color : #3a5a40; color:white;" class="btn btn mb-3" href="tambah.php">Tambah Pembelian</a>
        <table id="myTable" class="table table-striped table-sm mt-3">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Material</th>
              <th scope="col">Nama Pemasok</th>
              <th scope="col">Harga</th>
              <th scope="col">Jumlah</th>
              <th scope="col">Tanggal Beli</th>
              <th scope="col">Harga Total</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT p.*, m.nama_material, pem.nama_pemasok
                FROM data_pembelian p
                JOIN data_pemasok pem ON p.id_pemasok = pem.id_pemasok
                JOIN data_material m ON p.id_material = m.id_material");
                while($data = mysqli_fetch_array($tampil)):
                ?>
            <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['nama_material']; ?></td>
                    <td><?= $data['nama_pemasok']; ?></td>
                    <td><?= $data['harga_pembelian']; ?></td>
                    <td><?= $data['jumlah_pembelian']; ?></td> 
                    <td><?= $data['tanggal_pembelian']; ?></td> 
                    <td>Rp. <?= number_format($data['total_pembelian'],0,',','.'); ?></td> 
              <td>
                    <a href="index.php?hal=hapus&id=<?= $data['id_pembelian']?>" class="badge bg-danger border-0" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data?')"><span data-feather="x-circle"></span></a>
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

<script src="../DataTables/datatables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="../../assets/dashboard.js"></script>
</body>
</html>
