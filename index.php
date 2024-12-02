<?php include 'partials/header.php'; ?>

<div class="container-fluid p-0">
    <div class="hero bg-primary text-white text-center py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Selamat Datang di Toko Material Kami</h1>
                    <p class="lead mb-4">Temukan material bangunan berkualitas dan layanan terbaik di sini. Kami menyediakan berbagai macam kebutuhan konstruksi anda.</p>
                    <a href="material.php" class="btn btn-light btn-lg px-4 rounded-pill shadow-sm">
                        <i class="bi bi-cart-plus me-2"></i>Lihat Material Bangunan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Material Terbaru</h2>
            <p class="text-muted">Cek koleksi terbaru material berkualitas kami</p>
        </div>

        <div class="row g-4">
            <?php
            $tampil = mysqli_query($koneksi, "SELECT * FROM data_material ORDER BY id_material DESC LIMIT 3");
            while ($data = mysqli_fetch_array($tampil)) :
            ?>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <img src="<?= $data['gambar_material']; ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($data['nama_material']); ?>" 
                         style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3"><?= htmlspecialchars($data['nama_material']) ?></h5>
                        <p class="card-text text-muted"><?= htmlspecialchars($data['deskripsi_material']) ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="detail_material.php?hal=detail&id=<?= $data['id_material'] ?>" class="btn btn-outline-primary rounded-pill">Detail</a>
                            <small class="text-muted">Stok tersedia</small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
</div>

<?php include 'partials/footer.php'; ?>

<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
    }
</style>