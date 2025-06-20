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
class ProdukPDF extends FPDF
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
    $this->Cell(0, 10, 'DATA MASTER PRODUK', 0, 1, 'C');

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
    // Determine max length based on column width
    $maxLen = ($w > 40) ? 20 : (($w > 25) ? 12 : 8);
    $txt = (strlen($txt) > $maxLen) ? substr($txt, 0, $maxLen - 3) . '...' : $txt;
    $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
  }
}

// Create PDF instance
$pdf = new ProdukPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Table header
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(220, 38, 38); // Wings red color
$pdf->SetTextColor(255, 255, 255); // White text

// Header row
$pdf->Cell(10, 8, 'NO', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'KODE PRODUK', 1, 0, 'C', true);
$pdf->Cell(45, 8, 'NAMA PRODUK', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'KATEGORI', 1, 0, 'C', true);
$pdf->Cell(18, 8, 'SATUAN', 1, 0, 'C', true);
$pdf->Cell(18, 8, 'STOK', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'HARGA', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'SUPPLIER', 1, 0, 'C', true);
$pdf->Cell(35, 8, 'KETERANGAN', 1, 1, 'C', true);

// Reset text color for data
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 8);

$no = 1;
$totalProduk = 0;
$totalStok = 0;
$lowStockCount = 0;

// Query data produk
$sql = mysqli_query($conn, "SELECT p.id, p.nama_produk, p.kode_produk, p.stock, p.harga, p.keterangan, 
                                   k.nama_kategori, s.nama_satuan, sup.nama_sup 
                            FROM produk as p 
                            JOIN kategori AS k ON p.kategori_id = k.id
                            JOIN satuan AS s ON p.satuan_id = s.id 
                            JOIN supplier AS sup ON p.sup_id = sup.id
                            ORDER BY p.nama_produk ASC");

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

  // Highlight low stock items
  $isLowStock = ($d['stock'] < 20);
  if ($isLowStock) {
    $pdf->SetFillColor(254, 243, 199); // Light yellow for low stock
    $lowStockCount++;
  }

  $pdf->Cell(10, 6, $no++, 1, 0, 'C', $fill || $isLowStock);
  $pdf->CellFit(25, 6, $d['kode_produk'], 1, 0, 'C', $fill || $isLowStock);
  $pdf->CellFit(45, 6, $d['nama_produk'], 1, 0, 'L', $fill || $isLowStock);
  $pdf->CellFit(25, 6, $d['nama_kategori'], 1, 0, 'C', $fill || $isLowStock);
  $pdf->CellFit(18, 6, $d['nama_satuan'], 1, 0, 'C', $fill || $isLowStock);

  // Special handling for stock column
  if ($isLowStock) {
    $pdf->SetTextColor(217, 119, 6); // Orange text for low stock
    $pdf->Cell(18, 6, $d['stock'] . ' (!)', 1, 0, 'C', $fill || $isLowStock);
    $pdf->SetTextColor(0, 0, 0); // Reset to black
  } else {
    $pdf->Cell(18, 6, $d['stock'], 1, 0, 'C', $fill || $isLowStock);
  }

  $pdf->Cell(25, 6, 'Rp ' . number_format($d['harga'], 0, ',', '.'), 1, 0, 'R', $fill || $isLowStock);
  $pdf->CellFit(40, 6, $d['nama_sup'], 1, 0, 'L', $fill || $isLowStock);
  $pdf->CellFit(35, 6, $d['keterangan'] ?: '-', 1, 1, 'L', $fill || $isLowStock);

  $totalProduk++;
  $totalStok += $d['stock'];
  $fill = !$fill; // Alternate fill
}

// Summary section
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(220, 38, 38); // Wings red
$pdf->SetTextColor(255, 255, 255); // White text
$pdf->Cell(0, 8, 'RINGKASAN DATA PRODUK', 1, 1, 'C', true);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);
$pdf->SetFillColor(248, 249, 250); // Light gray

$pdf->Cell(70, 6, 'Total Produk:', 1, 0, 'L', true);
$pdf->Cell(30, 6, number_format($totalProduk) . ' items', 1, 0, 'C', false);
$pdf->Cell(70, 6, 'Total Stok Keseluruhan:', 1, 0, 'L', true);
$pdf->Cell(30, 6, number_format($totalStok) . ' unit', 1, 1, 'C', false);

$pdf->Cell(70, 6, 'Produk Stok Rendah (<20):', 1, 0, 'L', true);
$pdf->SetTextColor($lowStockCount > 0 ? 217 : 0, $lowStockCount > 0 ? 119 : 0, $lowStockCount > 0 ? 6 : 0);
$pdf->Cell(30, 6, number_format($lowStockCount) . ' items', 1, 0, 'C', false);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(70, 6, 'Tanggal Export:', 1, 0, 'L', true);
$pdf->Cell(30, 6, date('d-m-Y'), 1, 1, 'C', false);

// Legend for low stock
if ($lowStockCount > 0) {
  $pdf->Ln(5);
  $pdf->SetFont('Arial', 'I', 8);
  $pdf->SetFillColor(254, 243, 199); // Light yellow
  $pdf->Cell(10, 5, '', 1, 0, 'C', true);
  $pdf->Cell(0, 5, ' = Produk dengan stok rendah (kurang dari 20 unit)', 0, 1, 'L');
}

// Signature area
$pdf->Ln(15);
$pdf->SetFont('Arial', '', 9);
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
$pdf->Output('D', 'Data_Produk_' . date('d-m-Y_His') . '.pdf');