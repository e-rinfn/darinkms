<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami</title>
    <link rel="icon" href="image/favicon.png" type="image/png">
    
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Link Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<!-- Navbar -->
<style>
        /* Gaya untuk item aktif di navbar */
        .navbar-nav .nav-link.active {
            background-color: #EC1928; /* Warna background untuk item aktif */
            color: white !important; /* Warna teks */
            border-radius: 25px; /* Membuat bentuk oval */
            padding: 8px 16px; /* Menambah ruang dalam */
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%; /* Supaya navbar memanjang sesuai layar */
            z-index: 1030; /* Pastikan navbar di atas elemen lainnya */
            background-color: white; /* Berikan warna latar untuk kontras */
        }

            .navbar-nav .nav-link {
            font-size: 1rem; /* Ukuran teks lebih besar */
            font-weight: bold; /* Membuat teks lebih tebal (opsional) */
            margin-right: 15px; /* Menambahkan jarak antar elemen menu */
        }

        .nav-link:hover {
            color: #EC1928; /* Warna teks saat dihover */
        }

    </style>
    <nav class="navbar navbar-expand navbar-light">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="image/logo.png" width="300px" alt="Logo Perusahaan">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="index.php">BERANDA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pusatPengetahuan.php">PUSAT PENGETAHUAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pelatihan.php">PELATIHAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">HUBUNGI KAMI</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" style="background-color:#341EBB" href="login.php">MASUK <i class="bi bi-box-arrow-in-right" style="color:white; padding-right: 4px;"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Jarak antara konten dan top-->
    <br><br><br><br>

    <section class="py-4">
    <div class="container">
        <div class="row">
            <!-- Bagian Form Hubungi Kami (kiri) -->
            <div class="col-lg-6 mb-4">
                <h3 class="text-center">Hubungi Kami</h3>
                <hr>
                <form action="mailto:helpdesk.lpsetasikmalayakota@gmail.com" method="post" enctype="text/plain">
                    <div class="w-100">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="mb-3" style="flex: 1; margin-right: 1rem;">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control border-danger" id="name" name="Nama" required>
                            </div>
                            <div class="mb-3" style="flex: 1;">
                                <label for="no_hp" class="form-label">Nomor HP</label>
                                <input type="text" class="form-control border-danger" id="no_hp" name="No_Hp" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control border-danger" id="email" name="Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subjek</label>
                            <input type="text" class="form-control border-danger" id="subject" name="Subjek" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control border-danger" id="message" name="Pesan" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn text-light" style="background-color:#EC1928">Kirim Pesan</button>
                    </div>
                </form>
            </div>

            <!-- Bagian Peta (kanan) -->
            <div class="col-lg-6 mb-4">
                <h3 class="text-center">Alamat Kami</h3>
                <hr>
                <!-- Google Maps Embed -->
                <iframe class="mt-3" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.3358534195327!2d108.1943916757442!3d-7.316117271940007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f50d180e2f13d%3A0xa98230685291996f!2sLPSE%20Kota%20Tasikmalaya!5e0!3m2!1sid!2sid!4v1732288774068!5m2!1sid!2sid" 
                        width="100%" height="400" style="border:1px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
