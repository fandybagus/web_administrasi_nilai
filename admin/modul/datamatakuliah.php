<?php
if (!isset($_GET['action'])) {
?>

    <div class="row">
        <div class="col-md-12">
            <a href="?modul=<?php echo $_GET['modul']; ?>&action=add" class="btn btn-primary"> tambah data </a>
            <table class="table table-dark table-striped my-2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Matakuliah</th>
                        <th>Dosen</th>
                        <th>Jurusan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                     // Query untuk menampilkan data
                     $statement_sql = $cn_mysql->prepare("
                     SELECT
                         mk.idmatkul,
                         mk.matakuliah,
                         d.nama_dosen,
                         j.nm_jurusan
                     FROM
                         mst_matakuliah mk
                     JOIN
                         mst_dosen d ON mk.kode_dosen = d.nip_dosen
                     JOIN
                         mst_jurusan j ON mk.idjurusan = j.idjurusan
                     WHERE
                         mk.is_active = 1
                     ORDER BY
                         mk.idmatkul DESC
                ");
                    //untuk mengeksekusi kode sql 
                    $statement_sql->execute();
                    //untuk menampung hasil eksekusi query
                    $result = $statement_sql->get_result();
                    while ($data = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td class="col-md-1"><?php echo $no; ?></td>
                            <td class="col-md-2"><?php echo $data['matakuliah']; ?></td>
                            <td class="col-md-4"><?php echo $data['nama_dosen']; ?></td>
                            <td class="col-md-3"><?php echo $data['nm_jurusan']; ?></td>
                            <td>
                                <a href="?modul=<?php echo $_GET['modul']; ?>&action=edit&id=<?php echo $data['idmatkul']; ?>" class="btn btn-primary" title="detail data"><i class="bi bi-pencil-fill mx-2"></i></i><a>
                                <a href="?modul=<?php echo $_GET['modul']; ?>&action=delete&id=<?php echo $data['idmatkul']; ?>" class="btn btn-danger" title="hapus data"><i class="bi bi-trash-fill"></i></a>
                            </td>
                        </tr>

                    <?php 
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
} else {
    if ($_GET['action'] == "add") {
        //variabel untuk tambah data
        $process = "add"; //variabel ini digunakan untuk membedakan ketika memprocess data baik simpan data 
        $tahun_kuliah = generate_tahunkul();
        $jurusan = "";
        $dosen = "";
        $matakuliah = "";
    } else if ($_GET['action'] == "edit") {
        // variabel untuk ubah data
        $process = "edit"; // variabel ini digunakan untuk membedakan ketika memprocess data baik ubah data
        // proses mengambil data
        $keyid = $_GET['id']; // menampung variabel id yg di URL
        // untuk mendapatkan sql query 
        $statement_sql = $cn_mysql->prepare("SELECT * FROM mst_matakuliah WHERE idmatkul = ?");
        $statement_sql->bind_param("i", $keyid);
        // untuk mengeksekusi kode sql 
        $statement_sql->execute();
        $result = $statement_sql->get_result();
        $data = $result->fetch_assoc();
        $tahun_kuliah = $data['tahunkuliah']; // Adjust according to your database structure
        $jurusan = $data['idjurusan']; // Adjust according to your database structure
        $dosen = $data['kode_dosen']; // Adjust according to your database structure
        $matakuliah = $data['matakuliah']; // Adjust according to your database structure
    } else if ($_GET['action'] == "delete") {
        header("location: modul/datamatakuliahproses.php?proses=delete&id=" . $_GET['id'] . "");
    }

?>

    <!-- tampil form input/edit -->
    <form action="modul/datamatakuliahproses.php" method="post">
        <input type="hidden" name="proses" value="<?php echo $process; ?>">
        <input type="hidden" name="keyid" value="<?php echo $keyid; ?>">
        <input type="hidden" name="createdby" value="<?php echo $_SESSION['loginname']; ?>">
        <div class="row my-3">
            <label class="col-md-2">Tahun perkuliahan</label>
            <div class="col-md-5">
                <input class="form-control input-sm" name="thn_kuliah" value="<?php echo generate_tahunkul(); ?>" readonly>
            </div>
        </div>
        <div class="row">
            <label class="col-md-2">Jurusan : </label>
            <div class="col-md-5">
                <select class="form-select" id="jurusan" name="jurusan">
                    <option value="">Pilih Jurusan</option>
                    <?php
                    //untuk mendapatkan sql query 
                    $statement_sql = $cn_mysql->prepare("select*from mst_jurusan where is_active=1");
                    //untuk mengeksekusi kode sql 
                    $statement_sql->execute();
                    //untuk menampung hasil eksekusi query
                    $result = $statement_sql->get_result();
                    while ($data = $result->fetch_assoc()) {
                        if ($idjurusan == $data['idjurusan']) {
                            $pilih = "selected";
                        } else {
                            $pilih = "";
                        }
                        echo '<option value="' . $data['idjurusan'] . '" ' . $pilih . '>' . $data['nm_jurusan'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row my-3">
            <label class="col-md-2">Dosen : </label>
            <div class="col-md-5">
                <select class="form-select" id="dosen" name="dosen">
                    <option value="">Pilih Dosen</option>
                    <?php
                    //untuk mendapatkan sql query 
                    $statement_sql = $cn_mysql->prepare("select*from mst_dosen where is_active=1");
                    //untuk mengeksekusi kode sql 
                    $statement_sql->execute();
                    //untuk menampung hasil eksekusi query
                    $result = $statement_sql->get_result();
                    while ($data = $result->fetch_assoc()) {
                        if ($id_dosen == $data['nip_dosen']) {
                            $pilih = "selected";
                        } else {
                            $pilih = "";
                        }
                        echo '<option value="' . $data['nip_dosen'] . '" ' . $pilih . '>' . $data['nama_dosen'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <label class="col-md-2">Mata Kuliah :</label>
            <div class="col-md-5">
                <input type="text" class="form-control" name="matakuliah" id="matakuliah" value="<?php echo $matakuliah; ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-5">
                <hr>    
                <button type="reset" class="btn btn-sm btn-secondary" onclick="history.back()">
                    <i class="bi bi-x-circle-fill"></i> Batal
                </button>
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="bi bi-save-fill"></i> Simpan Data
                </button>
            </div>
        </div>
    </form>

<?php
}
?>
