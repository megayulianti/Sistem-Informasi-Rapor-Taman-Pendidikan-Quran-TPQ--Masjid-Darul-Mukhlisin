<?php
require 'functions.php';

// Ambil filter dari form
$filter_kelas = isset($_POST['kelas']) ? $_POST['kelas'] : 'all';
$filter_tahun = isset($_POST['tahun']) ? $_POST['tahun'] : 'all';
$filter_semester = isset($_POST['semester']) ? $_POST['semester'] : 'all';

// Ambil data untuk dropdown
$kelas_list = query("SELECT * FROM tb_kelas ORDER BY nama_kelas ASC");
$tahun_list = query("SELECT DISTINCT tahun_ajaran FROM tb_nilai ORDER BY tahun_ajaran DESC");
$semester_list = query("SELECT DISTINCT semester FROM tb_nilai ORDER BY semester ASC");

// Query data nilai dengan filter
$sql = "SELECT 
    s.nis, s.nama_siswa, k.nama_kelas, n.tahun_ajaran, n.semester,
    MAX(CASE WHEN n.mapel = 'Tilawah' THEN n.nilai END) AS tilawah,
    MAX(CASE WHEN n.mapel = 'Khat/Menulis' THEN n.nilai END) AS khat_menulis,
    MAX(CASE WHEN n.mapel = 'Ilmu Tajwid' THEN n.nilai END) AS ilmu_tajwid,
    MAX(CASE WHEN n.mapel = 'Tahfidz/Hafalan' THEN n.nilai END) AS tahfidz_hafalan,
    MAX(CASE WHEN n.mapel = 'Nagham/Irama' THEN n.nilai END) AS nagham_irama,
    MAX(CASE WHEN n.mapel = 'Aqidah/Akhlak' THEN n.nilai END) AS aqidah_akhlak,
    MAX(CASE WHEN n.mapel = 'Fiqih' THEN n.nilai END) AS fiqih,
    MAX(CASE WHEN n.mapel = 'Tarikh' THEN n.nilai END) AS tarikh,
    MAX(CASE WHEN n.mapel = 'Hafalan Doa' THEN n.nilai END) AS hafalan_doa,
    MAX(CASE WHEN n.mapel = 'Praktek Ibadah' THEN n.nilai END) AS praktek_ibadah,
    MAX(CASE WHEN n.mapel = 'Didikan Subuh' THEN n.nilai END) AS didikan_subuh
FROM tb_nilai n
JOIN tb_siswa s ON n.nis = s.nis
JOIN tb_kelas k ON n.id_kelas = k.id_kelas
WHERE 1=1";


if ($filter_kelas != 'all') {
  $sql .= " AND n.id_kelas = '$filter_kelas'";
}
if ($filter_tahun != 'all') {
  $sql .= " AND n.tahun_ajaran = '$filter_tahun'";
}
if ($filter_semester != 'all') {
  $sql .= " AND n.semester = '$filter_semester'";
}

$sql .= " GROUP BY s.nis, s.nama_siswa, k.nama_kelas, n.tahun_ajaran, n.semester";
$nilai = query($sql) ?? [];
?>

<div class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header text-center">
          <h1>DATA NILAI SISWA</h1>
          <hr>
        </div>

        <!-- Filter Form -->
        <form method="post" class="form-inline text-center" style="margin-bottom: 20px;">
          <label>Kelas:</label>
          <select name="kelas" class="form-control" required>
            <option value="all">-- Semua --</option>
            <?php foreach ($kelas_list as $k): ?>
              <option value="<?= $k['id_kelas'] ?>" <?= $filter_kelas == $k['id_kelas'] ? 'selected' : '' ?>>
                <?= $k['nama_kelas'] ?>
              </option>
            <?php endforeach; ?>
          </select>

          <label style="margin-left: 10px;">Tahun Ajaran:</label>
          <select name="tahun" class="form-control">
            <option value="all">-- Semua --</option>
            <?php foreach ($tahun_list as $t): ?>
              <option value="<?= $t['tahun_ajaran'] ?>" <?= $filter_tahun == $t['tahun_ajaran'] ? 'selected' : '' ?>>
                <?= $t['tahun_ajaran'] ?>
              </option>
            <?php endforeach; ?>
          </select>

          <label style="margin-left: 10px;">Semester:</label>
          <select name="semester" class="form-control">
            <option value="all">-- Semua --</option>
            <?php foreach ($semester_list as $s): ?>
              <option value="<?= $s['semester'] ?>" <?= $filter_semester == $s['semester'] ? 'selected' : '' ?>>
                <?= $s['semester'] ?>
              </option>
            <?php endforeach; ?>
          </select>

          <button type="submit" class="btn btn-primary" style="margin-left: 10px;">
            Tampilkan
          </button>
        </form>

        <!-- Tabel Nilai -->
        <div class="table-responsive">
          <table id="dataTables-example" class="table table-striped table-bordered table-hover">
          <thead>
  <tr>
    <th class="text-center">NO</th>
    <th class="text-center">NIS</th>
    <th class="text-center">Nama Siswa</th>
    <th class="text-center">Kelas</th>
    <th class="text-center">Tahun Ajaran</th>
    <th class="text-center">Semester</th>
    <th class="text-center">Tilawah</th>
    <th class="text-center">Khat/Menulis</th>
    <th class="text-center">Ilmu Tajwid</th>
    <th class="text-center">Tahfidz/Hafalan</th>
    <th class="text-center">Nagham/Irama</th>
    <th class="text-center">Aqidah/Akhlak</th>
    <th class="text-center">Fiqih</th>
    <th class="text-center">Tarikh</th>
    <th class="text-center">Hafalan Do'a</th>
    <th class="text-center">Praktek Ibadah</th>
    <th class="text-center">Didikan Subuh</th>
    <th class="text-center">Jumlah</th>
    <th class="text-center">Rata-rata</th>
    <th class="text-center">Keterangan</th>
    
  </tr>
</thead>

<tbody>
<?php if (is_array($nilai) && count($nilai) > 0): ?>
  

  <?php
$total_tilawah = 0;
$total_menulis = 0;
$total_tajwid = 0;
$total_hafalan = 0;
$total_nagham = 0;
$total_akhlak = 0;
$total_fiqih = 0;
$total_tarikh = 0;
$total_doa = 0;
$total_ibadah = 0;
$total_didikan = 0;
$total_siswa = 0;
?>

    <?php $i = 1; foreach ($nilai as $row): ?>
      <?php
    $nilai_mapel = [
      $row["tilawah"],
      $row["khat_menulis"],
      $row["ilmu_tajwid"],
      $row["tahfidz_hafalan"],
      $row["nagham_irama"],
      $row["aqidah_akhlak"],
      $row["fiqih"],
      $row["tarikh"],
      $row["hafalan_doa"],
      $row["praktek_ibadah"], 
      $row["didikan_subuh"],
    ];

    $jumlah_nilai = array_sum($nilai_mapel);
    $jumlah_mapel = count(array_filter($nilai_mapel, fn($v) => $v !== null));
    $rata2_nilai = $jumlah_mapel ? round($jumlah_nilai / $jumlah_mapel, 2) : 0;
    $keterangan = ($rata2_nilai >= 60) ? 'Lulus' : 'Tidak Lulus';
  ?>
    <tr>
      <td class="text-center"><?= $i++; ?></td>
      <td class="text-center"><?= $row["nis"]; ?></td>
      <td class="text-center"><?= $row["nama_siswa"]; ?></td>
      <td class="text-center"><?= $row["nama_kelas"]; ?></td>
      <td class="text-center"><?= $row["tahun_ajaran"]; ?></td>
      <td class="text-center"><?= $row["semester"]; ?></td>
      <td class="text-center"><?= $row["tilawah"]; ?></td>
      <td class="text-center"><?= $row["khat_menulis"]; ?></td>
      <td class="text-center"><?= $row["ilmu_tajwid"]; ?></td>
      <td class="text-center"><?= $row["tahfidz_hafalan"]; ?></td>
      <td class="text-center"><?= $row["nagham_irama"]; ?></td>
      <td class="text-center"><?= $row["aqidah_akhlak"]; ?></td>
      <td class="text-center"><?= $row["fiqih"]; ?></td>
      <td class="text-center"><?= $row["tarikh"]; ?></td>
      <td class="text-center"><?= $row["hafalan_doa"]; ?></td>
      <td class="text-center"><?= $row["praktek_ibadah"]; ?></td>      
      <td class="text-center"><?= $row["didikan_subuh"]; ?></td>
      <td class="text-center"><?= $jumlah_nilai; ?></td>
      <td class="text-center"><?= $rata2_nilai; ?></td>
      <td class="text-center"><?= $keterangan; ?></td>

    </tr>
    <?php

  $total_tilawah += $row["tilawah"];
  $total_menulis += $row["khat_menulis"];
  $total_tajwid += $row["ilmu_tajwid"];
  $total_hafalan += $row["hafalan_doa"];
  $total_nagham += $row["nagham_irama"];
  $total_akhlak += $row["aqidah_akhlak"];
  $total_fiqih += $row["fiqih"];
  $total_tarikh += $row["tarikh"];
  $total_doa += $row["hafalan_doa"];
  $total_ibadah += $row["praktek_ibadah"];
  $total_didikan += $row["didikan_subuh"];
  $total_siswa++;
?>
    <?php endforeach; ?>
    <tr style="font-weight: bold; background-color: #f0f0f0;">
  <td class="text-center" colspan="6">Jumlah</td>
  <td class="text-center"><?= $total_tilawah; ?></td>
  <td class="text-center"><?= $total_menulis; ?></td>
  <td class="text-center"><?= $total_tajwid; ?></td>
  <td class="text-center"><?= $total_hafalan; ?></td>
  <td class="text-center"><?= $total_nagham; ?></td>
  <td class="text-center"><?= $total_akhlak; ?></td>
  <td class="text-center"><?= $total_fiqih; ?></td>
  <td class="text-center"><?= $total_tarikh; ?></td>
  <td class="text-center"><?= $total_doa; ?></td>
  <td class="text-center"><?= $total_ibadah; ?></td>
  <td class="text-center"><?= $total_didikan; ?></td>
</tr>
    <tr style="font-weight: bold; background-color: #f0f0f0;">
  <td class="text-center" colspan="6">Rata-rata</td>
  <td class="text-center"><?= round($total_tilawah / $total_siswa, 2); ?></td>
  <td class="text-center"><?= round($total_menulis / $total_siswa, 2); ?></td>
  <td class="text-center"><?= round($total_tajwid / $total_siswa, 2); ?></td>
  <td class="text-center"><?= round($total_hafalan / $total_siswa, 2); ?></td>
  <td class="text-center"><?= round($total_nagham / $total_siswa, 2); ?></td>
  <td class="text-center"><?= round($total_akhlak / $total_siswa, 2); ?></td>
  <td class="text-center"><?= round($total_fiqih / $total_siswa, 2); ?></td>
  <td class="text-center"><?= round($total_tarikh / $total_siswa, 2); ?></td>
  <td class="text-center"><?= round($total_doa / $total_siswa, 2); ?></td>
  <td class="text-center"><?= round($total_ibadah / $total_siswa, 2); ?></td>
  <td class="text-center"><?= round($total_didikan / $total_siswa, 2); ?></td>
</tr>

  <?php else: ?>
    <tr>
      <td colspan="12" class="text-center">Data tidak ditemukan.</td>
    </tr>
  <?php endif; ?>
</tbody>

          </table>
        </div>

        <!-- Tombol Export PDF -->
       <!-- Form Cetak PDF -->
<!-- Form Cetak PDF -->
<form method="POST" action="data/Laporan/laporan_nilai.php" target="_blank">
  <input type="hidden" name="kelas" value="<?= $filter_kelas ?>">
  <input type="hidden" name="semester" value="<?= $filter_semester ?>">
  <input type="hidden" name="tahun_ajaran" value="<?= $filter_tahun ?>">
  <button type="submit" class="btn btn-danger">
    Cetak PDF
  </button>
</form>

        <?php include "modal_nilai.php"; ?>
      </div>
    </div>
  </div>
</div>
