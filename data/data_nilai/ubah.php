<?php
require 'functions.php'; 

$id_nilai = $_GET["id_nilai"];

$nilai = query("SELECT * FROM tb_nilai
            INNER JOIN tb_kelas ON tb_nilai.id_kelas = tb_kelas.id_kelas
            INNER JOIN tb_kelsis ON tb_nilai.nis = tb_kelsis.nis
            WHERE id_nilai = '$id_nilai'")[0];

if(isset($_POST['submit'])){
    if( ubah($_POST) > 0 ) {
        echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href = 'index.php?page=nilai&aksi=lihat2';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal diubah!');
                document.location.href = 'index.php?page=nilai&aksi=lihat2';
            </script>
        ";
    }
}
?>

<div class="content">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-12">

          <div class="box box-danger">
            <div class="box-header">
              <div class="text-center">
                <h1>UBAH NILAI SISWA</h1>
                <hr>
              </div>
              <div class="box-body">

                <form action="" method="POST">    

                    <div class="form-group">

                    <input type="hidden" name="id_nilai" id="id_nilai" class="form-control"
                    required autocomplete="off" value="<?= $nilai["id_nilai"]; ?>">
                    <br>

                    <?php
                    $sql_kategori = mysqli_query($conn,'SELECT * FROM tb_kelas');
                    ?>
                    <div class="col-md-6">
                    <label>Nama kelas</label>
                    <select class="form-control" name="kelas1" id="kelas1">
                        <option value="<?= $nilai["id_kelas"]; ?>"><?= $nilai["nama_kelas"]; ?></option>
                        <?php while($row_kategori = mysqli_fetch_array($sql_kategori)) { ?>
                        <option value="<?php echo $row_kategori['id_kelas'] ?>"><?php echo $row_kategori['nama_kelas'] ?></option>
                        <?php } ?>
                    </select>
                    <br>

                    <label>Tahun Ajaran</label>
                    <select class="form-control" id="tahun_ajaran" name="tahun_ajaran">
                        <option value="<?= $nilai["tahun_ajaran"]; ?>"><?= $nilai["tahun_ajaran"]; ?></option>
                        <?php
                        $ambil = mysqli_query($conn, "SELECT * FROM tb_thn_ajar");
                        while ($data = mysqli_fetch_assoc($ambil)){
                            echo '<option value="'.$data['nama_thn_ajar'].'">'.$data['semester'].' || '.$data['nama_thn_ajar'].'</option>';
                        } 
                        ?>
                    </select>
                    <br>

                    <label>Mata Pelajaran</label>
                    <select class="form-control" id="mapel" name="mapel">
                        <option value="<?= $nilai["mapel"]; ?>"><?= $nilai["mapel"]; ?></option>
                        <?php
                        $ambil = mysqli_query($conn, "SELECT * FROM tb_mapel");
                        while ($data = mysqli_fetch_assoc($ambil)){
                            echo '<option value="'.$data['nama_mapel'].'">'.$data['nama_mapel'].'</option>';
                        } 
                        ?>
                    </select>
                    <br>

                    <label>Nama Siswa</label>
                        <select class="form-control" id="siswa1" name="siswa1" required>
                        <option value="<?= $nilai['nis']; ?>"><?= $nilai['nama_siswa']; ?></option>
                        <?php
                        $siswa = mysqli_query($conn, "SELECT * FROM tb_kelsis");
                        while ($row = mysqli_fetch_assoc($siswa)) {
                            echo '<option value="'.$row['nis'].'">'.$row['nama_siswa'].'</option>';
                        }
                        ?>
                        </select>

                    <br>
                    </div>

                    <div class="col-md-6">
                    <label for="nilai">Nilai</label>
                    <input type="text" name="nilai" id="nilai" class="form-control"
                    required autocomplete="off" value="<?= $nilai["nilai"]; ?>" >
                    <br>

                    <label for="tulisan_nilai">Tulisan Nilai</label>
                    <input type="text" name="tulisan_nilai" id="tulisan_nilai" class="form-control"
                    required autocomplete="off" value="<?= $nilai["tulisan_nilai"]; ?>">
                    <br>
                    
                    <label for="semester">Semester</label>
                    <select name="semester" id="semester" class="form-control" required>
                        <option value="<?= $nilai['semester']; ?>"><?= $nilai['semester']; ?></option>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                    <br>


                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    </div>

                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
</div>

<br>
<br>
