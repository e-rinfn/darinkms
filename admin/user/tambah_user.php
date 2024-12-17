<?php
session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require '../../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $level = $_POST['level'];

    // Insert user baru ke tabel user
    $sql = "INSERT INTO user (username, password, level, nama, email) 
            VALUES ('$username', '$password', '$level', '$nama', '$email')";
    if ($conn->query($sql) === TRUE) {
        header("Location: user.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna Baru</title>
</head>


<body>
    <h1>Tambah Pengguna Baru</h1>
    <form action="tambah_user.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="level">Level:</label>
        <select id="level" name="level" required>
            <option value="admin">Admin</option>
            <option value="pegawai">Pegawai</option>
        </select><br><br>

        <input type="submit" value="Tambah Pengguna">
    </form>
</body>
</html>
