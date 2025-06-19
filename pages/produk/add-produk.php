<?php
// Error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set header JSON di awal
header('Content-Type: application/json');

try {
    include '../../config/koneksi.php';

    // Debug: log data yang diterima
    error_log("POST data received: " . print_r($_POST, true));

    // Validasi koneksi database
    if (!$conn) {
        throw new Exception("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Ambil dan bersihkan data POST
    $kode_produk = isset($_POST['kode_produk']) ? trim($_POST['kode_produk']) : '';
    $nama_produk = isset($_POST['nama_produk']) ? trim($_POST['nama_produk']) : '';
    $supplier = isset($_POST['supplier']) ? trim($_POST['supplier']) : '';
    $kategori = isset($_POST['kategori']) ? trim($_POST['kategori']) : '';
    $satuan = isset($_POST['satuan']) ? trim($_POST['satuan']) : '';
    $stock = isset($_POST['stock']) ? trim($_POST['stock']) : '';
    $harga = isset($_POST['harga']) ? trim($_POST['harga']) : '';
    $biaya_penyimpanan = isset($_POST['biaya_penyimpanan']) ? trim($_POST['biaya_penyimpanan']) : '';
    $keterangan = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : '';

    // Bersihkan format rupiah jika masih ada
    $harga = preg_replace('/[^0-9]/', '', $harga);
    $biaya_penyimpanan = preg_replace('/[^0-9]/', '', $biaya_penyimpanan);

    // Validasi data wajib
    if (
        empty($kode_produk) || empty($nama_produk) || empty($supplier) || empty($kategori) ||
        empty($satuan) || empty($stock) || empty($harga) || empty($biaya_penyimpanan)
    ) {

        $response = array(
            'status' => 'error',
            'message' => 'Data tidak boleh ada yang kosong. Periksa: kode_produk, nama_produk, supplier, kategori, satuan, stock, harga, biaya_penyimpanan'
        );
        echo json_encode($response);
        exit;
    }

    // Validasi tipe data
    if (!is_numeric($stock) || !is_numeric($harga) || !is_numeric($biaya_penyimpanan)) {
        $response = array(
            'status' => 'error',
            'message' => 'Stock, harga, dan biaya penyimpanan harus berupa angka'
        );
        echo json_encode($response);
        exit;
    }

    // Validasi nilai tidak negatif
    if ($stock < 0 || $harga < 0 || $biaya_penyimpanan < 0) {
        $response = array(
            'status' => 'error',
            'message' => 'Stock, harga, dan biaya penyimpanan tidak boleh negatif'
        );
        echo json_encode($response);
        exit;
    }

    // Escape string untuk mencegah SQL injection
    $kode_produk = mysqli_real_escape_string($conn, $kode_produk);
    $nama_produk = mysqli_real_escape_string($conn, $nama_produk);
    $supplier = mysqli_real_escape_string($conn, $supplier);
    $kategori = mysqli_real_escape_string($conn, $kategori);
    $satuan = mysqli_real_escape_string($conn, $satuan);
    $stock = mysqli_real_escape_string($conn, $stock);
    $harga = mysqli_real_escape_string($conn, $harga);
    $biaya_penyimpanan = mysqli_real_escape_string($conn, $biaya_penyimpanan);
    $keterangan = mysqli_real_escape_string($conn, $keterangan);

    // Cek apakah kode produk sudah ada
    $check_sql = "SELECT id FROM produk WHERE kode_produk = '$kode_produk'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $response = array(
            'status' => 'error',
            'message' => 'Kode produk sudah ada. Gunakan kode produk yang lain.'
        );
        echo json_encode($response);
        exit;
    }

    // Query INSERT
    $sql = "INSERT INTO produk (kode_produk, nama_produk, kategori_id, satuan_id, stock, harga, biaya_penyimpanan, sup_id, keterangan) 
            VALUES('$kode_produk', '$nama_produk', '$kategori', '$satuan', '$stock', '$harga', '$biaya_penyimpanan', '$supplier', '$keterangan')";

    error_log("SQL Query: " . $sql);

    $query = mysqli_query($conn, $sql);

    if ($query) {
        $response = array(
            'status' => 'success',
            'message' => 'Data produk berhasil ditambahkan',
            'inserted_id' => mysqli_insert_id($conn)
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Data produk gagal ditambahkan: ' . mysqli_error($conn),
            'sql' => $sql
        );
    }
} catch (Exception $e) {
    $response = array(
        'status' => 'error',
        'message' => 'Exception: ' . $e->getMessage()
    );
    error_log("Exception in add-produk.php: " . $e->getMessage());
}

echo json_encode($response);