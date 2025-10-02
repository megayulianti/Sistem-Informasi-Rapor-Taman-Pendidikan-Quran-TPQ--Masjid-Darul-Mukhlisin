<?php
require 'functions.php';
require '../fpdf/fpdf.php';

// Ambil filter dari form POST
$periode = isset($_POST['periode']) ? $_POST['periode'] : 'all';

// Ambil data berdasarkan periode
if ($periode == 'all') {
    $siswa = query("SELECT * FROM tb_siswa ORDER BY periode_masuk DESC, nama_siswa ASC");
    $judul = "DATA SISWA SEMUA PERIODE";
    $filename = "data_siswa_semua_periode.pdf";
} else {
    $siswa = query("SELECT * FROM tb_siswa WHERE periode_masuk = '$periode' ORDER BY nama_siswa ASC");
    $judul = "DATA SISWA PERIODE $periode";
    $filename = "data_siswa_periode_" . str_replace("/", "-", $periode) . ".pdf";
}

// Setup FPDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Kop Surat
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 8, 'Taman Pendidikan Quran (TPQ) Masjid Darul Mukhlisin', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 7, 'Jln. Lolong Belanti, Kec. Padang Utara, Kota Padang, Sumatera Barat.', 0, 1, 'C');

// Garis Pembatas Double Line
$pdf->Ln(2);
$x1 = 10;
$x2 = 287;
$y = $pdf->GetY();
$pdf->SetLineWidth(1);      // Garis tebal
$pdf->Line($x1, $y, $x2, $y);
$pdf->SetLineWidth(0.3);    // Garis tipis
$pdf->Line($x1, $y + 1.5, $x2, $y + 1.5);
$pdf->Ln(6);

// Judul Laporan
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, $judul, 0, 1, 'C');
$pdf->Ln(5);

// Header Tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'NIS', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Nama Siswa', 1, 0, 'C', true);
$pdf->Cell(35, 10, 'No HP Ortu', 1, 0, 'C', true);
$pdf->Cell(45, 10, 'Alamat', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'JK', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Tempat Lahir', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Tgl Lahir', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Agama', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Periode', 1, 1, 'C', true);

// Isi Tabel
$pdf->SetFont('Arial', '', 10);
$no = 1;
foreach ($siswa as $row) {
    $pdf->Cell(10, 8, $no++, 1, 0, 'C');
    $pdf->Cell(25, 8, $row['nis'], 1);
    $pdf->Cell(40, 8, $row['nama_siswa'], 1);
    $pdf->Cell(35, 8, $row['no_hp_ortu'], 1);
    $pdf->Cell(45, 8, $row['alamat'], 1);
    $pdf->Cell(20, 8, $row['jk'], 1);
    $pdf->Cell(30, 8, $row['tempat_lahir'], 1);
    $pdf->Cell(30, 8, $row['tanggal_lahir'], 1);
    $pdf->Cell(20, 8, $row['agama'], 1);
    $pdf->Cell(25, 8, $row['periode_masuk'], 1, 1);
}

// Tanda Tangan
$pdf->Ln(15);
$pdf->SetFont('Arial', '', 10);
$tanggal = 'Padang, ' . date('d F Y');
$pdf->Cell(0, 6, $tanggal, 0, 1, 'R');

// Posisi rata tengah kanan
$tanggal_width = $pdf->GetStringWidth($tanggal);
$ketua_text = 'Ketua,';
$ketua_width = $pdf->GetStringWidth($ketua_text);
$x_pos = $pdf->GetPageWidth() - 10 - $tanggal_width + ($tanggal_width - $ketua_width) / 2;
$pdf->SetX($x_pos);
$pdf->Cell($ketua_width, 6, $ketua_text, 0, 1);
$pdf->Ln(10);

// Garis tanda tangan
$tanda_width = $pdf->GetStringWidth('____________________');
$x_ttd = $x_pos + ($ketua_width - $tanda_width) / 2;
$pdf->SetX($x_ttd);
$pdf->Cell($tanda_width, 6, '____________________', 0, 1);

// Nama penandatangan
$pdf->SetFont('Arial', 'B', 10);
$nama = 'Busra. N,S.Pd.I, M.Pd';
$nama_width = $pdf->GetStringWidth($nama);
$x_nama = $x_pos + ($ketua_width - $nama_width) / 2;
$pdf->SetX($x_nama);
$pdf->Cell($nama_width, 6, $nama, 0, 1);

// Output PDF
$pdf->Output('I', $filename);
