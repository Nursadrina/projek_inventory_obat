<?php
session_start();
include 'koneksi.php';

$id_obat = $_GET['id'];
$id_user = $_SESSION['id_pengguna'];

// Ambil data obat
$query = mysqli_query($koneksi,
    "SELECT * FROM obat WHERE id_obat='$id_obat'"
);

$data = mysqli_fetch_assoc($query);

if($data['stok'] > 0){

    // Kurangi stok
    mysqli_query($koneksi,
        "UPDATE obat
         SET stok = stok - 1
         WHERE id_obat='$id_obat'"
    );

    // Catat pengeluaran
    mysqli_query($koneksi,
        "INSERT INTO pengeluaran_obat
        (id_obat, jumlah_keluar, tanggal_keluar, id_pengguna)
        VALUES
        ('$id_obat', '1', CURDATE(), '$id_user')"
    );

    // Jika stok habis → catat kekosongan
    if($data['stok'] - 1 <= 0){

        mysqli_query($koneksi,
            "INSERT INTO kekosongan_obat
            (id_obat, tanggal, keterangan)
            VALUES
            ('$id_obat', CURDATE(), 'Stok habis')"
        );
    }

    header("location:index.php");

}else{

    echo "
    <script>
        alert('Stok sudah habis!');
        window.location='index.php';
    </script>
    ";
}
?>
