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

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'KODE TRANSAKSI');
$sheet->setCellValue('C1', 'USER');
$sheet->setCellValue('D1', 'KODE PRODUK');
$sheet->setCellValue('E1', 'NAMA PRODUK');
$sheet->setCellValue('F1', 'SATUAN');
$sheet->setCellValue('G1', 'HARGA');
$sheet->setCellValue('H1', 'STOCK IN');
$sheet->setCellValue('I1', 'TOTAL');
$sheet->setCellValue('J1', 'SUPPLIER');
$sheet->setCellValue('K1', 'TANGGAL');

$i = 2;
$no = 1;

// Cek apakah ada filter tanggal
if (isset($_GET['dari']) && isset($_GET['sampai']) && !empty($_GET['dari']) && !empty($_GET['sampai'])) {
    $dari = $_GET['dari'];
    $sampai = $_GET['sampai'];

    $datas = mysqli_query(
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

    $filename = 'Data Pembelian ' . date('d-m-Y', strtotime($dari)) . ' sd ' . date('d-m-Y', strtotime($sampai)) . '.xlsx';
} else {
    // Jika tidak ada filter, ambil semua data
    $datas = mysqli_query(
        $conn,
        "SELECT tp.id, tp.kode_transaksi, tp.tanggal, u.nama, tp.keterangan, p.nama_produk, p.kode_produk, s.nama_satuan, tp.harga, tp.stock_in, tp.total_harga, sup.nama_sup
    FROM transaksi_pembelian AS tp 
    INNER JOIN produk AS p ON tp.produk_id = p.id
    INNER JOIN user AS u ON tp.user_id = u.id
    INNER JOIN satuan AS s ON tp.satuan_id = s.id
    INNER JOIN supplier AS sup ON tp.sup_id = sup.id
    ORDER BY tp.tanggal DESC"
    );

    $filename = 'Data Pembelian Semua.xlsx';
}

// Cek apakah query berhasil
if (!$datas) {
    die("Error: " . mysqli_error($conn));
}

// Isi data ke Excel
while ($data = mysqli_fetch_assoc($datas)) {
    $sheet->setCellValue('A' . $i, $no++);
    $sheet->setCellValue('B' . $i, $data['kode_transaksi']);
    $sheet->setCellValue('C' . $i, $data['nama']);
    $sheet->setCellValue('D' . $i, $data['kode_produk']);
    $sheet->setCellValue('E' . $i, $data['nama_produk']);
    $sheet->setCellValue('F' . $i, $data['nama_satuan']);
    $sheet->setCellValue('G' . $i, 'Rp ' . number_format($data['harga'], 0, ',', '.'));
    $sheet->setCellValue('H' . $i, $data['stock_in']);
    $sheet->setCellValue('I' . $i, 'Rp ' . number_format($data['total_harga'], 0, ',', '.'));
    $sheet->setCellValue('J' . $i, $data['nama_sup']);
    $sheet->setCellValue('K' . $i, date('d-m-Y', strtotime($data['tanggal'])));
    $i++;
}

// Save file Excel
$writer = new Xlsx($spreadsheet);
$writer->save($filename);

// Tutup koneksi database
mysqli_close($conn);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Export Data Pembelian</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center py-5">
        <div class="card shadow" style="width: 18rem;">
            <div class="card-header text-center bg-info text-white">
                <h4>Success!</h4>
            </div>
            <div class="card-body text-center">
                <p>Data berhasil di export</p>
                <a href="../laporan/laporan_pembelian.php" class="btn btn-sm bg-secondary w-100 text-white">Back</a>
            </div>
        </div>
    </div>

    <script>
    // Auto download file
    window.location = '<?= $filename ?>';
    </script>
</body>

</html>