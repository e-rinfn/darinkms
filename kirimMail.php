<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $to = "hooqidz@gmail.com"; // Ganti dengan alamat email tujuan
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $fullMessage = "Nama: $name\nEmail: $email\n\nPesan:\n$message";

    if (mail($to, $subject, $fullMessage, $headers)) {
        echo "Email berhasil dikirim.";
    } else {
        echo "Gagal mengirim email.";
    }
} else {
    echo "Metode pengiriman tidak valid.";
}
