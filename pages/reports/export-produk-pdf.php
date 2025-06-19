<?php

// memanggil library FPDF
require('../../library/fpdf/fpdf.php');
include '../../config/koneksi.php';

// intance object dan memberikan pengaturan halaman PDF

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(0, 10, 'DATA PRODUK', 0, 1, 'C');
$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(35, 10, 'Tanggal Export', 0, 0,);
$pdf->Cell(3, 10, ':', 0, 0, 'C');
$pdf->Cell(30, 10, date('d-m-Y'), 0, 1, 'C');

$pdf->Cell(0, 5, '', 0, 1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(10, 7, 'NO', 1, 0, 'C');
$pdf->Cell(30, 7, 'KODE PRODUK', 1, 0, 'C');
$pdf->Cell(45, 7, 'NAMA PRODUK', 1, 0, 'C');
$pdf->Cell(30, 7, 'KATEGORI', 1, 0, 'C');
$pdf->Cell(20, 7, 'SATUAN', 1, 0, 'C');
$pdf->Cell(20, 7, 'STOCK', 1, 0, 'C');
$pdf->Cell(30, 7, 'HARGA', 1, 0, 'C');
$pdf->Cell(50, 7, 'SUPPLIER', 1, 0, 'C');
$pdf->Cell(40, 7, 'KETERANGAN', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$no = 1;

$sql = mysqli_query($conn, "SELECT p.id, p.nama_produk, p.kode_produk, p.stock, p.harga, p.keterangan, k.nama_kategori, s.nama_satuan, sup.nama_sup 
FROM produk as p 
JOIN kategori AS k ON p.kategori_id = k.id
JOIN satuan AS s ON p.satuan_id = s.id 
JOIN supplier AS sup ON p.sup_id = sup.id");

while ($d = mysqli_fetch_array($sql)) {
  $pdf->Cell(10, 6, $no++, 1, 0, 'C');
  $pdf->Cell(30, 6, $d['kode_produk'], 1, 0, 'C');
  $pdf->Cell(45, 6, $d['nama_produk'], 1, 0, 'C');
  $pdf->Cell(30, 6, $d['nama_kategori'], 1, 0, 'C');
  $pdf->Cell(20, 6, $d['nama_satuan'], 1, 0, 'C');
  $pdf->Cell(20, 6, $d['stock'], 1, 0, 'C');
  $pdf->Cell(30, 6, 'Rp ' . number_format($d['harga'], 0, ',', '.'), 1, 0, 'C');
  $pdf->Cell(50, 6, $d['nama_sup'], 1, 0, 'C');
  $pdf->Cell(40, 6, $d['keterangan'], 1, 1, 'C');
}

$pdf->Output();