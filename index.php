<?php

require 'db.php';  // Koneksi ke database

// Query untuk mengambil data pengetahuan
$query_data_pengetahuan = "SELECT * FROM pengetahuan WHERE akses_publik = 1 ORDER BY created_at DESC";
$result_data_pengetahuan = $conn->query($query_data_pengetahuan);

// Query untuk mengambil data pelatihan
$query_data_pelatihan = "SELECT * FROM pelatihan WHERE akses_publik = 1 ORDER BY created_at DESC";
$result_data_pelatihan = $conn->query($query_data_pelatihan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link rel="icon" href="image/favicon.png" type="image/png">

    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Link Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Link Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
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

        .custom-spacing {
            margin-top: 20px;
        }

    </style>
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
                        <a class="nav-link active" href="#">BERANDA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pusatPengetahuan.php">PUSAT PENGETAHUAN</a>
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
        
    <!-- Carousel Style -->
    <style>
        #customCarousel {
            border-radius: 20px; /* Efek melengkung pada seluruh carousel */
            overflow: hidden; /* Menghindari konten keluar dari area carousel */
            background-color: #f8f9fa; /* Warna background carousel */
        }
        .carousel-item {
            border-radius: 20px; /* Efek melengkung pada setiap item */
            padding: 10px;
        }
        .carousel-control-prev,
        .carousel-control-next {
            width: 5%; /* Mengurangi lebar kontrol */
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5); /* Membuat ikon kontrol lebih terlihat */
            border-radius: 50%;
            padding: 5px;
        }
        .carousel-image {
            width: 100%; /* Menyesuaikan lebar dengan elemen kontainer */
            height: 60vh; /* Tinggi gambar 50% dari tinggi viewport */            
            object-fit: contain; /* Menjaga rasio aspek gambar dan menyesuaikan gambar dalam batasan kontainer */
        }
    </style>

    <!-- Section Carousel -->
    <section class="py-5">
        <div class="container">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <!-- Indikator -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <!-- Carousel Items -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="image/Carousel1.png" class="d-block w-100 carousel-image" alt="Slide 1">
                        <div class="carousel-caption d-none d-md-block">
                            <!-- <h5>Judul Slide 1</h5>
                            <p>Deskripsi singkat untuk slide pertama.</p> -->
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="image/Carousel2.png" class="d-block w-100 carousel-image" alt="Slide 2">
                        <div class="carousel-caption d-none d-md-block">
                            <!-- <h5>Judul Slide 2</h5>
                            <p>Deskripsi singkat untuk slide kedua.</p> -->
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="image/Carousel3.png" class="d-block w-100 carousel-image" alt="Slide 3">
                        <div class="carousel-caption d-none d-md-block">
                            <!-- <h5>Judul Slide 3</h5>
                            <p>Deskripsi singkat untuk slide ketiga.</p> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carousel Controls (Pindahkan ke bawah carousel) -->
            <div class="d-flex justify-content-center mt-4">
                <!-- Tombol Previous -->
                <button class="btn text-white rounded-pill ms-3" style="background-color: #EC1928;" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <i class="bi bi-arrow-left"></i> <!-- Ikon Kiri -->
                </button>

                <!-- Tombol Next -->
                <button class="btn text-white rounded-pill ms-3" style="background-color: #EC1928;" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <i class="bi bi-arrow-right"></i> <!-- Ikon Kanan -->
                </button>
            </div>
        </div>
    </section>

<br>


<style>
.row.flex-nowrap {
    display: flex;
    flex-wrap: nowrap; /* Mencegah baris baru */
    overflow-x: auto;  /* Mengaktifkan scroll horizontal */
    gap: 1rem;         /* Menambahkan jarak antar kartu */
}

.row.flex-nowrap::-webkit-scrollbar {
    height: 8px;        /* Mengatur ukuran scrollbar */
}

.row.flex-nowrap::-webkit-scrollbar-thumb {
    background: #999;   /* Warna scrollbar */
    border-radius: 4px; /* Membuat scrollbar lebih estetis */
}

.row.flex-nowrap::-webkit-scrollbar-track {
    background: #ddd;   /* Warna latar belakang scrollbar */
}

</style>
<!-- Section Pengetahuan Baru -->
<section class="py-5" style="background-color: #EC1928;">
    <div class="container">
        <h2 class="text-white mb-4">Pengetahuan Baru</h2>

        <!-- Daftar Pengetahuan -->
        <div class="row flex-nowrap overflow-auto" id="pengetahuanContainer">
            <?php while ($row = $result_data_pengetahuan->fetch_assoc()): ?>
                <div class="col-md-4 mb-4 pengetahuan-item">
                    <div class="card pengetahuan-card h-100 d-flex flex-column">
                        <!-- Menampilkan Thumbnail, jika ada -->
                        <?php if ($row['thumbnail_pengetahuan']): ?>
                            <img src="uploads/<?php echo htmlspecialchars($row['thumbnail_pengetahuan']); ?>" class="card-img-top" alt="Thumbnail Pengetahuan">
                        <?php else: ?>
                            <img src="image/default-thumbnail.png" class="card-img-top" alt="Default Thumbnail">
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate" title="<?php echo htmlspecialchars($row['judul']); ?>">
                                <?php 
                                $max_title_length = 30; // Batas karakter judul
                                $judul = htmlspecialchars($row['judul']);
                                echo strlen($judul) > $max_title_length ? substr($judul, 0, $max_title_length) . '...' : $judul;
                                ?>
                            </h5>
                            <p class="card-text flex-grow-1">
                                <?php 
                                $max_length = 200; // Batas karakter
                                $caption = htmlspecialchars($row['caption_pengetahuan']);
                                echo strlen($caption) > $max_length ? substr($caption, 0, $max_length) . '...' : $caption;
                                ?>
                            </p>
                            <div class="d-flex justify-content-center">
                                <p class="text-muted" style="margin-right: 1rem">
                                    <small>
                                        <i class="bi bi-calendar2-week"></i>
                                        <?php 
                                        $created_at = htmlspecialchars($row['created_at']);
                                        setlocale(LC_TIME, 'id_ID.UTF-8'); // Mengatur locale ke bahasa Indonesia
                                        echo "" . strftime('%d %B %Y', strtotime($created_at));
                                        ?>
                                    </small>
                                </p>
                                <p class="text-muted">
                                    <small>
                                        <?php 
                                        $user_id = htmlspecialchars($row['user_id']);
                                        $query_user = "SELECT nama FROM user WHERE id = ?";
                                        $stmt_user = $conn->prepare($query_user);
                                        $stmt_user->bind_param("i", $user_id);
                                        $stmt_user->execute();
                                        $result_user = $stmt_user->get_result();
                                        $user = $result_user->fetch_assoc();
                                        $posted_by = htmlspecialchars($user['nama']);
                                        echo "Post by: " . $posted_by;
                                        ?>
                                    </small>
                                </p>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="lihatPengetahuan.php?id=<?php echo $row['id']; ?>" class="btn btn-primary rounded-pill w-50" style="background-color: #EC1928">Baca</a>
                            </div>
                        </div>  
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>


<br><br><br>

<!-- Section Pelatihan -->
<style>
    .card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card img, .card video {
        max-height: 200px;
        object-fit: cover;
    }

    .row.flex-nowrap {
    display: flex;
    flex-wrap: nowrap; /* Mencegah baris baru */
    overflow-x: auto;  /* Mengaktifkan scroll horizontal */
    gap: 1rem;         /* Menambahkan jarak antar kartu */
}

.row.flex-nowrap::-webkit-scrollbar {
    height: 8px;        /* Mengatur ukuran scrollbar */
}

.row.flex-nowrap::-webkit-scrollbar-thumb {
    background: #999;   /* Warna scrollbar */
    border-radius: 4px; /* Membuat scrollbar lebih estetis */
}

.row.flex-nowrap::-webkit-scrollbar-track {
    background: #ddd;   /* Warna latar belakang scrollbar */
}
</style>

<section class="py-5" style="background-color: #341EBB;">
    <div class="container">
        <h2 class="text-white mb-4">Pelatihan Terpopuler</h2>
        <div class="row flex-nowrap overflow-auto" style="scroll-snap-type: x mandatory; padding-bottom: 20px;">
            <!-- Card 1 -->
            <?php while ($row = $result_data_pelatihan->fetch_assoc()): ?>
            <div class="col-md-4 mb-4 d-flex" style="scroll-snap-align: start; flex: 0 0 auto; width: 400px;">
                <div class="card w-100 d-flex flex-column" style="height: 100%;">
                    <?php if (!empty($row['video_pelatihan'])): ?>
                    <div class="video-thumbnail-container" style="position: relative;">
                        <!-- Video Player -->
                        <video width="100%" height="200" 
                            muted 
                            autoplay 
                            loop 
                            playsinline 
                            poster="uploads/<?php echo htmlspecialchars($row['thumbnail_video']); ?>" 
                            style="object-fit: contain; background-color: #000;">
                            <source src="uploads/<?php echo htmlspecialchars($row['video_pelatihan']); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>

                        <!-- Overlay untuk Play Icon yang membuka halaman baru -->
                        <a href="../../uploads/<?php echo htmlspecialchars($row['video_pelatihan']); ?>" target="_blank" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 2.5rem; pointer-events: auto;">
                            <i class="bi bi-play-circle-fill"></i>
                        </a>
                    </div>
                    <?php else: ?>
                    <!-- Jika video tidak tersedia, tampilkan placeholder -->
                    <img src="../../image/default-thumbnail.png" alt="Thumbnail Tidak Tersedia" class="img-fluid" style="width: 100%; height: 200px; object-fit: cover;">
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column" style="flex-grow: 1;">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['judul']); ?></h5>
                        <p class="card-text">
                            <?php 
                            $max_length = 100; // Batas karakter
                            $caption = htmlspecialchars($row['caption_pelatihan']);
                            echo strlen($caption) > $max_length ? substr($caption, 0, $max_length) . '...' : $caption;
                            ?>
                        </p>

                        <div class="d-flex justify-content-center mt-auto">
                            <p class="text-muted" style="margin-right: 1rem">
                                <small>
                                    <i class="bi bi-calendar2-week"></i>
                                    <?php 
                                    $created_at = htmlspecialchars($row['created_at']);
                                    setlocale(LC_TIME, 'id_ID.UTF-8'); // Mengatur locale ke bahasa Indonesia
                                    echo "" . strftime('%d %B %Y', strtotime($created_at));
                                    ?>
                                </small>
                            </p>
                            <p class="text-muted">
                                <small>
                                    <?php 
                                    $user_id = htmlspecialchars($row['user_id']);
                                    $query_user = "SELECT nama FROM user WHERE id = ?";
                                    $stmt_user = $conn->prepare($query_user);
                                    $stmt_user->bind_param("i", $user_id);
                                    $stmt_user->execute();
                                    $result_user = $stmt_user->get_result();
                                    $user = $result_user->fetch_assoc();
                                    $posted_by = htmlspecialchars($user['nama']);
                                    echo "Post by: " . $posted_by;
                                    ?>
                                </small>
                            </p>
                        </div>
                        <a href="lihatPelatihan.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Lihat Selengkapnya</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>


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

</body>
</html>
