<?php
require 'functions.php'; // Pastikan functions.php memuat koneksi dan fungsi query()

$periode = isset($_POST['periode']) ? $_POST['periode'] : 'all';

// Ambil semua periode masuk unik
$periode_list = query("SELECT DISTINCT periode_masuk FROM tb_siswa ORDER BY periode_masuk DESC");

// Ambil data siswa sesuai filter
if ($periode == 'all') {
    $siswa = query("SELECT * FROM tb_siswa ORDER BY periode_masuk DESC, nama_siswa ASC");
} else {
    $siswa = query("SELECT * FROM tb_siswa WHERE periode_masuk = '$periode' ORDER BY nama_siswa ASC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Siswa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>

<div class="container" style="margin-top: 30px;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Laporan Data Siswa</h4>
        </div>
        <div class="panel-body">

            <!-- FORM FILTER PERIODE -->
            <form action="" method="post" class="form-inline">
                <div class="form-group">
                    <label>Periode Masuk: </label>
                    <select class="form-control" name="periode">
                        <option value="all" <?= $periode == 'all' ? 'selected' : '' ?>>ALL</option>
                        <?php foreach ($periode_list as $p): ?>
                            <option value="<?= $p['periode_masuk'] ?>" <?= $periode == $p['periode_masuk'] ? 'selected' : '' ?>>
                                <?= $p['periode_masuk'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="tampilkan" class="btn btn-primary">Tampilkan Data</button>
            </form>
            <br>

            <!-- FORM CETAK PDF -->
            <form action="data/Laporan/laporan_siswa.php" method="post" target="_blank" class="form-inline">
                <div class="form-group">
                    <label>Cetak Periode: </label>
                    <select class="form-control" name="periode">
                        <option value="all">ALL</option>
                        <?php foreach ($periode_list as $p): ?>
                            <option value="<?= $p['periode_masuk'] ?>"><?= $p['periode_masuk'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="cetak" class="btn btn-danger">Cetak PDF</button>
            </form>

            <br>

            <!-- TABEL DATA SISWA -->
            <div class="table-responsive">
                <table class="table table-bordered" id="siswa">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>No Ortu</th>
                            <th>Alamat</th>
                            <th>JK</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Agama</th>
                            <th>Periode Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($siswa)) : ?>
                            <?php $no = 1; foreach ($siswa as $data): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= $data['nis'] ?></td>
                                <td><?= $data['nama_siswa'] ?></td>
                                <td class="text-center"><?= $data['no_hp_ortu'] ?></td>
                                <td><?= $data['alamat'] ?></td>
                                <td class="text-center"><?= $data['jk'] ?></td>
                                <td><?= $data['tempat_lahir'] ?></td>
                                <td><?= $data['tanggal_lahir'] ?></td>
                                <td class="text-center"><?= $data['agama'] ?></td>
                                <td class="text-center"><?= $data['periode_masuk'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- JS Bootstrap & jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
