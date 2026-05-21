<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user'])){
    header("location:login.php");
    exit;
}

$query = mysqli_query($koneksi,"
SELECT pemasukan_obat.*, obat.nama_obat, pengguna.nama_pengguna
FROM pemasukan_obat
JOIN obat ON pemasukan_obat.id_obat = obat.id_obat
JOIN pengguna ON pemasukan_obat.id_pengguna = pengguna.id_pengguna
ORDER BY tanggal_masuk DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Obat Masuk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="action-bar">
        <h2>Laporan Obat Masuk</h2>

        <a href="index.php" class="btn-main">
            Kembali
        </a>
    </div>

    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Jumlah Masuk</th>
                    <th>Tanggal</th>
                    <th>Petugas</th>
                </tr>
            </thead>

            <tbody>

                <?php while($data = mysqli_fetch_assoc($query)): ?>

                <tr>

                    <td><?= $data['nama_obat']; ?></td>

                    <td><?= $data['jumlah_masuk']; ?></td>

                    <td><?= date('d M Y', strtotime($data['tanggal_masuk'])); ?></td>

                    <td><?= $data['nama_pengguna']; ?></td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>

