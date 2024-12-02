<?php include 'partials/header.php'; ?>


<?php 

if(isset($_GET['hal'])){
    if($_GET['hal'] == "detail"){
        $tampil = mysqli_query($koneksi, "SELECT * FROM data_material WHERE id_material = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if($data){
            $id = $data['id_material'];
            $nama_material = $data['nama_material'];
            $deskripsi = $data['deskripsi_material'];
            $harga = $data['harga_material'];
            $stok = $data['stok_material'];
            $gambar = $data['gambar_material'];
        }
    }
}

if(isset($_POST['simpan'])){
    $materialId = $_POST["id_material"];
    $jumlahPembelian = $_POST["jumlah"]; // Jumlah material yang dibeli

    // Query database untuk mendapatkan stok dan harga material berdasarkan material_id
    $query = "SELECT stok_material, harga_material FROM data_material WHERE id_material = $materialId";
    $result = $koneksi->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stokMaterial = $row["stok_material"];
        $hargaMaterial = $row["harga_material"];

        // Periksa apakah jumlah material yang dibeli tidak melebihi stok yang tersedia
        if ($jumlahPembelian <= $stokMaterial) {
            // Kurangkan stok material yang tersedia
            $stokMaterial -= $jumlahPembelian;

            // Update stok material dalam database
            $updateQuery = "UPDATE data_material SET stok_material = $stokMaterial WHERE id_material = $materialId";
            if ($koneksi->query($updateQuery) === FALSE) {
                echo "Gagal mengupdate stok material.";
                exit;
            }

            // Check if the product is already in the cart
            $existingCartItemQuery = "SELECT * FROM data_keranjang WHERE id_material = $materialId AND id_pelanggan = $_POST[id_pelanggan]";
            $existingCartItemResult = $koneksi->query($existingCartItemQuery);

            if ($existingCartItemResult->num_rows > 0) {
                // Update quantity if the product is already in the cart
                $existingCartItem = $existingCartItemResult->fetch_assoc();
                $newQuantity = $existingCartItem['jumlah_keranjang'] + $jumlahPembelian;

                $updateCartItemQuery = "UPDATE data_keranjang SET jumlah_keranjang = $newQuantity, harga_keranjang = $hargaMaterial, total_keranjang = $newQuantity * $hargaMaterial WHERE id_keranjang = {$existingCartItem['id_keranjang']}";
                if ($koneksi->query($updateCartItemQuery) === TRUE) {
                    echo "<script>
                            alert('Berhasil Menambahkan Produk ke Keranjang!');
                            document.location='keranjang.php';
                          </script>";
                } else {
                    echo "Gagal mengupdate quantity dalam keranjang.";
                }
            } else {
                // Insert new item into the cart if the product is not in the cart
                $simpan = mysqli_query($koneksi, "INSERT INTO data_keranjang (id_material, id_pelanggan, harga_keranjang, jumlah_keranjang, total_keranjang) VALUES ('$materialId','$_POST[id_pelanggan]','$hargaMaterial','$jumlahPembelian','$hargaMaterial' * '$jumlahPembelian')");
                if ($simpan) {
                    echo "<script>
                            alert('Berhasil Menambahkan Produk ke Keranjang!');
                            document.location='keranjang.php';
                          </script>";
                } else {
                    echo "Gagal menambahkan produk ke keranjang.";
                }
            }
        } else {
            echo "<script>
                    alert('Jumlah material yang dibeli melebihi stok yang tersedia.');
                    window.location.href='detail_material.php?hal=detail&id=" . $data['id_material'] . "';
                  </script>";
        }
    } else {
        echo "Material tidak ditemukan.";
    }
}

?>
<section class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="mb-4">
                <img src="<?= $gambar; ?>" class="card-img-top" alt="Material">
            </div>
        </div>
        <div class="col-md-7">
            <div class="mb-4 mt-5">
                <div class="card-body ms-5">
                    <h1 class="card-title"><?= $nama_material; ?></h1>
                    <p class="card-text mt-2"><?= $deskripsi; ?></p>
                    <p class="text-muted">
                        Stok <?= $stok; ?>
                    </p>
                    <h3 class="mb-3"><?= "Rp " . number_format($harga, 0, ',', '.'); ?></h3>
                    <form action="" method="post" onsubmit="return checkLoginStatus()">
                        <input type="hidden" name="id_material" value="<?= $id ?>">   
                        <input type="hidden" id="harga" name="harga" value="<?= $harga ?>">
                        <input type="hidden" id="total" name="total">   
                        <input type="hidden" name="id_pelanggan" value="<?= isset($_SESSION['id_pelanggan']) ? $_SESSION['id_pelanggan'] : '' ?>">
                        <div class="mb-3 col-3">
                            <input type="number" class="form-control" id="jumlah" name="jumlah" oninput="validasiInput(this)" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-success" name="simpan">Add To Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script type="text/javascript">
function checkLoginStatus() {
    var isLoggedIn = <?php echo isset($_SESSION['id_pelanggan']) ? 'true' : 'false'; ?>;
    var isLoggedAdmin = <?php echo isset($_SESSION['id_admin']) ? 'true' : 'false'; ?>;

    if (isLoggedAdmin){
        alert('Anda admin tidak dapat melakukan pembelian.');
        return false;

    } else if (!isLoggedIn) {
        alert('Anda harus login untuk melakukan pembelian.');
        return false;
    }

    return true;
}

function validasiInput(input) {
    input.value = input.value.replace(/[^0-9]/g, '');

    if (input.value === '' || input.value === '0') {
        input.setCustomValidity('Masukkan angka yang valid dan bukan 0.');
    } else {
        input.setCustomValidity('');
    }
}

$('#jumlah').on('change', function () {
    const harga = $('#harga').val();
    const banyak = $('#jumlah').val();

    const total4 = banyak * harga;

    $('#total').val(`${total4}`);
})
</script>

<?php include 'partials/footer.php'; ?>
