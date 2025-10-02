<?php
// koneksi ke database
include "database/koneksi.php";

function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	return $rows;
}

$conn = mysqli_connect("localhost", "root", "", "raport");
function tambah($data) {
    global $conn;

    $id_nilai      = htmlspecialchars($data["id_nilai"] ?? '');
    $id_kelas      = htmlspecialchars($data["kelas1"] ?? '');
    $tahun_ajaran  = htmlspecialchars($data["tahun_ajaran"] ?? '');
	$semester  = htmlspecialchars($data["semester"] ?? '');
    $mapel         = htmlspecialchars($data["mapel"] ?? '');
    $nis           = htmlspecialchars($data["siswa1"] ?? '');  // pastikan ini ada di form
    $nilai         = htmlspecialchars($data["nilai"] ?? '');
    $tulisan_nilai = htmlspecialchars($data["tulisan_nilai"] ?? '');

    if ($nis == '') {
        echo "NIS belum dipilih!";
        return 0;
    }

    $query = "INSERT INTO tb_nilai (id_nilai, nis, mapel, nilai, tulisan_nilai, id_kelas, tahun_ajaran, semester)
              VALUES ('$id_nilai', '$nis', '$mapel', '$nilai', '$tulisan_nilai', '$id_kelas', '$tahun_ajaran', '$semester')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function ubah($data) {
	global $conn;

	$id_nilai = htmlspecialchars($data["id_nilai"]);
	$nis = htmlspecialchars($data["siswa1"]);
	$id_kelas = htmlspecialchars($data["kelas1"]);
	$tahun_ajaran = htmlspecialchars($data["tahun_ajaran"]);
	$semester = htmlspecialchars($data["semester"]);
	$mapel = htmlspecialchars($data["mapel"]);
	$nilai = htmlspecialchars($data["nilai"]);
	$tulisan_nilai = htmlspecialchars($data["tulisan_nilai"]);

	// query update data
	$query = "UPDATE tb_nilai SET
					nis = '$nis',
					id_kelas = '$id_kelas',
					tahun_ajaran = '$tahun_ajaran',
					semester = '$semester',
					mapel = '$mapel',
					nilai = '$nilai',
					tulisan_nilai = '$tulisan_nilai'
				WHERE id_nilai = '$id_nilai'";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function hapus($id_nilai) {
	global $conn;
	mysqli_query($conn, "DELETE FROM tb_nilai WHERE id_nilai = '$id_nilai'");
	return mysqli_affected_rows($conn);
}
?>
