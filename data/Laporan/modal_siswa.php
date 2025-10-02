<?php
// Ambil daftar periode
$periode_list = query("SELECT DISTINCT periode_masuk FROM tb_siswa ORDER BY periode_masuk DESC");
?>

<div class="modal fade" id="cetaksiswa" tabindex="-1" role="dialog" aria-labelledby="modalCetakLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <form method="get" action="laporan_siswa.php" target="_blank">
        <div class="modal-header">
          <h4 class="modal-title" id="modalCetakLabel">Cetak PDF Data Siswa</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="periode">Pilih Periode Masuk</label>
            <select name="periode_filter" id="periode" class="form-control" required>
              <option value="">-- Pilih Periode --</option>
              <?php foreach ($periode_list as $row): ?>
                <option value="<?= $row['periode_masuk'] ?>"><?= $row['periode_masuk'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="cetak_data" class="btn btn-primary">
            <i class="fa fa-print"></i> Cetak PDF
          </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </form>

    </div>
  </div>
</div>
