<?php
require 'functions.php';

// === Koneksi Database ===
$conn = mysqli_connect("localhost", "root", "", "raport");

// === AJAX: Ambil siswa berdasarkan kelas dan tahun ajaran ===
if (isset($_POST['get_siswa'])) {
    $id_kelas = $_POST['id_kelas'];
    $thn_ajar = $_POST['thn_ajar'];

    $query = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE id_kelas = '$id_kelas' AND thn_ajaran = '$thn_ajar' ORDER BY nis ASC");

    echo '<option value="">-- Pilih Siswa --</option>';
    while ($siswa = mysqli_fetch_assoc($query)) {
        echo '<option value="' . $siswa['nis'] . '">' . $siswa['nis'] . ' - ' . $siswa['nama_siswa'] . '</option>';
    }
    exit;
}

// === Auto Generate ID Nilai ===
$no = mysqli_query($conn, "SELECT id_nilai FROM tb_nilai ORDER BY id_nilai DESC");
$id_nilai = mysqli_fetch_array($no);
$kode = $id_nilai['id_nilai'] ?? 'Nl000';
$urut = substr($kode, 2, 3);
$tambah = (int) $urut + 1;
$format = "Nl" . str_pad($tambah, 3, '0', STR_PAD_LEFT);

// === Proses Simpan ===
if (isset($_POST['submit'])) {
    if (tambah($_POST) > 0) {
        echo "<script>alert('Data berhasil ditambah!'); document.location.href = 'index.php?page=nilai';</script>";
    } else {
        echo "<script>alert('Data gagal ditambah!'); document.location.href = 'index.php?page=nilai';</script>";
    }
}
?>

<!-- === HTML FORM === -->
<div class="content">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header text-center">
                    <h1>INPUT NILAI SISWA</h1>
                    <hr>
                </div>
                <div class="box-body">
                    <form action="" method="POST">
                        <input type="hidden" name="id_nilai" value="<?= $format; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nama Kelas</label>
                                <select class="form-control" name="kelas1" id="kelas1" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php
                                    $sql_kelas = mysqli_query($conn, "SELECT * FROM tb_kelas");
                                    while ($row_kelas = mysqli_fetch_assoc($sql_kelas)) {
                                        echo '<option value="' . $row_kelas['id_kelas'] . '">' . $row_kelas['nama_kelas'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <br>

                                <label>Tahun Ajaran</label>
                                <select class="form-control" id="tahun_ajaran" name="tahun_ajaran" required>
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    <?php
                                    $ambil = mysqli_query($conn, "SELECT * FROM tb_thn_ajar");
                                    while ($data = mysqli_fetch_assoc($ambil)) {
                                        echo '<option value="' . $data['nama_thn_ajar'] . '">'  . $data['nama_thn_ajar'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <br>

                                <label>Mata Pelajaran</label>
                                <select class="form-control" id="mapel" name="mapel" required>
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    <?php
                                    $ambil = mysqli_query($conn, "SELECT * FROM tb_mapel");
                                    while ($data = mysqli_fetch_assoc($ambil)) {
                                        echo '<option value="' . $data['nama_mapel'] . '">' . $data['nama_mapel'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <br>

                                <label>Nama Siswa</label>
                             <select class="form-control" name="siswa1" id="nis" required>
                                <option value="">-- Pilih Nama Siswa --</option>
                                <?php
                                $ambil = mysqli_query($conn, "SELECT * FROM tb_siswa");
                                while ($data = mysqli_fetch_assoc($ambil)) {
                                    echo '<option value="' . $data['nis'] . '">' . $data['nama_siswa'] . '</option>';
                                }
                                ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="nilai">Nilai</label>
                                <input type="text" name="nilai" id="nilai" class="form-control" required autocomplete="off">
                                <br>

                                <label for="tulisan_nilai">Tulisan Nilai</label>
                                <input type="text" name="tulisan_nilai" id="tulisan_nilai" class="form-control" required autocomplete="off">
                                <br>

                                <!-- ✅ Tambahan: Field Semester -->
                                <label for="semester">Semester</label>
                                <select name="semester" id="semester" class="form-control" required>
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                                <br>

                                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- ✅ jQuery AJAX untuk ambil siswa -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#kelas1, #thn_ajar').on('change', function() {
        var id_kelas = $('#kelas1').val();
        var thn_ajar = $('#thn_ajar').val();

        if (id_kelas !== "" && thn_ajar !== "") {
            $.ajax({
                type: 'POST',
                url: 'nilai.php',
                data: {
                    get_siswa: true,
                    id_kelas: id_kelas,
                    thn_ajar: thn_ajar
                },
                success: function(response) {
                    $('#siswa1').html(response);
                }
            });
        }
    });
});
</script>