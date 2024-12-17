<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

require '../../db.php'; // file untuk koneksi ke database

// Proses tambah pengetahuan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $judul = $_POST['judul'];
    $caption_pengetahuan = $_POST['caption_pengetahuan'];
    $akses_publik = isset($_POST['akses_publik']) ? 1 : 0;

    // Proses upload file PDF
    $file_pdf_pengetahuan = '';
    if (isset($_FILES['file_pdf_pengetahuan']) && $_FILES['file_pdf_pengetahuan']['error'] == 0) {
        $file_pdf_pengetahuan = $_FILES['file_pdf_pengetahuan']['name'];
        $target_dir = "../../uploads/";
        $target_file_pdf = $target_dir . basename($file_pdf_pengetahuan);

        // Upload file PDF
        if (!move_uploaded_file($_FILES['file_pdf_pengetahuan']['tmp_name'], $target_file_pdf)) {
            echo "Error: File PDF tidak dapat diupload.";
            exit;
        }
    }

    // Proses upload thumbnail
    $thumbnail_pengetahuan = '';
    if (isset($_FILES['thumbnail_pengetahuan']) && $_FILES['thumbnail_pengetahuan']['error'] == 0) {
        $thumbnail_pengetahuan = $_FILES['thumbnail_pengetahuan']['name'];
        $target_file_thumbnail = $target_dir . basename($thumbnail_pengetahuan);
        
        // Upload thumbnail
        move_uploaded_file($_FILES['thumbnail_pengetahuan']['tmp_name'], $target_file_thumbnail);
    }

    // Insert data ke database
    $sql = "INSERT INTO pengetahuan (judul, file_pdf_pengetahuan, caption_pengetahuan, akses_publik, thumbnail_pengetahuan, user_id) 
            VALUES ('$judul', '$file_pdf_pengetahuan', '$caption_pengetahuan', '$akses_publik', '$thumbnail_pengetahuan', {$_SESSION['user_id']})";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: pengetahuan.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>