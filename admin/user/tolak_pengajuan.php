<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require '../../db.php';

$id = $_GET['id'];
$sql = "DELETE FROM pengajuan WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Pengajuan ditolak.";
    header("Location: user.php");
    exit(); // Pastikan untuk menghentikan eksekusi skrip setelah header()
} else {
    echo "Error: " . $conn->error;
    header("Location: user.php");
    exit(); // Berikan waktu untuk pengguna membaca pesan kesalahan
}
?>
