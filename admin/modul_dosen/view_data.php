<?php
session_start();
require_once('../../config/koneksidb.php');
require_once('../../config/general.php');

// Fungsi untuk menghitung grade berdasarkan nilai akhir
function hitungGrade($nilaiAkhir) {
    if ($nilaiAkhir >= 85) {
        return 'A';
    } elseif ($nilaiAkhir >= 70) {
        return 'B';
    } elseif ($nilaiAkhir >= 55) {
        return 'C';
    } elseif ($nilaiAkhir >= 40) {
        return 'D';
    } else {
        return 'E';
    }
}

if (!isset($_GET['action'])) {
    if (isset($_GET['id'])) {
        $kode_dosen = $_GET['nip_dosen'];
        $idmatkul = $_GET['id'];

        // Query untuk mengambil data nilai mahasiswa berdasarkan idmatkul
        $query = "SELECT n.*, m.nama_mhs, m.nim, mk.matakuliah AS matakuliah 
                  FROM data_nilai n 
                  JOIN mst_mahasiswa m ON n.nim_mhs = m.nim 
                  JOIN mst_matakuliah mk ON n.idmatkul = mk.idmatkul 
                  WHERE n.idmatkul = ?";
        $statement = $cn_mysql->prepare($query);
        $statement->bind_param("i", $idmatkul);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            // Ambil nama mata kuliah
            $row = $result->fetch_assoc();
            $matkul = $row['matakuliah'];
        } else {
            echo "Data tidak ditemukan.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nilai Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <?php
                // Additional content can go here
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-dark table-striped my-2">
                    <thead>
                        <tr>
                            <th colspan="7" class="text-center">Mata Kuliah : <?php echo htmlspecialchars($matkul); ?></th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>NIM Mahasiswa</th>
                            <th>Nama Mahasiswa</th>
                            <th>Nilai Akhir</th>
                            <th>Grade</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Mendapatkan kode_dosen dan idmatkul dari URL atau form input
                        $kode_dosen = $_GET['nip_dosen']; // Sesuaikan dengan cara mendapatkan nilai kode_dosen
                        $idmatkul = $_GET['id']; // Sesuaikan dengan cara mendapatkan nilai idmatkul

                        // Query SQL untuk mengambil data nilai beserta nama mahasiswa dari tabel mst_mahasiswa
                        $sql = "SELECT dn.nim_mhs, mm.nama_mhs, dn.total_poin 
                                FROM data_nilai dn
                                INNER JOIN mst_mahasiswa mm ON dn.nim_mhs = mm.nim
                                WHERE dn.nip_dosen = ? AND dn.idmatkul = ?";
                        $statement = $cn_mysql->prepare($sql);
                        $statement->bind_param("si", $kode_dosen, $idmatkul);
                        $statement->execute();
                        $result = $statement->get_result();

                        $no = 1; // Untuk nomor urut di tabel

                        // Pastikan query dieksekusi dengan sukses sebelum melakukan pengulangan
                        if ($result->num_rows > 0) {
                            // Loop untuk menampilkan data nilai
                            while ($data = $result->fetch_assoc()) {
                                $nilaiAkhir = $data['total_poin'];
                                $grade = hitungGrade($nilaiAkhir);
                        ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo htmlspecialchars($data['nim_mhs']); ?></td>
                                    <td><?php echo htmlspecialchars($data['nama_mhs']); ?></td>
                                    <td><?php echo htmlspecialchars($nilaiAkhir); ?></td>
                                    <td><?php echo htmlspecialchars($grade); ?></td>
                                    <td>
                                        <a href="?modul_dosen=<?php echo isset($_GET['modul_dosen']) ? htmlspecialchars($_GET['modul_dosen']) : ''; ?>&action=edit&id=<?php echo htmlspecialchars($data["nim_mhs"]); ?>&idmatkul=<?php echo htmlspecialchars($idmatkul); ?>&kode_dosen=<?php echo htmlspecialchars($kode_dosen); ?>" class="btn btn-primary" title="Detail Data"><i class="bi bi-pencil-fill mx-2"></i> Edit</a>
                                        <a href="?modul_dosen=<?php echo isset($_GET['modul_dosen']) ? htmlspecialchars($_GET['modul_dosen']) : ''; ?>&action=delete&id=<?php echo htmlspecialchars($data["nim_mhs"]); ?>&idmatkul=<?php echo htmlspecialchars($idmatkul); ?>&kode_dosen=<?php echo htmlspecialchars($kode_dosen); ?>" class="btn btn-danger" title="Hapus Data"><i class="bi bi-trash-fill"></i> Hapus</a>
                                    </td>
                                </tr>
                        <?php
                                $no++;
                            }
                        } else {
                            echo "Tidak ada data nilai untuk kode dosen '$kode_dosen' dan idmatkul '$idmatkul'.";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php
} else {
    if ($_GET['action'] == "edit") {
        // Variabel untuk ubah data
        $process = "edit";
        $keyid = $_GET['id'];
        $idmatkul = $_GET['idmatkul'];
        $kode_dosen = $_GET['kode_dosen'];

        // Query untuk mengambil data mahasiswa dan nilai berdasarkan NIM
        $statement_sql = $cn_mysql->prepare("
            SELECT m.*, n.total_poin, n.is_approved 
            FROM mst_mahasiswa m 
            LEFT JOIN data_nilai n ON m.nim = n.nim_mhs AND n.idmatkul = ? 
            WHERE m.nim = ?
        ");
        $statement_sql->bind_param("ss", $idmatkul, $keyid);
        $statement_sql->execute();
        $result = $statement_sql->get_result();
        $data = $result->fetch_assoc();
        $nim = $data['nim'];
        $nama = $data['nama_mhs'];
        $nilai_akhir = isset($data['total_poin']) ? $data['total_poin'] : 0; // pastikan nilai terdefinisi
        $grade = hitungGrade($nilai_akhir);
        $is_approved = $data['is_approved'];
    } elseif ($_GET['action'] == "delete") {
        // Proses delete data
        $keyid = $_GET['id'];
        $idmatkul = $_GET['idmatkul'];
        $kode_dosen = $_GET['kode_dosen'];

        // Query untuk menghapus data
        $delete_sql = $cn_mysql->prepare("DELETE FROM data_nilai WHERE nim_mhs = ? AND idmatkul = ?");
        $delete_sql->bind_param("ss", $keyid, $idmatkul);
        if ($delete_sql->execute()) {
            echo "<script>alert('Data berhasil dihapus.'); window.location.href='viewdataproses.php?id=$idmatkul&nip_dosen=$kode_dosen';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data.'); window.location.href='viewdataproses.php?id=$idmatkul&nip_dosen=$kode_dosen';</script>";
        }
        exit;
    }
?>
<!-- Tampil form input/edit -->
<form action="modul_dosen/viewdataproses.php" method="post">
    <input type="hidden" name="proses" value="<?php echo htmlspecialchars($process); ?>">
    <input type="hidden" name="keyid" value="<?php echo htmlspecialchars($keyid); ?>">
    <input type="hidden" name="idmatkul" value="<?php echo htmlspecialchars($idmatkul); ?>">
    <input type="hidden" name="kode_dosen" value="<?php echo htmlspecialchars($kode_dosen); ?>">

    <div class="row my-3">
        <label class="col-md-2">NIM</label>
        <div class="col-md-5">
            <p class="form-control-static">: <?php echo $nim; ?></p>
        </div>
    </div>
    <div class="row my-3">
        <label class="col-md-2">Nama</label>
        <div class="col-md-5">
            <p class="form-control-static">: <?php echo $nama; ?></p>
        </div>
    </div>
    <div class="row my-3">
        <label class="col-md-2">Nilai Akhir</label>
        <div class="col-md-5">
            <p class="form-control-static">: <?php echo $nilai_akhir; ?></p>
        </div>
    </div>
    <div class="row my-3">
        <label class="col-md-2">Grade</label>
        <div class="col-md-5">
            <p class="form-control-static">: <?php echo $grade; ?></p>
        </div>
    </div>
    <div class="row my-3">
        <label class="col-md-2">Approved</label>
        <div class="col-md-5">
            <p class="form-control-static">: <?php echo $is_approved; ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <hr>
            <button type="reset" class="btn btn-sm btn-secondary" onclick="history.back()">
                <i class="bi bi-x-circle-fill"></i> Batal
            </button>
        </div>
    </div>
</form>
<?php
}
?>
