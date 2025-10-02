<?php
require 'functions.php';

// Ambil data dari URL
$nis = $_GET["nis"];

// Ambil data siswa berdasarkan NIS
$siswa = query("SELECT * FROM tb_siswa WHERE nis = '$nis'")[0];

// Hitung periode otomatis (misal: 2025/2026)
$tahun_sekarang = date('Y');
$tahun_depan = $tahun_sekarang + 1;
$periode_otomatis = "$tahun_sekarang/$tahun_depan";

// Cek apakah tombol submit ditekan
if (isset($_POST["submit"])) {
    if (ubah($_POST) > 0) {
        echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php?page=siswa';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'index.php?page=siswa';
              </script>";
    }
}
?>

<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-12">
    <div class="box box-danger">
      <div class="box-header">
        <div class="text-center">
          <h1>UBAH DATA SISWA</h1>
          <hr>
        </div>
      </div>
      <div class="box-body">
        <form action="" method="POST" enctype="multipart/form-data">	
          <div class="form-group row">					
            <div class="col-md-6">
              <label for="nis">NIS</label>
              <input type="text" name="nis" id="nis" class="form-control" required autocomplete="off" value="<?= $siswa["nis"]; ?>" readonly>
              <br>
              
              <label for="nama_siswa">Nama Lengkap</label>
              <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" required autocomplete="off" value="<?= $siswa["nama_siswa"]; ?>">
              <br>

              <label for="no_hp_ortu">No HP Orang Tua</label>
              <input type="text" name="no_hp_ortu" id="no_hp_ortu" class="form-control" required autocomplete="off" value="<?= $siswa["no_hp_ortu"]; ?>">
              <br>

              <label for="alamat">Alamat</label>
              <input type="text" name="alamat" id="alamat" class="form-control" required autocomplete="off" value="<?= $siswa["alamat"]; ?>">
              <br>

              <label for="periode_masuk">Periode Masuk</label>
              <input type="text" name="periode_masuk" id="periode_masuk" class="form-control" value="<?= $periode_otomatis ?>" readonly>
              <br>

              <?php $o = explode(',', $siswa['jk']); ?>
              <label for="jk">Jenis Kelamin</label>
              <div class="radio">
                <label class="radio-inline">
                  <input type="radio" name="jk" id="jk" value="Laki-laki" <?= in_array('Laki-laki', $o) ? 'checked' : '' ?>> Laki-laki
                </label>
                <label class="radio-inline">
                  <input type="radio" name="jk" id="jk" value="Perempuan" <?= in_array('Perempuan', $o) ? 'checked' : '' ?>> Perempuan
                </label>
              </div>
              <br><br>
            </div>

            <div class="col-md-6">
              <label for="tempat_lahir">Tempat Lahir</label>
              <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required autocomplete="off" value="<?= $siswa["tempat_lahir"]; ?>">
              <br>

              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required autocomplete="off" value="<?= $siswa["tanggal_lahir"]; ?>">
              <br>

              <label for="agama">Agama</label>
              <select class="form-control" id="agama" name="agama">
                <option value="<?= $siswa["agama"]; ?>"><?= $siswa["agama"]; ?></option>
                <option value="ISLAM">ISLAM</option>
              </select>
              <br>

              <label for="foto">Foto</label><br>
              <img src="img/foto/siswa/<?= $siswa["foto"]; ?>" width="100"><br><br>
              <input type="file" name="foto" id="foto" class="form-control">
              <br>

              <input type="hidden" name="fotolama" value="<?= $siswa["foto"]; ?>">
              <button type="submit" name="submit" class="btn btn-primary">Ubah</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<br><br>
