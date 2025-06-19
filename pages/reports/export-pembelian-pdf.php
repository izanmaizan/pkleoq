<?php
// memanggil library FPDF
require('../../library/fpdf/fpdf.php');
include '../../config/koneksi.php';

// instance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('L', 'mm', 'LEGAL');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(0, 10, 'DATA TRANSAKSI PEMBELIAN', 0, 1, 'C');

// Tampilkan rentang tanggal jika ada filter
if (isset($_GET['dari']) && isset($_GET['sampai'])) {
  $pdf->Cell(0, 10, 'Periode: ' . date('d-m-Y', strtotime($_GET['dari'])) . ' s/d ' . date('d-m-Y', strtotime($_GET['sampai'])), 0, 1, 'C');
}

$pdf->Cell(0, 5, '', 0, 1);

$pdf->SetFont('Arial', '', 11);
$pdf->Cell(35, 10, 'Tanggal Export', 0, 0);
$pdf->Cell(3, 10, ':', 0, 0, 'C');
$pdf->Cell(30, 10, date('d-m-Y'), 0, 1);

$pdf->Cell(0, 5, '', 0, 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 7, 'NO', 1, 0, 'C');
$pdf->Cell(35, 7, 'KODE TRANSAKSI', 1, 0, 'C');
$pdf->Cell(25, 7, 'USER', 1, 0, 'C');
$pdf->Cell(25, 7, 'KODE PRODUK', 1, 0, 'C');
$pdf->Cell(40, 7, 'NAMA PRODUK', 1, 0, 'C');
$pdf->Cell(15, 7, 'SATUAN', 1, 0, 'C');
$pdf->Cell(25, 7, 'HARGA', 1, 0, 'C');
$pdf->Cell(15, 7, 'STOCK IN', 1, 0, 'C');
$pdf->Cell(25, 7, 'TOTAL', 1, 0, 'C');
$pdf->Cell(30, 7, 'SUPPLIER', 1, 0, 'C');
$pdf->Cell(25, 7, 'TANGGAL', 1, 1, 'C');

$pdf->SetFont('Arial', '', 7);
$no = 1;
$totalHargaKeseluruhan = 0;

// Query berdasarkan filter tanggal
if (isset($_GET['dari']) && isset($_GET['sampai'])) {
  $dari = $_GET['dari'];
  $sampai = $_GET['sampai'];

  $sql = mysqli_query(
    $conn,
    "SELECT tp.id, tp.kode_transaksi, tp.tanggal, u.nama, tp.keterangan, p.nama_produk, p.kode_produk, s.nama_satuan, tp.harga, tp.stock_in, tp.total_harga, sup.nama_sup
  FROM transaksi_pembelian AS tp 
  INNER JOIN produk AS p ON tp.produk_id = p.id
  INNER JOIN user AS u ON tp.user_id = u.id
  INNER JOIN satuan AS s ON tp.satuan_id = s.id
  INNER JOIN supplier AS sup ON tp.sup_id = sup.id
  WHERE tp.tanggal BETWEEN '$dari' AND '$sampai'
  ORDER BY tp.tanggal DESC"
  );
} else {
  // Jika tidak ada filter, ambil semua data
  $sql = mysqli_query(
    $conn,
    "SELECT tp.id, tp.kode_transaksi, tp.tanggal, u.nama, tp.keterangan, p.nama_produk, p.kode_produk, s.nama_satuan, tp.harga, tp.stock_in, tp.total_harga, sup.nama_sup
  FROM transaksi_pembelian AS tp 
  INNER JOIN produk AS p ON tp.produk_id = p.id
  INNER JOIN user AS u ON tp.user_id = u.id
  INNER JOIN satuan AS s ON tp.satuan_id = s.id
  INNER JOIN supplier AS sup ON tp.sup_id = sup.id
  ORDER BY tp.tanggal DESC"
  );
}

while ($d = mysqli_fetch_array($sql)) {
  $pdf->Cell(10, 6, $no++, 1, 0, 'C');
  $pdf->Cell(35, 6, $d['kode_transaksi'], 1, 0, 'C');
  $pdf->Cell(25, 6, $d['nama'], 1, 0, 'C');
  $pdf->Cell(25, 6, $d['kode_produk'], 1, 0, 'C');
  $pdf->Cell(40, 6, $d['nama_produk'], 1, 0, 'C');
  $pdf->Cell(15, 6, $d['nama_satuan'], 1, 0, 'C');
  $pdf->Cell(25, 6, 'Rp ' . number_format($d['harga'], 0, ',', '.'), 1, 0, 'C');
  $pdf->Cell(15, 6, $d['stock_in'], 1, 0, 'C');
  $pdf->Cell(25, 6, 'Rp ' . number_format($d['total_harga'], 0, ',', '.'), 1, 0, 'C');
  $pdf->Cell(30, 6, $d['nama_sup'], 1, 0, 'C');
  $pdf->Cell(25, 6, date('d-m-Y', strtotime($d['tanggal'])), 1, 1, 'C');

  // Menghitung total harga keseluruhan
  $totalHargaKeseluruhan += $d['total_harga'];
}

// Tampilkan total keseluruhan
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(245, 7, 'TOTAL KESELURUHAN', 1, 0, 'C');
$pdf->Cell(25, 7, 'Rp ' . number_format($totalHargaKeseluruhan, 0, ',', '.'), 1, 1, 'C');

$pdf->Output();