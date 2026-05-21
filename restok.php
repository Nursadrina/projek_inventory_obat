<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM obat WHERE id_obat='$id'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Restok Obat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="modal-content" style="display:block; margin-top:50px;">
        <h2>Restok Obat</h2>

        <form action="proses_restok.php" method="POST">

            <input type="hidden" name="id_obat" value="<?= $data['id_obat']; ?>">

            <label>Nama Obat</label>
            <input type="text" value="<?= $data['nama_obat']; ?>" readonly>

            <label>Jumlah Tambahan</label>
            <input type="number" name="jumlah" min="1" required>

            <button type="submit" class="btn-save">
                Tambah Stok
            </button>

        </form>
    </div>
</div>

</body>
</html>