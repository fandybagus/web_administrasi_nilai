<?php
require_once("../../config/koneksidb.php");
require_once("../../config/general.php");

// Memeriksa apakah 'proses' ada di dalam $_POST atau $_GET
if (isset($_POST['proses'])) {
    $proses = $_POST['proses'];
} elseif (isset($_GET['proses'])) {
    $proses = $_GET['proses'];
} else {
    // Jika 'proses' tidak ada dalam POST atau GET, berikan pesan kesalahan atau arahkan ke halaman yang sesuai
    notif("Proses tidak valid");
    back("../staff.php?modul=datamahasiswa");
    exit;
}

if ($proses == "add") {
    // Retrieve form data for adding
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $idjurusan = $_POST['jurusan'];
    $createdby = $_POST['createdby'];

    // Handle file upload
    $foto_folder = null;
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_size = $_FILES['foto']['size'];
        $foto_ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
        $allowed_ext = array('pdf', 'png', 'jpg', 'jpeg');

        // Validate file size and extension
        if ($foto_size > 5242880) { // 5MB in bytes
            notif("Ukuran file tidak boleh lebih dari 5MB");
            // Debugging line
            error_log("File size exceeds 5MB");
            back("../staff.php?modul=datamahasiswa");
            exit;
        }

        if (!in_array($foto_ext, $allowed_ext)) {
            notif("Jenis file yang diperbolehkan hanya PDF, PNG, JPG, dan JPEG");
            // Debugging line
            error_log("File type not allowed: " . $foto_ext);
            back("../staff.php?modul=datamahasiswa");
            exit;
        }

        $foto_folder = "../../assets/img_mhs/" . $foto;

        // Move the uploaded file to the desired folder
        if (!move_uploaded_file($foto_tmp, $foto_folder)) {
            $foto_folder = null;
        }
    }

    // Set is_active to 1
    $is_active = 1;

    // Insert data into the database
    $statement_sql = $cn_mysql->prepare(
        "INSERT INTO mst_mahasiswa (nim, nama_mhs, email_mhs, password, telp_mhs, alamat_mhs, idjurusan, foto, is_active) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $statement_sql->bind_param("ssssssssi", $nim, $nama, $email, $password, $telepon, $alamat, $idjurusan, $foto_folder, $is_active);

    if ($statement_sql->execute()) {
        notif("Data berhasil tersimpan");
        // Debugging line
        error_log("Data successfully inserted");
        back("../staff.php?modul=datamahasiswa");
    } else {
        notif("Data gagal tersimpan");
        // Debugging line
        error_log("Data insertion failed: " . $statement_sql->error);
        back("../staff.php?modul=datamahasiswa");
    }
} elseif ($proses == "edit") {
    // Retrieve form data for editing
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $idjurusan = $_POST['jurusan'];
    $modifiedby = $_POST['modifiedby'];

    // Handle file upload
    $foto_folder = null;
    $update_query = "UPDATE mst_mahasiswa SET 
                        nama_mhs = ?, 
                        email_mhs = ?, 
                        telp_mhs = ?, 
                        alamat_mhs = ?, 
                        idjurusan = ?";
    
    // Check if a new photo is uploaded
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_size = $_FILES['foto']['size'];
        $foto_ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
        $allowed_ext = array('pdf', 'png', 'jpg', 'jpeg');

        // Validate file size and extension
        if ($foto_size > 5242880) { // 5MB in bytes
            notif("Ukuran file tidak boleh lebih dari 5MB");
            // Debugging line
            error_log("File size exceeds 5MB");
            back("../staff.php?modul=datamahasiswa");
            exit;
        }

        if (!in_array($foto_ext, $allowed_ext)) {
            notif("Jenis file yang diperbolehkan hanya PDF, PNG, JPG, dan JPEG");
            // Debugging line
            error_log("File type not allowed: " . $foto_ext);
            back("../staff.php?modul=datamahasiswa");
            exit;
        }

        $foto_folder = "../../assets/img_mhs/" . $foto;

        // Move the uploaded file to the desired folder
        if (!move_uploaded_file($foto_tmp, $foto_folder)) {
            $foto_folder = null;
        }

        // Append foto field to update query
        $update_query .= ", foto = ?";
    }

    // Append WHERE clause to update query
    $update_query .= " WHERE nim = ?";

    // Prepare and bind parameters
    $statement_sql = $cn_mysql->prepare($update_query);
    
    if ($foto_folder) {
        $statement_sql->bind_param("sssssss", $nama, $email, $telepon, $alamat, $idjurusan, $foto_folder, $nim);
    } else {
        $statement_sql->bind_param("ssssss", $nama, $email, $telepon, $alamat, $idjurusan, $nim);
    }

    // Execute statement
    if ($statement_sql->execute()) {
        notif("Data berhasil diperbarui");
        // Debugging line
        error_log("Data successfully updated");
        back("../staff.php?modul=datamahasiswa");
    } else {
        notif("Data gagal diperbarui");
        // Debugging line
        error_log("Data update failed: " . $statement_sql->error);
        back("../staff.php?modul=datamahasiswa");
    }
} elseif ($proses == "delete" && isset($_GET['id'])) {
    $nim_to_delete = $_GET['id'];

    $statement_sql = $cn_mysql->prepare("DELETE FROM mst_mahasiswa WHERE nim = ?");
    $statement_sql->bind_param("s", $nim_to_delete);
    
    if ($statement_sql->execute()) {
        notif("Data berhasil dihapus");
        back("../staff.php?modul=datamahasiswa");
    } else {
        notif("Data gagal dihapus: " . $statement_sql->error);
        back("../staff.php?modul=datamahasiswa");
    }
    $statement_sql->close();
} else {
    // Jika 'proses' tidak valid atau tidak ada 'id' untuk penghapusan, berikan pesan kesalahan atau arahkan ke halaman yang sesuai
    notif("Proses tidak valid");
    back("../staff.php?modul=datamahasiswa");
}

?>
