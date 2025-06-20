<?php
session_start();
include '../../config/koneksi.php';

// Set header untuk JSON response
header('Content-Type: application/json');

// Disable error output agar tidak merusak JSON
error_reporting(0);
ini_set('display_errors', 0);

try {
    // Cek apakah user sudah login
    if (!isset($_SESSION['username'])) {
        throw new Exception("Unauthorized access");
    }

    // Validasi parameter ID
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception("ID riwayat diperlukan");
    }

    $riwayat_id = (int)$_GET['id'];

    // Cek koneksi database
    if (!$conn) {
        throw new Exception("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Query untuk mengambil header riwayat
    $header_query = "SELECT 
                        r.id,
                        r.tanggal_dari,
                        r.tanggal_sampai,
                        r.tanggal_perhitungan,
                        r.total_produk,
                        r.total_demand,
                        r.total_eoq,
                        r.avg_eoq,
                        r.max_eoq,
                        r.min_eoq,
                        r.total_setup_cost,
                        r.avg_setup_cost,
                        r.total_cost_eoq,
                        r.keterangan,
                        r.status,
                        u.username,
                        u.nama as nama_user
                     FROM riwayat_eoq r 
                     LEFT JOIN user u ON r.user_id = u.id 
                     WHERE r.id = ?";

    $stmt_header = mysqli_prepare($conn, $header_query);
    if (!$stmt_header) {
        throw new Exception("Error preparing header query: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_header, "i", $riwayat_id);

    if (!mysqli_stmt_execute($stmt_header)) {
        throw new Exception("Error executing header query: " . mysqli_stmt_error($stmt_header));
    }

    $header_result = mysqli_stmt_get_result($stmt_header);

    if (mysqli_num_rows($header_result) == 0) {
        mysqli_stmt_close($stmt_header); // Close saat ada error
        throw new Exception("Riwayat dengan ID $riwayat_id tidak ditemukan");
    }

    $header_data = mysqli_fetch_assoc($header_result);
    mysqli_stmt_close($stmt_header); // Close setelah selesai

    // Query untuk mengambil detail produk
    $detail_query = "SELECT 
                    nama_produk,
                    demand_tahunan,
                    harga_produk,
                    biaya_pemesanan,
                    biaya_penyimpanan,
                    eoq_optimal,
                    frekuensi_pesan,
                    interval_hari,
                    total_cost_eoq,
                    CASE 
                        WHEN supplier = '0' OR supplier = '' OR supplier IS NULL 
                        THEN 'Unknown Supplier'
                        ELSE supplier 
                    END as supplier,
                    nilai_penjualan
                 FROM riwayat_eoq_detail 
                 WHERE riwayat_eoq_id = ?
                 ORDER BY eoq_optimal DESC, nama_produk ASC";

    $stmt_detail = mysqli_prepare($conn, $detail_query);
    if (!$stmt_detail) {
        throw new Exception("Error preparing detail query: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_detail, "i", $riwayat_id);

    if (!mysqli_stmt_execute($stmt_detail)) {
        mysqli_stmt_close($stmt_detail);
        throw new Exception("Error executing detail query: " . mysqli_stmt_error($stmt_detail));
    }

    $detail_result = mysqli_stmt_get_result($stmt_detail);

    $detail_data = array();
    while ($row = mysqli_fetch_assoc($detail_result)) {
        $detail_data[] = $row;
    }

    mysqli_stmt_close($stmt_detail); // Close setelah selesai

    // Hitung statistik tambahan
    $summary_stats = array(
        'total_nilai_penjualan' => 0,
        'total_biaya_setup' => 0,
        'total_biaya_penyimpanan' => 0,
        'produk_tertinggi_eoq' => null,
        'produk_terendah_eoq' => null
    );

    if (!empty($detail_data)) {
        // Hitung total
        foreach ($detail_data as $item) {
            $summary_stats['total_nilai_penjualan'] += floatval($item['nilai_penjualan']);
            $summary_stats['total_biaya_setup'] += floatval($item['biaya_pemesanan']);
            $summary_stats['total_biaya_penyimpanan'] += floatval($item['biaya_penyimpanan']);
        }

        // Produk dengan EOQ tertinggi dan terendah
        $sorted_data = $detail_data;
        usort($sorted_data, function ($a, $b) {
            return intval($b['eoq_optimal']) - intval($a['eoq_optimal']);
        });

        $summary_stats['produk_tertinggi_eoq'] = array(
            'nama' => $sorted_data[0]['nama_produk'],
            'eoq' => intval($sorted_data[0]['eoq_optimal'])
        );

        $summary_stats['produk_terendah_eoq'] = array(
            'nama' => end($sorted_data)['nama_produk'],
            'eoq' => intval(end($sorted_data)['eoq_optimal'])
        );
    }

    // Response sukses
    echo json_encode(array(
        'success' => true,
        'data' => array(
            'header' => $header_data,
            'details' => $detail_data,
            'summary' => $summary_stats
        ),
        'metadata' => array(
            'total_detail_records' => count($detail_data),
            'retrieved_at' => date('Y-m-d H:i:s'),
            'riwayat_id' => $riwayat_id
        )
    ));
} catch (Exception $e) {
    // Response error
    echo json_encode(array(
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => 'GET_DETAIL_ERROR'
    ));
} finally {
    // Clean up connections - hanya tutup jika masih terbuka
    if (isset($conn) && $conn) {
        mysqli_close($conn);
    }
}

// Exit setelah output JSON agar tidak ada output tambahan
exit;