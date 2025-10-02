<?php
require 'functions.php';

// ambil data di url
$id_kelas = $_GET["id_kelas"];

// query data kelas berdasarkan id
$kelas = query("SELECT * FROM tb_kelas WHERE id_kelas = '$id_kelas'")[0]; 

// cek apakah tombol submit sudah ditekan
if( isset($_POST["submit"]) ) {
	// cek apakah data berhasil diubah
	if( ubah($_POST) > 0 ) {
		echo "
			<script>
				alert('data berhasil diubah!');
				document.location.href = 'index.php?page=kelas';
			</script>
		";
	} else {
		echo "
			<script>
				alert('data gagal diubah!');
				document.location.href = 'index.php?page=kelas';
			</script>
		";
	}
}
?>



 <div class="row">
		<div class="col-md-2">
		</div>
        <div class="col-md-8">

          <div class="box box-danger">
            <div class="box-header">
              <div class="text-center">
				<h1>UBAH DATA KELAS</h1>
				<hr>
            </div>
            <div class="box-body">
		
                    <form action="" method="POST">	
                    
					<div class="form-group">
					
					<label for="id_kelas">Id Kelas</label>
					<input type="text" name="id_kelas" id="id_kelas" class="form-control"
					required autocomplete="off" value="<?=$kelas["id_kelas"]; ?>" readonly >
					<br>
					
				
					
					<label for="nama_kelas">Nama Kelas</label>
					<input type="text" name="nama_kelas" id="nama_kelas" class="form-control"
					required autocomplete="off" value="<?=$kelas["nama_kelas"]; ?>">
					<br>
					
					<label for="kapasitas">Kapasitas</label>
					<input type="text" name="kapasitas" id="kapasitas" class="form-control"
					required autocomplete="off" value="<?=$kelas["kapasitas"]; ?>">
					<br>
					
					<button type="submit" name="submit" class="btn btn-primary">Ubah</button>
					
				</form>
				</div>
			</div>
			</div>
			</div>
			<br>
			<br>