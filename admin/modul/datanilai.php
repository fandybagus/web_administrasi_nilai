<?php
// Definisikan fungsi getGrade
function getGrade($total_poin)
{
    if ($total_poin >= 85) {
        return 'A';
    } elseif ($total_poin >= 70) {
        return 'B';
    } elseif ($total_poin >= 55) {
        return 'C';
    } elseif ($total_poin >= 40) {
        return 'D';
    } else {
        return 'E';
    }
}

// Kode untuk koneksi database dan query
if (!isset($_GET['action'])) {
?>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-dark table-striped my-2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dosen</th>
                        <th>Mata Kuliah</th>
                        <th>Nama Mahasiswa</th>
                        <th>Nilai Akhir</th>
                        <th>Grade</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Query untuk mendapatkan data gabungan dari beberapa tabel dengan urutan berdasarkan idnilai DESC
                    $statement_sql = $cn_mysql->prepare(
                        "SELECT dn.idnilai, d.nama_dosen, mk.matakuliah, m.nama_mhs, dn.total_poin, dn.is_approved
                    FROM data_nilai dn 
                    JOIN mst_dosen d ON dn.nip_dosen = d.nip_dosen 
                    JOIN mst_matakuliah mk ON dn.idmatkul = mk.idmatkul 
                    JOIN mst_mahasiswa m ON dn.nim_mhs = m.nim 
                    ORDER BY dn.idnilai DESC"
                    ); // Menambahkan ORDER BY untuk mengurutkan berdasarkan idnilai secara descending                    
                    // Mengeksekusi query SQL
                    $statement_sql->execute();
                    // Menampung hasil eksekusi query
                    $result = $statement_sql->get_result();
                    while ($data = $result->fetch_assoc()) {
                        // Hitung grade jika nilai sudah disetujui
                        $grade = '';
                        if ($data['is_approved'] == 1) {
                            $grade = getGrade($data['total_poin']);
                        }
                    ?>
                        <tr>
                            <td class="col-md-1"><?php echo $no; ?></td>
                            <td class="col-md-2"><?php echo $data['nama_dosen']; ?></td>
                            <td class="col-md-3"><?php echo $data['matakuliah']; ?></td>
                            <td class="col-md-3"><?php echo $data['nama_mhs']; ?></td>
                            <td class="col-md-2"><?php echo $data['total_poin']; ?></td>
                            <?php if ($data['is_approved'] == 1) { ?>
                                <td class="col-md-2"><?php echo $grade; ?></td> <!-- Menampilkan Grade -->
                            <?php } else { ?>
                                <td class="col-md-2">-</td> <!-- Tampilkan tanda '-' jika belum disetujui -->
                            <?php } ?>
                            <td>
                                <?php if ($data['is_approved'] == 0) { ?>
                                    <a href="?modul=<?php echo $_GET['modul']; ?>&action=acc&id=<?php echo $data['idnilai']; ?>" class="btn btn-success" title="ACC"><i class="bi bi-check2"></i></a>
                                <?php } else { ?>
                                    <button class="btn btn-secondary" disabled>ACC</button> <!-- Tombol ACC yang dinonaktifkan -->
                                <?php } ?>
                            </td>
                        </tr>
                    <?php $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
} elseif ($_GET['action'] == 'acc') {
    // Aksi untuk menyetujui nilai dan menampilkan grade
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $statement_acc = $cn_mysql->prepare("UPDATE data_nilai SET is_approved = 1 WHERE idnilai = ?");
        $statement_acc->bind_param('i', $id);
        $statement_acc->execute();

        // Redirect untuk menghindari refresh halaman yang sama
        header("Location: ?modul=" . $_GET['modul']);
        exit();
    }
}
?>