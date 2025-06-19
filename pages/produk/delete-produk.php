<?php

include '../../config/koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM produk WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $response = array(
            'status' => 'success',
            'message' => 'Data produk berhasil dihapus'
        );

        // Mengembalikan respons dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Gagal menghapus data produk'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'ID produk tidak ditemukan'
    );
}

mysqli_close($conn);