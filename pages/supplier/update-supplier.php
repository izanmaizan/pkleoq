<?php

include '../../config/koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $kd_supplier = $_POST['kd_supplier'];
    $nama_supplier = $_POST['nama_supplier'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE supplier SET kode_sup = '$kd_supplier', nama_sup = '$nama_supplier', alamat = '$alamat', no_hp = '$no_hp' WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $response = array(
            'status' => 'success',
            'message' => 'Data supplier berhasil diupdate'
        );

        // Mengembalikan respons dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Gagal mengupdate data supplier'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'ID supplier tidak ditemukan'
    );
}

// Menutup koneksi
mysqli_close($conn);

?>