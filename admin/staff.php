<?php
session_start();
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
        <!-- link css -->
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
                    <span class="mx-3" style="float: right;"> LP3I COLLEGE SURABAYA</span>
                </h5>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <a href="logout.php" class="btn btn-danger">LOGOUT</a>
                </div>
            </div>
        </nav>
        <!-- NAVBAR -->

        <!-- CONTENT -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 bg-black left-menu menuscol">
                    <h4 class="p-3 text-white text-center border-bottom">MENU</h4>
                    <ul class="list-group list-group-flush">
                        <?php
                        // Mendapatkan menu dari database
                        $stmt = $cn_mysql->prepare("SELECT * FROM mst_menus WHERE isactive=1");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($d = $result->fetch_assoc()) {
                            echo '<li class="list-group-item"><a href="' . $d["menu_link"] . '">' . $d["menu_name"] . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-md-10 p-4">
                    <?php
                    if (!isset($_GET['modul'])) {
                    ?>
                        <h5><span style="float: right;"> Welcome: <?php echo $_SESSION['loginname']; ?></span></h5>
                        <hr>
                </div>
            <?php
                    } else {
                        echo '
                        <h5 id="title">
                            Module: ' . $_GET['modul'] . '
                            <span style="float: right;"> Welcome: ' . $_SESSION['loginname'] . '</span>
                        </h5>
                        <hr>
                        ';
                        // Menyiapkan halaman modul untuk disertakan
                        $pagenya = $_GET['modul'] . ".php";
                        include_once("modul/$pagenya");
                    }
            ?>
            </div>
        </div>
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

        <!-- JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.tiny.cloud/1/dko82xe3wzgquvpaeiws05jr25r0l4kftzrbqaxlovgyc6sj/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            // Inisialisasi TinyMCE
            tinymce.init({
                selector: 'textarea', // Ganti dengan selector yang sesuai dengan textarea Anda

            });
        </script>
    </body>

    </html>
<?php
} else {
    // Jika user belum login, arahkan ke halaman login
    echo "<script>alert('Memerlukan login');</script>";
    echo "<meta http-equiv='refresh' content='0;url=../index.php'>";
    exit;
}
?>
