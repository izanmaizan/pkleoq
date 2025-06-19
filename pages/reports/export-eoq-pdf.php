<?php
// ============================================================================
// EXPORT EOQ PDF - SISTEM EOQ PT WINGS GROUP INDONESIA
// ============================================================================

// Memanggil library FPDF
require('../../library/fpdf/fpdf.php');
include '../../config/koneksi.php';

// ============================================================================
// TAHAP 1: VALIDASI INPUT DAN DECODE DATA
// ============================================================================

// Validasi parameter yang diperlukan
if (!isset($_GET['data']) || !isset($_GET['dari']) || !isset($_GET['sampai'])) {
  die('Error: Parameter data, dari, dan sampai diperlukan');
}

// Decode data JSON dari parameter
$data = json_decode(urldecode($_GET['data']), true);

// Validasi decode JSON berhasil
if ($data === null) {
  die('Error: Data JSON tidak valid');
}

// Validasi data tidak kosong
if (empty($data)) {
  die('Error: Data EOQ kosong');
}

// Ambil parameter tanggal
$dari = $_GET['dari'];
$sampai = $_GET['sampai'];

// ============================================================================
// TAHAP 2: INISIALISASI PDF DAN PENGATURAN HALAMAN
// ============================================================================

// Instance object FPDF dengan pengaturan halaman Legal Portrait
$pdf = new FPDF('P', 'mm', 'LEGAL');
$pdf->AddPage();

// Margin dan spacing
$left_margin = 10;
$pdf->SetLeftMargin($left_margin);

// ============================================================================
// TAHAP 3: HEADER LAPORAN
// ============================================================================

// Logo atau header perusahaan
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 12, 'PT WINGS GROUP INDONESIA', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, 'Cabang Muara Bungo, Jambi', 0, 1, 'C');
$pdf->Ln(5);

// Judul laporan
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'LAPORAN ANALISIS ECONOMIC ORDER QUANTITY (EOQ)', 0, 1, 'C');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 8, 'Periode: ' . date('d-m-Y', strtotime($dari)) . ' s/d ' . date('d-m-Y', strtotime($sampai)), 0, 1, 'C');
$pdf->Ln(3);

// Informasi export
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 6, 'Tanggal Export', 0, 0);
$pdf->Cell(5, 6, ':', 0, 0);
$pdf->Cell(50, 6, date('d-m-Y H:i:s'), 0, 0);
$pdf->Cell(40, 6, 'Total Produk', 0, 0);
$pdf->Cell(5, 6, ':', 0, 0);
$pdf->Cell(30, 6, count($data) . ' produk', 0, 1);
$pdf->Ln(5);

// ============================================================================
// TAHAP 4: HEADER TABEL EOQ
// ============================================================================

$pdf->SetFont('Arial', 'B', 9);

// Header tabel dengan lebar yang disesuaikan
$pdf->Cell(8, 8, 'NO', 1, 0, 'C');
$pdf->Cell(60, 8, 'NAMA PRODUK', 1, 0, 'C');
$pdf->Cell(20, 8, 'DEMAND', 1, 0, 'C');
$pdf->Cell(25, 8, 'BIAYA PESAN', 1, 0, 'C');
$pdf->Cell(25, 8, 'BIAYA SIMPAN', 1, 0, 'C');
$pdf->Cell(18, 8, 'EOQ', 1, 0, 'C');
$pdf->Cell(18, 8, 'FREQ', 1, 0, 'C');
$pdf->Cell(26, 8, 'INTERVAL', 1, 1, 'C');

// Sub-header untuk unit
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(8, 4, '', 1, 0, 'C');
$pdf->Cell(60, 4, '', 1, 0, 'C');
$pdf->Cell(20, 4, '(unit)', 1, 0, 'C');
$pdf->Cell(25, 4, '(Rp)', 1, 0, 'C');
$pdf->Cell(25, 4, '(Rp)', 1, 0, 'C');
$pdf->Cell(18, 4, '(unit)', 1, 0, 'C');
$pdf->Cell(18, 4, '(/thn)', 1, 0, 'C');
$pdf->Cell(26, 4, '(hari)', 1, 1, 'C');

// ============================================================================
// TAHAP 5: ISI TABEL DATA EOQ
// ============================================================================

$pdf->SetFont('Arial', '', 8);
$no = 1;

foreach ($data as $item) {
  // Validasi dan ambil data dengan fallback values
  $nama_produk = isset($item['nama_produk']) ? $item['nama_produk'] : 'N/A';
  $demand = isset($item['demand_tahunan']) ? (int)$item['demand_tahunan'] : 0;
  $biaya_pesan = isset($item['biaya_pemesanan']) ? (float)$item['biaya_pemesanan'] : 0;
  $biaya_simpan = isset($item['biaya_penyimpanan']) ? (float)$item['biaya_penyimpanan'] : 0;
  $eoq = isset($item['eoq_optimal']) ? (int)$item['eoq_optimal'] : 0;
  $freq = isset($item['frekuensi_pesan']) ? (int)$item['frekuensi_pesan'] : 0;
  $interval = isset($item['interval_hari']) ? (int)$item['interval_hari'] : 0;

  // Potong nama produk jika terlalu panjang
  if (strlen($nama_produk) > 35) {
    $nama_produk = substr($nama_produk, 0, 32) . '...';
  }

  // Hitung tinggi cell yang diperlukan untuk nama produk
  $cell_height = 6;
  if (strlen($nama_produk) > 25) {
    $cell_height = 8; // Tinggi lebih untuk nama panjang
  }

  // Cetak baris data
  $pdf->Cell(8, $cell_height, $no++, 1, 0, 'C');
  $pdf->Cell(60, $cell_height, $nama_produk, 1, 0, 'L');
  $pdf->Cell(20, $cell_height, number_format($demand, 0, ',', '.'), 1, 0, 'C');
  $pdf->Cell(25, $cell_height, number_format($biaya_pesan, 0, ',', '.'), 1, 0, 'R');
  $pdf->Cell(25, $cell_height, number_format($biaya_simpan, 0, ',', '.'), 1, 0, 'R');
  $pdf->Cell(18, $cell_height, number_format($eoq, 0, ',', '.'), 1, 0, 'C');
  $pdf->Cell(18, $cell_height, $freq, 1, 0, 'C');
  $pdf->Cell(26, $cell_height, $interval, 1, 1, 'C');

  // Cek apakah perlu halaman baru
  if ($pdf->GetY() > 320) { // Mendekati batas halaman Legal
    $pdf->AddPage();

    // Ulangi header di halaman baru
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(8, 8, 'NO', 1, 0, 'C');
    $pdf->Cell(60, 8, 'NAMA PRODUK', 1, 0, 'C');
    $pdf->Cell(20, 8, 'DEMAND', 1, 0, 'C');
    $pdf->Cell(25, 8, 'BIAYA PESAN', 1, 0, 'C');
    $pdf->Cell(25, 8, 'BIAYA SIMPAN', 1, 0, 'C');
    $pdf->Cell(18, 8, 'EOQ', 1, 0, 'C');
    $pdf->Cell(18, 8, 'FREQ', 1, 0, 'C');
    $pdf->Cell(26, 8, 'INTERVAL', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 8);
  }
}

// ============================================================================
// TAHAP 6: RINGKASAN STATISTIK EOQ
// ============================================================================

$pdf->Ln(8);

// Hitung statistik dari data
$total_demand = array_sum(array_column($data, 'demand_tahunan'));
$total_eoq = array_sum(array_column($data, 'eoq_optimal'));
$avg_eoq = count($data) > 0 ? round($total_eoq / count($data), 1) : 0;
$avg_freq = count($data) > 0 ? round(array_sum(array_column($data, 'frekuensi_pesan')) / count($data), 1) : 0;

// Header ringkasan
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 8, 'RINGKASAN ANALISIS EOQ', 0, 1, 'C');
$pdf->Ln(2);

// Tabel ringkasan
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(100, 7, 'METRIK', 1, 0, 'C');
$pdf->Cell(80, 7, 'NILAI', 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 6, 'Total Produk Dianalisis', 1, 0, 'L');
$pdf->Cell(80, 6, count($data) . ' produk', 1, 1, 'C');

$pdf->Cell(100, 6, 'Total Demand Tahunan', 1, 0, 'L');
$pdf->Cell(80, 6, number_format($total_demand, 0, ',', '.') . ' unit', 1, 1, 'C');

$pdf->Cell(100, 6, 'Total EOQ Optimal', 1, 0, 'L');
$pdf->Cell(80, 6, number_format($total_eoq, 0, ',', '.') . ' unit', 1, 1, 'C');

$pdf->Cell(100, 6, 'Rata-rata EOQ per Produk', 1, 0, 'L');
$pdf->Cell(80, 6, $avg_eoq . ' unit', 1, 1, 'C');

$pdf->Cell(100, 6, 'Rata-rata Frekuensi Pemesanan', 1, 0, 'L');
$pdf->Cell(80, 6, $avg_freq . ' kali per tahun', 1, 1, 'C');

// ============================================================================
// TAHAP 7: INFORMASI METODOLOGI
// ============================================================================

$pdf->Ln(8);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, 'METODOLOGI PERHITUNGAN EOQ', 0, 1, 'L');
$pdf->Ln(2);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 5, '1. Formula EOQ: EOQ = √((2 × D × S) / H)', 0, 1, 'L');
$pdf->Cell(0, 5, '   Dimana: D = Demand, S = Setup Cost (12% harga), H = Holding Cost', 0, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(0, 5, '2. Biaya Pemesanan (Setup Cost) = 12% × Harga Produk', 0, 1, 'L');
$pdf->Cell(0, 5, '3. Frekuensi Pemesanan = Demand Tahunan ÷ EOQ', 0, 1, 'L');
$pdf->Cell(0, 5, '4. Interval Pemesanan = 365 hari ÷ Frekuensi Pemesanan', 0, 1, 'L');
$pdf->Ln(3);
$pdf->Cell(0, 5, 'Catatan: Semua nilai EOQ dibulatkan ke bilangan bulat terdekat', 0, 1, 'L');

// ============================================================================
// TAHAP 8: FOOTER
// ============================================================================

$pdf->Ln(10);

// Posisi absolut untuk footer
$pdf->SetY(-30);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 4, 'Laporan ini dihasilkan secara otomatis oleh Sistem EOQ PT Wings Group Indonesia', 0, 1, 'C');
$pdf->Cell(0, 4, 'Dicetak pada: ' . date('d-m-Y H:i:s') . ' oleh sistem', 0, 1, 'C');

// ============================================================================
// TAHAP 9: OUTPUT PDF
// ============================================================================

// Set nama file dengan timestamp
$filename = 'Laporan_EOQ_' . date('Y-m-d_His') . '.pdf';

// Output PDF dengan nama file yang sesuai
$pdf->Output('D', $filename); // 'D' untuk download, 'I' untuk display di browser

// ============================================================================
// LOG AKTIVITAS (OPSIONAL)
// ============================================================================

// Uncomment untuk logging aktivitas export
/*
$log_message = "Export EOQ PDF - Periode: $dari to $sampai - " . count($data) . " produk - " . date('Y-m-d H:i:s');
error_log($log_message);
*/

// ============================================================================
// DOKUMENTASI PERBAIKAN:
// ============================================================================

/*
PERBAIKAN YANG DILAKUKAN:

1. PERBAIKAN STRUKTUR DATA
   - Menggunakan field yang benar: 'eoq_optimal' bukan 'eoq'
   - Menggunakan 'supplier' bukan 'nama_supplier'
   - Menambah validasi untuk semua field data

2. PERBAIKAN ERROR HANDLING
   - Validasi parameter GET sebelum digunakan
   - Validasi JSON decode berhasil
   - Fallback values untuk data yang missing

3. PERBAIKAN LAYOUT PDF
   - Header yang lebih informatif
   - Tabel dengan kolom yang sesuai dengan data EOQ
   - Ringkasan statistik yang berguna
   - Informasi metodologi perhitungan

4. PERBAIKAN FUNGSIONALITAS
   - Auto page break untuk data banyak
   - Format angka yang konsisten
   - Nama file dengan timestamp
   - Footer informatif

5. PERBAIKAN KUALITAS
   - Font dan spacing yang konsisten
   - Alignment yang tepat
   - Cell height yang sesuai konten
   - Professional layout

FITUR BARU YANG DITAMBAHKAN:
- Ringkasan statistik EOQ
- Informasi metodologi perhitungan
- Header perusahaan yang profesional
- Auto pagination untuk data banyak
- Validasi data yang komprehensif
*/