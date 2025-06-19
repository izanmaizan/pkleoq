<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Export Data Produk</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center py-5">
        <div class="card shadow" style="width: 18rem;">
            <div class="card-header text-center bg-info text-white">
                <h4>Success!</h4>
            </div>
            <div class="card-body text-center">
                <p>Data berhasil di export</p>
                <a href="../laporan/laporan_produk.php" class="btn btn-sm bg-secondary w-100 text-white">Back</a>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
</body>

</html>

<?php
include '../../config/koneksi.php';
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'KODE PRODUK');
$sheet->setCellValue('C1', 'NAMA PRODUK');
$sheet->setCellValue('D1', 'KATEGORI');
$sheet->setCellValue('E1', 'SATUAN');
$sheet->setCellValue('F1', 'STOK');
$sheet->setCellValue('G1', 'HARGA');
$sheet->setCellValue('H1', 'SUPPLIER');
$sheet->setCellValue('I1', 'KETERANGAN');

$i = 2;
$no = 1;

$datas = mysqli_query($conn, "SELECT p.id, p.nama_produk, p.kode_produk, p.stock, p.harga, p.keterangan, k.nama_kategori, s.nama_satuan, sup.nama_sup 
    FROM produk as p 
    JOIN kategori AS k ON p.kategori_id = k.id
    JOIN satuan AS s ON p.satuan_id = s.id 
    JOIN supplier AS sup ON p.sup_id = sup.id");

while ($data = mysqli_fetch_assoc($datas)) {
    $sheet->setCellValue('A' . $i, $no++);
    $sheet->setCellValue('B' . $i, $data['kode_produk']);
    $sheet->setCellValue('C' . $i, $data['nama_produk']);
    $sheet->setCellValue('D' . $i, $data['nama_kategori']);
    $sheet->setCellValue('E' . $i, $data['nama_satuan']);
    $sheet->setCellValue('F' . $i, $data['stock']);
    $sheet->setCellValue('G' . $i, $data['harga']);
    $sheet->setCellValue('H' . $i, $data['nama_sup']);
    $sheet->setCellValue('I' . $i, $data['keterangan']);
    $i++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('Data Produk Apotek.xlsx');
echo "<script>window.location = 'Data Produk Apotek.xlsx'</script>";

?>