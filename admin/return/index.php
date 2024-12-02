<?php
include '../../config/koneksi.php';

session_start();

if ($_SESSION['status'] != 'login') {
    session_unset();
    session_destroy();
    header("location:../");
}

// Handle delete action
if (isset($_GET['hal']) && $_GET['hal'] == "hapus") {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $hapus = mysqli_query($koneksi, "DELETE FROM return_produk WHERE id_return = '$id'");

    if ($hapus) {
        echo "<script>
        alert('Hapus data sukses!');
        document.location='index.php';
        </script>";
    } else {
        echo "<script>
        alert('Gagal menghapus data!');
        document.location='index.php';
        </script>";
    }
}

if (isset($_GET['hal']) && $_GET['hal'] == "terima") {
  $id = mysqli_real_escape_string($koneksi, $_GET['id']);
  
  // Update return status
  $update_return = mysqli_query($koneksi, "UPDATE return_produk SET status_return = 'Disetujui' WHERE id_return = '$id'");
  
  // Check if the return status was successfully updated
  if ($update_return) {
      // Retrieve the order ID associated with the return
      $query = mysqli_query($koneksi, "SELECT id_order FROM return_produk WHERE id_return = '$id'");
      $data = mysqli_fetch_assoc($query);
      $id_order = $data['id_order'];
      
      // Update order status to 'Sudah Bayar'
      $update_order = mysqli_query($koneksi, "UPDATE data_order SET status_order = 'Sudah Bayar' WHERE id_order = '$id_order'");
      
      if ($update_order) {
          echo "<script>
          alert('Return accepted and order status updated to Sudah Bayar!');
          document.location='index.php';
          </script>";
      } else {
          echo "<script>
          alert('Failed to update the order status!');
          document.location='index.php';
          </script>";
      }
  } else {
      echo "<script>
      alert('Failed to accept the return!');
      document.location='index.php';
      </script>";
  }
}

if (isset($_GET['hal']) && $_GET['hal'] == "tolak") {
  $id = mysqli_real_escape_string($koneksi, $_GET['id']);
  
  // Update return status to 'Ditolak'
  $update_return = mysqli_query($koneksi, "UPDATE return_produk SET status_return = 'Ditolak' WHERE id_return = '$id'");
  
  // Check if the return status was successfully updated
  if ($update_return) {
      // Retrieve the order ID associated with the return
      $query = mysqli_query($koneksi, "SELECT id_order FROM return_produk WHERE id_return = '$id'");
      $data = mysqli_fetch_assoc($query);
      $id_order = $data['id_order'];
      
      // Update order status to 'Selesai'
      $update_order = mysqli_query($koneksi, "UPDATE data_order SET status_order = 'Selesai' WHERE id_order = '$id_order'");
      
      if ($update_order) {
          echo "<script>
          alert('Return rejected and order status updated to Selesai!');
          document.location='index.php';
          </script>";
      } else {
          echo "<script>
          alert('Failed to update the order status!');
          document.location='index.php';
          </script>";
      }
  } else {
      echo "<script>
      alert('Failed to reject the return!');
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
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="../material/index.php">
              Material
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="../penjualan/index.php">
              Penjualan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../pembelian/index.php">
              Pembelian
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../pemasok/index.php">
              Pemasok
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../distributor/index.php">
              Distributor
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../return/index.php">
              Barang Return
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
      <div class="col-lg-12">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Daftar Barang Return</h1>
        </div>

        <div class="table-responsive col-lg-12">
          <table id="myTable" class="table table-striped table-sm mt-3">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">ID Order</th>
                <th scope="col">Alasan Return</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Status</th>
                <th scope="col">Tanggal Return</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $tampil = mysqli_query($koneksi, "SELECT rp.*, ro.id_order
                                                  FROM return_produk rp 
                                                  JOIN detail_return dr ON rp.id_return = dr.id_return 
                                                  JOIN data_order ro ON ro.id_order = rp.id_order
                                                  JOIN data_order_item roi ON roi.id_order = ro.id_order 
                                                  ORDER BY rp.id_return DESC");
              while ($data = mysqli_fetch_array($tampil)) :
              ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $data['id_order']; ?></td>
                  <td><?= $data['alasan_return']; ?></td>
                  <td><?= $data['keterangan_return']; ?></td>
                  <td>
                    <?php if ($data['status_return'] == 'Menunggu Konfirmasi') { ?>
                      <span class="badge bg-warning"><?= $data['status_return'] ?></span>
                    <?php } elseif ($data['status_return'] == 'Disetujui') { ?>
                      <span class="badge bg-success"><?= $data['status_return'] ?></span>
                    <?php } else { ?>
                      <span class="badge bg-danger"><?= $data['status_return'] ?></span>
                    <?php } ?>
                  </td>
                  <td><?= $data['tanggal_return']; ?></td>
                  <td>
                    <a href="detail.php?hal=detail&id=<?= $data['id_return']?>" class="badge bg-info border-0"><span data-feather="eye"></span></a>
                    <a href="index.php?hal=terima&id=<?= $data['id_return']?>" class="badge bg-success border-0" onclick="return confirm('Apakah Anda yakin ingin menerima return ini?')"><span data-feather="check-circle"></span></a>
                    <a href="index.php?hal=tolak&id=<?= $data['id_return']?>" class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menolak return ini?')"><span data-feather="x-circle"></span></a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</div>

<script src="../DataTables/jQuery-3.7.0/jquery-3.7.0.min.js"></script>
<script src="../DataTables/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="../../assets/dashboard.js"></script>
<script>
  $(document).ready(function () {
    $('#myTable').DataTable();
  });
</script>

</body>
</html>
