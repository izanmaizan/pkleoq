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
    ->setTitle("Data Produk")
    ->setSubject("Master Data Produk")
    ->setDescription("Data master produk PT Wings Group Indonesia");

// Add title
$sheet->setCellValue('A1', 'DATA MASTER PRODUK');
$sheet->setCellValue('A2', 'PT WINGS GROUP INDONESIA');
$sheet->mergeCells('A1:I1');
$sheet->mergeCells('A2:I2');

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
    'A3' => 'NO',
    'B3' => 'KODE PRODUK',
    'C3' => 'NAMA PRODUK',
    'D3' => 'KATEGORI',
    'E3' => 'SATUAN',
    'F3' => 'STOK',
    'G3' => 'HARGA',
    'H3' => 'SUPPLIER',
    'I3' => 'KETERANGAN'
];

foreach ($headers as $cell => $value) {
    $sheet->setCellValue($cell, $value);
}

// Apply header styling
$sheet->getStyle('A3:I3')->applyFromArray($headerStyle);

// Set column widths
$columnWidths = [
    'A' => 8,   // NO
    'B' => 18,  // KODE PRODUK
    'C' => 30,  // NAMA PRODUK
    'D' => 20,  // KATEGORI
    'E' => 15,  // SATUAN
    'F' => 12,  // STOK
    'G' => 18,  // HARGA
    'H' => 25,  // SUPPLIER
    'I' => 30   // KETERANGAN
];

foreach ($columnWidths as $column => $width) {
    $sheet->getColumnDimension($column)->setWidth($width);
}

$i = 4;
$no = 1;

// Query data produk
$query = "SELECT p.id, p.nama_produk, p.kode_produk, p.stock, p.harga, p.keterangan, 
                 k.nama_kategori, s.nama_satuan, sup.nama_sup 
          FROM produk as p 
          JOIN kategori AS k ON p.kategori_id = k.id
          JOIN satuan AS s ON p.satuan_id = s.id 
          JOIN supplier AS sup ON p.sup_id = sup.id
          ORDER BY p.nama_produk ASC";

$datas = mysqli_query($conn, $query);

// Check if query was successful
if (!$datas) {
    die("Error: " . mysqli_error($conn));
}

// Fill data to Excel
while ($data = mysqli_fetch_assoc($datas)) {
    $sheet->setCellValue('A' . $i, $no++);
    $sheet->setCellValue('B' . $i, $data['kode_produk']);
    $sheet->setCellValue('C' . $i, $data['nama_produk']);
    $sheet->setCellValue('D' . $i, $data['nama_kategori']);
    $sheet->setCellValue('E' . $i, $data['nama_satuan']);
    $sheet->setCellValue('F' . $i, (int)$data['stock']);
    $sheet->setCellValue('G' . $i, (int)$data['harga']);
    $sheet->setCellValue('H' . $i, $data['nama_sup']);
    $sheet->setCellValue('I' . $i, $data['keterangan'] ?: '-');

    // Apply data styling
    $sheet->getStyle('A' . $i . ':I' . $i)->applyFromArray($dataStyle);

    // Format number columns
    $sheet->getStyle('F' . $i)->getNumberFormat()->setFormatCode('#,##0');
    $sheet->getStyle('G' . $i)->getNumberFormat()->setFormatCode('#,##0');

    // Center align specific columns
    $sheet->getStyle('A' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('E' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Check stock level and highlight low stock
    if ((int)$data['stock'] < 20) {
        $lowStockStyle = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'FEF3C7'] // Light yellow
            ],
            'font' => [
                'color' => ['rgb' => 'D97706'] // Orange text
            ]
        ];
        $sheet->getStyle('F' . $i)->applyFromArray($lowStockStyle);
    }

    $i++;
}

// Add summary row
$summaryRow = $i + 1;
$sheet->setCellValue('A' . $summaryRow, 'Total Produk:');
$sheet->setCellValue('B' . $summaryRow, ($no - 1) . ' items');
$sheet->setCellValue('C' . $summaryRow, 'Dicetak pada:');
$sheet->setCellValue('D' . $summaryRow, date('d F Y, H:i'));

$summaryStyle = [
    'font' => ['bold' => true],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['rgb' => 'F3F4F6']
    ]
];

$sheet->getStyle('A' . $summaryRow . ':D' . $summaryRow)->applyFromArray($summaryStyle);

// Auto-fit rows
for ($row = 1; $row <= $summaryRow; $row++) {
    $sheet->getRowDimension($row)->setRowHeight(-1);
}

// Generate filename
$filename = 'Data_Produk_' . date('d-m-Y_His') . '.xlsx';

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