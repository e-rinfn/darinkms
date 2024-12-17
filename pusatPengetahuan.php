<?php

require 'db.php';  // Koneksi ke database

// Query untuk mengambil data pengetahuan
$query_data_pengetahuan = "SELECT * FROM pengetahuan WHERE akses_publik = 1 ORDER BY created_at DESC";
$result_data_pengetahuan = $conn->query($query_data_pengetahuan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Pengetahuan</title>
    <link rel="icon" href="image/favicon.png" type="image/png">
    
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Link Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Gaya untuk item aktif di navbar */
        .navbar-nav .nav-link.active {
            background-color: #EC1928; /* Warna background untuk item aktif */
            color: white !important; /* Warna teks */
            border-radius: 25px; /* Membuat bentuk oval */
            padding: 8px 16px; /* Menambah ruang dalam */
        }

        .navbar-nav .nav-link {
            font-size: 1rem; /* Ukuran teks lebih besar */
            font-weight: bold; /* Membuat teks lebih tebal (opsional) */
            margin-right: 15px; /* Menambahkan jarak antar elemen menu */
        }

        .nav-link:hover {
            color: #EC1928; /* Warna teks saat dihover */
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%; /* Supaya navbar memanjang sesuai layar */
            z-index: 1030; /* Pastikan navbar di atas elemen lainnya */
            background-color: white; /* Berikan warna latar untuk kontras */
        }

        /* Styling tombol di bawah carousel */
        .carousel-controls {
            margin-top: 10px;
            text-align: left;
        }
        .carousel-controls .btn {
            margin: 0 5px;
        }

        /* Gaya untuk judul Tugas dan Fungsi */
        .rounded-custom {
        border-radius: 30px; /* Nilai ini bisa Anda sesuaikan untuk melengkungkan sudut lebih besar */
        }


        .custom-margin {
        margin-bottom: 30px; /* Jarak bawah antar kolom */
        }

        .bg-custom-tugas {
        background-color: #EC1928; /* Contoh warna biru muda */
        }

        .bg-custom-fungsi {
            background-color: #341EBB; /* Contoh warna kuning */
        }

        .bg-custom-regulasi {
            background-color: #EC1928; /* Contoh warna oranye */
        }

        .section-with-bg {
            background-image: url('image/bg.png'); /* Ganti dengan URL gambar Anda */
            background-color: #EC1928; /* Warna latar belakang jika gambar tidak tersedia */
            background-size: cover; /* Mengatur agar gambar mengisi seluruh area */
            background-position: center; /* Menempatkan gambar di tengah */
            background-attachment: fixed; /* Agar latar belakang tetap saat scrolling (opsional) */
            background-repeat: no-repeat; /* Mencegah pengulangan gambar */
            padding: 50px 0; /* Memberikan ruang atas dan bawah pada section */
            color: #fff; /* Warna teks agar kontras dengan latar belakang */
        }

        .video-container {
            padding: 10px;
            border-radius: 10px;
        }

        .video-list .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .video-list .card:hover {
            transform: scale(1.05);
        }

    </style>
</head>
<body>
    <!-- Navbar -->
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
                        <a class="nav-link" href="index.php">BERANDA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">PUSAT PENGETAHUAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pelatihan.php">PELATIHAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="hubungiKami.php">HUBUNGI KAMI</a>
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

    <!-- Section card pengetahuan -->
    <section class="py-5 section-with-bg">
    <div class="container">
        <div class="mb-4 d-flex justify-content-center">
            <input 
                type="text" 
                id="searchInput" 
                class="form-control w-50" 
                placeholder="Cari pengetahuan berdasarkan judul atau deskripsi..." 
                onkeyup="filterCards()">
        </div>

        <div id="cardContainer" class="card-container d-flex flex-wrap justify-content-center">
        <?php 
        // Menampilkan data pengetahuan dari database
        while ($row = $result_data_pengetahuan->fetch_assoc()): 
            $user_id = htmlspecialchars($row['user_id']);
            $query_user = "SELECT nama FROM user WHERE id = ?";
            $stmt_user = $conn->prepare($query_user);
            $stmt_user->bind_param("i", $user_id);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();
            $user = $result_user->fetch_assoc();
            $posted_by = htmlspecialchars($user['nama']);

            $created_at = htmlspecialchars($row['created_at']);
            setlocale(LC_TIME, 'id_ID.UTF-8');
            $formatted_date = strftime('%d %B %Y', strtotime($created_at));
        ?>
   
            <!-- Card 1 -->
            <div class="card m-3" style="width: 18rem;" 
                data-title="<?php echo htmlspecialchars($row['judul']); ?>" 
                data-description="<?php echo htmlspecialchars($row['caption_pengetahuan']); ?>">
                
                <!-- Menampilkan Thumbnail, jika ada -->
                <?php if ($row['thumbnail_pengetahuan']): ?>
                    <img src="uploads/<?php echo htmlspecialchars($row['thumbnail_pengetahuan']); ?>" class="card-img-top" alt="Thumbnail Pengetahuan">
                <?php else: ?>
                    <img src="image/default-thumbnail.png" class="card-img-top" alt="Default Thumbnail">
                <?php endif; ?>                    

                <div class="card-body">
                    <h5 class="card-title" title="<?php echo htmlspecialchars($row['judul']); ?>">
                        <?php 
                        $max_title_length = 30; // Batas karakter judul
                        $judul = htmlspecialchars($row['judul']);
                        echo strlen($judul) > $max_title_length ? substr($judul, 0, $max_title_length) . '...' : $judul;
                        ?>
                    </h5>
                    <p class="card-text"><?php 
                        $max_length = 200; // Batas karakter
                        $caption = htmlspecialchars($row['caption_pengetahuan']);
                        echo strlen($caption) > $max_length ? substr($caption, 0, $max_length) . '...' : $caption;
                    ?></p>
                    <p class="text-muted mb-1" style="font-size: 0.9rem;">
                        <strong>Diunggah oleh:</strong> <small><?php echo $posted_by; ?></small><br>
                        <small><i class="bi bi-calendar2-week"></i> <?php echo $formatted_date; ?></small>
                    </p>
                    <div class="d-flex justify-content-center mt-3">
                        <a href="lihatPengetahuan.php?id=<?php echo $row['id']; ?>" class="btn btn-primary rounded-pill w-50" style="background-color: #EC1928">Baca</a>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>                
        </div>
    </div>
    <div id="noResults" class="alert alert-warning text-center" style="display: none;">
        Pengetahuan tidak ditemukan. Coba kata kunci lain.
    </div>

    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .card-text {
            height: 80px; /* Batasi tinggi deskripsi */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-custom {
            background-color: #EC1928; /* Warna latar belakang tombol */
            color: white;            /* Warna teks tombol */
            border: none;            /* Hilangkan border */
            padding: 10px 20px;      /* Sesuaikan padding */
            font-size: 1rem;         /* Sesuaikan ukuran font */
            width: 200px;            /* Sesuaikan lebar tombol */
            border-radius: 30px;     /* Melengkungkan sudut tombol */
            transition: background-color 0.3s ease; /* Efek transisi saat hover */
        }

        .btn-custom:hover {
            background-color: #FFD700; /* Warna latar belakang saat tombol dihover */
        }

        #noResults {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50%; /* Atur ukuran sesuai kebutuhan */
            margin: 20px auto; /* Pusatkan secara horizontal */
            padding: 20px;
            border: 2px solid #ffc107;
            background-color: #fff3cd;
            color: #856404;
            border-radius: 10px;
            font-size: 1.2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Opsional, untuk menambahkan bayangan */
        }
    </style>

    <script>
        function filterCards() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const cards = document.querySelectorAll("#cardContainer .card");
            let found = false;

            cards.forEach(card => {
                const title = card.getAttribute("data-title").toLowerCase();
                const description = card.getAttribute("data-description").toLowerCase();

                if (title.includes(input) || description.includes(input)) {
                    card.style.display = "block";
                    found = true;
                } else {
                    card.style.display = "none";
                }
            });

            // Tampilkan atau sembunyikan pemberitahuan
            const noResults = document.getElementById("noResults");
            if (found) {
                noResults.style.display = "none";
            } else {
                noResults.style.display = "block";
            }
        }
    </script>
</section>



<br>
<br>
<br>
<br>


<!-- Footer -->
<section class="py-5" style="background-color: #EC1928;">
    <div class="container">
        <div class="row">
            <!-- Bagian Peta -->
            <div class="col-lg-7 mb-4 px-4"> <!-- Menambahkan padding kiri dan kanan -->
                <h3 class="mb-3 text-white">Alamat Kami</h3>
                <!-- Google Maps Embed -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.3358534195327!2d108.1943916757442!3d-7.316117271940007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f50d180e2f13d%3A0xa98230685291996f!2sLPSE%20Kota%20Tasikmalaya!5e0!3m2!1sid!2sid!4v1732288774068!5m2!1sid!2sid" 
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <!-- Bagian Kontak -->
            <div class="col-lg-5 mb-4 px-4 mt-4"> <!-- Menambahkan margin atas untuk memberikan jarak -->
                <h3 class="mb-3 text-white">Hubungi Kami</h3>
                <p class="text-white"><strong><i class="bi bi-geo-alt"></i> Alamat:</strong> Balai Kota Tasikmalaya</p>
                <p class="text-white"><strong><i class="bi bi-telephone"></i> Telepon:</strong> 082217754652</p>
                <p class="text-white"><strong><i class="bi bi-envelope"></i> Email:</strong> helpdesk.lpsetasikmalayakota@gmail.com</p>

                <h4 class="mt-4 text-white">Tautan Terkait</h4>
                <ul class="list-unstyled">
                    <li><a href="index.php" target="_blank" class="text-white">Beranda</a></li>
                    <li><a href="hubungiKami.php" target="_blank" class="text-white">Hubungi Kami</a></li>
                    <li><a href="login.php" target="_blank" class="text-white">Masuk</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>


</body>

<footer class="text-dark py-4">
    <div class="container">
        <!-- Bagian Hak Cipta -->
        <div class="text-center mt-4">
            <p>© 2024 All Rights Reserved. Rin Design by UKPBJ Kota Tasikmalaya.</p>
        </div>
    </div>
</footer>

</html>
