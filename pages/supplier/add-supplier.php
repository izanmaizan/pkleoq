<?php

include '../../config/koneksi.php';

$kd_supplier = $_POST['kd_supplier'];
$nama_supplier = $_POST['nama_supplier'];
$no_telp = $_POST['no_hp'];
$alamat = $_POST['alamat'];

if ($kd_supplier == '' || $nama_supplier == '' || $no_telp == '' || $alamat == '') {
    //kembalikan data dalam bentuk json
    $response = array(
        'status' => 'error',
        'message' => 'Data tidak boleh ada yang kosong'
    );

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    $sql = "INSERT INTO supplier (kode_sup, nama_sup, alamat, no_hp) VALUES('$kd_supplier', '$nama_supplier','$alamat', '$no_telp')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $response = array(
            'status' => 'success',
            'message' => 'Data supplier berhasil ditambahkan'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Data supplier gagal ditambahkan'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
