<?php
session_start();
include 'koneksi.php';

$query = mysqli_query($koneksi,"
SELECT pengeluaran_obat.*, obat.nama_obat, pengguna.nama_pengguna
FROM pengeluaran_obat
JOIN obat ON pengeluaran_obat.id_obat = obat.id_obat
JOIN pengguna ON pengeluaran_obat.id_pengguna = pengguna.id_pengguna
ORDER BY tanggal_keluar DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Obat Keluar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="action-bar">
        <h2>Laporan Obat Keluar</h2>

        <a href="index.php" class="btn-main">
            Kembali
        </a>
    </div>

    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Jumlah Keluar</th>
                    <th>Tanggal</th>
                    <th>Petugas</th>
                </tr>
            </thead>

            <tbody>

                <?php while($data = mysqli_fetch_assoc($query)): ?>

                <tr>

                    <td><?= $data['nama_obat']; ?></td>

                    <td><?= $data['jumlah_keluar']; ?></td>

                    <td><?= date('d M Y', strtotime($data['tanggal_keluar'])); ?></td>

                    <td><?= $data['nama_pengguna']; ?></td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>