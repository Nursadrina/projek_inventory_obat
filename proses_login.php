<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Mencari pengguna yang aktif
$query = "SELECT * FROM pengguna WHERE username='$username' AND password='$password' AND status_aktif='aktif'";
$login = mysqli_query($koneksi, $query);
$cek = mysqli_num_rows($login);

if($cek > 0){
    $data = mysqli_fetch_assoc($login);
    $_SESSION['user'] = $username;
    $_SESSION['id_pengguna'] = $data['id_pengguna'];
    $_SESSION['nama_pengguna'] = $data['nama_pengguna'];
    
    header("location:index.php");
} else {
    echo "<script>alert('Login Gagal! Username atau Password salah.'); window.location='login.php';</script>";
}
?>
