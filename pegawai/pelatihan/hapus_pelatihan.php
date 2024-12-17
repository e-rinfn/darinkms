<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

require '../../db.php';

$id = $_GET['id'];

$sql = "DELETE FROM pelatihan WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: pelatihan.php");
    exit;
} else {
    echo "Error: " . $conn->error;
}
?>
