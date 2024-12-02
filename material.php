<?php include 'partials/header.php'; ?>

<section class="container mt-5">
    <h2 class="mb-4">Daftar Material Bangunan</h2>
    <div class="row">
        <?php
        $limit = 10; // Jumlah item per halaman

        // Mendapatkan halaman saat ini dari URL, default ke halaman 1
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($page - 1) * $limit;

        $tampil = mysqli_query($koneksi, "SELECT * FROM data_material LIMIT $start, $limit");
        while ($data = mysqli_fetch_array($tampil)) :
        ?>
            <div class="col-md-12 col-lg-3">
                <div class="card mb-4">
                    <img style="height: 200px; object-fit: cover;" src="<?= $data['gambar_material']; ?>" class="card-img-top" alt="Material">
                    <div class="card-body">
                        <h3 class="card-title"><?= $data['nama_material'] ?></h3>
                        <h5><?= "Rp " . number_format($data['harga_material'], 0, ',', '.') ?></h5>
                        <a class="btn btn-outline-primary rounded-pill" href="detail_material.php?hal=detail&id=<?= $data['id_material'] ?>">Detail</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php
    // Menghitung total halaman
    $result = mysqli_query($koneksi, "SELECT COUNT(id_material) as total FROM data_material");
    $row = mysqli_fetch_assoc($result);
    $total_pages = ceil($row['total'] / $limit);
    ?>

    <!-- Link Pagination menggunakan struktur Bootstrap -->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php
            // Link Halaman Sebelumnya
            echo "<li class='page-item " . ($page == 1 ? 'disabled' : '') . "'><a class='page-link' href='?page=" . ($page - 1) . "'>Previous</a></li>";

            // Link Halaman
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
            }

            // Link Halaman Berikutnya
            echo "<li class='page-item " . ($page == $total_pages ? 'disabled' : '') . "'><a class='page-link' href='?page=" . ($page + 1) . "'>Next</a></li>";
            ?>
        </ul>
    </nav>
</section>

<?php include 'partials/footer.php'; ?>



