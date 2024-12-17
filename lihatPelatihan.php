<?php
require 'db.php'; // Ganti dengan path yang benar ke file koneksi database

// Validasi ID pelatihan
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID tidak valid.";
    exit;
}

$id = (int) $_GET['id'];

// Ambil data pelatihan berdasarkan ID
$sql = "SELECT * FROM pelatihan WHERE id = $id AND akses_publik = 1"; // Tampilkan hanya pelatihan yang aksesnya publik
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "Pelatihan tidak ditemukan atau akses ditolak.";
    exit;
}

$row = $result->fetch_assoc();

// Query untuk mengambil data pelatihan
$query_data_pelatihan = "SELECT * FROM pelatihan WHERE akses_publik = 1 ORDER BY created_at DESC";
$result_data_pelatihan = $conn->query($query_data_pelatihan);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelatihan : <?php echo htmlspecialchars($row['judul']); ?></title>
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
                        <a class="nav-link" href="index.php">BERANDA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pusatPengetahuan.php">PUSAT PENGETAHUAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="pelatihan.php">PELATIHAN</a>
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
    <br><br><br>

    <div class="container d-flex flex-row mt-5">
    <!-- Kolom PDF Viewer -->
    <div class="col-8">
        <!-- Judul -->
        <h4><?php echo htmlspecialchars($row['judul']); ?></h4>
        <!-- Posted by -->
        <div>
                <p class="mb-2">
                    <?php 
                    $user_id = htmlspecialchars($row['user_id']);
                    $query_user = "SELECT nama FROM user WHERE id = ?";
                    $stmt_user = $conn->prepare($query_user);
                    $stmt_user->bind_param("i", $user_id);
                    $stmt_user->execute();
                    $result_user = $stmt_user->get_result();
                    $user = $result_user->fetch_assoc();
                    $posted_by = htmlspecialchars($user['nama']);
                    echo "Posted by: " . $posted_by;
                    ?>
                </p>
        </div>
        <!-- Video Viewer -->
        <?php if (!empty($row['video_pelatihan']) && file_exists("uploads/" . $row['video_pelatihan'])): ?>
            <div class="video-container" style="position: relative; width: 100%; height: 400px;">
                <video width="100%" height="100%" controls>
                    <source src="uploads/<?php echo htmlspecialchars($row['video_pelatihan']); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php else: ?>
            <p>Video pelatihan tidak tersedia.</p>
        <?php endif; ?>

<hr>

<div class="d-flex justify-content-between align-items-center">
    <!-- Bagian kiri: Posted by -->
    <div>
        <p class="mb-0">
            <i class="bi bi-calendar2-week"></i>
            <?php 
            $created_at = htmlspecialchars($row['created_at']);
            setlocale(LC_TIME, 'id_ID.UTF-8'); // Mengatur locale ke bahasa Indonesia
            echo "" . strftime('%d %B %Y', strtotime($created_at));
            ?>
        </p>
    </div>

    <div>
        <!-- Tombol Buka Video -->
        <a href="uploads/<?php echo htmlspecialchars($row['video_pelatihan']); ?>" target="_blank" class="btn btn-secondary me-2">Buka Video</a>

        <!-- Tombol Bagikan -->
        <button class="btn btn-primary rounded-pill" onclick="shareKnowledge()"><i class="bi bi-share"></i></button>
    </div>
</div>
<script>
    function shareKnowledge() {
        const url = window.location.href;
        const title = document.title;
        if (navigator.share) {
            navigator.share({
                title: title,
                url: url
            }).then(() => {
                console.log('Berhasil dibagikan');
            }).catch((error) => {
                console.error('Gagal membagikan', error);
            });
        } else {
            prompt('Salin URL ini untuk dibagikan:', url);
        }
    }
    </script>
        <!-- Deskripsi -->
        <p class="text-muted mt-3"> <?php echo htmlspecialchars($row['caption_pelatihan']); ?></p>
    </div>
    <!-- Kolom Daftar Pelatihan -->
    <div class="col-4 mt-5 mb-3">
        <h5 style="margin-left: 1rem;" >Daftar Pelatihan</h5>
        <div class="p-3" style="height: 800px; overflow-y: auto;">
            <div class="row flex-column" id="pelatihanContainer">
                <?php while ($row = $result_data_pelatihan->fetch_assoc()): ?>
                    <div class="col mb-4 pelatihan-item">
                        <div class="card pelatihan-card h-100 d-flex flex-column">
                            <!-- Menampilkan Video Thumbnail, jika ada -->
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
                                    $caption = htmlspecialchars($row['caption_pelatihan']);
                                    echo strlen($caption) > $max_length ? substr($caption, 0, $max_length) . '...' : $caption;
                                    ?>
                                </p>
                                <a href="lihatPelatihan.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Lihat Pengetahuan</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
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
