<?php include 'partials/header.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username_pelanggan'])) {
    // Jika tidak, redirect ke halaman login dengan pesan alert
    echo "<script>
    alert('Anda harus login terlebih dahulu!');
    document.location='login_pelanggan.php';
    </script>";
    exit;
}

$id_pelanggan = $_SESSION['id_pelanggan'];

if (isset($_GET['hal']) && $_GET['hal'] == "hapus") {
    $id_keranjang = $_GET['id'];

    // Retrieve the quantity and id_material from data_keranjang
    $result = mysqli_query($koneksi, "SELECT * FROM data_keranjang WHERE id_keranjang = $id_keranjang");
    $data_keranjang = mysqli_fetch_assoc($result);

    $jumlah_keranjang = $data_keranjang['jumlah_keranjang'];
    $id_material = $data_keranjang['id_material'];

    // Delete the item from data_keranjang
    $hapus = mysqli_query($koneksi, "DELETE FROM data_keranjang WHERE id_keranjang = $id_keranjang");

    if ($hapus) {
        // Update stok_material in data_material
        $update_stok = mysqli_query($koneksi, "UPDATE data_material SET stok_material = stok_material + $jumlah_keranjang WHERE id_material = $id_material");

        if ($update_stok) {
            echo "<script>
                alert('Hapus data sukses!');
                document.location='keranjang.php';
            </script>";
        } else {
            // Handle the update_stok failure
            echo "<script>
                alert('Gagal mengupdate stok material!');
                document.location='keranjang.php';
            </script>";
        }
    } else {
        // Handle the delete failure
        echo "<script>
            alert('Gagal menghapus data keranjang!');
            document.location='keranjang.php';
        </script>";
    }
}

?>

<div class="container mt-5">
    <h2 class="mb-4">Keranjang</h2>
    <?php
    $tampil = mysqli_query($koneksi, "SELECT k.*, m.nama_material, m.gambar_material
        FROM data_keranjang k
        JOIN data_material m ON k.id_material = m.id_material
        WHERE id_pelanggan = $id_pelanggan ORDER BY id_keranjang DESC");
    
    if (mysqli_num_rows($tampil) > 0) {
    ?>
        <div class="row">
            <div class="col-md-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Material</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Total</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while($data = mysqli_fetch_array($tampil)):
                        ?>
                            <tr>
                                <th scope="row"><?= $no++ ?></th>
                                <td>
                                    <img src="<?= $data['gambar_material']; ?>" alt="<?= $data['nama_material']; ?>" class="img-thumbnail" style="max-width: 100px;">
                                    <?= $data['nama_material']; ?>
                                </td>
                                <td><?= $data['jumlah_keranjang'] ?></td>
                                <td>Rp. <?= number_format($data['harga_keranjang'],0,',','.'); ?></td>
                                <td>Rp. <?= number_format($data['total_keranjang'],0,',','.'); ?></td>
                                <td>
                                    <a href="keranjang.php?hal=hapus&id=<?= $data['id_keranjang']?>" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data?')">
                                        <span data-feather="x-circle"></span>Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Keranjang Belanja</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php 
                                $keranjang = "SELECT SUM(total_keranjang) as total_harga_keranjang FROM data_keranjang WHERE id_pelanggan = $id_pelanggan";

                                $resultkeranjang = $koneksi->query($keranjang);
                                $rowkeranjang = $resultkeranjang->fetch_assoc();
                                $total_keranjang = $rowkeranjang["total_harga_keranjang"];
                                ?>
                                Total:
                                <span>Rp. <?= number_format($total_keranjang,0,',','.'); ?></span>
                            </li>
                        </ul>
                        <a href="checkout.php?hal=checkout&id=<?= $id_pelanggan ?>" class="btn btn-primary mt-3">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="material.php" class="btn btn-success">Lanjut Belanja</a>
    <?php } else { ?>
        <p>Tidak ada produk dalam keranjang belanja.</p>
        <a href="material.php" class="btn btn-success">Mulai Belanja</a>
    <?php } ?>
</div>

<?php include 'partials/footer.php'; ?>
