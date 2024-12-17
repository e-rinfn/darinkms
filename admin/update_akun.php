<?php
session_start();
include('../db.php');  // Include koneksi database

$user_id = $_SESSION['user_id'];  // Ambil ID pengguna yang sedang login

// Ambil data dari form
$username = mysqli_real_escape_string($conn, $_POST['username']);
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$level = mysqli_real_escape_string($conn, $_POST['level']);
$password = $_POST['password'];

// Jika password diubah, hash passwordnya
if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE user SET username = '$username', nama = '$nama', email = '$email', level = '$level', password = '$hashed_password' WHERE id = '$user_id'";
} else {
    // Jika password tidak diubah, cukup update data lainnya
    $query = "UPDATE user SET username = '$username', nama = '$nama', email = '$email', level = '$level' WHERE id = '$user_id'";
}

// Eksekusi query untuk update data pengguna
if (mysqli_query($conn, $query)) {
    echo "Akun berhasil diperbarui!";
    // Redirect setelah berhasil update
    header("Location: dashboard.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
?>
