<?php

include '../../config/koneksi.php';

if (isset($_POST['id'])) {

    $id = $_POST['id'];

    $delete = mysqli_query($conn, "DELETE FROM satuan WHERE id = '$id'");

    if ($delete) {
        $response = array(
            'status' => 'success',
            'message' => 'Data satuan berhasil dihapus'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Data satuan gagal dihapus'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

?>