<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require '../../db.php';

$id = $_GET['id'];

$sql = "DELETE FROM pengetahuan WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: pengetahuan.php");
    exit;
} else {
    echo "Error: " . $conn->error;
}
?>
