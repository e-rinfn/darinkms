<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'user') {
    header("Location: ../../login.php");
    exit;
}

require '../../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $caption_pelatihan = $_POST['caption_pelatihan'];
    $akses_publik = isset($_POST['akses_publik']) ? 1 : 0;

    $target_dir = "../../uploads/";
    $update_video = "";
    $video_pelatihan = $_POST['video_pelatihan_lama']; // Menggunakan video lama sebagai default jika tidak ada video baru

    // Proses upload video pelatihan baru jika ada
    if (isset($_FILES['video_pelatihan']) && $_FILES['video_pelatihan']['name']) {
        // Hapus video lama jika ada dan mengganti dengan video baru
        $video_pelatihan_lama = $_POST['video_pelatihan_lama'];
        if (!empty($video_pelatihan_lama) && file_exists($target_dir . $video_pelatihan_lama)) {
            unlink($target_dir . $video_pelatihan_lama); // Hapus video lama
        }

        // Proses upload video baru
        $video_pelatihan = $_FILES['video_pelatihan']['name'];
        $target_file_video = $target_dir . basename($video_pelatihan);
        if (move_uploaded_file($_FILES['video_pelatihan']['tmp_name'], $target_file_video)) {
            $update_video = ", video_pelatihan='$video_pelatihan'";
        } else {
            echo "Gagal mengunggah video pelatihan.";
        }
    }

    // Query update ke database
    $sql = "UPDATE pelatihan 
            SET judul='$judul', 
                caption_pelatihan='$caption_pelatihan', 
                akses_publik='$akses_publik', 
                updated_at=NOW() 
                $update_video 
            WHERE id=$id";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        header("Location: pelatihan.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Mengambil data pelatihan berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM pelatihan WHERE id=$id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}
?>