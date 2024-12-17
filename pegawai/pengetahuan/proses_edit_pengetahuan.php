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
    $caption_pengetahuan = $_POST['caption_pengetahuan'];
    $akses_publik = isset($_POST['akses_publik']) ? 1 : 0;

    $target_dir = "../../uploads/";
    $update_pdf = "";
    $update_thumbnail = "";

    // Proses upload file PDF baru jika ada
    if (isset($_FILES['file_pdf']) && $_FILES['file_pdf']['name']) {
        $file_pdf = $_FILES['file_pdf']['name'];
        $target_file_pdf = $target_dir . basename($file_pdf);
        if (move_uploaded_file($_FILES['file_pdf']['tmp_name'], $target_file_pdf)) {
            $update_pdf = ", file_pdf_pengetahuan='$file_pdf'";
        } else {
            echo "Gagal mengunggah file PDF.";
        }
    }

    // Proses upload thumbnail baru jika ada
    if (isset($_FILES['thumbnail_pengetahuan']) && $_FILES['thumbnail_pengetahuan']['name']) {
        $thumbnail_pengetahuan = $_FILES['thumbnail_pengetahuan']['name'];
        $target_file_thumbnail = $target_dir . basename($thumbnail_pengetahuan);
        if (move_uploaded_file($_FILES['thumbnail_pengetahuan']['tmp_name'], $target_file_thumbnail)) {
            $update_thumbnail = ", thumbnail_pengetahuan='$thumbnail_pengetahuan'";
        } else {
            echo "Gagal mengunggah thumbnail.";
        }
    }

    // Query update ke database
    $sql = "UPDATE pengetahuan 
            SET judul='$judul', 
                caption_pengetahuan='$caption_pengetahuan', 
                akses_publik='$akses_publik', 
                updated_at=NOW() 
                $update_pdf 
                $update_thumbnail 
            WHERE id=$id";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        header("Location: pengetahuan.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Mengambil data pengetahuan berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM pengetahuan WHERE id=$id");
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