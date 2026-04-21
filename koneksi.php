<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "projekpbo";

$koneksi = mysqli_connect("localhost", "root", "", "projekpbo");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>