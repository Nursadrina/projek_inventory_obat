<?php
session_start(); 
// Menghapus semua variabel sesi
$_SESSION = array();
// Menghancurkan sesi
session_destroy();
// Mengarahkan kembali ke halaman login (Tahap awal flowchart)
header("location: login.php");
exit;
?>