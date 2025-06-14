<?php
// Koneksi ke database
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $unit_kerja = $_POST['unit_kerja'];
    $file_pengajuan = $_FILES['file_pengajuan']['name'];

    // Cek NIK dan Email di tabel user dan pengajuan
    $cek_sql = "SELECT 'user' AS sumber FROM user WHERE nik = '$nik' OR email = '$email'
                UNION
                SELECT 'pengajuan' AS sumber FROM pengajuan WHERE nik = '$nik' OR email = '$email'";
    $result = $conn->query($cek_sql);

    if ($result->num_rows > 0) {
        // Jika ada duplikasi, tampilkan alert dan hentikan proses
        echo "<script>
            alert('NIK atau Email sudah terdaftar di sistem. Silakan gunakan data lain.');
            window.history.back();
        </script>";
        exit();
    } else {
        // Proses upload file pengajuan
        if ($file_pengajuan) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($file_pengajuan);

            if (move_uploaded_file($_FILES['file_pengajuan']['tmp_name'], $target_file)) {
                // Insert data ke tabel pengajuan
                $sql = "INSERT INTO pengajuan (nama, nik, email, password, no_hp, alamat, unit_kerja, file_pengajuan) 
                        VALUES ('$nama', '$nik', '$email', '$password', '$no_hp', '$alamat', '$unit_kerja', '$file_pengajuan')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>
                        alert('Pengajuan berhasil dikirim. Menunggu persetujuan admin.');
                        window.location.href = 'login.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Gagal menyimpan data. Kesalahan: {$conn->error}');
                        window.history.back();
                    </script>";
                }
            } else {
                echo "<script>
                    alert('Gagal mengunggah file. Pastikan file valid dan coba lagi.');
                    window.history.back();
                </script>";
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan</title>
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
            background-color: #EC1928;
            color: white !important;
            border-radius: 25px;
            padding: 8px 16px;
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            background-color: white;
        }

        .navbar-nav .nav-link {
            font-size: 1rem;
            font-weight: bold;
            margin-right: 15px;
        }

        .nav-link:hover {
            color: #EC1928;
        }

        .form-section {
            margin-top: 5rem; /* Memberikan jarak dari navbar */
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

<br><br>

    <!-- Form Pengajuan -->
    <div class="container form-section">
        <h1 class="text-center mb-2">Formulir Pengajuan Akun</h1>
        <br>
            <form action="pengajuan.php" method="POST" enctype="multipart/form-data">
                <div class="w-50">
                    <div class="d-flex justify-content-between">
                        <div class="mb-3" style="flex: 1; margin-right: 1rem;">
                            <input type="text" class="form-control border-danger" id="nama" name="nama" placeholder="Nama" required onkeypress='return harusHuruf(event)' style="width: 100%;">
                        </div>

                        <div class="mb-3" style="flex: 1;">
                            <input type="text" class="form-control border-danger" id="no_hp" name="no_hp" placeholder="Nomor HP" required onkeypress='return hanyaAngka(event)' style="width: 100%;">
                        </div>
                    </div>


                    <div class="mb-3">
                        <input type="email" class="form-control border-danger" id="email" name="email" placeholder="Email"  required>
                    </div>

                    <div class="mb-3">
                        <input type="password" class="form-control border-danger" id="password" name="password" placeholder="Kata Sandi" required>
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control border-danger" id="nik" name="nik" placeholder="NIK">
                    </div>

                    <div class="mb-3">
                        <textarea class="form-control border-danger" id="alamat" name="alamat" rows="3" placeholder="Alamat" required></textarea>
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control border-danger" id="unit_kerja" name="unit_kerja" placeholder="Unit Kerja" required>
                    </div>

                    <div class="mb-3">

                        <label for="file_pengajuan" class="form-label" style="margin-left: 1rem">Unggah surat permohonan akun</label>
                        <input type="file" class="form-control border-danger" id="file_pengajuan" name="file_pengajuan" required>
                    </div>

                    <div class="d-flex">
                        <button type="submit" style="margin-right: 1rem; background-color:#EC1928; color: white" class="btn btn-sm ">Kirim Pengajuan</button>
                        <a href="login.php" class="btn btn-sm" style="background-color:#EC1928; color: white">Kembali</a>
                    </div>
                </div>
            </form>
    </div>
</body>
</html>
<script>

function harusHuruf(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode < 65 || charCode > 90)&&(charCode < 97 || charCode > 122)&&charCode>32)
            return false;
        return true;
}

function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}
</script>