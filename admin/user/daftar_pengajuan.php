<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require '../../db.php';

$sql = "SELECT * FROM pengajuan";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengajuan</title>
</head>
<body>
    <h1>Daftar Pengajuan User Baru</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIK</th>
                <th>Email</th>
                <th>Unit Kerja</th>
                <th>File Pengajuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['nik']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['unit_kerja']); ?></td>
                    <td><a href="../uploads/<?php echo htmlspecialchars($row['file_pengajuan']); ?>" target="_blank">Lihat File</a></td>
                    <td>
                        <a href="setujui_pengajuan.php?id=<?php echo $row['id']; ?>">Setujui</a>
                        <a href="tolak_pengajuan.php?id=<?php echo $row['id']; ?>">Tolak</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
