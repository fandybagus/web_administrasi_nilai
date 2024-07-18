<?php 
require_once("../../config/koneksidb.php");
require_once("../../config/general.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $proses = $_POST['proses'];
    
    if ($proses == "add") {
    // Menghasilkan tahun kuliah
    $tahunkuliah = generate_tahunkul();
    $jurusan = $_POST['jurusan'];
    $dosen = $_POST['dosen'];
    $matakuliah = $_POST['matakuliah'];
    $is_active = 1; // atau sesuai dengan nilai default yang diinginkan
    
    // Query untuk memasukkan data ke dalam tabel mst_matakuliah
    $statment_sql = $cn_mysql->prepare("INSERT INTO mst_matakuliah (matakuliah, idjurusan, tahunkuliah, kode_dosen, is_active) VALUES (?, ?, ?, ?, ?)");

    // Mengikat parameter ke dalam query
    $statment_sql->bind_param("ssssi", $matakuliah, $jurusan, $tahunkuliah, $dosen, $is_active);

    // Mengeksekusi query dan mengecek apakah berhasil
    if ($statment_sql->execute()) {
        back("../staff.php?modul=datamatakuliah");
        notif("Data berhasil tersimpan");
    } else {
        back("../staff.php?modul=datamatakuliah&action=add");
        notif("Data gagal tersimpan");
    }

    // Menutup statement
    $statment_sql->close();
    }
} if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $proses = $_POST['proses'];
    
    if ($proses == "add") {
        // Proses tambah data
        // ...
    } elseif ($proses == "edit") {
        // Proses edit data
        $keyid = $_POST['keyid'];
        $tahun_kuliah = $_POST['thn_kuliah'];
        $jurusan = $_POST['jurusan'];
        $dosen = $_POST['dosen'];
        $matakuliah = $_POST['matakuliah'];

        // Query untuk melakukan update data mata kuliah
        $statement_sql = $cn_mysql->prepare("UPDATE mst_matakuliah SET matakuliah=?, idjurusan=?, tahunkuliah=?, kode_dosen=? WHERE idmatkul=?");

        // Bind parameter ke dalam query
        $statement_sql->bind_param("sssss", $matakuliah, $jurusan, $tahun_kuliah, $dosen, $keyid);

        // Mengeksekusi query
        $result = $statement_sql->execute();

        // Periksa hasil eksekusi
        if ($result) {
            notif("Data berhasil diupdate");
            back("../staff.php?modul=datamatakuliah");
        } else {
            notif("Data gagal diupdate: " . $statement_sql->error);
            back("../staff.php?modul=datamatakuliah&action=edit&id=" . $keyid);
        }

        // Menutup statement
        $statement_sql->close();
    }
}


if (isset($_GET['proses']) && $_GET['proses'] == "delete") {
    $statement_sql = $cn_mysql->prepare("DELETE FROM mst_matakuliah WHERE idmatkul = ?");
    $statement_sql->bind_param("s", $_GET['id']);
    
    if ($statement_sql->execute()) {
        notif("data berhasil dihapus");
        back("../staff.php?modul=datamatakuliah");
        exit;
    } else {
        notif("data gagal dihapus: " . $statement_sql->error);
        back("../staff.php?modul=datamatakuliah");
        exit;
    }
    $statement_sql->close();
}
?>
