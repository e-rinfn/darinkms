<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

require '../../db.php'; // file untuk koneksi ke database


// Query untuk mengambil data pelatihan
$query_data_pelatihan = "SELECT * FROM pelatihan ORDER BY created_at DESC";
$result_data_pelatihan = $conn->query($query_data_pelatihan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pelatihan</title>
    <link rel="icon" href="../../image/favicon.png" type="image/png">

    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Link Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <!-- Style sidebar -->
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #575d63;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-bottom: 20px; /* Tambahkan jarak antara logo dan konten berikutnya */
        }

        .logo {
            max-width: 100%; /* Pastikan gambar responsif */
            height: auto;
        }
    </style>


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- <h3 class="text-white text-center">ADMIN</h3> -->
        <!-- Logo -->
        <div class="logo-container">
            <img src="../../image/logo.png" width="200" alt="Logo" class="logo">
        </div>
        <hr>
        <a href="../dashboard.php"  ><i class="bi bi-house-fill"></i> - Beranda</a>
        <a href="../pengetahuan/pengetahuan.php" ><i class="bi bi-lightbulb-fill"></i> - Pengetahuan</a>
        <a href="#" class="bg-light text-dark"><i class="bi bi-journals"></i> - Pelatihan</a>
        <a href="../user/user.php"><i class="bi bi-people-fill"></i> - User</a>
    </div>


    <!-- Style content -->
    <style>
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>

    <!-- Content Section -->
    <div class="content" style="background-color: #D9D9D9">

        <!-- Navbar start -->
        <nav class="navbar navbar-expand navbar-light" style="background: #EC1928">
        <!-- Toggler untuk mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="container-fluid">
                <div class="d-flex w-100">
                    <!-- Search Bar (di tengah) -->
                    <div class="col-7 mx-auto d-flex justify-content-center">
                        <form class="d-flex w-75">
                            <input class="form-control form-control-sm" type="search" placeholder="Cari..." aria-label="Search" id="searchInput">
                        </form>
                    </div>
                    
                    <!-- Dropdown menu di sebelah kanan -->
                    <div class="col-2 text-end">
                        <ul class="navbar-nav ">
                            <li class="nav-item dropdown">
                                <a class="text-light nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    ADMINISTRATOR
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalAkun">Akun</a></li>
                                    <li><a class="dropdown-item" href="../../logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <!-- Modal untuk melihat dan mengubah data user -->
                    <div class="modal fade" id="modalAkun" tabindex="-1" aria-labelledby="modalAkunLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="update_akun.php" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalAkunLabel">Ubah Akun</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Ambil data pengguna yang sedang login -->
                                        <?php
                                        $user_id = $_SESSION['user_id'];  // Sesuaikan dengan session yang Anda gunakan
                                        // Query untuk mengambil data pengguna dari database
                                        $query = "SELECT * FROM user WHERE id = '$user_id'";
                                        $result = mysqli_query($conn, $query);
                                        $user = mysqli_fetch_assoc($result);
                                        ?>

                                        <!-- Input untuk Username -->
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                        </div>

                                        <!-- Input untuk Nama -->
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
                                        </div>

                                        <!-- Input untuk Email -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                        </div>

                                        <!-- Menampilkan Level sebagai Read-Only -->
                                        <div class="mb-3">
                                            <label for="level" class="form-label">Level</label>
                                            <input type="text" class="form-control" id="level" name="level" value="<?php echo htmlspecialchars($user['level']); ?>" readonly>
                                        </div>

                                        <!-- Input untuk Password -->
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
        <!-- Navbar end -->


        <style>
            .card {
                display: flex;
                flex-direction: column;
                height: 100%;
            }
            .card-body {
                flex-grow: 1;
            }
            .card-img-top {
                object-fit: contain;
                height: 200px; /* Sesuaikan tinggi thumbnail */
            }    
            
            /* Flexbox untuk memastikan card berada di tengah */
            .row {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;  /* Center horizontally */
                align-items: flex-start;      /* Start vertically */
            }
            
            .pelatihan-card {
                display: block;   /* Pastikan card tampil sebagai block */
                margin-bottom: 15px; /* Spasi antar card */
            }
        </style>

        <!-- Konten Utama -->
        <div class="container mt-3 bg-light rounded">
            <div class="row text-light align-items-center p-3 shadow-sm" style="background: #ED9455">
                <!-- Heading -->
                <div class="col-md-8">
                    <h3 class="mb-0">Pusat Pelatihan</h3>
                </div>
                <!-- Tombol Tambah Pelatihan -->
                <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                    <button class="btn btn-light text-dark" data-bs-toggle="modal" data-bs-target="#modalTambahPelatihan">
                    <b><i class="bi bi-plus"></i>Tambah Pelatihan</b>
                    </button>
                </div>
            </div>


        <!-- Modal Tambah Pelatihan start -->
        <div class="modal fade" id="modalTambahPelatihan" tabindex="-1" aria-labelledby="modalTambahPelatihanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="proses_tambah_pelatihan.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahPelatihanLabel">Tambah Pelatihan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                            <div class="mb-3">
                                <label for="caption_pelatihan" class="form-label">Caption</label>
                                <textarea class="form-control" id="caption_pelatihan" name="caption_pelatihan" rows="3" required></textarea>
                            </div>
                            <!-- <div class="mb-3">
                                <label for="thumbnail_pelatihan" class="form-label">Thumbnail</label>
                                <input type="file" class="form-control" id="thumbnail_pelatihan" name="thumbnail_pelatihan">
                            </div> -->
                            <div class="mb-3">
                                <label for="video_pelatihan" class="form-label">Video Pelatihan</label>
                                <input type="file" class="form-control" id="video_pelatihan" name="video_pelatihan" accept="video/*">
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="akses_publik" name="akses_publik">
                                <label class="form-check-label" for="akses_publik">Akses Publik</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Pelatihan end -->

        <br>   

        <!-- Daftar pelatihan start-->
        <div class="row">
            <?php while ($row = $result_data_pelatihan->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card pelatihan-card">

                <!-- Menampilkan Video sebagai Thumbnail -->
                <?php if (!empty($row['video_pelatihan'])): ?>
                    <div class="video-thumbnail-container" style="position: relative;">
                        <!-- Video Player -->
                        <video width="100%" height="200" 
                            muted 
                            autoplay 
                            loop 
                            playsinline 
                            poster="../../uploads/<?php echo htmlspecialchars($row['thumbnail_video']); ?>" 
                            style="object-fit: cover; background-color: #000;">
                            <source src="../../uploads/<?php echo htmlspecialchars($row['video_pelatihan']); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>

                        
                        <!-- Overlay untuk Play Icon yang membuka halaman baru -->
                        <a href="../../uploads/<?php echo htmlspecialchars($row['video_pelatihan']); ?>" target="_blank" style="
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                            color: white;
                            font-size: 2.5rem;
                            pointer-events: auto;">
                            <i class="bi bi-play-circle-fill"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Jika video tidak tersedia, tampilkan placeholder -->
                    <img src="../../image/default-thumbnail.png" alt="Thumbnail Tidak Tersedia" class="img-fluid" style="width: 100%; height: 200px; object-fit: cover;">
                <?php endif; ?>


                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['judul']); ?></h5>
                            <p class="card-text">
                                <?php 
                                $max_length = 100; // Batas karakter
                                $caption = htmlspecialchars($row['caption_pelatihan']);
                                echo strlen($caption) > $max_length ? substr($caption, 0, $max_length) . '...' : $caption;
                                ?>
                            </p>
                            <p><strong>Akses Publik:</strong> <?php echo $row['akses_publik'] ? 'Ya' : 'Tidak'; ?></p>
                            <a href="#" class="btn btn-warning" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalEditPelatihan" 
                                data-id="<?php echo $row['id']; ?>" 
                                data-judul="<?php echo htmlspecialchars($row['judul']); ?>" 
                                data-caption="<?php echo htmlspecialchars($row['caption_pelatihan']); ?>" 
                                data-akses="<?php echo $row['akses_publik']; ?>">
                                Edit
                            </a>  

                            <!-- Tombol Hapus -->
                            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusPelatihanModal" data-id="<?php echo $row['id']; ?>">Hapus</a>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Edit Pelatihan -->
                <div class="modal fade" id="modalEditPelatihan" tabindex="-1" aria-labelledby="modalEditPelatihanLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="proses_edit_pelatihan.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditPelatihanLabel">Edit Pelatihan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                    <!-- Judul Pelatihan -->
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Pelatihan:</label>
                                        <input type="text" id="judul" name="judul" class="form-control" value="<?php echo htmlspecialchars($row['judul']); ?>" required>
                                    </div>

                                    <!-- Caption Pelatihan -->
                                    <div class="mb-3">
                                        <label for="caption_pelatihan" class="form-label">Caption Pelatihan:</label>
                                        <textarea id="caption_pelatihan" name="caption_pelatihan" class="form-control" required><?php echo htmlspecialchars($row['caption_pelatihan']); ?></textarea>
                                    </div>

                                    <!-- Akses Publik -->
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" id="akses_publik" name="akses_publik" class="form-check-input" <?php echo $row['akses_publik'] == 1 ? 'checked' : ''; ?>>
                                        <label for="akses_publik" class="form-check-label">Akses Publik</label>
                                    </div>

                                    <!-- Video Pelatihan -->
                                    <div class="mb-3">
                                        <label for="video_pelatihan" class="form-label">Video Pelatihan:</label>
                                        <input type="file" id="video_pelatihan" name="video_pelatihan" class="form-control">
                                        <small class="form-text text-muted">Video saat ini: <?php echo htmlspecialchars($row['video_pelatihan']); ?></small>
                                    </div>

                                    <!-- Input untuk menyimpan video lama -->
                                    <input type="hidden" name="video_pelatihan_lama" value="<?php echo htmlspecialchars($row['video_pelatihan']); ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        </div>
    </div>


    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="hapusPelatihanModal" tabindex="-1" aria-labelledby="hapusPelatihanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusPelatihanModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="confirmDelete" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Menangkap ID dan Edit Pelatihan 
        document.addEventListener('DOMContentLoaded', function () {

            // Tangkap semua tombol Edit
            const editButtons = document.querySelectorAll('a[data-bs-toggle="modal"][data-bs-target="#modalEditPelatihan"]');

            editButtons.forEach(button => {
                button.addEventListener('click', function () {

                    // Ambil data dari atribut data- pada tombol
                    const id = this.getAttribute('data-id');
                    const judul = this.getAttribute('data-judul');
                    const caption = this.getAttribute('data-caption');
                    const akses = this.getAttribute('data-akses') === '1'; // Convert ke boolean
                    const thumbnailUrl = this.getAttribute('data-thumbnail');

                    // Isi data ke dalam modal
                    const modal = document.querySelector('#modalEditPelatihan');
                    modal.querySelector('input[name="id"]').value = id;
                    modal.querySelector('input[name="judul"]').value = judul;
                    modal.querySelector('textarea[name="caption_pelatihan"]').value = caption;
                    modal.querySelector('input[name="akses_publik"]').checked = akses;

                    // Perbarui thumbnail
                    const thumbnailImg = modal.querySelector('#currentThumbnail');
                    if (thumbnailImg) {
                        thumbnailImg.src = thumbnailUrl;
                    }
                });
            });
        });
    </script>

    <script>
        // Menangkap ID dan menambahkan ke tombol Hapus
        var deleteLinks = document.querySelectorAll('.btn-danger[data-bs-toggle="modal"]');
        deleteLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                var deleteUrl = 'hapus_pelatihan.php?id=' + id;
                document.getElementById('confirmDelete').setAttribute('href', deleteUrl);
            });
        });
    </script>

    <script>
        // Funsi mencari pelatihan    
        document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const pelatihanCards = document.querySelectorAll('.pelatihan-card'); // Pastikan setiap card pelatihan diberi kelas "pelatihan-card"

            searchInput.addEventListener('input', function() {
                const query = searchInput.value.toLowerCase(); // Ambil nilai pencarian dan ubah ke lowercase untuk pencocokan yang lebih fleksibel

                // Loop melalui setiap card pelatihan
                pelatihanCards.forEach(function(card) {
                    const title = card.querySelector('.card-title').textContent.toLowerCase(); // Ambil teks judul
                    const caption = card.querySelector('.card-text').textContent.toLowerCase(); // Ambil teks caption

                    // Jika query ditemukan di judul atau caption, tampilkan card, jika tidak sembunyikan
                    if (title.includes(query) || caption.includes(query)) {
                        card.style.display = 'block'; // Tampilkan card
                    } else {
                        card.style.display = 'none'; // Sembunyikan card
                    }
                });

                // Setelah pencarian dilakukan, atur kembali posisi card agar tetap berada di tengah
                const visibleCards = document.querySelectorAll('.pelatihan-card:not([style*="display: none"])');
                if (visibleCards.length === 0) {
                    document.querySelector('.row').style.justifyContent = 'center';  // Jika tidak ada yang ditemukan, tetap di tengah
                }
            });
        });
    </script>
</body>
</html>
