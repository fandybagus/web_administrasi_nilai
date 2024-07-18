<?php
session_start();
// Pastikan sesi 'userlogin' sudah diatur setelah login berhasil
if (isset($_SESSION['userlogin'])) {
    require_once('../config/koneksidb.php');
    require_once('../config/general.php');
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HOME</title>
        <!-- link js -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../assets/adminstyle.css" />
    </head>

    <body class="d-flex flex-column min-vh-100">
        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <img src="../assets/img/LOGO-04.png" alt="Logo" style="height: 40px;">
                <h5>
                    <span class="mx-3" style="float: right;"> welcome : <?php echo $_SESSION['loginname']; ?></span>
                </h5>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <form action="logout.php" method="post">
                        <button type="submit" class="btn btn-danger" name="logout">LOGOUT</button>
                    </form>
                </div>
            </div>
        </nav>
        <!-- NAVBAR -->
        <!-- CONTENT -->
        <div class="container d-flex flex-column align-items-center">
            <div class="row justify-content-center">
                <?php
                // Query untuk mengambil data mata kuliah berdasarkan kode_dosen dan tahun_kuliah
                $kode_dosen = generate_no_dosen(); // Ambil kode_dosen dari sesi userlogin, sesuai dengan kebutuhan Anda
                $tahun_kuliah = generate_tahunkul(); // Tahun kuliah bisa disesuaikan dengan logika Anda
                $query = "SELECT * FROM mst_matakuliah WHERE kode_dosen = ? || tahunkuliah = ?";
                $statement = $cn_mysql->prepare($query);
                $statement->bind_param("ss", $kode_dosen, $tahun_kuliah);
                $statement->execute();
                $result = $statement->get_result();

                // Periksa apakah ada hasil dari query
                if ($result->num_rows > 0) {
                    // Loop untuk menampilkan masing-masing mata kuliah
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="col-md-7 p-5 text-center border">
                            <label for="" class="labelm"><?php echo $row['matakuliah']; ?></label>
                            <a href="modul_dosen/input_nilai.php?id=<?php echo $row['idmatkul']; ?>" class="btn btn-primary">Input nilai</a>
                            <a href="modul_dosen/view_data.php?id=<?php echo $row['idmatkul']; ?>&nip_dosen=<?php echo $row['kode_dosen']; ?>" class="btn btn-secondary">View data</a>
                        </div>
                <?php
                    }
                } else {
                    // Tampilkan pesan jika tidak ada mata kuliah ditemukan
                    echo '<div class="col-md-12 p-5 border"><p>Tidak ada mata kuliah tersedia untuk tahun kuliah ini.</p></div>';
                }
                ?>
            </div>
        </div>
        <!-- Kontainer untuk konten dinamis -->
        <div class="container">
                
        </div>
        <!-- CONTENT -->
        <!-- FOOTER -->
        <footer class="bg-dark text-white footer mt-auto">
            <div class="container">
                <div class="row">
                    <h5 class="text-center">COPYRIGHT 2024</h5>
                </div>
            </div>
        </footer>
        <!-- FOOTER -->

        <!-- script js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
} else {
    // Jika sesi 'userlogin' tidak ada, maka pengguna tidak diizinkan mengakses halaman ini
    echo "<script>alert('Memerlukan login');</script>";
    echo "<meta http-equiv='refresh' content='0;url=../index.php'>";
    exit;
}
?>
