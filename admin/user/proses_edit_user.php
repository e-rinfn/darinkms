<?php
// Pastikan session sudah dimulai
session_start();

// Koneksi ke database
include('../../db.php'); // Sesuaikan dengan file koneksi Anda

// Cek apakah user sudah login dan memiliki ID
if (!isset($_SESSION['user_id'])) {
    // Redirect ke halaman login jika belum login
    header("Location: login.php");
    exit;
}

// Ambil data dari form modal
$id = $_POST['id']; // ID pengguna yang akan diperbarui
$username = $_POST['username']; // Username baru
$nama = $_POST['nama']; // Nama baru
$email = $_POST['email']; // Email baru
$level = $_POST['level']; // Level baru
$password = $_POST['password']; // Password baru (opsional)

// Cek apakah password diubah
if (!empty($password)) {
    // Jika password diubah, hash password baru
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE user SET username = ?, nama = ?, email = ?, level = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $username, $nama, $email, $level, $passwordHash, $id);
} else {
    // Jika password tidak diubah, jangan update password
    $query = "UPDATE user SET username = ?, nama = ?, email = ?, level = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $username, $nama, $email, $level, $id);
}

// Eksekusi query
if ($stmt->execute()) {
    // Jika berhasil, redirect ke halaman daftar pengguna atau halaman yang diinginkan
    header("Location: user.php?message=success");
} else {
    // Jika gagal, beri pesan error
    header("Location: user.php?message=error");
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>
