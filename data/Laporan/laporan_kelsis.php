<?php
require 'functions.php';
require '../fpdf/fpdf.php';

// Ambil filter tahun ajaran dari POST
$tahun_filter = isset($_POST['tahun_ajaran']) ? $_POST['tahun_ajaran'] : 'all';

// Ambil data dan nama tahun ajaran
if ($tahun_filter !== 'all') {
    $tahun_info = query("SELECT * FROM tb_thn_ajar WHERE id_thn_ajar = '$tahun_filter'");
    $tahun_nama = $tahun_info[0]['nama_thn_ajar'];

    $kelsis = query("SELECT * FROM tb_kelsis
        INNER JOIN tb_kelas ON tb_kelsis.id_kelas = tb_kelas.id_kelas
        INNER JOIN tb_thn_ajar ON tb_kelsis.id_thn_ajar = tb_thn_ajar.id_thn_ajar
        WHERE tb_kelsis.id_thn_ajar = '$tahun_filter'");
} else {
    $tahun_nama = "Semua Tahun Ajaran";
    $kelsis = query("SELECT * FROM tb_kelsis
        INNER JOIN tb_kelas ON tb_kelsis.id_kelas = tb_kelas.id_kelas
        INNER JOIN tb_thn_ajar ON tb_kelsis.id_thn_ajar = tb_thn_ajar.id_thn_ajar");
}

// Inisialisasi PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// ---------------------------
// KOP SURAT
// ---------------------------
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 8, 'Taman Pendidikan Quran (TPQ) Masjid Darul Mukhlisin', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 7, 'Jln. Lolong Belanti, Kec. Padang Utara, Kota Padang, Sumatera Barat.', 0, 1, 'C');

// Garis pembatas (double-line)
$pdf->Ln(2);
$x1 = 10;
$x2 = 287;
$y = $pdf->GetY();
$pdf->SetLineWidth(1);
$pdf->Line($x1, $y, $x2, $y);
$pdf->SetLineWidth(0.3);
$pdf->Line($x1, $y + 1.5, $x2, $y + 1.5);
$pdf->Ln(6);

// ---------------------------
// JUDUL LAPORAN
// ---------------------------
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'LAPORAN DATA KELAS SISWA', 0, 1, 'C');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 8, 'Tahun Ajaran: ' . $tahun_nama, 0, 1, 'C');
$pdf->Ln(5);

// ---------------------------
// HEADER TABEL
// ---------------------------
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'NIS', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Nama Siswa', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Kelas', 1, 0, 'C', true);
$pdf->Cell(55, 10, 'Tahun Ajaran', 1, 1, 'C', true);

// ---------------------------
// ISI TABEL
// ---------------------------
$pdf->SetFont('Arial', '', 10);
$no = 1;
foreach ($kelsis as $row) {
    $pdf->Cell(10, 8, $no++, 1);
    $pdf->Cell(25, 8, $row['nis'], 1);
    $pdf->Cell(60, 8, $row['nama_siswa'], 1);
    $pdf->Cell(40, 8, $row['nama_kelas'], 1);
    $pdf->Cell(55, 8, $row['nama_thn_ajar'], 1);
    $pdf->Ln();
}

// ---------------------------
// TANDA TANGAN
// ---------------------------
$pdf->Ln(15);
$pdf->SetFont('Arial', '', 10);
$tanggal = 'Padang, ' . date('d F Y');
$pdf->Cell(0, 6, $tanggal, 0, 1, 'R');

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

// ---------------------------
// OUTPUT PDF
// ---------------------------
$nama_file = 'laporan_kelas_siswa_' . str_replace('/', '-', $tahun_nama) . '.pdf';
$pdf->Output('I', $nama_file);
