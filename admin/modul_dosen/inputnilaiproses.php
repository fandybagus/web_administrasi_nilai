<?php
session_start();
require_once('../../config/koneksidb.php');
require_once('../../config/general.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the form
    $mataKuliah = $_POST['mataKuliah'];
    $idmatkul = $_POST['idmatkul'];
    $idjurusan = $_POST['idjurusan'];
    $nip_dosen = $_POST['nip_dosen'];
    $nim_mhs = $_POST['namaMahasiswa'];
    $nilai_formatif = $_POST['nilaiFormatif1'];
    $nilai_perilaku = $_POST['nilaiPerilaku'];
    $nilai_tugas = $_POST['nilaiTugas'];
    $nilai_uts = $_POST['nilaiUTS'];
    $nilai_uas = $_POST['nilaiUAS'];

    // Calculate points
    $poin_formatif = $nilai_formatif * 0.1;
    $poin_perilaku = $nilai_perilaku * 0.1;
    $poin_tugas = $nilai_tugas * 0.2;
    $poin_uts = $nilai_uts * 0.2;
    $poin_uas = $nilai_uas * 0.4;
    $total_poin = $poin_formatif + $poin_perilaku + $poin_tugas + $poin_uts + $poin_uas;

    // Ambil NIP dosen yang login dari sesi
    $created_by = isset($_SESSION['userlogin']) ? $_SESSION['userlogin'] : 'Unknown';

    // Check for duplicate entry
    $query_check = "SELECT COUNT(*) FROM data_nilai WHERE nip_dosen = ? AND nim_mhs = ? AND idmatkul = ?";
    $stmt_check = $cn_mysql->prepare($query_check);
    $stmt_check->bind_param('ssi', $nip_dosen, $nim_mhs, $idmatkul);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        echo "Data dengan NIP dosen, NIM mahasiswa, dan ID mata kuliah yang sama sudah ada.";
    } else {
        // Insert data into the database
        $query = "INSERT INTO data_nilai (nip_dosen, nim_mhs, idmatkul, nilai_formatif, nilai_perilaku, nilai_tugas, nilai_uts, nilai_uas, poin_formatif, poin_perilaku, poin_tugas, poin_uts, poin_uas, total_poin, created_date, created_by, is_approved)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, 0)";
        $stmt = $cn_mysql->prepare($query);
        $stmt->bind_param('ssiiddiiddiidds', $nip_dosen, $nim_mhs, $idmatkul, $nilai_formatif, $nilai_perilaku, $nilai_tugas, $nilai_uts, $nilai_uas, $poin_formatif, $poin_perilaku, $poin_tugas, $poin_uts, $poin_uas, $total_poin, $created_by);

        if ($stmt->execute()) {
            echo "Data berhasil disimpan.";
            header("Location: ../dosen.php"); // Redirect to a success page
            exit(); // Ensure script termination after redirect
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $cn_mysql->close();
}
?>
