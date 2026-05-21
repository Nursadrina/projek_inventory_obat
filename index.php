<?php 
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user'])){
    header("location:login.php");
    exit;
}

$query = "SELECT * FROM obat ORDER BY nama_obat ASC";

$result = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart Inventory</title>

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>
    <header class="navbar">

        <div class="logo">
            <i class="fas fa-capsules"></i> Smart Inventory
        </div>

        <div class="nav-tools">
            <a href="laporan_masuk.php" class="nav-link">
                <i class="fas fa-arrow-down"></i> Obat Masuk
            </a>
            <a href="laporan_keluar.php" class="nav-link">
                <i class="fas fa-arrow-up"></i> Obat Keluar
            </a>
            <a href="logout.php" id="logoutBtn" class="nav-link">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

    </header>

    <div class="container">

        <!-- ACTION BAR -->
        <div class="action-bar">
            <h2>Stok Obat Terkini</h2>
            <button id="btnTambah" class="btn-main">
                <i class="fas fa-plus"></i> Tambah Obat Baru
            </button>
        </div>

        <!-- SEARCH -->
        <input type="text"  id="liveSearch" onkeyup="searchTable()" placeholder="Cari nama obat..." class="search-bar">
        <!-- TABLE -->
        <div class="table-container">
            <table id="obatTable">
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Kadaluarsa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(mysqli_num_rows($result) > 0):
                        while($row = mysqli_fetch_assoc($result)):
                        $expired = strtotime($row['tanggal_kadaluarsa']) < time();
                        $class = '';
                        if($row['stok'] <= 0){
                            $class = 'stok-habis';
                        }
                        if($expired){
                            $class = 'expired';
                        }
                    ?>
                    <tr class="<?= $class ?>">
                        <!-- NAMA OBAT -->
                        <td>
                            <?= htmlspecialchars($row['nama_obat']); ?>
                        </td>
                        <!-- STOK -->
                        <td>
                            <strong><?= $row['stok']; ?></strong>
                        </td>

                        <!-- SATUAN -->
                        <td>
                            <?= htmlspecialchars($row['satuan']); ?>
                        </td>
                        <!-- KADALUARSA -->
                        <td>
                            <?= date('d M Y', strtotime($row['tanggal_kadaluarsa'])); ?>
                            <?php if($expired): ?>
                                <br>
                                <small style="color:red;">
                                    Sudah Kadaluarsa
                                </small>
                            <?php endif; ?>

                        </td>

                        <!-- AKSI -->

                        <td>
                            <!-- JIKA STOK ADA -->
                            <?php if($row['stok'] > 0): ?>

                                <a 
                                    href="proses_keluar.php?id=<?= $row['id_obat']; ?>"
                                    class="btn-keluar"
                                    onclick="return confirm('Serahkan 1 unit obat ini?')"
                                >
                                    <i class="fas fa-hand-holding-medical"></i>
                                    Serahkan
                                </a>

                            <?php else: ?>

                                <!-- RESTOK -->
                                <a 
                                    href="restok.php?id=<?= $row['id_obat']; ?>" 
                                    class="btn-restok"
                                >
                                    <i class="fas fa-plus-circle"></i>
                                    Restok
                                </a>

                            <?php endif; ?>

                            <a 
                                href="hapus_obat.php?id=<?= $row['id_obat']; ?>"
                                class="btn-hapus"
                                onclick="return confirm('Yakin ingin menghapus obat ini?')"
                            >
                                <i class="fas fa-trash"></i>
                                Hapus
                            </a>
                        </td>
                    </tr>

                    <?php 
                        endwhile;
                    else:
                    ?>
                    <tr>

                        <td colspan="5" style="text-align:center; padding:20px;">
                            Data obat tidak ditemukan.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>
                <i class="fas fa-plus-circle"></i>
                Input Pemasukan
            </h3>

            <hr style="border:0.5px solid #333; margin-bottom:20px;">

            <form action="proses_tambah.php" method="POST">

                <label>Nama Obat</label>

                <input 
                    type="text" 
                    name="nama_obat" 
                    placeholder="Contoh: Paracetamol" 
                    required
                >
                <label>Jumlah Masuk</label>

                <input 
                    type="number" 
                    name="jumlah" 
                    placeholder="0" 
                    min="1" 
                    required
                >
                <label>Satuan</label>
                <select name="satuan" required>
                    <option value="Tablet">Tablet</option>
                    <option value="Strip">Strip</option>
                    <option value="Botol">Botol</option>
                    <option value="Pcs">Pcs</option>
                </select>

                <label>Tanggal Kadaluarsa</label>
                <input type="date" name="tanggal_kadaluarsa" required>             
                    <button type="submit" class="btn-save">
                    Simpan ke Database
                </button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById("modalTambah");

        const btn = document.getElementById("btnTambah");

        const span = document.getElementsByClassName("close")[0];

        btn.onclick = () => {

            modal.style.display = "block";

        }

        span.onclick = () => {

            modal.style.display = "none";

        }

        window.onclick = (event) => {

            if(event.target == modal){

                modal.style.display = "none";

            }

        }

        function searchTable(){

            let input = document
            .getElementById("liveSearch")
            .value
            .toUpperCase();

            let table = document.getElementById("obatTable");

            let tr = table.getElementsByTagName("tr");

            for(let i = 1; i < tr.length; i++){

                let td = tr[i].getElementsByTagName("td")[0];

                if(td){

                    let txtValue = td.textContent || td.innerText;

                    tr[i].style.display = 
                    txtValue.toUpperCase().indexOf(input) > -1
                    ? ""
                    : "none";

                }

            }

        }

        document.getElementById("logoutBtn")
        .addEventListener("click", function(e){

            e.preventDefault();

            if(confirm("Apakah Anda yakin ingin keluar dari sistem?")){

                window.location.href = "logout.php";

            }

        });

    </script>

</body>

</html>
