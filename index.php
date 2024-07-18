<?php
session_start();
require_once('config/koneksidb.php');
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
    <link rel="stylesheet" href="assets/style.css" />
</head>

<body class="min-vh-100">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/img/LOGO-04.png" alt="Logo" style="height: 40px;">
                <span class="text-light ms-2">LP3I COLLEGE SURABAYA</span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <div class="dropdown">
                    <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        LOGIN MASUK
                    </button>
                    <ul class="dropdown-menu">
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">DOSEN</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">STAFF</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- NAVBAR -->

    <!-- CONTENT -->
    <div class="text-center">
        <img src="assets/img/giant banner Oktober 2023.png" class="img-fluid mx-auto d-block" style="max-width: 575px;">
    </div>
    <hr>
    <h2 class="text-center">INFO TERBARU</h2>
    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    BERITA TERBARU
                </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    Jadwal UAS untuk kelas Juni tanggal 20 maret - 27 maret
                    <br>Jadwal UAS untuk kelas September tanggal 15 juli - 21 juli
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    JADWAL PERDANA MASUK 
                </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    kelas juni akan dimulai pada tanggal 06 Juni 
                    <br>kelas juni akan dimulai pada tanggal 12 September 
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    JADWAL LIBUR SEMESTER
                </button>
            </h2>
            <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    untuk kelas Juni libur semester tanggal 28 maret - 20 april
                    <br>untuk kelas Juni libur semester tanggal 22 Juli - 19 Agustus
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT -->

    <!-- FOOTER -->
    <footer class="bg-dark text-white footer mt-auto">
        <div class="container">
            <div class="row">
                <h5>Kontak</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt"></i> Alamat: Jl. Raya Manyar No.43A, Menur Pumpungan, Kec. Sukolilo, Surabaya, Jawa Timur</li>
                    <li><i class="bi bi-telephone-fill"></i> Telepon: +62 0315937020</li>
                    <li><i class="bi bi-instagram"></i><a href="https://www.instagram.com/lp3i.surabaya/">Instagram: lp3i.surabaya</a></li>
                    <li><i class="bi bi-envelope"></i> Email: lp3icollagesurabaya@gmail.com</li>
                </ul>
            </div>
        </div>
        </div>
    </footer>
    <!-- FOOTER -->

    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="ceklogin.php" method="post" class="bg-light p-4 m-5">
                        <div class="alert alert-danger" role="alert" id="alert" style="display: none"></div>
                        <div class="alert alert-success" role="alert" id="alertok" style="display: none"></div>
                        <div id="judul" class="mt-3"></div>
                        <div class="mb-4">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="logusername" class="form-control" id="logusername" oninvalid="this.setCustomValidity('Username belum diisi')" required oninput="setCustomValidity('')" />
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="logpassword" class="form-control" id="logpassword" oninvalid="this.setCustomValidity('Password belum diisi')" required oninput="setCustomValidity('')" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnbatal" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" id="btnmasuk" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- script js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>