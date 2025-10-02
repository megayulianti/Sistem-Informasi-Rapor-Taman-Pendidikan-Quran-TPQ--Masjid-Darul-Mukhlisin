<?php
require 'functions.php';
require '../fpdf/fpdf.php';

$pdf = new FPDF('L', 'mm', 'A4'); // Landscape, A4 size
$pdf->AddPage();

// Judul utama
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Taman Pendidikan Quran (TPQ) Masjid Darul Mukhlisin', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 7, 'Jln.Lolong Belanti, Kec. Padang Utara, Kota Padang, Sumatera Barat.', 0, 1, 'C');

// Garis bawah
$y = $pdf->GetY();
$pdf->Line(15, $y + 3, 280, $y + 3); // Lebar Legal Landscape sekitar 280 mm

// Judul laporan
$pdf->SetFont('Arial', 'B', 14);
$pdf->Ln(10);
$pdf->Cell(0, 10, 'LAPORAN DATA STAF', 0, 1, 'C');

// Header tabel
$pdf->SetFont('Times', 'B', 10);
$pdf->SetFillColor(200, 200, 200);
$pdf->Cell(12, 8, 'NO', 1, 0, 'C', true);
$pdf->Cell(50, 8, 'Nama Lengkap', 1, 0, 'C', true);
$pdf->Cell(35, 8, 'Tempat Lahir', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Tanggal Lahir', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'JK', 1, 0, 'C', true);
$pdf->Cell(55, 8, 'Alamat', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Agama', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'No HP', 1, 1, 'C', true);

$pdf->SetFont('Times', '', 10);

$i = 1;
if (isset($_POST['cetak_data']) && !empty(trim($_POST['kategori']))) {
    $kategori = $_POST['kategori'];
    // Validasi input supaya aman (disarankan menggunakan prepared statement)
    $staf = query("SELECT * FROM tb_staf
                   WHERE nama_staf LIKE '%$kategori%' OR
                         alamat LIKE '%$kategori%' OR
                         jk LIKE '%$kategori%' OR
                         tempat_lahir LIKE '%$kategori%' OR
                         agama LIKE '%$kategori%'");
} else {
    $staf = query("SELECT * FROM tb_staf");
}

foreach ($staf as $row) {
    $pdf->Cell(12, 8, $i++, 1, 0, 'C');
    $pdf->Cell(50, 8, $row['nama_staf'], 1, 0, 'L');
    $pdf->Cell(35, 8, $row['tempat_lahir'], 1, 0, 'L');
    $pdf->Cell(30, 8, $row['tanggal_lahir'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['jk'], 1, 0, 'C');
    $pdf->Cell(55, 8, $row['alamat'], 1, 0, 'L');
    $pdf->Cell(30, 8, $row['agama'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['no_hp'], 1, 1, 'C');
}


// Spasi sebelum tanda tangan (diperkecil agar tidak terlalu jauh)
$pdf->Ln(8);

// Tanggal dan tempat (rata kanan)
$pdf->SetFont('Arial', '', 10);
$tanggal = 'Padang, ' . date('d F Y');
$pdf->Cell(0, 6, $tanggal, 0, 1, 'R');

// Hitung lebar teks tanggal
$tanggal_width = $pdf->GetStringWidth($tanggal);

// Tulis "Ketua," di bawah tanggal, posisinya disesuaikan
$ketua_text = 'Ketua,';
$ketua_width = $pdf->GetStringWidth($ketua_text);
$x_pos = $pdf->GetPageWidth() - 10 - $tanggal_width + ($tanggal_width - $ketua_width) / 2;
$pdf->SetX($x_pos);
$pdf->Cell($ketua_width, 6, $ketua_text, 0, 1);

// Spasi untuk tanda tangan (juga diperkecil)
$pdf->Ln(10);

// Garis tanda tangan di bawah "Ketua,"
$tanda_width = $pdf->GetStringWidth('____________________');
$x_ttd = $x_pos + ($ketua_width - $tanda_width) / 2;
$pdf->SetX($x_ttd);
$pdf->Cell($tanda_width, 6, '____________________', 0, 1);

// Nama penandatangan di bawahnya
$pdf->SetFont('Arial', 'B', 10);
$nama = 'Busra. N,S.Pd.I, M.Pd';
$nama_width = $pdf->GetStringWidth($nama);
$x_nama = $x_pos + ($ketua_width - $nama_width) / 2;
$pdf->SetX($x_nama);
$pdf->Cell($nama_width, 6, $nama, 0, 1);

$pdf->Output('I', 'laporan_staf.pdf');
