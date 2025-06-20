<?php
// Include session check
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: ../../index.php");
  exit;
}

// Load library and database connection
require('../../library/fpdf/fpdf.php');
include '../../config/koneksi.php';

// Custom PDF class for better formatting
class PenjualanPDF extends FPDF
{
  // Page header
  function Header()
  {
    // Logo (if exists)
    // $this->Image('../../logo.png', 10, 6, 30);

    // Title
    $this->SetFont('Arial', 'B', 16);
    $this->Cell(0, 10, 'PT WINGS GROUP INDONESIA', 0, 1, 'C');
    $this->SetFont('Arial', 'B', 14);
    $this->Cell(0, 10, 'LAPORAN TRANSAKSI PENJUALAN', 0, 1, 'C');

    // Date range if filtered
    if (isset($_GET['dari']) && isset($_GET['sampai'])) {
      $this->SetFont('Arial', '', 11);
      $this->Cell(0, 8, 'Periode: ' . date('d F Y', strtotime($_GET['dari'])) . ' s/d ' . date('d F Y', strtotime($_GET['sampai'])), 0, 1, 'C');
    }

    $this->SetFont('Arial', '', 10);
    $this->Cell(0, 5, 'Dicetak pada: ' . date('d F Y, H:i') . ' oleh: ' . $_SESSION['username'], 0, 1, 'C');
    $this->Ln(5);
  }

  // Page footer
  function Footer()
  {
    $this->SetY(-15);
    $this->SetFont('Arial', 'I', 8);
    $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . ' - Sistem EOQ PT Wings Group', 0, 0, 'C');
  }

  // Better Cell function for text wrapping
  function CellFit($w, $h, $txt, $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
  {
    // Cut text if too long
    $txt = (strlen($txt) > 15) ? substr($txt, 0, 12) . '...' : $txt;
    $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
  }
}

// Create PDF instance
$pdf = new PenjualanPDF('L', 'mm', 'LEGAL');
$pdf->AddPage();

// Table header
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(220, 38, 38); // Wings red color
$pdf->SetTextColor(255, 255, 255); // White text

// Header row
$pdf->Cell(10, 8, 'NO', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'KODE TRANSAKSI', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'USER', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'KODE PRODUK', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'NAMA PRODUK', 1, 0, 'C', true);
$pdf->Cell(15, 8, 'SATUAN', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'HARGA', 1, 0, 'C', true);
$pdf->Cell(15, 8, 'QTY', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'SUBTOTAL', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'SUPPLIER', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'TANGGAL', 1, 1, 'C', true);

// Reset text color for data
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 7);

$no = 1;
$totalHargaKeseluruhan = 0;

// Build query based on date filter
if (isset($_GET['dari']) && isset($_GET['sampai']) && !empty($_GET['dari']) && !empty($_GET['sampai'])) {
  $dari = mysqli_real_escape_string($conn, $_GET['dari']);
  $sampai = mysqli_real_escape_string($conn, $_GET['sampai']);

  $sql = mysqli_query(
    $conn,
    "SELECT tp.id, tp.kd_transaksi, tp.tanggal, u.nama, tp.keterangan, 
                p.nama_produk, p.kode_produk, s.nama_satuan, tp.harga, tp.stock_out, 
                tp.total_harga, sup.nama_sup
         FROM transaksi_penjualan AS tp 
         INNER JOIN produk AS p ON tp.produk_id = p.id
         INNER JOIN user AS u ON tp.user_id = u.id
         INNER JOIN satuan AS s ON tp.satuan_id = s.id
         INNER JOIN supplier AS sup ON tp.sup_id = sup.id
         WHERE tp.tanggal BETWEEN '$dari' AND '$sampai'
         ORDER BY tp.tanggal DESC, tp.kd_transaksi ASC"
  );
} else {
  $sql = mysqli_query(
    $conn,
    "SELECT tp.id, tp.kd_transaksi, tp.tanggal, u.nama, tp.keterangan, 
                p.nama_produk, p.kode_produk, s.nama_satuan, tp.harga, tp.stock_out, 
                tp.total_harga, sup.nama_sup
         FROM transaksi_penjualan AS tp 
         INNER JOIN produk AS p ON tp.produk_id = p.id
         INNER JOIN user AS u ON tp.user_id = u.id
         INNER JOIN satuan AS s ON tp.satuan_id = s.id
         INNER JOIN supplier AS sup ON tp.sup_id = sup.id
         ORDER BY tp.tanggal DESC, tp.kd_transaksi ASC"
  );
}

// Check if query successful
if (!$sql) {
  die("Error: " . mysqli_error($conn));
}

// Data rows with alternating colors
$fill = false;
while ($d = mysqli_fetch_array($sql)) {
  // Set alternating row colors
  if ($fill) {
    $pdf->SetFillColor(248, 249, 250); // Light gray
  } else {
    $pdf->SetFillColor(255, 255, 255); // White
  }

  $pdf->Cell(10, 6, $no++, 1, 0, 'C', $fill);
  $pdf->CellFit(30, 6, $d['kd_transaksi'], 1, 0, 'C', $fill);
  $pdf->CellFit(25, 6, $d['nama'], 1, 0, 'C', $fill);
  $pdf->CellFit(25, 6, $d['kode_produk'], 1, 0, 'C', $fill);
  $pdf->CellFit(40, 6, $d['nama_produk'], 1, 0, 'L', $fill);
  $pdf->CellFit(15, 6, $d['nama_satuan'], 1, 0, 'C', $fill);
  $pdf->Cell(25, 6, 'Rp ' . number_format($d['harga'], 0, ',', '.'), 1, 0, 'R', $fill);
  $pdf->Cell(15, 6, number_format($d['stock_out']), 1, 0, 'C', $fill);
  $pdf->Cell(25, 6, 'Rp ' . number_format($d['total_harga'], 0, ',', '.'), 1, 0, 'R', $fill);
  $pdf->CellFit(30, 6, $d['nama_sup'], 1, 0, 'C', $fill);
  $pdf->Cell(25, 6, date('d-m-Y', strtotime($d['tanggal'])), 1, 1, 'C', $fill);

  $totalHargaKeseluruhan += $d['total_harga'];
  $fill = !$fill; // Alternate fill
}

// Total row
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(220, 38, 38); // Wings red
$pdf->SetTextColor(255, 255, 255); // White text
$pdf->Cell(240, 8, 'TOTAL KESELURUHAN', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Rp ' . number_format($totalHargaKeseluruhan, 0, ',', '.'), 1, 1, 'R', true);

// Summary information
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 5, 'Total Transaksi: ' . ($no - 1) . ' transaksi', 0, 1);
$pdf->Cell(0, 5, 'Total Nilai Penjualan: Rp ' . number_format($totalHargaKeseluruhan, 0, ',', '.'), 0, 1);

// Signature area
$pdf->Ln(15);
$pdf->Cell(200, 5, '', 0, 0); // Spacer
$pdf->Cell(80, 5, 'Muara Bungo, ' . date('d F Y'), 0, 1, 'C');
$pdf->Cell(200, 5, '', 0, 0); // Spacer
$pdf->Cell(80, 5, 'Mengetahui,', 0, 1, 'C');
$pdf->Ln(20);
$pdf->Cell(200, 5, '', 0, 0); // Spacer
$pdf->Cell(80, 5, '(_____________________)', 0, 1, 'C');
$pdf->Cell(200, 5, '', 0, 0); // Spacer
$pdf->Cell(80, 5, 'Manager', 0, 1, 'C');

// Close database connection
mysqli_close($conn);

// Output PDF
$pdf->Output('D', 'Laporan_Penjualan_' . date('d-m-Y_His') . '.pdf');