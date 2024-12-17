<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require '../db.php';  // Koneksi ke database


// Query untuk menghitung jumlah pengetahuan
$query_pengetahuan = "SELECT COUNT(*) AS total_pengetahuan FROM pengetahuan";
$result_pengetahuan = $conn->query($query_pengetahuan);
$row_pengetahuan = $result_pengetahuan->fetch_assoc();
$total_pengetahuan = $row_pengetahuan['total_pengetahuan'];

// Query untuk menghitung jumlah pelatihan
$query_pelatihan = "SELECT COUNT(*) AS total_pelatihan FROM pelatihan";
$result_pelatihan = $conn->query($query_pelatihan);
$row_pelatihan = $result_pelatihan->fetch_assoc();
$total_pelatihan = $row_pelatihan['total_pelatihan'];

// Query untuk menghitung jumlah pelatihan
$query_user = "SELECT COUNT(*) AS total_user FROM user";
$result_user = $conn->query($query_user);
$row_user = $result_user->fetch_assoc();
$total_user = $row_user['total_user'];

// Query untuk mengambil data pengetahuan
$query_data_pengetahuan = "SELECT * FROM pengetahuan ORDER BY created_at DESC";
$result_data_pengetahuan = $conn->query($query_data_pengetahuan);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="../image/favicon.png" type="image/png">

    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Link Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   
    <!-- Link Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
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
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        
        /* Flexbox untuk memastikan card berada di tengah */
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;  /* Center horizontally */
            align-items: flex-start;      /* Start vertically */
        }
        
        .pengetahuan-card {
            display: block;   /* Pastikan card tampil sebagai block */
            margin-bottom: 15px; /* Spasi antar card */
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
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
    <div class="logo-container">
        <img src="../image/logo.png" width="200" alt="Logo" class="logo">
    </div>
    <hr>
    <a href="dashboard.php" class="bg-light text-dark"><i class="bi bi-house-fill"></i> - Beranda</a>
    <a href="pengetahuan/pengetahuan.php"><i class="bi bi-lightbulb-fill"></i> - Pengetahuan</a>
    <a href="pelatihan/pelatihan.php"><i class="bi bi-journals"></i> - Pelatihan</a>
    <a href="user/user.php"><i class="bi bi-people-fill"></i> - User</a>
</div>

<!-- Content Section -->
<div class="content" style="background-color: #D9D9D9">
    <!-- Navbar -->
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
                                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
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

    <style>
        .pengetahuan-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Opsional untuk estetika */
        }
        .pengetahuan-card img {
            object-fit: contain; /* Agar gambar tidak terdistorsi */
            height: 200px; /* Sesuaikan tinggi thumbnail */
        }
        .card-body {
            display: flex;
            flex-direction: column;
        }
        .card-text {
            flex-grow: 1; /* Membuat deskripsi fleksibel untuk mengisi ruang kosong */
        }
    </style>
    
    <div class="container mt-3 bg-light p-3 rounded">
        <h2>Selamat datang di Dashboard</h2>
<hr>
        <div class="row d-flex justify-content-center">
            <div class="col-md-3 mb-3">
                <div class="card text-white" style="background: #ED9455">
                    <div class="card-body">
                        <h5 class="text-center card-title"><i class="bi bi-people-fill"></i> - USER</h5>
                        <hr>
                        <h4 class="text-center"><?php echo $total_user; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white" style="background: #FFBB70">
                    <div class="card-body">
                        <h5 class="text-center card-title"><i class="bi bi-lightbulb-fill"></i> - PENGETAHUAN</h5>
                        <hr>
                        <h4 class="text-center"><?php echo $total_pengetahuan; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white" style="background: #ED9455">
                    <div class="card-body">
                        <h5 class="text-center card-title"><i class="bi bi-journals"></i> - PELATIHAN</h5>
                        <hr>
                        <h4 class="text-center"><?php echo $total_pelatihan; ?></h4>
                    </div>
                </div>
            </div>
        </div>
<hr>
<h3><i class="bi bi-tags-fill"></i>Daftar Pengetahuan</h3>
<br>
<!-- Daftar Pengetahuan -->
<div class="row" id="pengetahuanContainer">
    <?php while ($row = $result_data_pengetahuan->fetch_assoc()): ?>
        <div class="col-md-4 mb-4 pengetahuan-item">
            <div class="card pengetahuan-card d-flex flex-column">
                <!-- Menampilkan Thumbnail, jika ada -->
                <?php if ($row['thumbnail_pengetahuan']): ?>
                    <img src="../uploads/<?php echo htmlspecialchars($row['thumbnail_pengetahuan']); ?>" class="card-img-top" alt="Thumbnail Pengetahuan">
                <?php else: ?>
                    <img src="../image/default-thumbnail.png" class="card-img-top" alt="Default Thumbnail">
                <?php endif; ?>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['judul']); ?></h5>
                    <p class="card-text flex-grow-1">
                        <?php 
                        $max_length = 200; // Batas karakter
                        $caption = htmlspecialchars($row['caption_pengetahuan']);
                        echo strlen($caption) > $max_length ? substr($caption, 0, $max_length) . '...' : $caption;
                        ?>
                    </p>
                    <p><strong>Akses Publik:</strong> <?php echo $row['akses_publik'] ? 'Ya' : 'Tidak'; ?></p>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const pengetahuanItems = document.querySelectorAll('.pengetahuan-item'); // Elemen yang akan dicari
        const container = document.getElementById('pengetahuanContainer');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.toLowerCase().trim(); // Ambil nilai pencarian dan ubah ke lowercase

            let hasVisibleCard = false; // Flag untuk mengecek jika ada kartu yang ditampilkan

            // Loop melalui setiap item
            pengetahuanItems.forEach(function(item) {
                const title = item.querySelector('.card-title').textContent.toLowerCase(); // Judul
                const caption = item.querySelector('.card-text').textContent.toLowerCase(); // Caption

                // Periksa apakah query cocok dengan judul atau caption
                if (title.includes(query) || caption.includes(query)) {
                    item.style.display = 'block'; // Tampilkan
                    hasVisibleCard = true; // Ada kartu yang ditampilkan
                } else {
                    item.style.display = 'none'; // Sembunyikan
                }
            });

            // Jika tidak ada kartu yang cocok, tambahkan pesan "Tidak ditemukan"
            if (!hasVisibleCard) {
                if (!document.getElementById('noResultsMessage')) {
                    const noResultsMessage = document.createElement('div');
                    noResultsMessage.id = 'noResultsMessage';
                    noResultsMessage.className = 'text-center w-100';
                    noResultsMessage.textContent = 'Tidak ada hasil yang ditemukan.';
                    container.appendChild(noResultsMessage);
                }
            } else {
                const noResultsMessage = document.getElementById('noResultsMessage');
                if (noResultsMessage) {
                    noResultsMessage.remove(); // Hapus pesan jika ada hasil
                }
            }
        });
    });
</script>
</body>
</html>
