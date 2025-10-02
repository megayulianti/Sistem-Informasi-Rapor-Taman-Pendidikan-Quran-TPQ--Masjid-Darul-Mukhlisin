<?php
require 'functions.php';

// Ambil filter tahun ajaran dari POST jika ada
$tahun_ajaran = isset($_POST['tahun_ajaran']) ? $_POST['tahun_ajaran'] : 'all';

// Ambil semua data tahun ajaran untuk dropdown
$tahun_list = query("SELECT * FROM tb_thn_ajar");

// Ambil data kelas siswa sesuai filter
if ($tahun_ajaran == 'all') {
    $kelsis = query("SELECT * FROM tb_kelsis 
        INNER JOIN tb_kelas ON tb_kelsis.id_kelas = tb_kelas.id_kelas 
        INNER JOIN tb_thn_ajar ON tb_kelsis.id_thn_ajar = tb_thn_ajar.id_thn_ajar
        ORDER BY tb_thn_ajar.nama_thn_ajar DESC");
} else {
    $kelsis = query("SELECT * FROM tb_kelsis 
        INNER JOIN tb_kelas ON tb_kelsis.id_kelas = tb_kelas.id_kelas 
        INNER JOIN tb_thn_ajar ON tb_kelsis.id_thn_ajar = tb_thn_ajar.id_thn_ajar
        WHERE tb_kelsis.id_thn_ajar = '$tahun_ajaran'
        ORDER BY tb_thn_ajar.nama_thn_ajar DESC");
}
?>

<div class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header text-center">
                    <h1>DATA KELAS SISWA</h1>
                    <hr>
                </div>

                <!-- Filter Tahun Ajaran -->
                <form method="post" class="form-inline text-center" style="margin-bottom: 20px;">
                    <label for="tahun_ajaran">Filter Tahun Ajaran:</label>
                    <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" onchange="this.form.submit()">
                        <option value="all" <?= $tahun_ajaran == 'all' ? 'selected' : '' ?>>-- Semua Tahun Ajaran --</option>
                        <?php foreach ($tahun_list as $t): ?>
                            <option value="<?= $t['id_thn_ajar'] ?>" <?= $tahun_ajaran == $t['id_thn_ajar'] ? 'selected' : '' ?>>
                                <?= $t['nama_thn_ajar'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <!-- Tombol Cetak PDF -->
                <form method="post" action="data/Laporan/laporan_kelsis.php" target="_blank" style="text-align:center; margin-bottom: 20px;">
                    <input type="hidden" name="tahun_ajaran" value="<?= $tahun_ajaran ?>">
                    <button type="submit" class="btn btn-danger"><i class="fa fa-print"></i> Cetak PDF</button>
                </form>

                <!-- Tabel -->
                <div class="table-responsive">
                    <table id="dataTables-example" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">ID</th>
                                <th class="text-center">NIS</th>
                                <th class="text-center">Nama Siswa</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Tahun Ajaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($kelsis as $row): ?>
                                <tr>
                                    <td class="text-center"><?= $i++; ?></td>
                                    <td class="text-center"><?= $row["id_kelsis"]; ?></td>
                                    <td class="text-center"><?= $row["nis"]; ?></td>
                                    <td class="text-center"><?= $row["nama_siswa"]; ?></td>
                                    <td class="text-center"><?= $row["nama_kelas"]; ?></td>
                                    <td class="text-center"><?= $row["nama_thn_ajar"]; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div> <!-- /.table-responsive -->

            </div> <!-- /.box -->
        </div> <!-- /.col -->
    </div> <!-- /.row -->
</div> <!-- /.content -->
