<?php

include '../../config/koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){

    session_unset();
    session_destroy();

    header("location:../");
}

$id=$_SESSION['id_admin'];
$nama=$_SESSION['nama_admin'];

if(isset($_POST['simpan'])){

    // Periksa apakah ada permintaan material_id dan jumlah_material dari AJAX
    if (isset($_POST["material_id"]) && isset($_POST["jumlah"])) {
        $materialId = $_POST["material_id"];
        $jumlahPembelian = $_POST["jumlah"]; // Jumlah material yang dibeli

        // Query database untuk mendapatkan stok material berdasarkan material_id
        $query = "SELECT stok_material FROM data_material WHERE id_material = $materialId";
        $result = $koneksi->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stokMaterial = $row["stok_material"];

                // Kurangkan stok material yang tersedia
                $stokMaterial += $jumlahPembelian;

                // Update stok material dalam database
                $updateQuery = "UPDATE data_material SET stok_material = $stokMaterial WHERE id_material = $materialId";
                if ($koneksi->query($updateQuery) === TRUE) {
                    echo "Stok material berhasil diperbarui.";
                    $simpan = mysqli_query($koneksi, "INSERT INTO data_pembelian (id_material,harga_pembelian ,jumlah_pembelian, tanggal_pembelian, total_pembelian, id_pemasok, id_admin) VALUES ('$_POST[material_id]','$_POST[harga]','$_POST[jumlah]','$_POST[tanggal]','$_POST[harga_total]','$_POST[id_pemasok]','$_POST[id_admin]')");
                } else {
                    echo "Gagal mengupdate stok material.";
                }
            
        } else {
            echo "Material tidak ditemukan.";
        }
    }

    if($simpan){
        echo "<script>
                alert('Simpan data sukses!');
                document.location='index.php';
            </script>";
    } else {
        echo "<script>
                alert('Simpan data Gagal!');
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
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/dashboard.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Pembelian</h1>
      </div>

<div class="col-lg-8">
    <form method="post" class="mb-5" enctype="multipart/form-data">
      <input type="hidden" name="id_admin" value="<?= $id ?>">
    <div class="mb-3">
            <label for="admin" class="form-label">Admin</label>
            <input style="background-color:#edede9;" type="text" class="form-control" value="<?= $nama ?>" readonly>
        </div>
    <div class="mb-3">
         <label for="material_id" class="form-label">Material</label>
            <select class="form-select js-example-basic-single" id="material_id" name="material_id">
            <option value="0" >Pilih</option>
            <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * FROM data_material");
                while($data = mysqli_fetch_array($tampil)):
                ?>
                  <option value="<?= $data[0]?>" data-harga="<?= $data[3] ?>" data-stok="<?= $data[4] ?>" ><?= $data[1]?></option>
                  <?php 
                 endwhile; 
                ?>
            </select>
        </div>
    <div class="mb-3">
         <label for="id_pemasok" class="form-label">Nama Pemasok</label>
            <select class="form-select js-example-basic-single" id="id_pemasok" name="id_pemasok" required>
            <option value="0" >Pilih</option>
            <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * FROM data_pemasok");
                while($data = mysqli_fetch_array($tampil)):
                ?>
                  <option value="<?= $data[0]?>"><?= $data['nama_pemasok']?></option>
                  <?php 
                 endwhile; 
                ?>
            </select>
        </div>
    <div class="mb-3">
        <label for="harga" class="form-label">Harga Pembelian</label>
        <input type="number" class="form-control" id="harga" name="harga" readonly required>
    </div>
    <div class="mb-3">
        <label for="jumlah" class="form-label">Jumlah Pembelian</label>
        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
    </div>
    <div class="mb-3">
        <label for="tanggal" class="form-label">Tanggal Pembelian</label>
        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
    </div>
    <div class="mb-3">
        <label for="harga_total" class="form-label">Harga Total</label>
        <input type="number" class="form-control" id="harga_total" name="harga_total" readonly required>
    </div>

    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
    </form>
</div>
</div>
</main>
</div>
</div>

<script src="../../assets/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    $('#material_id').change(function() {
        var materialId = $(this).val();
        var selectedOption = $('#material_id option:selected');
        var harga = selectedOption.data('harga');
        var stok = selectedOption.data('stok');
        $('#harga').val(harga);

        var jumlah = $('#jumlah').val();
        var hargaTotal = harga * jumlah;
        $('#harga_total').val(hargaTotal);
    });

    $('#jumlah').change(function() {
        var jumlah = $(this).val();
        var harga = $('#harga').val();
        var hargaTotal = harga * jumlah;
        $('#harga_total').val(hargaTotal);
    });

    $(".js-example-basic-single").select2();
  });
</script>

</body>
</html>
