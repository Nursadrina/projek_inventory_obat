<?php
session_start();
include 'koneksi.php';

$nama_obat = $_POST['nama_obat'];
$jumlah    = $_POST['jumlah'];
$satuan    = $_POST['satuan'];
$tgl_exp   = $_POST['tanggal_kadaluarsa'];
$id_user   = $_SESSION['id_pengguna'];

// Cek apakah obat sudah ada
$cek = mysqli_query($koneksi,
    "SELECT * FROM obat WHERE nama_obat='$nama_obat'"
);

if(mysqli_num_rows($cek) > 0){

    // Jika sudah ada → update stok
    $data = mysqli_fetch_assoc($cek);
    $id_obat = $data['id_obat'];

    mysqli_query($koneksi,
        "UPDATE obat
         SET stok = stok + '$jumlah',
             tanggal_kadaluarsa='$tgl_exp'
         WHERE id_obat='$id_obat'"
    );

}else{

    // Jika belum ada → insert baru
    mysqli_query($koneksi,
        "INSERT INTO obat
        (nama_obat, stok, satuan, tanggal_kadaluarsa)
        VALUES
        ('$nama_obat', '$jumlah', '$satuan', '$tgl_exp')"
    );

    $id_obat = mysqli_insert_id($koneksi);
}

// Simpan riwayat pemasukan
mysqli_query($koneksi,
    "INSERT INTO pemasukan_obat
    (id_obat, jumlah_masuk, tanggal_masuk, id_pengguna)
    VALUES
    ('$id_obat', '$jumlah', CURDATE(), '$id_user')"
);

header("location:index.php");
?>
