<?php
// koneksi ke database
include "database/koneksi.php";

// Fungsi umum untuk menjalankan query dan mengembalikan array
function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	return $rows;
}

// Fungsi untuk membuat periode otomatis berdasarkan tahun sekarang
function getPeriodeOtomatis() {
	$tahun = date('Y');
	return "$tahun/" . ($tahun + 1);
}

// Fungsi tambah data siswa
function tambah($data)
{
	global $conn;

	$nis            = htmlspecialchars($data["nis"]);
	$nama_siswa     = htmlspecialchars($data["nama_siswa"]);
	$no_hp_ortu     = htmlspecialchars($data["no_hp_ortu"]);
	$alamat         = htmlspecialchars($data["alamat"]);
	$jk             = htmlspecialchars($data["jk"]);
	$tempat_lahir   = htmlspecialchars($data["tempat_lahir"]);
	$tanggal_lahir  = htmlspecialchars($data["tanggal_lahir"]);
	$agama          = htmlspecialchars($data["agama"]);
	$periode_masuk  = getPeriodeOtomatis(); // otomatis

	// Upload foto
	$foto = upload();
	if (!$foto) {
		return false;
	}

	$query = "INSERT INTO tb_siswa 
				(nis, nama_siswa, no_hp_ortu, alamat, jk, tempat_lahir, tanggal_lahir, agama, periode_masuk, foto)
			  VALUES
				('$nis', '$nama_siswa', '$no_hp_ortu', '$alamat', '$jk', '$tempat_lahir', '$tanggal_lahir', '$agama', '$periode_masuk', '$foto')";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

// Fungsi upload gambar
function upload()
{
	$namaFile   = $_FILES['foto']['name'];
	$ukuranFile = $_FILES['foto']['size'];
	$error      = $_FILES['foto']['error'];
	$tmpName    = $_FILES['foto']['tmp_name'];

	// Cek apakah tidak ada gambar yang diupload
	if ($error === 4) {
		echo "<script>alert('Pilih gambar terlebih dahulu!');</script>";
		return false;
	}

	// Validasi ekstensi
	$extValid = ['jpg', 'jpeg', 'png'];
	$extFile = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
	if (!in_array($extFile, $extValid)) {
		echo "<script>alert('Yang anda upload bukan gambar!');</script>";
		return false;
	}

	// Validasi ukuran file max 2MB
	if ($ukuranFile > 2000000) {
		echo "<script>alert('Ukuran gambar terlalu besar!');</script>";
		return false;
	}

	// Nama file baru agar unik
	$namaBaru = uniqid() . '.' . $extFile;
	move_uploaded_file($tmpName, 'img/foto/siswa/' . $namaBaru);

	return $namaBaru;
}

// Fungsi ubah data siswa
function ubah($data) {
	global $conn;

	$nis             = htmlspecialchars($data["nis"] ?? '');
	$nama_siswa      = htmlspecialchars($data["nama_siswa"] ?? '');
	$no_hp_ortu      = htmlspecialchars($data["no_hp_ortu"] ?? '');
	$alamat          = htmlspecialchars($data["alamat"] ?? '');
	$jk              = htmlspecialchars($data["jk"] ?? '');
	$tempat_lahir    = htmlspecialchars($data["tempat_lahir"] ?? '');
	$tanggal_lahir   = htmlspecialchars($data["tanggal_lahir"] ?? '');
	$agama           = htmlspecialchars($data["agama"] ?? '');
	$fotolama        = htmlspecialchars($data["fotolama"] ?? '');

	// Periode otomatis (jika ingin tidak berubah, bisa pakai $data["periode_masuk"] saja)
	$periode_masuk   = getPeriodeOtomatis();

	// Cek apakah user upload foto baru atau tidak
	if ($_FILES['foto']['error'] === 4) {
		$foto = $fotolama;
	} else {
		$foto = upload();
		if (!$foto) return false;

		// Hapus foto lama jika ada
		if (file_exists("img/foto/siswa/" . $fotolama)) {
			unlink("img/foto/siswa/" . $fotolama);
		}
	}

	$query = "UPDATE tb_siswa SET
		nama_siswa = '$nama_siswa',
		level = 'siswa',
		no_hp_ortu = '$no_hp_ortu',
		alamat = '$alamat',
		jk = '$jk',
		tempat_lahir = '$tempat_lahir',
		tanggal_lahir = '$tanggal_lahir',
		agama = '$agama',
		periode_masuk = '$periode_masuk',
		foto = '$foto'
		WHERE nis = '$nis'";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

// Fungsi hapus data siswa
function hapus($nis) {
	global $conn;

	// Ambil foto dulu untuk dihapus dari folder
	$sql = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE nis = '$nis'");
	$row = mysqli_fetch_array($sql);
	if ($row && file_exists("img/foto/siswa/" . $row['foto'])) {
		unlink("img/foto/siswa/" . $row['foto']);
	}

	mysqli_query($conn, "DELETE FROM tb_siswa WHERE nis = '$nis'");
	return mysqli_affected_rows($conn);
}
?>
