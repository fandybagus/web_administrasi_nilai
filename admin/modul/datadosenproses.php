<?php
require_once("../../config/koneksidb.php");
require_once("../../config/general.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $proses = $_POST['proses'];

    if ($proses == "add") {
        $kode_dosen = generate_no_dosen();
        $nama = $_POST['nama'];
        $email_dosen = $_POST['email'];
        $password = $_POST['password'];
        $telepon = $_POST['telepon'];
        $alamat = $_POST['alamat'];
        $isactive = 1;

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $statement_sql = $cn_mysql->prepare("SELECT email_dosen FROM mst_dosen WHERE email_dosen=?");
        $statement_sql->bind_param("s", $email_dosen);
        $statement_sql->execute();
        $result = $statement_sql->get_result();

        if ($result->num_rows > 0) {
            notif("email sudah terdaftar");
            back("../staff.php?page=datadosen");
        } else {
            $statement_sql = $cn_mysql->prepare("INSERT INTO mst_dosen (nip_dosen, nama_dosen, email_dosen, password, telp_dosen, alamat_dos, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $statement_sql->bind_param("ssssssi", $kode_dosen, $nama, $email_dosen, $hashed_password, $telepon, $alamat, $isactive);

            if ($statement_sql->execute()) {
                notif("berhasil tersimpan");
                back("../staff.php?page=datadosen");
                exit();
            } else {
                notif("gagal tersimpan: " . $statement_sql->error);
                back("../staff.php?page=datadosen");
                exit();
            }
        }
        $statement_sql->close();
    } elseif ($proses == "edit") {
        $keyid = $_POST['keyid'];
        $nama_dosen = $_POST['nama'];
        $email_dosen = $_POST['email'];
        $password = $_POST['password'];
        $telepon = $_POST['telepon'];
        $alamat = $_POST['alamat'];
        $isactive = 1;

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $statement_sql = $cn_mysql->prepare(
            "UPDATE `mst_dosen` SET `nama_dosen` = ?, `email_dosen` = ?, `password` = ?, `telp_dosen` = ?, `alamat_dos` = ? WHERE `nip_dosen` = ?"
        );

        if (!$statement_sql) {
            die("Statement preparation failed: " . $cn_mysql->error);
        }

        $statement_sql->bind_param("ssssss", $nama_dosen, $email_dosen, $hashed_password, $telepon, $alamat, $keyid);

        if ($statement_sql->execute()) {
            notif("berhasil diupdate");
            back("../staff.php?modul=datadosen");
            exit;
        } else {
            error_log("Statement execution failed: " . $statement_sql->error);
            notif("gagal diupdate: " . $statement_sql->error);
            back("../staff.php?modul=datadosen");
        }

        $statement_sql->close();
    }
}

if (isset($_GET['proses']) && $_GET['proses'] == "delete") {
    $statement_sql = $cn_mysql->prepare("DELETE FROM mst_dosen WHERE nip_dosen = ?");
    $statement_sql->bind_param("s", $_GET['id']);
    
    if ($statement_sql->execute()) {
        notif("data berhasil dihapus");
        back("../staff.php?modul=datadosen");
        exit;
    } else {
        notif("data gagal dihapus: " . $statement_sql->error);
        back("../staff.php?modul=datadosen");
        exit;
    }
    $statement_sql->close();
}

$cn_mysql->close();
?>
