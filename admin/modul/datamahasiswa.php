<?php
if (!isset($_GET['action'])) {
?>
    <div class="row">
        <div class="col-md-12">
            <a href="?modul=<?php echo $_GET['modul']; ?>&action=add" class="btn btn-primary">Tambah Data</a>
            <table class="table table-dark table-striped my-2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Jurusan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Query untuk mengambil data mahasiswa beserta nama jurusan
                    $statement_sql = $cn_mysql->prepare(
                        "SELECT mst_mahasiswa.nim, mst_mahasiswa.nama_mhs, mst_mahasiswa.telp_mhs, mst_jurusan.nm_jurusan 
                        FROM mst_mahasiswa 
                        JOIN mst_jurusan ON mst_mahasiswa.idjurusan = mst_jurusan.idjurusan 
                        WHERE mst_mahasiswa.is_active = 1 
                        ORDER BY mst_mahasiswa.nim DESC"
                    );
                    
                    $statement_sql->execute();
                    $result = $statement_sql->get_result();
                    while ($data = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td class="col-md-1"><?php echo $no; ?></td>
                            <td class="col-md-2"><?php echo $data['nim']; ?></td>
                            <td class="col-md-2"><?php echo $data['nama_mhs']; ?></td>
                            <td class="col-md-1"><?php echo $data['telp_mhs']; ?></td>
                            <td class="col-md-3"><?php echo $data['nm_jurusan']; ?></td>
                            <td>
                                <a href="?modul=<?php echo $_GET['modul']; ?>&action=edit&id=<?php echo $data['nim']; ?>" class="btn btn-primary" title="Detail Data"><i class="bi bi-pencil-fill mx-2"></i> Edit</a>
                                <a href="?modul=<?php echo $_GET['modul']; ?>&action=delete&id=<?php echo $data['nim']; ?>" class="btn btn-danger" title="Hapus Data"><i class="bi bi-trash-fill"></i> Hapus</a>
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
} else {
    if ($_GET['action'] == "add") {
        // Variabel untuk tambah data
        $process = "add";
        $nim = generate_no_mhs();
        $nama = "";
        $email = "";
        $password = "";
        $telepon = "";
        $alamat = "";
        $idjurusan = ""; // Pastikan variabel $idjurusan didefinisikan dengan benar

    } else if ($_GET['action'] == "edit") {
        // Variabel untuk ubah data
        $process = "edit";
        $keyid = $_GET['id'];
        // Query untuk mengambil data mahasiswa berdasarkan NIM
        $statement_sql = $cn_mysql->prepare("SELECT * FROM mst_mahasiswa WHERE nim = ?");
        $statement_sql->bind_param("s", $keyid);
        $statement_sql->execute();
        $result = $statement_sql->get_result();
        $data = $result->fetch_assoc();
        $nim = $data['nim'];
        $nama = $data['nama_mhs'];
        $email = $data['email_mhs'];
        $telepon = $data['telp_mhs'];
        $alamat = $data['alamat_mhs'];
        $idjurusan = $data['idjurusan']; // Pastikan variabel $idjurusan diisi dengan nilai yang sesuai dari database

    } else if ($_GET['action'] == "delete") {
        header("location: modul/datamahasiswaproses.php?proses=delete&id=" . $_GET['id'] . "");
    }
?>

    <!-- Tampil form input/edit -->
    <form enctype="multipart/form-data" action="modul/datamahasiswaproses.php" method="post">
        <input type="hidden" name="proses" value="<?php echo $process; ?>">
        <input type="hidden" name="keyid" value="<?php echo $keyid; ?>">
        <input type="hidden" name="createdby" value="<?php echo $_SESSION['loginname']; ?>">
        <div class="row my-3">
            <label class="col-md-2">NIM</label>
            <div class="col-md-5">
                <input class="form-control input-sm" name="nim" value="<?php echo $nim; ?>" readonly>
            </div>
        </div>
        <div class="row my-3">
            <label class="col-md-2">Nama :</label>
            <div class="col-md-5">
                <input type="text" name="nama" class="form-control input-sm" value="<?php echo $nama; ?>" required>
            </div>
        </div>
        <div class="row my-3">
            <label class="col-md-2">Email :</label>
            <div class="col-md-5">
                <input type="text" name="email" class="form-control input-sm" value="<?php echo $email; ?>" required>
            </div>
        </div>
        <div class="row">
            <label class="col-md-2">Password :</label>
            <div class="col-md-5">
                <input type="password" class="form-control" name="password" id="pw" required>
            </div>
        </div>
        <div class="row my-3">
            <label class="col-md-2">Telepon :</label>
            <div class="col-md-5">
                <input type="text" name="telepon" class="form-control input-sm" value="<?php echo $telepon; ?>" required>
            </div>
        </div>
        <div class="row my-3">
            <label class="col-md-2">Alamat :</label>
            <div class="col-md-5">
                <textarea name="alamat" class="form-control input-sm" required><?php echo $alamat; ?></textarea>
            </div>
        </div>
        <div class="row">
            <label class="col-md-2">Jurusan : </label>
            <div class="col-md-5">
                <select class="form-select" id="jurusan" name="jurusan">
                    <option value="">Pilih Jurusan</option>
                    <?php
                     //untuk mendapatkan sql query 
                     $statment_sql = $cn_mysql->prepare("select*from mst_jurusan where is_active=1");
                     //untuk mengeksekusi kode sql 
                     $statment_sql->execute();
                     //untuk menampung hasil eksekusi query
                     $result = $statment_sql->get_result();
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
            <label class="col-md-2">Foto :</label>
            <div class="col-md-5">
                <input type="file" name="foto" class="form-control input-sm">
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
