<?php

include '../../config/koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){
    session_unset();
    session_destroy();
    header("location:../");
}

if(isset($_GET['hal'])){
    if($_GET['hal'] == "detail"){
        // Query to get return details based on return ID
        $tampil = mysqli_query($koneksi, "SELECT * FROM return_produk WHERE id_return = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if($data){
            $id = $data['id_return'];
            $id_order = $data['id_order'];
            $alasan = $data['alasan_return'];
            $keterangan = $data['keterangan_return'];
            $bukti = $data['bukti_return'];
            $status = $data['status_return'];
            $tanggal = $data['tanggal_return'];
        }

        // Query to get the details of items in the return (joined with data_order_item and material info)
        $query_produk = mysqli_query($koneksi, "SELECT dr.*, doi.jumlah_order_item, domat.nama_material, domat.harga_material
                                                FROM detail_return dr
                                                JOIN data_order_item doi ON dr.id_detail_order = doi.id_order_item
                                                JOIN data_material domat ON doi.id_material = domat.id_material
                                                WHERE dr.id_return = '$id'");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/dashboard.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            <a class="nav-link" href="../penjualan/index.php">
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
            <a class="nav-link active" href="../return/index.php">
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
        <h2>Detail Return</h2>
    </div>
    <a class="btn btn-success mb-3" href="index.php">Kembali</a>
    <div class="card mb-3 col-md-6">
    <div class="card-body">

    <div>
        <h6>Detail Return:</h6>
        <span>Alasan: <?= $alasan ?></span><br>
        <span>Keterangan: <?= $keterangan ?></span><br>
        <span>Status: <?= $status ?></span><br>
        <p>Tanggal: <?= $tanggal ?></p>
    </div>

        <h5 class="card-title">Return ID: <?php echo $data['id_return']; ?></h5>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama Material</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalHarga = 0; // Variable to store total price
                while ($produk = mysqli_fetch_array($query_produk)) :
                    $hargaSatuan = $produk['harga_material'];
                    $totalHargaProduk = $hargaSatuan * $produk['jumlah_order_item'];
                    $totalHarga += $totalHargaProduk;
                ?>
                    <tr>
                        <td><?= $produk['nama_material'] ?></td>
                        <td><?= $produk['jumlah_order_item'] ?></td>
                        <td>Rp <?= number_format($totalHargaProduk, 0, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="mt-3">
            <h5>Grand Total: Rp <?= number_format($totalHarga, 0, ',', '.') ?></h5>
        </div>
    </div>
</div>

    </div>
    </main>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="../../assets/dashboard.js"></script>
</body>
</html>
