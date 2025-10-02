<?php
require '../fpdf/fpdf.php';
require 'functions.php'; // Pastikan $conn sudah tersedia di sini

$pdf = new FPDF('P', 'mm', 'Legal');
$pdf->AddPage();

// Margin kiri dan kanan (default 10mm)
$leftMargin = 10;
$rightMargin = 10;
$pdf->SetLeftMargin($leftMargin);
$pdf->SetRightMargin($rightMargin);

$pdf->SetFont('Times', 'B', 16);

// Header sekolah
$pdf->Cell(0, 10, 'SMA NEGERI 2 DOGIYAI', 0, 1, 'C');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0, 8, 'Kecamatan Mapia, Kabupaten Dogiyai, Provinsi Papua', 0, 1, 'C');
$pdf->Cell(0, 6, 'Jln. Trans Papua Nabire-Enarotali Km. 184', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Times', 'B', 18);
$pdf->Cell(0, 10, 'RAPORT SISWA', 0, 1, 'C');
$pdf->Ln(5);

// Data siswa
$pdf->SetFont('Times', '', 12);
$labelWidth = 35;
$colonWidth = 5;

$pdf->Cell($labelWidth, 8, 'NIS', 0, 0);
$pdf->Cell($colonWidth, 8, ':', 0, 0);
$pdf->Cell(0, 8, $_POST['nis'] ?? '-', 0, 1);

$pdf->Cell($labelWidth, 8, 'Nama', 0, 0);
$pdf->Cell($colonWidth, 8, ':', 0, 0);
$pdf->Cell(0, 8, $_POST['nama'] ?? '-', 0, 1);

$pdf->Cell($labelWidth, 8, 'Kelas', 0, 0);
$pdf->Cell($colonWidth, 8, ':', 0, 0);
$pdf->Cell(0, 8, $_POST['kelas'] ?? '-', 0, 1);

$pdf->Cell($labelWidth, 8, 'Tahun Ajaran', 0, 0);
$pdf->Cell($colonWidth, 8, ':', 0, 0);
$pdf->Cell(0, 8, $_POST['tahun'] ?? '-', 0, 1);
$pdf->Ln(10);

// Header tabel nilai
$pdf->SetFont('Times', 'B', 10);
$header = ['NO','NIS','Nama Siswa','Kelas','Tahun Ajaran','Mapel','Tgs1','Tgs2','Tgs3','UTS','UAS','Rata-rata'];
$widths = [7, 15, 40, 15, 20, 30, 10, 10, 10, 12, 12, 15];

// Print header kolom dengan border dan background abu-abu muda
$pdf->SetFillColor(230,230,230);
foreach ($header as $key => $col) {
    $pdf->Cell($widths[$key], 8, $col, 1, 0, 'C', true);
}
$pdf->Ln();

// Data tabel nilai
$pdf->SetFont('Times', '', 9);

$nama = $_POST['nama'] ?? '';
$thn_ajar = $_POST['tahun'] ?? '';

// Query data nilai siswa sesuai nama dan tahun ajaran
$nilai = mysqli_query($conn, "SELECT tb_nilai.*, tb_siswa.nama_siswa, tb_kelas.nama_kelas 
    FROM tb_nilai
    INNER JOIN tb_siswa ON tb_nilai.nis = tb_siswa.nis
    INNER JOIN tb_kelas ON tb_nilai.id_kelas = tb_kelas.id_kelas
    WHERE tb_siswa.nama_siswa LIKE '%$nama%' AND tb_nilai.tahun_ajaran LIKE '%$thn_ajar%'");

$i = 1;
$total = 0;
$jumlah = mysqli_num_rows($nilai);

while ($row = mysqli_fetch_assoc($nilai)) {
    $pdf->Cell($widths[0], 7, $i++, 1, 0, 'C');
    $pdf->Cell($widths[1], 7, $row['nis'], 1, 0, 'C');

    // Nama siswa dengan MultiCell agar wrap teks rapi jika panjang
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell($widths[2], 7, $row['nama_siswa'], 1, 'L');
    $hNama = $pdf->GetY() - $y; // tinggi baris MultiCell nama
    $pdf->SetXY($x + $widths[2], $y);

    $pdf->Cell($widths[3], $hNama, $row['nama_kelas'], 1, 0, 'C');
    $pdf->Cell($widths[4], $hNama, $row['tahun_ajaran'], 1, 0, 'C');

    // Mapel juga menggunakan MultiCell untuk teks rapi
    $xMapel = $pdf->GetX();
    $yMapel = $pdf->GetY();
    $pdf->MultiCell($widths[5], 7, $row['mapel'], 1, 'L');
    $hMapel = $pdf->GetY() - $yMapel;
    $pdf->SetXY($xMapel + $widths[5], $yMapel);

    // Untuk kolom nilai, pakai tinggi terbesar antara nama dan mapel supaya cell rata
    $heightMax = max($hNama, $hMapel);

    $pdf->Cell($widths[6], $heightMax, $row['nilai'], 1, 0, 'C');
    $pdf->Cell($widths[7], $heightMax, $row['tulisan_nilai'], 1, 0, 'C');
    $pdf->Cell($widths[11], $heightMax, number_format($row['rata'], 2, ',', '.'), 1, 1, 'C');

    $total += $row['rata'];
}

// Baris nilai rata-rata
$rata = ($jumlah > 0) ? number_format($total / $jumlah, 2, ',', '.') : '0';
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(array_sum($widths) - $widths[11], 8, 'Nilai Rata-rata', 1, 0, 'C', true);
$pdf->Cell($widths[11], 8, $rata, 1, 1, 'C', true);

$pdf->Ln(15);

// Tanda tangan
$pdf->SetFont('Times', '', 12);
$pdf->Cell(90, 6, 'Dogiyai, .... ........... '.date("Y"), 0, 0, 'C');
$pdf->Cell(90, 6, 'Mengetahui:', 0, 1, 'C');

$pdf->Cell(90, 20, 'Walikelas', 0, 0, 'C');
$pdf->Cell(90, 20, 'Orang Tua/Wali', 0, 1, 'C');

$pdf->Ln(10);
$pdf->Cell(90, 6, '________________________', 0, 0, 'C');
$pdf->Cell(90, 6, '________________________', 0, 1, 'C');

$pdf->Output('D', 'Raport_Siswa.pdf');
