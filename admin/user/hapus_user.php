<?php
session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require '../../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus pengguna dari tabel user
    $sql = "DELETE FROM user WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: user.php");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "User tidak ditemukan.";
    exit;
}
?>
