<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

require '../../db.php';

// Ambil daftar pengguna dari database
$sql_user = "SELECT * FROM user";
$result_user = $conn->query($sql_user);


// Ambil daftar pengajuan dari database
$sql_pengajuan = "SELECT * FROM pengajuan";
$result_pengajuan = $conn->query($sql_pengajuan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin User</title>
    <link rel="icon" href="../../image/favicon.png" type="image/png">

    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Link Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>
<!-- Style Sidebar -->
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
    <div class="logo-container">
        <img src="../../image/logo.png" width="200" alt="Logo" class="logo">
    </div>
    <hr>
    <a href="../dashboard.php"  ><i class="bi bi-house-fill"></i> - Beranda</a>
    <a href="../pengetahuan/pengetahuan.php"><i class="bi bi-lightbulb-fill"></i> - Pengetahuan</a>
    <a href="../pelatihan/pelatihan.php"><i class="bi bi-journals"></i> - Pelatihan</a>
    <a href="../user/user.php"  class="bg-light text-dark"><i class="bi bi-people-fill"></i> - User</a>
</div>

<!-- Style Content -->
<style>
    .content {
        margin-left: 250px;
        padding: 20px;
    }
</style>

<!-- Konten Utama -->
<div class="content" style="background-color: #D9D9D9;">
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

<!-- Daftar Pengguna -->
<div class="container mt-4" style="background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0,0,0,0.1);">
    <!-- Header -->
    <div class="row align-items-center p-3 mb-4">
        <div class="col-md-8">
            <h3 class="mb-0">Daftar Pengguna</h3>
        </div>
        <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
            <button class="btn fw-bold text-light" style="background-color: #ED9455" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
                <i class="bi bi-plus"></i> Tambah User
            </button>
        </div>
    </div>

    <!-- Tabel Daftar Pengguna -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_user->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['level']); ?></td>
                        <td>
                            <!-- Tombol Edit -->
                            <button 
                                type="button" 
                                class="btn btn-sm btn-primary me-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editUserModal"
                                data-id="<?php echo $row['id']; ?>"
                                data-username="<?php echo htmlspecialchars($row['username']); ?>"
                                data-nama="<?php echo htmlspecialchars($row['nama']); ?>"
                                data-email="<?php echo htmlspecialchars($row['email']); ?>"
                                data-level="<?php echo htmlspecialchars($row['level']); ?>"
                            >
                                Edit
                            </button>
                            <!-- Tombol Hapus -->
                            <a href="hapus_user.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit Pengguna -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="proses_edit_user.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Input untuk ID (hidden) -->
                    <input type="hidden" id="edit-id" name="id">

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="edit-username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit-username" name="username" required>
                    </div>

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="edit-nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit-nama" name="nama" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="edit-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit-email" name="email" required>
                    </div>

                    <!-- Level -->
                    <div class="mb-3">
                        <label for="edit-level" class="form-label">Level</label>
                        <select class="form-select" id="edit-level" name="level" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
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

<!-- Script untuk mengisi data modal saat tombol Edit diklik -->
<script>
    // Ketika modal Edit dibuka
    var editUserModal = document.getElementById('editUserModal');
    editUserModal.addEventListener('show.bs.modal', function (event) {
        // Mendapatkan data dari tombol Edit yang diklik
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-id');
        var username = button.getAttribute('data-username');
        var nama = button.getAttribute('data-nama');
        var email = button.getAttribute('data-email');
        var level = button.getAttribute('data-level');

        // Mengisi form modal dengan data yang didapat
        var modalId = editUserModal.querySelector('#edit-id');
        var modalUsername = editUserModal.querySelector('#edit-username');
        var modalNama = editUserModal.querySelector('#edit-nama');
        var modalEmail = editUserModal.querySelector('#edit-email');
        var modalLevel = editUserModal.querySelector('#edit-level');

        modalId.value = userId;
        modalUsername.value = username;
        modalNama.value = nama;
        modalEmail.value = email;
        modalLevel.value = level;
    });
</script>


    <!-- Daftar Pengajuan -->
    <div class="container mt-4" style="background-color: white; padding: 20px;">
            <h1 class="mb-4">Daftar Pengajuan</h1>
            
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>E-Mail</th>
                    <th>Unit Kerja</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result_pengajuan->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['nik']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['unit_kerja']); ?></td>
                    <td>
                        <a href="../../uploads/<?php echo htmlspecialchars($row['file_pengajuan']); ?>" target="_blank" class="btn btn-info btn-sm">
                            Lihat File
                        </a>
                    </td>
                    <td>
                        <a href="setujui_pengajuan.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Setujui</a>
                        <a href="tolak_pengajuan.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Tolak</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal untuk tambah pengguna -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="tambah_user.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="level" class="form-label">Level</label>
                    <select class="form-select" id="level" name="level" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
            </form>
            </div>
        </div>
    </div>
</div>

</body>

</html>
