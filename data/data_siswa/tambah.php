<?php
require 'functions.php';

// Hitung periode otomatis
$tahun_sekarang = date('Y');
$tahun_depan = $tahun_sekarang + 1;
$periode_otomatis = "$tahun_sekarang/$tahun_depan";

// Cek apakah tombol submit ditekan
if (isset($_POST["submit"])) {
    if (tambah($_POST) > 0) {
        echo "<script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'index.php?page=siswa';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal ditambahkan!');
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
          <h1>TAMBAH DATA SISWA</h1>
          <hr>
        </div>
      </div>
      <div class="box-body">
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="form-group row">
            <div class="col-md-6">
              <label for="nis">NIS</label>
              <input type="text" name="nis" id="nis" class="form-control" required autocomplete="off">
              <br>

              <label for="nama_siswa">Nama Lengkap</label>
              <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" required autocomplete="off">
              <br>

              <label for="no_hp_ortu">No HP Orang Tua</label>
              <input type="text" name="no_hp_ortu" id="no_hp_ortu" class="form-control" required autocomplete="off">
              <br>

              <label for="jk">Jenis Kelamin</label>
              <div class="radio">
                <label class="radio-inline">
                  <input type="radio" name="jk" value="Laki-laki" checked> Laki-laki
                </label>
                <label class="radio-inline">
                  <input type="radio" name="jk" value="Perempuan"> Perempuan
                </label>
              </div>
              <br><br>
            </div>

            <div class="col-md-6">
              <label for="tempat_lahir">Tempat Lahir</label>
              <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required autocomplete="off">
              <br>

              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required autocomplete="off">
              <br>

              <label for="alamat">Alamat</label>
              <input type="text" name="alamat" id="alamat" class="form-control" required autocomplete="off">
              <br>

              <label for="agama">Agama</label>
              <select class="form-control" id="agama" name="agama" required>
                <option value="">-- Pilih --</option>
                <option value="ISLAM">ISLAM</option>
              </select>
              <br>

              <label for="periode_masuk">Periode Masuk</label>
              <input type="text" name="periode_masuk" id="periode_masuk" class="form-control" value="<?= $periode_otomatis ?>" readonly>
              <br>

              <label for="foto">Foto</label>
              <input type="file" name="foto" id="foto" class="form-control" required>
              <br>

              <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<br><br>
