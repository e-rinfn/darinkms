<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input user dengan filter
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi input
    if (empty($username) || empty($password)) {
        $error = "Username dan password wajib diisi!";
    } else {
        // Cek user di database
        $query = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $query->bind_param("s", $username);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['level'] = $user['level'];

                // Redirect berdasarkan level
                if ($user['level'] === 'admin') {
                    header("Location: admin/dashboard.php");
                } elseif ($user['level'] === 'user') {
                    header("Location: pegawai/dashboard.php");
                } else {
                    $error = "Level pengguna tidak valid!";
                }
                exit;
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
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
                        <a class="nav-link" href="pelatihan.php">PELATIHAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="hubungiKami.php">HUBUNGI KAMI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php">MASUK <i class="bi bi-box-arrow-in-right" style="color:white; padding-right: 4px;"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Jarak antara konten dan top-->
    <br><br><br><br>
    
    <section class="py-2">
    <style>
        /* CSS for the container */
        .container {
            display: flex;
            align-items: center;
            gap: 20px; /* Jarak antara gambar dan form */
        }

        /* Style for the image */
        .login-image img {
            max-width: 100%; /* Agar gambar responsif */
            width: 500px; /* Ukuran gambar tetap */
            height: auto;
            border-radius: 10px; /* Opsional: Tambahkan sudut melengkung */
        }

        /* Style for the form */
        .login-form {
            max-width: 400px;
            width: 100%;
            text-align: left;
        }

        /* Style for labels and inputs */
        .login-form label {
            display: block;
            margin-bottom: 10px;
        }

        .login-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Style for the button */
        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #0056b3;
        }

    </style>
    <div class="container d-flex align-items-center justify-content-between">
        <!-- Gambar di sebelah kiri -->
        <div class="login-image">
            <img src="image/login.jpg" alt="Login Image" width="500px" class="img-fluid">
        </div>

        <!-- Form Login di sebelah kanan -->
        <div class="login-form">
            <h1 class="mb-5 " >LOGIN</h1>
            <?php if (isset($error)): ?>
                <p style="color:red;"><?= $error; ?></p>
            <?php endif; ?>
            <form method="POST">
                <label><input type="text" name="username" placeholder="Username" required></label><br>
                <label><input type="password" name="password" placeholder="Password" required></label><br>
                <p><a href="pengajuan.php">Belum memiliki akun?</a></p>

                <button type="submit" class="w-50 rounded-pill" style="background-color: #EC1928">Login</button>
            </form>
        </div>
    </div>
</section>


</body>
<footer class="text-dark  mt-auto">
    <div class="container d-flex justify-content-center">
        <!-- Bagian Hak Cipta -->
        <div class="text-center mt-4">
            <p>© 2024 All Rights Reserved. Rin Design by UKPBJ Kota Tasikmalaya.</p>
        </div>
    </div>
</footer>
</html>
