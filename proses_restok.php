<?php
session_start();
include 'koneksi.php';

$id_obat = $_POST['id_obat'];
$jumlah  = $_POST['jumlah'];
$id_user = $_SESSION['id_pengguna'];

// 1. Tambah stok obat
$query = "UPDATE obat 
          SET stok = stok + '$jumlah'
          WHERE id_obat='$id_obat'";

if(mysqli_query($koneksi, $query)){

    // 2. Catat ke tabel pemasukan_obat
    mysqli_query($koneksi,
        "INSERT INTO pemasukan_obat
        (id_obat, jumlah_masuk, tanggal_masuk, id_pengguna)
        VALUES
        ('$id_obat', '$jumlah', CURDATE(), '$id_user')"
    );

    echo "
    <script>
        alert('Stok berhasil ditambahkan!');
        window.location='index.php';
    </script>
    ";

}else{

    echo "
    <script>
        alert('Gagal menambah stok!');
        window.location='index.php';
    </script>
    ";
}
?>