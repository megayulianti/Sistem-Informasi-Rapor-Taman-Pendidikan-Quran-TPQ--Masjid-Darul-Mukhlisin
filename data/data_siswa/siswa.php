<?php
require 'functions.php';

$siswa = query("SELECT * FROM tb_siswa");
?>

<div class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header text-center">
          <h1>DATA SISWA</h1>
          <hr>
          <a href="?page=siswa&aksi=tambah">
            <button type="button" class="btn btn-primary">
              <i class="fa fa-plus"> </i> Tambah Data
            </button>
          </a>
        </div>

        <div class="table-responsive">
          <table id="dataTables-example" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center">NO</th>
                <th class="text-center">NIS</th>
                <th class="text-center">Nama Siswa</th>
                <th class="text-center">No Ortu</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Jenis Kelamin</th>
                <th class="text-center">Tempat Lahir</th>
                <th class="text-center">Tanggal Lahir</th>
                <th class="text-center">Agama</th>
                <th class="text-center">Periode Masuk</th>
                <th class="text-center">Foto</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php foreach ($siswa as $row): ?>
                <tr>
                  <td class="text-center"><?= $i; ?></td>
                  <td class="text-center"><?= $row["nis"]; ?></td>
                  <td class="text-center"><?= $row["nama_siswa"]; ?></td>
                  <td class="text-center"><?= $row["no_hp_ortu"]; ?></td>
                  <td class="text-center"><?= $row["alamat"]; ?></td>
                  <td class="text-center"><?= $row["jk"]; ?></td>
                  <td class="text-center"><?= $row["tempat_lahir"]; ?></td>
                  <td class="text-center"><?= $row["tanggal_lahir"]; ?></td>
                  <td class="text-center"><?= $row["agama"]; ?></td>
                  <td class="text-center"><?= $row["periode_masuk"]; ?></td>
                  <td class="text-center"><?= $row["foto"]; ?></td>
                  <td class="text-center">
                    <a href="?page=siswa&aksi=ubah&nis=<?= $row["nis"]; ?>" class="btn btn-success btn-xs">Ubah</a>
                    <a href="?page=siswa&aksi=hapus&nis=<?= $row["nis"]; ?>" onclick="return confirm('Yakin data ingin dihapus!!!');" class="btn btn-danger btn-xs">Hapus</a>
                  </td>
                </tr>
                <?php $i++; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<br><br>
