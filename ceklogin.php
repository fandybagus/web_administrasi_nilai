<?php
session_start();
require_once('config/koneksidb.php'); // untuk koneksi ke database
require_once('config/general.php'); // untuk koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['logusername'];
    $password = $_POST['logpassword'];

    // Escape string untuk menghindari SQL injection
    $username = mysqli_real_escape_string($cn_mysql, $username);

    // Query menggunakan prepared statement untuk mendapatkan data pengguna dari tabel dosen
    $query_dosen = "SELECT * FROM mst_dosen WHERE email_dosen = ?";
    $statement_dosen = $cn_mysql->prepare($query_dosen);
    $statement_dosen->bind_param("s", $username);
    $statement_dosen->execute();
    $result_dosen = $statement_dosen->get_result();

    // Query menggunakan prepared statement untuk mendapatkan data pengguna dari tabel staff
    $query_staff = "SELECT * FROM mst_pegawai WHERE email = ?";
    $statement_staff = $cn_mysql->prepare($query_staff);
    $statement_staff->bind_param("s", $username);
    $statement_staff->execute();
    $result_staff = $statement_staff->get_result();

    if ($result_dosen->num_rows == 1) {
        // Jika username ditemukan di tabel dosen, verifikasi password
        $data = $result_dosen->fetch_assoc();
        if (password_verify($password, $data['password'])) {
            // Jika password benar, buat session dan redirect ke halaman dosen
            $_SESSION['userlogin'] = $data['nama_dosen'];
            $_SESSION['loginname'] = $data['nama_dosen'];
            header("Location: admin/dosen.php");
            exit();
        } else {
            notif("password salah, login gagal");
            back("");
        }
    } elseif ($result_staff->num_rows == 1) {
        // Jika username ditemukan di tabel staff, verifikasi password
        $data = $result_staff->fetch_assoc();
        if (password_verify($password, $data['password'])) {
            // Jika password benar, buat session dan redirect ke halaman staff
            $_SESSION['userlogin'] = $data['nama'];
            $_SESSION['loginname'] = $data['nama'];
            header("Location: admin/staff.php");
            exit();
        } else {
            notif("password salah, login gagal");
            back("");
        }
    } else {
        // Jika username tidak ditemukan di kedua tabel
        notif("username tidak ditemukan");
        back("");
    }
}


?>
