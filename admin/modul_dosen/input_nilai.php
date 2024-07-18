<?php
require_once('../../config/koneksidb.php');
require_once('../../config/general.php');
session_start();

// Ambil ID mata kuliah dari URL
$idMatkul = isset($_GET['id']) ? $_GET['id'] : 0;

// Query untuk mendapatkan detail mata kuliah, jurusan, dan nip dosen berdasarkan ID
$query = "SELECT mk.matakuliah, j.nm_jurusan, j.idjurusan, d.nip_dosen 
          FROM mst_matakuliah mk 
          JOIN mst_jurusan j ON mk.idjurusan = j.idjurusan 
          JOIN mst_dosen d ON mk.kode_dosen = d.nip_dosen 
          WHERE mk.idmatkul = ?";
$stmt = $cn_mysql->prepare($query);
$stmt->bind_param('i', $idMatkul);
$stmt->execute();
$result = $stmt->get_result();

$mataKuliah = '';
$jurusan = '';
$idJurusan = 0;
$nipDosen = '';

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $mataKuliah = $row['matakuliah'];
    $jurusan = $row['nm_jurusan'];
    $idJurusan = $row['idjurusan'];
    $nipDosen = $row['nip_dosen'];
}

$createdBy = isset($_SESSION['userlogin']) ? $_SESSION['userlogin'] : 'Unknown';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../../assets/style.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container vertical-center">
        <div class="col-md-8 mx-auto">
            <div class="card mt-5">
                <div class="card-header">
                    Form Input
                </div>
                <div class="card-body">
                    <form action="inputnilaiproses.php" method="post">
                        <input type="hidden" name="mataKuliah" value="<?php echo $mataKuliah; ?>">
                        <input type="hidden" name="idmatkul" value="<?php echo $idMatkul; ?>">
                        <input type="hidden" name="idjurusan" value="<?php echo $idJurusan; ?>">
                        <input type="hidden" name="nip_dosen" value="<?php echo $nipDosen; ?>">
                        <input type="hidden" name="created_by" value="<?php echo $createdBy; ?>">
                        
                        <div class="form-group row">
                            <label for="mataKuliah" class="col-sm-3 col-form-label text-right">Mata Kuliah</label>
                            <div class="col-sm-9 mb-3">
                                <input type="text" class="form-control" id="mataKuliah" name="mataKuliah" value="<?php echo $mataKuliah; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jurusan" class="col-sm-3 col-form-label text-right">Jurusan</label>
                            <div class="col-sm-9 mb-3">
                                <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?php echo $jurusan; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="namaMahasiswa" class="col-sm-3 col-form-label text-right">Nama Mahasiswa</label>
                            <div class="col-sm-9 mb-3"> 
                                <select class="form-control" id="namaMahasiswa" name="namaMahasiswa" required>
                                    <?php
                                    // Query untuk mendapatkan daftar mahasiswa berdasarkan jurusan
                                    $query = "SELECT nim, nama_mhs FROM mst_mahasiswa WHERE idjurusan = ?";
                                    $stmt = $cn_mysql->prepare($query);
                                    $stmt->bind_param('i', $idJurusan);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    // Memeriksa apakah query menghasilkan hasil
                                    if ($result->num_rows > 0) {
                                        // Menampilkan data mahasiswa dalam dropdown
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['nim'] . "'>" . $row['nama_mhs'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="nilaiFormatif" class="col-sm-6 col-form-label">Nilai Formatif (10%)</label>
                            <div class="col-sm-6 mb-3">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="nilaiFormatif1" name="nilaiFormatif1" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="poinformatif" name="poinformatif" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nilaiPerilaku" class="col-sm-6 col-form-label">Nilai Perilaku (10%)</label>
                            <div class="col-sm-6 mb-3">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="nilaiPerilaku" name="nilaiPerilaku" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="poinperilaku" name="poinperilaku" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nilaiTugas" class="col-sm-6 col-form-label">Nilai Tugas (20%)</label>
                            <div class="col-sm-6 mb-3">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="nilaiTugas" name="nilaiTugas" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="pointugas" name="pointugas" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nilaiUTS" class="col-sm-6 col-form-label">Nilai UTS (20%)</label>
                            <div class="col-sm-6 mb-3">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="nilaiUTS" name="nilaiUTS" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="nilaiuts" name="nilaiuts" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nilaiUAS" class="col-sm-6 col-form-label">Nilai UAS (40%)</label>
                            <div class="col-sm-6 mb-3">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="nilaiUAS" name="nilaiUAS" onchange="updateNilai()">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="nilaiuas" name="nilaiuas" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary float-end mx-1">Simpan</button>
                                    <button type="button" class="btn btn-secondary float-end mx-2" onclick="history.back()">Batal</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../../assets/validasi.js"></script>

    <script>
        $(document).ready(function() {
            function updateNilai() {
                let nilaiFormatif1 = parseFloat($('#nilaiFormatif1').val()) || 0;
                let nilaiPerilaku = parseFloat($('#nilaiPerilaku').val()) || 0;
                let nilaiTugas = parseFloat($('#nilaiTugas').val()) || 0;
                let nilaiUTS = parseFloat($('#nilaiUTS').val()) || 0;
                let nilaiUAS = parseFloat($('#nilaiUAS').val()) || 0;

                let totalFormatif = nilaiFormatif1 * 0.1;
                let totalPerilaku = nilaiPerilaku * 0.1;
                let totalTugas = nilaiTugas * 0.2;
                let totalUTS = nilaiUTS * 0.2;
                let totalUAS = nilaiUAS * 0.4;

                $('#poinformatif').val(totalFormatif);
                $('#poinperilaku').val(totalPerilaku);
                $('#pointugas').val(totalTugas);
                $('#nilaiuts').val(totalUTS);
                $('#nilaiuas').val(totalUAS);
            }

            $('#nilaiFormatif1, #nilaiPerilaku, #nilaiTugas, #nilaiUTS, #nilaiUAS').on('change', function() {
                updateNilai();
            });
        });
    </script>
</body>

</html>
