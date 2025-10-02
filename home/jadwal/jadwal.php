<?php
require 'functions.php';

$japel = query("select * from tb_japel
			INNER JOIN tb_kelas ON tb_japel.id_kelas = tb_kelas.id_kelas
			INNER JOIN tb_thn_ajar ON tb_japel.id_thn_ajar = tb_thn_ajar.id_thn_ajar
			");

?>

<div class="content">

      <div class="row">
        <div class="col-xs-18">
          <div class="box">
            <div class="box-header">
			 <div class="box-header">
              <div class="text-center">
				<h1>JADWAL PELAJARAN</h1>
				<hr>
            </div>
           
            </div>
            <!-- /.box-header -->
             <div class="table-responsive">
              <table id="dataTables-example" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th scope="col" class="text-center">NO</th>
	  <th scope="col" class="text-center">Id Jadwal</th>
      <th scope="col" class="text-center">Kelas</th>
      <th scope="col" class="text-center">Tahun Ajaran</th>
	  <th scope="col" class="text-center">File</th>
	  <th scope="col" class="text-center">Aksi</th>
	  </tr>
  </thead>
  <tbody>
	<?php $i = 1; ?>
    <?php foreach ($japel as $row): ?>
	<tr>
      <td class="text-center"><?= $i; ?></td>
      <td class="text-center"><?= $row ["id_japel"]; ?></td>
	  <td class="text-center"><?= $row ["nama_kelas"]; ?></td>
	  <td class="text-center"><?= $row ["nama_thn_ajar"]; ?></td>
	  <td class="text-center"><?= $row ["file"]; ?></td>
	  <td class="text-center">
	  
		<a href="?page=jadwal&aksi=lihat&id_japel=<?= $row ["id_japel"]; ?>" class="btn btn-primary btn-xs" >Download<a>
		
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
</div>
