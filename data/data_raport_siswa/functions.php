<?php
// koneksi ke database
$conn = mysqli_connect("localhost","root","","raport");



function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}


function tambah($data){
	global $conn;

	$id_nilai = htmlspecialchars($data["id_nilai"]);
	$nis = htmlspecialchars($data["siswa1"]);
	$id_kelas = htmlspecialchars($data["kelas1"]);
	$tahun_ajaran = htmlspecialchars($data["thn_ajar"]);
	$semester = htmlspecialchars($data["semester"]); // ✅ Tambah ini
	$mapel = htmlspecialchars($data["mapel"]);
	$nilai = htmlspecialchars($data["nilai"]);
	$tulisan_nilai = htmlspecialchars($data["tulisan_nilai"]);
	$rata = htmlspecialchars($data["rata"]);
	$uts = htmlspecialchars($data["uts"]);
	$uas = htmlspecialchars($data["uas"]);

	// query insert data
	$query = "INSERT INTO tb_nilai
		(id_nilai, nis, id_kelas, tahun_ajaran, semester, mapel, nilai, tulisan_nilai, rata)
		VALUES
		('$id_nilai','$nis','$id_kelas','$tahun_ajaran','$semester','$mapel','$nilai','$tulisan_nilai','$rata')";
	
	mysqli_query($conn, $query);
	
	return mysqli_affected_rows($conn);
}


function ubah_nilai($data){
	global $conn;

	$id_nilai = htmlspecialchars($data["id_nilai"]);
	$nis = htmlspecialchars($data["siswa1"]);
	$id_kelas = htmlspecialchars($data["kelas1"]);
	$tahun_ajaran = htmlspecialchars($data["thn_ajar"]);
	$semester = htmlspecialchars($data["semester"]); // ✅ Tambah ini
	$mapel = htmlspecialchars($data["mapel"]);
	$nilai = htmlspecialchars($data["nilai"]);
	$tulisan_nilai = htmlspecialchars($data["tulisan_nilai"]);
	$rata = htmlspecialchars($data["rata"]);
	$uts = htmlspecialchars($data["uts"]);
	$uas = htmlspecialchars($data["uas"]);

	$query = "UPDATE tb_nilai SET
		nis = '$nis',
		id_kelas = '$id_kelas',
		tahun_ajaran = '$tahun_ajaran',
		semester = '$semester',
		mapel = '$mapel',
		nilai = '$nilai',
		tulisan_nilai = '$tulisan_nilai',
		rata = '$rata'
		WHERE id_nilai = '$id_nilai'";
	
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}


function hapus($id_pengumuman) {
	global $conn;
	mysqli_query($conn, "DELETE FROM tb_pengumuman WHERE id_pengumuman = '$id_pengumuman'");
	return mysqli_affected_rows($conn);
}


?>