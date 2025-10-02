<?php
require 'functions.php';
require '../fpdf/fpdf.php';

// Cek parameter
if (!isset($_GET['nis']) || !isset($_GET['semester'])) {
    echo "NIS atau semester tidak ditemukan.";
    exit;
}

$nis = $_GET['nis'];
$semester = $_GET['semester'];

// Ambil data siswa
$siswa = query("SELECT * FROM tb_siswa WHERE nis = '$nis'")[0];

// Ambil data nilai siswa berdasarkan semester
$nilai = query("SELECT * FROM tb_nilai
    INNER JOIN tb_siswa ON tb_nilai.nis = tb_siswa.nis
    INNER JOIN tb_kelas ON tb_nilai.id_kelas = tb_kelas.id_kelas
    WHERE tb_nilai.nis = '$nis' AND tb_nilai.semester = '$semester'
    ORDER BY id_nilai DESC");

// Fungsi konversi angka ke huruf
function terbilang($angka)
{
    $angka = (int)$angka;
    $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
    
    if ($angka < 12) {
        return $huruf[$angka];
    } elseif ($angka < 20) {
        return $huruf[$angka - 10] . " Belas";
    } elseif ($angka < 100) {
        return $huruf[floor($angka / 10)] . " Puluh " . $huruf[$angka % 10];
    } elseif ($angka < 200) {
        return "Seratus " . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        return $huruf[floor($angka / 100)] . " Ratus " . terbilang($angka % 100);
    } else {
        return "Angka terlalu besar";
    }
}

// Buat PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Header
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Taman Pendidikan Quran (TPQ) Masjid Darul Mukhlisin', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 7, 'Jln.Lolong Belanti, Kec. Padang Utara, Kota Padang, Sumatera Barat.', 0, 1, 'C');
$y = $pdf->GetY();
$pdf->Line(15, $y + 3, 195, $y + 3);
$pdf->Ln(5);

// Judul
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'NILAI RAPORT SISWA', 0, 1, 'C');

// Info Siswa
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 8, 'Nama Lengkap', 0, 0);
$pdf->Cell(5, 8, ':', 0, 0);
$pdf->Cell(100, 8, $siswa['nama_siswa'], 0, 1);

$pdf->Cell(40, 8, 'NIS', 0, 0);
$pdf->Cell(5, 8, ':', 0, 0);
$pdf->Cell(100, 8, $siswa['nis'], 0, 1);

$kelas = isset($nilai[0]) ? $nilai[0]['nama_kelas'] : '-';
$pdf->Cell(40, 8, 'Kelas', 0, 0);
$pdf->Cell(5, 8, ':', 0, 0);
$pdf->Cell(100, 8, $kelas, 0, 1);

$tahun_ajaran = isset($nilai[0]) ? $nilai[0]['tahun_ajaran'] : '-';
$pdf->Cell(40, 8, 'Tahun Ajaran', 0, 0);
$pdf->Cell(5, 8, ':', 0, 0);
$pdf->Cell(100, 8, $tahun_ajaran, 0, 1);

// ✅ Tampilkan Semester
$pdf->Cell(40, 8, 'Semester', 0, 0);
$pdf->Cell(5, 8, ':', 0, 0);
$pdf->Cell(100, 8, $semester, 0, 1);

$pdf->Ln(5);

// Tabel Nilai
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(80, 10, 'Mata Pelajaran', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Nilai', 1, 0, 'C', true);
$pdf->Cell(75, 10, 'Nilai (Huruf)', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 11);
$no = 1;
$total_nilai = 0;
$jml_mapel = count($nilai);

foreach ($nilai as $n) {
    $pdf->Cell(10, 8, $no++, 1, 0, 'C');
    $pdf->Cell(80, 8, $n['mapel'], 1, 0);
    $pdf->Cell(25, 8, $n['nilai'], 1, 0, 'C');
    $pdf->Cell(75, 8, $n['tulisan_nilai'], 1, 1);
    $total_nilai += $n['nilai'];
}

// Rata-rata
$rata_rata = $jml_mapel > 0 ? round($total_nilai / $jml_mapel, 2) : 0;
$nilai_bulat = floor($rata_rata);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(90, 10, 'Rata-Rata Nilai', 1, 0, 'C');
$pdf->Cell(25, 10, $rata_rata, 1, 0, 'C');
$pdf->Cell(75, 10, '(' . terbilang($nilai_bulat) . ')', 1, 1, 'C');

$pdf->Ln(20);

// Tanda tangan Orang Tua
$currentY = $pdf->GetY();
$pdf->SetFont('Arial', '', 10);
$pdf->SetX(15);
$pdf->Cell(0, 6, 'Mengetahui,', 0, 1, 'L');
$pdf->SetX(15);
$pdf->Cell(0, 6, 'Orang Tua/Wali', 0, 1, 'L');
$pdf->Ln(10);
$pdf->SetX(15);
$pdf->Cell(60, 6, '____________________', 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(15);
$pdf->Cell(120, 10, '(........................)', 0, 1, 'L');

// Tanda tangan Ketua
$pdf->SetFont('Arial', '', 10);
$tanggal = 'Padang, ' . date('d F Y');
$pdf->SetY($currentY);
$pdf->Cell(0, 6, $tanggal, 0, 1, 'R');

$tanggal_width = $pdf->GetStringWidth($tanggal);
$ketua_text = 'Ketua,';
$ketua_width = $pdf->GetStringWidth($ketua_text);
$x_pos = $pdf->GetPageWidth() - 10 - $tanggal_width + ($tanggal_width - $ketua_width) / 2;

$pdf->SetX($x_pos);
$pdf->Cell($ketua_width, 6, $ketua_text, 0, 1);

$pdf->Ln(10);
$tanda_width = $pdf->GetStringWidth('____________________');
$x_ttd = $x_pos + ($ketua_width - $tanda_width) / 2;
$pdf->SetX($x_ttd);
$pdf->Cell($tanda_width, 6, '____________________', 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$nama = 'Busra. N, S.Pd.I, M.Pd';
$nama_width = $pdf->GetStringWidth($nama);
$x_nama = $x_pos + ($ketua_width - $nama_width) / 2;
$pdf->SetX($x_nama);
$pdf->Cell($nama_width, 6, $nama, 0, 1);

// Output
$pdf->Output('I', 'laporan_raport_' . $siswa['nis'] . '_' . $semester . '.pdf');
