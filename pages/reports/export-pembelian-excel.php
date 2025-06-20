<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit;
}

include '../../config/koneksi.php';
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set document properties
$spreadsheet->getProperties()
    ->setCreator("PT Wings Group")
    ->setTitle("Laporan Pembelian")
    ->setSubject("Data Transaksi Pembelian")
    ->setDescription("Laporan transaksi pembelian PT Wings Group Indonesia");

// Header styling
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
        'size' => 12
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'dc2626']
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000']
        ]
    ]
];

// Data styling
$dataStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => 'CCCCCC']
        ]
    ],
    'alignment' => [
        'vertical' => Alignment::VERTICAL_CENTER
    ]
];

// Set column headers
$headers = [
    'A1' => 'NO',
    'B1' => 'KODE TRANSAKSI',
    'C1' => 'USER',
    'D1' => 'KODE PRODUK',
    'E1' => 'NAMA PRODUK',
    'F1' => 'SATUAN',
    'G1' => 'HARGA SATUAN',
    'H1' => 'QTY BELI',
    'I1' => 'SUBTOTAL',
    'J1' => 'SUPPLIER',
    'K1' => 'TANGGAL'
];

foreach ($headers as $cell => $value) {
    $sheet->setCellValue($cell, $value);
}

// Apply header styling
$sheet->getStyle('A1:K1')->applyFromArray($headerStyle);

// Set column widths
$columnWidths = [
    'A' => 8,   // NO
    'B' => 20,  // KODE TRANSAKSI
    'C' => 20,  // USER
    'D' => 15,  // KODE PRODUK
    'E' => 30,  // NAMA PRODUK
    'F' => 12,  // SATUAN
    'G' => 18,  // HARGA SATUAN
    'H' => 12,  // QTY BELI
    'I' => 18,  // SUBTOTAL
    'J' => 25,  // SUPPLIER
    'K' => 15   // TANGGAL
];

foreach ($columnWidths as $column => $width) {
    $sheet->getColumnDimension($column)->setWidth($width);
}

$i = 2;
$no = 1;
$totalKeseluruhan = 0;

// Build query based on date filter
if (isset($_GET['dari']) && isset($_GET['sampai']) && !empty($_GET['dari']) && !empty($_GET['sampai'])) {
    $dari = mysqli_real_escape_string($conn, $_GET['dari']);
    $sampai = mysqli_real_escape_string($conn, $_GET['sampai']);

    $query = "SELECT tp.id, tp.kode_transaksi, tp.tanggal, u.nama, tp.keterangan, 
                     p.nama_produk, p.kode_produk, s.nama_satuan, tp.harga, tp.stock_in, 
                     tp.total_harga, sup.nama_sup
              FROM transaksi_pembelian AS tp 
              INNER JOIN produk AS p ON tp.produk_id = p.id
              INNER JOIN user AS u ON tp.user_id = u.id
              INNER JOIN satuan AS s ON tp.satuan_id = s.id
              INNER JOIN supplier AS sup ON tp.sup_id = sup.id
              WHERE tp.tanggal BETWEEN '$dari' AND '$sampai'
              ORDER BY tp.tanggal DESC, tp.kode_transaksi ASC";

    $filename = 'Laporan_Pembelian_' . date('d-m-Y', strtotime($dari)) . '_sd_' . date('d-m-Y', strtotime($sampai)) . '.xlsx';

    // Add title with date range
    $sheet->insertNewRowBefore(1, 2);
    $sheet->setCellValue('A1', 'LAPORAN TRANSAKSI PEMBELIAN');
    $sheet->setCellValue('A2', 'Periode: ' . date('d F Y', strtotime($dari)) . ' s/d ' . date('d F Y', strtotime($sampai)));
    $sheet->mergeCells('A1:K1');
    $sheet->mergeCells('A2:K2');

    $titleStyle = [
        'font' => ['bold' => true, 'size' => 16],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
    ];
    $subtitleStyle = [
        'font' => ['bold' => true, 'size' => 12],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
    ];

    $sheet->getStyle('A1')->applyFromArray($titleStyle);
    $sheet->getStyle('A2')->applyFromArray($subtitleStyle);

    // Update header row and data start
    foreach ($headers as $cell => $value) {
        $newCell = str_replace('1', '3', $cell);
        $sheet->setCellValue($newCell, $value);
    }
    $sheet->getStyle('A3:K3')->applyFromArray($headerStyle);
    $i = 4;
} else {
    $query = "SELECT tp.id, tp.kode_transaksi, tp.tanggal, u.nama, tp.keterangan, 
                     p.nama_produk, p.kode_produk, s.nama_satuan, tp.harga, tp.stock_in, 
                     tp.total_harga, sup.nama_sup
              FROM transaksi_pembelian AS tp 
              INNER JOIN produk AS p ON tp.produk_id = p.id
              INNER JOIN user AS u ON tp.user_id = u.id
              INNER JOIN satuan AS s ON tp.satuan_id = s.id
              INNER JOIN supplier AS sup ON tp.sup_id = sup.id
              ORDER BY tp.tanggal DESC, tp.kode_transaksi ASC";

    $filename = 'Laporan_Pembelian_Semua_' . date('d-m-Y') . '.xlsx';
}

$datas = mysqli_query($conn, $query);

// Check if query was successful
if (!$datas) {
    die("Error: " . mysqli_error($conn));
}

// Fill data to Excel
while ($data = mysqli_fetch_assoc($datas)) {
    $sheet->setCellValue('A' . $i, $no++);
    $sheet->setCellValue('B' . $i, $data['kode_transaksi']);
    $sheet->setCellValue('C' . $i, $data['nama']);
    $sheet->setCellValue('D' . $i, $data['kode_produk']);
    $sheet->setCellValue('E' . $i, $data['nama_produk']);
    $sheet->setCellValue('F' . $i, $data['nama_satuan']);
    $sheet->setCellValue('G' . $i, (int)$data['harga']);
    $sheet->setCellValue('H' . $i, (int)$data['stock_in']);
    $sheet->setCellValue('I' . $i, (int)$data['total_harga']);
    $sheet->setCellValue('J' . $i, $data['nama_sup']);
    $sheet->setCellValue('K' . $i, date('d-m-Y', strtotime($data['tanggal'])));

    // Apply data styling
    $sheet->getStyle('A' . $i . ':K' . $i)->applyFromArray($dataStyle);

    // Format currency columns
    $sheet->getStyle('G' . $i)->getNumberFormat()->setFormatCode('#,##0');
    $sheet->getStyle('I' . $i)->getNumberFormat()->setFormatCode('#,##0');

    // Center align number columns
    $sheet->getStyle('A' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('H' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $totalKeseluruhan += (int)$data['total_harga'];
    $i++;
}

// Add total row
$totalRow = $i;
$sheet->setCellValue('A' . $totalRow, '');
$sheet->setCellValue('B' . $totalRow, '');
$sheet->setCellValue('C' . $totalRow, '');
$sheet->setCellValue('D' . $totalRow, '');
$sheet->setCellValue('E' . $totalRow, '');
$sheet->setCellValue('F' . $totalRow, '');
$sheet->setCellValue('G' . $totalRow, '');
$sheet->setCellValue('H' . $totalRow, 'TOTAL:');
$sheet->setCellValue('I' . $totalRow, $totalKeseluruhan);
$sheet->setCellValue('J' . $totalRow, '');
$sheet->setCellValue('K' . $totalRow, '');

// Style total row
$totalStyle = [
    'font' => ['bold' => true],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'F3F4F6']
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000']
        ]
    ]
];

$sheet->getStyle('A' . $totalRow . ':K' . $totalRow)->applyFromArray($totalStyle);
$sheet->getStyle('H' . $totalRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('I' . $totalRow)->getNumberFormat()->setFormatCode('#,##0');

// Auto-fit rows
for ($row = 1; $row <= $totalRow; $row++) {
    $sheet->getRowDimension($row)->setRowHeight(-1);
}

// Save Excel file
$writer = new Xlsx($spreadsheet);

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Save to output
$writer->save('php://output');

// Close database connection
mysqli_close($conn);
exit;