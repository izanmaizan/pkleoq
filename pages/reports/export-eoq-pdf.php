<?php

// memanggil library FPDF
require('../../library/fpdf/fpdf.php');
include '../../config/koneksi.php';

// intance object dan memberikan pengaturan halaman PDF

$pdf = new FPDF('P', 'mm', 'LEGAL');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(0, 10, 'LAPORAN EOQ', 0, 1, 'C');
$pdf->Cell(0, 10, date('d-m-Y', strtotime($_GET['dari'])) . ' s/d ' . date('d-m-Y', strtotime($_GET['sampai'])), 0, 1, 'C');
$pdf->Cell(0, 5, '', 0, 1);

$pdf->SetFont('Arial', '', 11);
$pdf->Cell(28, 10, 'Tanggal Export', 0, 0,);
$pdf->Cell(3, 10, ':', 0, 0, 'C');
$pdf->Cell(28, 10, date('d-m-Y'), 0, 1,);

$pdf->Cell(0, 5, '', 0, 1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(10, 7, 'NO', 1, 0, 'C');
$pdf->Cell(45, 7, 'NAMA PRODUK', 1, 0, 'C');
$pdf->Cell(30, 7, 'EOQ', 1, 0, 'C');
$pdf->Cell(30, 7, 'SAFTY STOCK', 1, 0, 'C');
$pdf->Cell(20, 7, 'ROP', 1, 0, 'C');
$pdf->Cell(65, 7, 'SUPPLIER', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$no = 1;

if (isset($_GET['data'])) {
  $data = json_decode(urldecode($_GET['data']), true);

  foreach ($data as $key => $value) {
    $pdf->Cell(10, 6, $no++, 1, 0, 'C');
    $pdf->Cell(45, 6, $value['nama_produk'], 1, 0, 'C');
    $pdf->Cell(30, 6, $value['eoq'], 1, 0, 'C');
    $pdf->Cell(30, 6, $value['safty_stock'], 1, 0, 'C');
    $pdf->Cell(20, 6, $value['rop'], 1, 0, 'C');
    $pdf->Cell(65, 6, $value['nama_supplier'], 1, 1, 'C');
  }
}

$pdf->Output();