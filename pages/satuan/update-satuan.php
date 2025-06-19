<?php

include '../../config/koneksi.php';

$id = $_POST['id'];
$nm_satuan = $_POST['nm_satuan'];
$keterangan = $_POST['keterangan'];

// Periksa apakah nama satuan sudah ada di database selain data yang sedang diupdate
$validate = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS jumlah_satuan FROM satuan WHERE nama_satuan = '$nm_satuan' AND id != $id"
);

$check = mysqli_fetch_array($validate);

if ($check['jumlah_satuan'] > 0) {

    $response = array(
        'success' => false,  // PERBAIKAN: Ubah dari 'status' => 'error' ke 'success' => false
        'message' => 'Satuan sudah ada'
    );

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    // Jika satuan belum ada, lakukan proses update data
    $update = mysqli_query($conn, "UPDATE satuan SET nama_satuan = '$nm_satuan', keterangan = '$keterangan' WHERE id = '$id'");

    if ($update) {
        // Jika update berhasil, set session success dan kembali ke halaman sebelumnya
        $response = array(
            'success' => true,  // PERBAIKAN: Ubah dari 'status' => 'success' ke 'success' => true
            'message' => 'Data satuan berhasil diperbarui'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        $response = array(
            'success' => false,  // PERBAIKAN: Ubah dari 'status' => 'error' ke 'success' => false
            'message' => 'Data satuan gagal diperbarui'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}