<?php
session_start();
include '../../config/koneksi.php';

// Set header untuk JSON response
header('Content-Type: application/json');

try {
    // Cek apakah user sudah login
    if (!isset($_SESSION['username'])) {
        throw new Exception("Unauthorized access");
    }

    // Ambil parameter
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $limit = isset($_GET['limit']) ? max(1, min(100, (int)$_GET['limit'])) : 10;
    $filter_dari = isset($_GET['filter_dari']) && !empty($_GET['filter_dari']) ? $_GET['filter_dari'] : null;
    $filter_sampai = isset($_GET['filter_sampai']) && !empty($_GET['filter_sampai']) ? $_GET['filter_sampai'] : null;

    $offset = ($page - 1) * $limit;

    // Build WHERE clause
    $where_conditions = array();
    $where_params = array();

    if ($filter_dari && $filter_sampai) {
        $where_conditions[] = "r.tanggal_perhitungan BETWEEN ? AND ?";
        $where_params[] = $filter_dari . ' 00:00:00';
        $where_params[] = $filter_sampai . ' 23:59:59';
    } elseif ($filter_dari) {
        $where_conditions[] = "r.tanggal_perhitungan >= ?";
        $where_params[] = $filter_dari . ' 00:00:00';
    } elseif ($filter_sampai) {
        $where_conditions[] = "r.tanggal_perhitungan <= ?";
        $where_params[] = $filter_sampai . ' 23:59:59';
    }

    $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

    // Query untuk menghitung total records
    $count_query = "SELECT COUNT(*) as total 
                    FROM riwayat_eoq r 
                    LEFT JOIN user u ON r.user_id = u.id 
                    $where_clause";

    if (!empty($where_params)) {
        $count_stmt = mysqli_prepare($conn, $count_query);
        if ($count_stmt) {
            $types = str_repeat('s', count($where_params));
            mysqli_stmt_bind_param($count_stmt, $types, ...$where_params);
            mysqli_stmt_execute($count_stmt);
            $count_result = mysqli_stmt_get_result($count_stmt);
            $total_records = mysqli_fetch_assoc($count_result)['total'];
            mysqli_stmt_close($count_stmt);
        } else {
            throw new Exception("Error in count query: " . mysqli_error($conn));
        }
    } else {
        $count_result = mysqli_query($conn, $count_query);
        if (!$count_result) {
            throw new Exception("Error in count query: " . mysqli_error($conn));
        }
        $total_records = mysqli_fetch_assoc($count_result)['total'];
    }

    // Query untuk mengambil data
    $data_query = "SELECT 
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
                        u.username
                   FROM riwayat_eoq r 
                   LEFT JOIN user u ON r.user_id = u.id 
                   $where_clause
                   ORDER BY r.tanggal_perhitungan DESC 
                   LIMIT $limit OFFSET $offset";

    if (!empty($where_params)) {
        $data_stmt = mysqli_prepare($conn, $data_query);
        if ($data_stmt) {
            $types = str_repeat('s', count($where_params));
            mysqli_stmt_bind_param($data_stmt, $types, ...$where_params);
            mysqli_stmt_execute($data_stmt);
            $data_result = mysqli_stmt_get_result($data_stmt);
        } else {
            throw new Exception("Error in data query: " . mysqli_error($conn));
        }
    } else {
        $data_result = mysqli_query($conn, $data_query);
        if (!$data_result) {
            throw new Exception("Error in data query: " . mysqli_error($conn));
        }
    }

    // Fetch data
    $data = array();
    while ($row = mysqli_fetch_assoc($data_result)) {
        $data[] = $row;
    }

    // Close prepared statement if used
    if (isset($data_stmt)) {
        mysqli_stmt_close($data_stmt);
    }

    // Calculate pagination info
    $total_pages = ceil($total_records / $limit);
    $from = $total_records > 0 ? $offset + 1 : 0;
    $to = min($offset + $limit, $total_records);

    // Response
    echo json_encode(array(
        'success' => true,
        'data' => $data,
        'pagination' => array(
            'current_page' => $page,
            'total_pages' => $total_pages,
            'total_records' => (int)$total_records,
            'from' => $from,
            'to' => $to,
            'limit' => $limit
        ),
        'filters' => array(
            'filter_dari' => $filter_dari,
            'filter_sampai' => $filter_sampai,
            'limit' => $limit
        )
    ));
} catch (Exception $e) {
    echo json_encode(array(
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => 'RIWAYAT_ERROR'
    ));
} finally {
    if (isset($conn) && $conn) {
        mysqli_close($conn);
    }
}