<?php

include '../../config/koneksi.php';

if (isset($_POST['id'])) {

    $id = $_POST['id'];

    $delete = mysqli_query($conn, "DELETE FROM kategori WHERE id = '$id'");

    if ($delete) {
        $response = array(
            'status' => 'success',
            'message' => 'Data kategori berhasil dihapus'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Data kategori gagal dihapus'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

?>