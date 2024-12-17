<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'user') {
    header("Location: ../../login.php");
    exit;
}

require '../../db.php';

// Proses tambah pelatihan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $judul = $_POST['judul'];
    $caption_pelatihan = $_POST['caption_pelatihan'];
    $akses_publik = isset($_POST['akses_publik']) ? 1 : 0;

    // Proses upload video pelatihan
    $video_pelatihan = '';
    if (isset($_FILES['video_pelatihan']) && $_FILES['video_pelatihan']['error'] == 0) {
        $video_pelatihan = $_FILES['video_pelatihan']['name'];
        $target_dir = "../../uploads/";
        $target_file_video = $target_dir . basename($video_pelatihan);

        // Upload video pelatihan
        if (!move_uploaded_file($_FILES['video_pelatihan']['tmp_name'], $target_file_video)) {
            echo "Error: Video pelatihan tidak dapat diupload.";
            exit;
        }
    }


    // Insert data ke database
    $sql = "INSERT INTO pelatihan (judul, video_pelatihan, caption_pelatihan, akses_publik, user_id) 
            VALUES ('$judul', '$video_pelatihan', '$caption_pelatihan', '$akses_publik', {$_SESSION['user_id']})";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: pelatihan.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
