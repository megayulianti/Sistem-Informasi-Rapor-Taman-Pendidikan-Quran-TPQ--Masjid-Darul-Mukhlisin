<?php
require 'functions.php';
require '../fpdf/fpdf.php';

// Ambil nama_kelas dari database
$kelas_id = trim($_POST['kelas'] ?? '');
$kelas_result = query("SELECT nama_kelas FROM tb_kelas WHERE id_kelas = '$kelas_id'");
$nama_kelas = $kelas_result[0]['nama_kelas'] ?? '-';

$semester = trim($_POST['semester'] ?? '');
$tahun_ajaran = trim($_POST['tahun_ajaran'] ?? '');

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// =========================
// HEADER
// =========================
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Taman Pendidikan Quran (TPQ) Masjid Darul Mukhlisin', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 7, 'Jln. Lolong Belanti, Kec. Padang Utara, Kota Padang, Sumatera Barat.', 0, 1, 'C');

$y = $pdf->GetY();
$pdf->SetLineWidth(1);
$pdf->Line(10, $y + 2, 287, $y + 2);
$pdf->SetLineWidth(0.3);
$pdf->Line(10, $y + 4, 287, $y + 4);
$pdf->Ln(10);

// =========================
// JUDUL + FILTER INFO
// =========================
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'REKAP NILAI SISWA', 0, 1, 'C');

$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 6, "Kelas: $nama_kelas", 0, 1, 'C');
$pdf->Cell(0, 6, "Semester: $semester", 0, 1, 'C');
$pdf->Cell(0, 6, "Tahun Ajaran: $tahun_ajaran", 0, 1, 'C');
$pdf->Ln(5);

// =========================
// QUERY DATA
// =========================
if (isset($_POST['cetak_data'])) {
    $query_nilai = "SELECT * FROM tb_nilai
                    INNER JOIN tb_siswa ON tb_nilai.nis = tb_siswa.nis
                    INNER JOIN tb_kelas ON tb_nilai.id_kelas = tb_kelas.id_kelas
                    WHERE nama_kelas LIKE '%$kelas%'
                    AND semester LIKE '%$semester%'
                    AND tahun_ajaran LIKE '%$tahun_ajaran%'";
} else {
    $query_nilai = "SELECT * FROM tb_nilai
                    INNER JOIN tb_siswa ON tb_nilai.nis = tb_siswa.nis
                    INNER JOIN tb_kelas ON tb_nilai.id_kelas = tb_kelas.id_kelas";
}

$all_nilai = query($query_nilai);

// Ambil semua mapel unik
$mapel_list = [];
foreach ($all_nilai as $row) {
    if (!in_array($row['mapel'], $mapel_list)) {
        $mapel_list[] = $row['mapel'];
    }
}
sort($mapel_list);

// =========================
// PERHITUNGAN LEBAR KOLOM
// =========================
$total_lebar_tabel = 267; // A4 landscape width - 20 (margin)
$lebar_no = 10;
$lebar_nama = 45;
$lebar_jumlah = 10;
$lebar_rata2 = 10;
$lebar_ket = 10;

$sisa_lebar = $total_lebar_tabel - ($lebar_no + $lebar_nama + $lebar_jumlah + $lebar_rata2 + $lebar_ket);
$jumlah_mapel = count($mapel_list);
$lebar_per_mapel = $jumlah_mapel > 0 ? $sisa_lebar / $jumlah_mapel : 25;

// =========================
// HEADER TABEL
// =========================
$pdf->SetFont('Times', 'B', 6);
$pdf->SetFillColor(220, 220, 220);
$pdf->Cell($lebar_no, 10, 'NO', 1, 0, 'C', true);
$pdf->Cell($lebar_nama, 10, 'Nama Siswa', 1, 0, 'C', true);

foreach ($mapel_list as $mapel) {
    $pdf->Cell($lebar_per_mapel, 10, $mapel, 1, 0, 'C', true);
}

$pdf->Cell($lebar_jumlah, 10, 'Jumlah', 1, 0, 'C', true);
$pdf->Cell($lebar_rata2, 10, 'Rata2', 1, 0, 'C', true);
$pdf->Cell($lebar_ket, 10, 'Keterangan', 1, 1, 'C', true);

// =========================
// ISI DATA
// =========================
$siswa_list = [];
foreach ($all_nilai as $row) {
    $nis = $row['nis'];
    if (!isset($siswa_list[$nis])) {
        $siswa_list[$nis] = [
            'nis' => $nis,
            'nama_siswa' => $row['nama_siswa'],
            'nilai' => []
        ];
    }
    $siswa_list[$nis]['nilai'][$row['mapel']] = $row['nilai'];
}

$pdf->SetFont('Times', '', 9);
$i = 1;
foreach ($siswa_list as $siswa) {
    $pdf->Cell($lebar_no, 8, $i++, 1, 0, 'C');
    $pdf->Cell($lebar_nama, 8, $siswa['nama_siswa'], 1, 0);

    $total = 0;
    $count = 0;

    foreach ($mapel_list as $mapel) {
        $nilai_value = $siswa['nilai'][$mapel] ?? 0;
        $pdf->Cell($lebar_per_mapel, 8, $nilai_value, 1, 0, 'C');
        $total += $nilai_value;
        $count++;
    }

    $rata_angka = $count ? $total / $count : 0;
    $rata2 = number_format($rata_angka, 2);
    $keterangan = ($rata_angka >= 60) ? 'Lulus' : 'Tidak Lulus';

    $pdf->Cell($lebar_jumlah, 8, $total, 1, 0, 'C');
    $pdf->Cell($lebar_rata2, 8, $rata2, 1, 0, 'C');
    $pdf->Cell($lebar_ket, 8, $keterangan, 1, 1, 'C');
}

// =========================
// TANDA TANGAN
// =========================
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

$tanda_width = $pdf->GetStringWidth('____________________');
$x_ttd = $x_pos + ($ketua_width - $tanda_width) / 2;
$pdf->SetX($x_ttd);
$pdf->Cell($tanda_width, 6, '____________________', 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$nama = 'Busra. N,S.Pd.I, M.Pd';
$nama_width = $pdf->GetStringWidth($nama);
$x_nama = $x_pos + ($ketua_width - $nama_width) / 2;
$pdf->SetX($x_nama);
$pdf->Cell($nama_width, 6, $nama, 0, 1);

// =========================
// OUTPUT PDF
// =========================
$pdf->Output('I', 'rekap_nilai_siswa.pdf');
?>