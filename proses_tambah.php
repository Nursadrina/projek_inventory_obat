<?php
session_start();
include 'koneksi.php';

$nama_obat = $_POST['nama_obat'];
$jumlah    = $_POST['jumlah'];
$satuan    = $_POST['satuan'];
$tgl_exp   = $_POST['tanggal_kadaluarsa'];
$id_user   = $_SESSION['id_pengguna'];

// 1. Simpan ke tabel master obat
$query_obat = "INSERT INTO obat (nama_obat, stok, satuan, tanggal_kadaluarsa) 
               VALUES ('$nama_obat', '$jumlah', '$satuan', '$tgl_exp')";

if(mysqli_query($koneksi, $query_obat)){
    $id_obat_baru = mysqli_insert_id($koneksi);
    
    // 2. Catat riwayat ke tabel pemasukan_obat
    $query_masuk = "INSERT INTO pemasukan_obat (id_obat, jumlah_masuk, tanggal_masuk, id_pengguna) 
                    VALUES ('$id_obat_baru', '$jumlah', CURDATE(), '$id_user')";
    mysqli_query($koneksi, $query_masuk);

    header("location:index.php");
} else {
    echo "Gagal menyimpan: " . mysqli_error($koneksi);
}
?>