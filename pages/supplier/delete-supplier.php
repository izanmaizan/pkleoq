<?php

include '../../config/koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM supplier WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $response = array(
            'status' => 'success',
            'message' => 'Data supplier berhasil dihapus'
        );

        // Mengembalikan respons dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($response);

    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Gagal menghapus data supplier'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'ID supplier tidak ditemukan'
    );
}

mysqli_close($conn);

?>