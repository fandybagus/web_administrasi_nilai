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
                        <th>NIP</th>
                        <th>Nama </th>
                        <th>Telepon</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    //untuk mendapatkan sql query 
                    $statment_sql = $cn_mysql->prepare("select*from mst_dosen where is_active=1 ORDER BY nip_dosen DESC");
                    //untuk mengeksekusi kode sql 
                    $statment_sql->execute();
                    //untuk menampung hasil eksekusi query
                    $result = $statment_sql->get_result();
                    while ($data = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td class="col-md-1"><?php echo $no; ?></td>
                            <td class="col-md-2"><?php echo $data['nip_dosen']; ?></td>
                            <td class="col-md-4"><?php echo $data['nama_dosen']; ?></td>
                            <td class="col-md-3"><?php echo $data['telp_dosen']; ?></td>
                            <td>
                                <a href="?modul=<?php echo $_GET['modul']; ?>&action=edit&id=<?php echo $data['nip_dosen']; ?>" class="btn btn-primary" title="detail data"><i class="bi bi-pencil-fill mx-2"></i></i><a>
                                <a href="?modul=<?php echo $_GET['modul']; ?>&action=delete&id=<?php echo $data['nip_dosen']; ?>" class="btn btn-danger" title="hapus data"><i class="bi bi-trash-fill "></i></a>
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
        //variabel untuk tambah data
        $process = "add"; //variabel ini digunakan untuk membedakan ketika memprocess data baik simpan data 
        $nip = generate_no_dosen();
        $nama = "";
        $email="";
        $password="";
        $telepon="";
        $alamat="";

    } else if ($_GET['action'] == "edit") {
        // variabel untuk ubah data
        $process = "edit"; // variabel ini digunakan untuk membedakan ketika memprocess data baik ubah data
        // proses mengambil data
        $keyid = $_GET['id']; // menampung variabel id yg di URL
        // untuk mendapatkan sql query 
        $statment_sql = $cn_mysql->prepare("SELECT * FROM mst_dosen WHERE nip_dosen = ?");
        $statment_sql->bind_param("s", $keyid); // "s" indicates the type is string
        // untuk mengeksekusi kode sql 
        $statment_sql->execute();
        $result = $statment_sql->get_result();
        $data = $result->fetch_assoc();
        $kode_dosen = $data['nip_dosen'];
        $nama = $data['nama_dosen'];
        $email = $data['email_dosen'];
        $telepon = $data['telp_dosen'];
        $alamat = $data['alamat_dos']; 
    
    } else if ($_GET['action'] == "delete") {
        header("location: modul/datadosenproses.php?proses=delete&id=" . $_GET['id'] . "");
    }

?>

    <!-- tampil form input/edit -->
    <form action="modul/datadosenproses.php" method="post">
    <input type="hidden" name="proses" value="<?php echo $process; ?>">
    <input type="hidden" name="keyid" value="<?php echo $keyid; ?>">
    <input type="hidden" name="createdby" value="<?php echo $_SESSION['loginname']; ?>">
    <div class="row my-3">
        <label class="col-md-2">NIP</label>
        <div class="col-md-5">
            <input class="form-control input-sm" name="nip"  value="<?php echo generate_no_dosen(); ?>" readonly>
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
