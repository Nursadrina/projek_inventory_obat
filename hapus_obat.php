<?php
session_start();
include 'koneksi.php';

// Proteksi login
if(!isset($_SESSION['user'])){
    header("location:login.php");
    exit;
}

// Ambil id
$id = $_GET['id'];


// Hapus riwayat pemasukan
mysqli_query($koneksi,
"DELETE FROM pemasukan_obat WHERE id_obat='$id'");

// Hapus riwayat pengeluaran
mysqli_query($koneksi,
"DELETE FROM pengeluaran_obat WHERE id_obat='$id'");

$query = mysqli_query($koneksi,
"DELETE FROM obat WHERE id_obat='$id'");

if($query){

    echo "
    <script>
        alert('Obat berhasil dihapus!');
        window.location='index.php';
    </script>
    ";

}else{

    echo "
    <script>
        alert('Gagal menghapus obat!');
        window.location='index.php';
    </script>
    ";

}
?>