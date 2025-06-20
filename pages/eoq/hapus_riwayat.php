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

    // Validasi method POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method");
    }

    // Validasi parameter ID
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception("ID riwayat diperlukan");
    }

    $riwayat_id = (int)$_POST['id'];

    // Cek koneksi database
    if (!$conn) {
        throw new Exception("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Cek apakah riwayat exists
    $check_query = "SELECT id, tanggal_dari, tanggal_sampai, total_produk FROM riwayat_eoq WHERE id = ?";
    $stmt_check = mysqli_prepare($conn, $check_query);

    if (!$stmt_check) {
        throw new Exception("Error preparing check query: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_check, "i", $riwayat_id);

    if (!mysqli_stmt_execute($stmt_check)) {
        mysqli_stmt_close($stmt_check);
        throw new Exception("Error executing check query: " . mysqli_stmt_error($stmt_check));
    }

    $check_result = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($check_result) == 0) {
        mysqli_stmt_close($stmt_check);
        throw new Exception("Riwayat tidak ditemukan");
    }

    $riwayat_data = mysqli_fetch_assoc($check_result);
    mysqli_stmt_close($stmt_check);

    // Start transaction
    if (!mysqli_autocommit($conn, false)) {
        throw new Exception("Failed to start transaction: " . mysqli_error($conn));
    }

    // Hapus detail terlebih dahulu (karena foreign key constraint)
    $delete_detail_query = "DELETE FROM riwayat_eoq_detail WHERE riwayat_eoq_id = ?";
    $stmt_delete_detail = mysqli_prepare($conn, $delete_detail_query);

    if (!$stmt_delete_detail) {
        mysqli_rollback($conn);
        throw new Exception("Error preparing delete detail query: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_delete_detail, "i", $riwayat_id);

    if (!mysqli_stmt_execute($stmt_delete_detail)) {
        mysqli_stmt_close($stmt_delete_detail);
        mysqli_rollback($conn);
        throw new Exception("Error deleting detail records: " . mysqli_stmt_error($stmt_delete_detail));
    }

    $deleted_details = mysqli_stmt_affected_rows($stmt_delete_detail);
    mysqli_stmt_close($stmt_delete_detail);

    // Hapus header riwayat
    $delete_header_query = "DELETE FROM riwayat_eoq WHERE id = ?";
    $stmt_delete_header = mysqli_prepare($conn, $delete_header_query);

    if (!$stmt_delete_header) {
        mysqli_rollback($conn);
        throw new Exception("Error preparing delete header query: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_delete_header, "i", $riwayat_id);

    if (!mysqli_stmt_execute($stmt_delete_header)) {
        mysqli_stmt_close($stmt_delete_header);
        mysqli_rollback($conn);
        throw new Exception("Error deleting header record: " . mysqli_stmt_error($stmt_delete_header));
    }

    $deleted_headers = mysqli_stmt_affected_rows($stmt_delete_header);
    mysqli_stmt_close($stmt_delete_header);

    // Commit transaction
    if (!mysqli_commit($conn)) {
        throw new Exception("Failed to commit transaction: " . mysqli_error($conn));
    }

    // Response sukses
    echo json_encode(array(
        'success' => true,
        'message' => 'Riwayat berhasil dihapus',
        'data' => array(
            'riwayat_id' => $riwayat_id,
            'tanggal_dari' => $riwayat_data['tanggal_dari'],
            'tanggal_sampai' => $riwayat_data['tanggal_sampai'],
            'total_produk' => $riwayat_data['total_produk'],
            'deleted_details' => $deleted_details,
            'deleted_headers' => $deleted_headers
        ),
        'timestamp' => date('Y-m-d H:i:s')
    ));
} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($conn) && $conn) {
        mysqli_rollback($conn);
    }

    echo json_encode(array(
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => 'DELETE_RIWAYAT_ERROR',
        'timestamp' => date('Y-m-d H:i:s')
    ));
} finally {
    // Restore autocommit dan close connection
    if (isset($conn) && $conn) {
        mysqli_autocommit($conn, true);
        mysqli_close($conn);
    }
}

// Exit untuk memastikan tidak ada output tambahan
exit;