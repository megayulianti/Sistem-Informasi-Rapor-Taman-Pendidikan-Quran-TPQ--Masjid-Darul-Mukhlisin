<?php
require 'functions.php';

// Ambil semua siswa untuk dropdown
$all_siswa = query("SELECT nis, nama_siswa FROM tb_siswa ORDER BY nama_siswa ASC");

$selected_nis = null;
$selected_siswa = null;
$selected_semester = null;

if (isset($_POST['nis']) && isset($_POST['semester'])) {
    $selected_nis = $_POST['nis'];
    $selected_semester = $_POST['semester'];
    $selected_siswa = query("SELECT * FROM tb_siswa WHERE nis = '$selected_nis'")[0];
}
?>

<div class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header text-center">
          <h1>Cetak Nilai Raport Siswa</h1>
          <hr>
        </div>

        <!-- Form pilih siswa dan semester -->
        <form method="post" class="form-inline text-center" style="margin-bottom: 20px;">
          <label for="nis">Nama Siswa:&nbsp;</label>
          <select name="nis" id="nis" class="form-control" required>
            <option value="">-- Pilih Siswa --</option>
            <?php foreach ($all_siswa as $s) : ?>
              <option value="<?= htmlspecialchars($s['nis']) ?>" <?= ($selected_nis == $s['nis']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($s['nama_siswa']) ?>
              </option>
            <?php endforeach; ?>
          </select>

          &nbsp;&nbsp;

          <label for="semester">Semester:&nbsp;</label>
          <select name="semester" id="semester" class="form-control" required>
            <option value="">-- Pilih Semester --</option>
            <option value="Ganjil" <?= ($selected_semester == "Ganjil") ? 'selected' : '' ?>>Ganjil</option>
            <option value="Genap" <?= ($selected_semester == "Genap") ? 'selected' : '' ?>>Genap</option>
          </select>

          &nbsp;&nbsp;
          <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <!-- Jika sudah pilih siswa dan semester, tampilkan info dan tombol cetak -->
        <?php if ($selected_siswa && $selected_semester): ?>
          <div class="text-center" style="margin-bottom: 20px;">
            <h3>Nama Siswa: <?= htmlspecialchars($selected_siswa['nama_siswa']) ?></h3>
            <h4>NIS: <?= htmlspecialchars($selected_siswa['nis']) ?></h4>
            <h4>Semester: <?= htmlspecialchars($selected_semester) ?></h4>

            <a href="data/data_raport_siswa/laporan_raport_siswa.php?nis=<?= urlencode($selected_siswa['nis']) ?>&semester=<?= urlencode($selected_semester) ?>" target="_blank" class="btn btn-success">
              <i class="fa fa-print"></i> Cetak Nilai Rapor
            </a>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>
