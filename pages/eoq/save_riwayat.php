<?php
session_start();
include '../../config/koneksi.php';

// Set header untuk JSON response
header('Content-Type: application/json');

// PERBAIKAN: Disable error output agar tidak merusak JSON
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1); // Keep log errors untuk debugging

try {
    // Cek apakah user sudah login
    if (!isset($_SESSION['username'])) {
        throw new Exception("Unauthorized access");
    }

    // Validasi method POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method");
    }

    // Ambil data dari POST
    if (!isset($_POST['history_data']) || empty($_POST['history_data'])) {
        throw new Exception("Data riwayat tidak ditemukan");
    }

    $history_data = json_decode($_POST['history_data'], true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Format data tidak valid: " . json_last_error_msg());
    }

    // Validasi data yang diperlukan
    $required_fields = ['tanggal_dari', 'tanggal_sampai', 'statistics', 'products'];
    foreach ($required_fields as $field) {
        if (!isset($history_data[$field])) {
            throw new Exception("Field $field diperlukan");
        }
    }

    // Ambil user ID dari session
    $user_query = mysqli_query($conn, "SELECT id FROM user WHERE username = '" . mysqli_real_escape_string($conn, $_SESSION['username']) . "'");
    if (!$user_query || mysqli_num_rows($user_query) == 0) {
        throw new Exception("User tidak ditemukan");
    }
    $user_data = mysqli_fetch_assoc($user_query);
    $user_id = $user_data['id'];

    // Extract statistics
    $stats = $history_data['statistics'];
    $tanggal_dari = $history_data['tanggal_dari'];
    $tanggal_sampai = $history_data['tanggal_sampai'];

    // Start transaction
    if (!mysqli_autocommit($conn, false)) {
        throw new Exception("Failed to start transaction: " . mysqli_error($conn));
    }

    // PERBAIKAN: Inisialisasi statement variables
    $stmt_riwayat = null;
    $stmt_detail = null;

    // Insert ke tabel riwayat_eoq
    $insert_riwayat = "INSERT INTO riwayat_eoq (
        user_id, 
        tanggal_dari, 
        tanggal_sampai, 
        total_produk, 
        total_demand, 
        total_eoq, 
        avg_eoq, 
        max_eoq, 
        min_eoq, 
        total_setup_cost, 
        avg_setup_cost, 
        total_cost_eoq,
        keterangan,
        status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt_riwayat = mysqli_prepare($conn, $insert_riwayat);
    if (!$stmt_riwayat) {
        throw new Exception("Error preparing riwayat statement: " . mysqli_error($conn));
    }

    $keterangan = "Perhitungan EOQ periode " . date('d/m/Y', strtotime($tanggal_dari)) . " - " . date('d/m/Y', strtotime($tanggal_sampai));
    $status = 'completed';

    // Validasi tipe data sebelum bind
    $total_products = (int)($stats['total_products'] ?? 0);
    $total_demand = (int)($stats['total_demand'] ?? 0);
    $total_eoq = (int)($stats['total_eoq'] ?? 0);
    $avg_eoq = (float)($stats['avg_eoq'] ?? 0);
    $max_eoq = (int)($stats['max_eoq'] ?? 0);
    $min_eoq = (int)($stats['min_eoq'] ?? 0);
    $total_setup_cost = (float)($stats['total_setup_cost'] ?? 0);
    $avg_setup_cost = (float)($stats['avg_setup_cost'] ?? 0);
    $total_cost_eoq = (float)($stats['total_cost_eoq'] ?? 0);

    mysqli_stmt_bind_param(
        $stmt_riwayat,
        "issiiiiiiddsss",
        $user_id,
        $tanggal_dari,
        $tanggal_sampai,
        $total_products,
        $total_demand,
        $total_eoq,
        $avg_eoq,
        $max_eoq,
        $min_eoq,
        $total_setup_cost,
        $avg_setup_cost,
        $total_cost_eoq,
        $keterangan,
        $status
    );

    if (!mysqli_stmt_execute($stmt_riwayat)) {
        throw new Exception("Error inserting riwayat: " . mysqli_stmt_error($stmt_riwayat));
    }

    $riwayat_id = mysqli_insert_id($conn);

    // PERBAIKAN: Close statement setelah selesai digunakan
    mysqli_stmt_close($stmt_riwayat);
    $stmt_riwayat = null; // Set ke null agar tidak di-close lagi

    error_log("Riwayat header inserted with ID: $riwayat_id");

    // Insert detail produk
    if (!empty($history_data['products'])) {
        $insert_detail = "INSERT INTO riwayat_eoq_detail (
            riwayat_eoq_id,
            nama_produk,
            demand_tahunan,
            harga_produk,
            biaya_pemesanan,
            biaya_penyimpanan,
            eoq_optimal,
            frekuensi_pesan,
            interval_hari,
            total_cost_eoq,
            supplier,
            nilai_penjualan
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_detail = mysqli_prepare($conn, $insert_detail);
        if (!$stmt_detail) {
            throw new Exception("Error preparing detail statement: " . mysqli_error($conn));
        }

        $success_count = 0;
        $error_count = 0;

        foreach ($history_data['products'] as $index => $product) {
            // PERBAIKAN SUPPLIER - Lebih sistematis dan debugging yang lebih baik
            $supplier_name = 'Unknown Supplier'; // Default value
            $debug_supplier_info = array();

            // Log data supplier yang diterima
            error_log("Product $index supplier data received: " . json_encode([
                'supplier' => $product['supplier'] ?? 'not_set',
                'nama_sup' => $product['nama_sup'] ?? 'not_set',
                'sup_id' => $product['sup_id'] ?? 'not_set'
            ]));

            // Prioritas 1: Gunakan field 'supplier' yang sudah diproses di JavaScript
            if (isset($product['supplier']) && !empty(trim($product['supplier']))) {
                $temp_supplier = trim($product['supplier']);
                // Pastikan bukan default value dan bukan ID numerik saja
                if (
                    $temp_supplier !== 'Unknown Supplier' &&
                    $temp_supplier !== '0' &&
                    $temp_supplier !== 'null' &&
                    !preg_match('/^Supplier ID: \d+$/', $temp_supplier)
                ) {
                    $supplier_name = $temp_supplier;
                    $debug_supplier_info['source'] = 'field_supplier';
                    $debug_supplier_info['value'] = $temp_supplier;
                }
            }

            // Prioritas 2: Jika masih default, cek field 'nama_sup'
            if ($supplier_name === 'Unknown Supplier' && isset($product['nama_sup'])) {
                $temp_nama_sup = is_string($product['nama_sup']) ? trim($product['nama_sup']) : strval($product['nama_sup']);
                if (
                    !empty($temp_nama_sup) &&
                    $temp_nama_sup !== '0' &&
                    $temp_nama_sup !== 'null' &&
                    !is_numeric($temp_nama_sup)
                ) {
                    $supplier_name = $temp_nama_sup;
                    $debug_supplier_info['source'] = 'field_nama_sup';
                    $debug_supplier_info['value'] = $temp_nama_sup;
                }
            }

            // Prioritas 3: Query database berdasarkan sup_id jika tersedia
            if ($supplier_name === 'Unknown Supplier' && isset($product['sup_id']) && $product['sup_id'] != '0') {
                $supplier_query_by_id = "SELECT nama_sup FROM supplier WHERE id = ? LIMIT 1";
                $stmt_supplier_id = mysqli_prepare($conn, $supplier_query_by_id);
                if ($stmt_supplier_id) {
                    mysqli_stmt_bind_param($stmt_supplier_id, "i", $product['sup_id']);
                    if (mysqli_stmt_execute($stmt_supplier_id)) {
                        $supplier_result = mysqli_stmt_get_result($stmt_supplier_id);
                        if ($supplier_row = mysqli_fetch_assoc($supplier_result)) {
                            if (!empty($supplier_row['nama_sup'])) {
                                $supplier_name = $supplier_row['nama_sup'];
                                $debug_supplier_info['source'] = 'database_by_sup_id';
                                $debug_supplier_info['value'] = $supplier_row['nama_sup'];
                                $debug_supplier_info['sup_id'] = $product['sup_id'];
                            }
                        }
                    }
                    mysqli_stmt_close($stmt_supplier_id);
                }
            }

            // Prioritas 4: Query database berdasarkan nama produk dan periode transaksi
            if ($supplier_name === 'Unknown Supplier' && isset($product['nama_produk'])) {
                $supplier_query = "SELECT DISTINCT s.nama_sup 
                         FROM transaksi_penjualan tp 
                         JOIN produk p ON tp.produk_id = p.id 
                         LEFT JOIN supplier s ON tp.sup_id = s.id 
                         WHERE p.nama_produk = ? 
                         AND tp.tanggal BETWEEN ? AND ?
                         AND s.nama_sup IS NOT NULL 
                         AND s.nama_sup != '' 
                         AND s.nama_sup != '0'
                         ORDER BY tp.tanggal DESC
                         LIMIT 1";

                $stmt_supplier = mysqli_prepare($conn, $supplier_query);
                if ($stmt_supplier) {
                    mysqli_stmt_bind_param($stmt_supplier, "sss", $product['nama_produk'], $tanggal_dari, $tanggal_sampai);
                    if (mysqli_stmt_execute($stmt_supplier)) {
                        $supplier_result = mysqli_stmt_get_result($stmt_supplier);
                        if ($supplier_row = mysqli_fetch_assoc($supplier_result)) {
                            if (!empty($supplier_row['nama_sup'])) {
                                $supplier_name = $supplier_row['nama_sup'];
                                $debug_supplier_info['source'] = 'database_by_product_name';
                                $debug_supplier_info['value'] = $supplier_row['nama_sup'];
                            }
                        }
                    }
                    mysqli_stmt_close($stmt_supplier);
                }
            }

            // Prioritas 5: Query supplier berdasarkan produk tanpa filter tanggal
            if ($supplier_name === 'Unknown Supplier' && isset($product['nama_produk'])) {
                $supplier_query_all = "SELECT DISTINCT s.nama_sup 
                             FROM produk p 
                             LEFT JOIN supplier s ON p.sup_id = s.id 
                             WHERE p.nama_produk = ?
                             AND s.nama_sup IS NOT NULL 
                             AND s.nama_sup != '' 
                             AND s.nama_sup != '0'
                             LIMIT 1";

                $stmt_supplier_all = mysqli_prepare($conn, $supplier_query_all);
                if ($stmt_supplier_all) {
                    mysqli_stmt_bind_param($stmt_supplier_all, "s", $product['nama_produk']);
                    if (mysqli_stmt_execute($stmt_supplier_all)) {
                        $supplier_result = mysqli_stmt_get_result($stmt_supplier_all);
                        if ($supplier_row = mysqli_fetch_assoc($supplier_result)) {
                            if (!empty($supplier_row['nama_sup'])) {
                                $supplier_name = $supplier_row['nama_sup'];
                                $debug_supplier_info['source'] = 'database_product_table';
                                $debug_supplier_info['value'] = $supplier_row['nama_sup'];
                            }
                        }
                    }
                    mysqli_stmt_close($stmt_supplier_all);
                }
            }

            // Log hasil debugging supplier
            error_log("Product $index supplier resolution: " . json_encode([
                'nama_produk' => $product['nama_produk'],
                'final_supplier' => $supplier_name,
                'debug_info' => $debug_supplier_info
            ]));

            // Validasi data lain dengan fallback values
            $nama_produk = isset($product['nama_produk']) ? trim($product['nama_produk']) : 'Unknown Product';
            $demand_tahunan = isset($product['demand_tahunan']) ? (int)$product['demand_tahunan'] : 0;
            $harga_produk = isset($product['harga_produk']) ? (float)$product['harga_produk'] : 0;
            $biaya_pemesanan = isset($product['biaya_pemesanan']) ? (float)$product['biaya_pemesanan'] : 0;
            $biaya_penyimpanan = isset($product['biaya_penyimpanan']) ? (float)$product['biaya_penyimpanan'] : 0;
            $eoq_optimal = isset($product['eoq_optimal']) ? (int)$product['eoq_optimal'] : 0;
            $frekuensi_pesan = isset($product['frekuensi_pesan']) ? (int)$product['frekuensi_pesan'] : 0;
            $interval_hari = isset($product['interval_hari']) ? (int)$product['interval_hari'] : 0;
            $total_cost_eoq = isset($product['total_cost_eoq']) ? (float)$product['total_cost_eoq'] : 0;
            $nilai_penjualan = isset($product['nilai_penjualan']) ? (float)$product['nilai_penjualan'] : 0;

            mysqli_stmt_bind_param(
                $stmt_detail,
                "isidddiiiids",
                $riwayat_id,
                $nama_produk,
                $demand_tahunan,
                $harga_produk,
                $biaya_pemesanan,
                $biaya_penyimpanan,
                $eoq_optimal,
                $frekuensi_pesan,
                $interval_hari,
                $total_cost_eoq,
                $supplier_name,
                $nilai_penjualan
            );

            if (mysqli_stmt_execute($stmt_detail)) {
                $success_count++;
                error_log("SUCCESS inserting product $index: $nama_produk with supplier: $supplier_name");
            } else {
                $error_count++;
                error_log("ERROR inserting detail product $index: " . mysqli_stmt_error($stmt_detail));
            }
        }


        // PERBAIKAN: Close statement detail setelah selesai loop
        mysqli_stmt_close($stmt_detail);
        $stmt_detail = null; // Set ke null agar tidak di-close lagi

        error_log("Insert detail results: Success: $success_count, Errors: $error_count");
    }

    // Commit transaction
    if (!mysqli_commit($conn)) {
        throw new Exception("Failed to commit transaction: " . mysqli_error($conn));
    }

    // Response sukses
    echo json_encode(array(
        'success' => true,
        'message' => 'Riwayat EOQ berhasil disimpan',
        'riwayat_id' => $riwayat_id,
        'data' => array(
            'tanggal_dari' => $tanggal_dari,
            'tanggal_sampai' => $tanggal_sampai,
            'total_produk' => $total_products,
            'total_records_inserted' => count($history_data['products'])
        )
    ));
} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($conn)) {
        mysqli_rollback($conn);
    }

    // Log error untuk debugging
    error_log("Save Riwayat Error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());

    echo json_encode(array(
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => 'SAVE_RIWAYAT_ERROR'
    ));
} finally {
    // PERBAIKAN: Close connections dengan pengecekan yang tepat
    if (isset($stmt_riwayat) && $stmt_riwayat !== null) {
        mysqli_stmt_close($stmt_riwayat);
    }
    if (isset($stmt_detail) && $stmt_detail !== null) {
        mysqli_stmt_close($stmt_detail);
    }
    if (isset($conn) && $conn) {
        mysqli_autocommit($conn, true);
        mysqli_close($conn);
    }
}

// Exit untuk memastikan tidak ada output tambahan
exit;