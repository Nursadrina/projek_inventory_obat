<?php
session_start();
include 'koneksi.php';

$id_obat = $_GET['id'];
$id_user = $_SESSION['id_pengguna'];

// 1. Kurangi stok di tabel obat
$update_stok = "UPDATE obat SET stok = stok - 1 WHERE id_obat = '$id_obat' AND stok > 0";

if(mysqli_query($koneksi, $update_stok)){
    // 2. Catat riwayat ke tabel pengeluaran_obat
    $query_keluar = "INSERT INTO pengeluaran_obat (id_obat, jumlah_keluar, tanggal_keluar, id_pengguna) 
                     VALUES ('$id_obat', 1, CURDATE(), '$id_user')";
    mysqli_query($koneksi, $query_keluar);
    
    header("location:index.php");
} else {
    echo "Gagal memproses data.";
}
?>