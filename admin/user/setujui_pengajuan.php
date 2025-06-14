<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require '../../db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM pengajuan WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row) {
    // Periksa apakah password sudah di-hash
    $password = $row['password'];
    if (!password_get_info($password)['algo']) {
        // Hash password jika belum di-hash
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Menambahkan pengguna baru ke tabel user
    $sql_insert = "INSERT INTO user (username, password, level, nama, nik, email, no_hp, alamat, unit_kerja) 
                    VALUES ('" . $row['email'] . "', '$password', 'user', '" . $row['nama'] . "', '" . $row['nik'] . "', '" . $row['email'] . "', '" . $row['no_hp'] . "', '" . $row['alamat'] . "', '" . $row['unit_kerja'] . "')";
    if ($conn->query($sql_insert) === TRUE) {
        // Menghapus pengajuan setelah disetujui
        $sql_delete = "DELETE FROM pengajuan WHERE id=$id";
        $conn->query($sql_delete);

        // Redirect ke halaman index.php
        header("Location: user.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Pengajuan tidak ditemukan.";
}
?>

