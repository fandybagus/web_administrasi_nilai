<?php
function notif($pesan)
{
    //untuk menyisipkan file di dalam javascript harus di antara tag script
    echo "<script>alert('$pesan');</script>";
}

//cara menyisipkan tag link html ke 
function back($page)
{
    header("Location: " . $page);
    exit();
}



function generate_no_dosen() {
    // Ambil data NIP dosen yang paling terakhir
    $statement_sql = $GLOBALS['cn_mysql']->prepare("SELECT nip_dosen FROM mst_dosen ORDER BY nip_dosen DESC LIMIT 1");
    $statement_sql->execute(); 
    $result = $statement_sql->get_result();
    $cekdata = $result->num_rows; // Untuk pengecekan apakah ada data atau tidak di tabel, hasilnya berupa angka
    
    $tahun_sekarang = date('Y');
    
    if ($cekdata > 0) {
        // Jika sudah ada data di tabel mst_dosen
        $data = $result->fetch_assoc();
        $code_lama = $data['nip_dosen'];
        $tahun_ditabel = substr($code_lama, 3, 4); // Ambil tahun dari NIP yang ada (format NIPYYYYXXX)
        
        if ($tahun_ditabel == $tahun_sekarang) {
            $nourut = (int)substr($code_lama, 7, 3) + 1; // Ambil nomor urut dan tambahkan 1
            $nourut_baru = str_pad($nourut, 3, "0", STR_PAD_LEFT); // Tambahkan leading zeros jika perlu
        } else {
            // Jika tahun telah berubah, reset nomor urut ke 001
            $nourut_baru = "001";
        }
    } else {
        // Jika belum ada data di tabel mst_dosen
        $nourut_baru = "001";
    }
    
    // Generate NIP baru dengan format NIPYYYYXXX
    $code_dosen = "NIP" . $tahun_sekarang . $nourut_baru;
    
    return $code_dosen;
}

function generate_no_mhs() {
    // Ambil data NIM mahasiswa yang paling terakhir
    $statement_sql = $GLOBALS['cn_mysql']->prepare("SELECT nim FROM mst_mahasiswa ORDER BY nim DESC LIMIT 1");
    $statement_sql->execute(); 
    $result = $statement_sql->get_result();
    $cekdata = $result->num_rows; // Untuk pengecekan apakah ada data atau tidak di tabel, hasilnya berupa angka
    
    $tahun_sekarang = date('Y');
    
    if ($cekdata > 0) {
        // Jika sudah ada data di tabel mst_mahasiswa
        $data = $result->fetch_assoc();
        $code_lama = $data['nim'];
        $tahun_ditabel = substr($code_lama, 3, 4); // Ambil tahun dari NIM yang ada (format NIMYYYYXXX)
        
        if ($tahun_ditabel == $tahun_sekarang) {
            $nourut = (int)substr($code_lama, 7, 4) + 1; // Ambil nomor urut dan tambahkan 1
            $nourut_baru = str_pad($nourut, 4, "0", STR_PAD_LEFT); // Tambahkan leading zeros jika perlu
        } else {
            // Jika tahun telah berubah, reset nomor urut ke 0001
            $nourut_baru = "0001";
        }
    } else {
        // Jika belum ada data di tabel mst_mahasiswa
        $nourut_baru = "0001";
    }
    
    // Generate NIM baru dengan format NIMYYYYXXX
    $code_mhs = "NIM" . $tahun_sekarang . $nourut_baru;
    
    return $code_mhs;
}

function generate_tahunkul() {
    // Ambil data NIM mahasiswa yang paling terakhir
    $statement_sql = $GLOBALS['cn_mysql']->prepare("SELECT idmatkul FROM mst_matakuliah ORDER BY idmatkul DESC LIMIT 1");
    $statement_sql->execute(); 
    
    $tahun_sekarang = date('Y');
    
    $code_matkul = $tahun_sekarang;
    
    return $code_matkul;
}

?>

