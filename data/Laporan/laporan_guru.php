<?php
require '../fpdf/fpdf.php';
require 'functions.php';

// Buat objek PDF
$pdf = new FPDF('L', 'mm', 'A4'); // L = Landscape, mm = milimeter, Legal = ukuran kertas
$pdf->AddPage();

// Judul
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Taman Pendidikan Quran (TPQ) Masjid Darul Mukhlisin', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 7, 'Jln.Lolong Belanti, Kec. Padang Utara, Kota Padang, Sumatera Barat.', 0, 1, 'C');

// Jarak sedikit di bawah baris terakhir
$y = $pdf->GetY();
$pdf->Line(15, $y + 3, 290, $y + 3); // lebih dekat dan pas lebar halaman A4 landscape atau portrait

// Judul laporan
$pdf->SetFont('Arial', 'B', 14);
$pdf->Ln(10);
$pdf->Cell(0, 10, 'LAPORAN DATA GURU', 0, 1, 'C');

// Table Header
$pdf->SetFont('Times', 'B', 10);
$pdf->SetFillColor(200, 200, 200);
$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'NIP', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Nama Lengkap', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'No HP', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Alamat', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'JK', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Status Guru', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Tempat Lahir', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Tanggal Lahir', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Agama', 1, 1, 'C', true);

// Ambil data
$i = 1;
if (isset($_POST['cetak_data'])) {
    $kategori = $_POST['kategori'];
    $guru = query("SELECT * FROM tb_guru WHERE 
        nama_guru LIKE '%$kategori%' OR
        alamat LIKE '%$kategori%' OR
        jk LIKE '%$kategori%' OR
        status_guru LIKE '%$kategori%' OR
        tempat_lahir LIKE '%$kategori%' OR
        agama LIKE '%$kategori%'");
} else {
    $guru = query("SELECT * FROM tb_guru");
}

// Tampilkan data
$pdf->SetFont('Times', '', 10);
foreach ($guru as $row) {
    $pdf->Cell(10, 8, $i++, 1, 0, 'C');
    $pdf->Cell(30, 8, $row["nip"], 1, 0);
    $pdf->Cell(40, 8, $row["nama_guru"], 1, 0);
    $pdf->Cell(30, 8, $row["no_tlp"], 1, 0);
    $pdf->Cell(40, 8, $row["alamat"], 1, 0);
    $pdf->Cell(20, 8, $row["jk"], 1, 0, 'C');
    $pdf->Cell(30, 8, $row["status_guru"], 1, 0, 'C');
    $pdf->Cell(30, 8, $row["tempat_lahir"], 1, 0);
    $pdf->Cell(30, 8, $row["tanggal_lahir"], 1, 0);
    $pdf->Cell(20, 8, $row["agama"], 1, 1);
}

// Spasi sebelum tanda tangan
$pdf->Ln(15);

// Tanggal dan tempat (rata kanan)
$pdf->SetFont('Arial', '', 10);
$tanggal = 'Padang, ' . date('d F Y');
$pdf->Cell(0, 6, $tanggal, 0, 1, 'R');

// Hitung lebar teks tanggal
$tanggal_width = $pdf->GetStringWidth($tanggal);

// Tulis "Ketua," di tengah bawah tanggal
$ketua_text = 'Ketua,';
$ketua_width = $pdf->GetStringWidth($ketua_text);

// Posisi X: posisi akhir teks tanggal - setengah panjang teks "Ketua,"
$x_pos = $pdf->GetPageWidth() - 10 - $tanggal_width + ($tanggal_width - $ketua_width) / 2;
$pdf->SetX($x_pos);
$pdf->Cell($ketua_width, 6, $ketua_text, 0, 1);

// Spasi untuk tanda tangan
$pdf->Ln(10);

// Garis tanda tangan di tengah bawah "Ketua,"
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

// Output PDF
$pdf->Output('I', 'laporan_guru.pdf');
?>
