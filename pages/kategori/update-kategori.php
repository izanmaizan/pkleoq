<?php

include '../../config/koneksi.php';

$id = $_POST['id'];
$nm_kategori = $_POST['nm_kategori'];
$keterangan = $_POST['keterangan'];

// Periksa apakah nama kategori sudah ada di database selain data yang sedang diupdate
$validate = mysqli_query(
    $conn, "SELECT COUNT(*) AS jumlah_kategori FROM kategori WHERE nama_kategori = '$nm_kategori' AND id != $id"
);

$check = mysqli_fetch_array($validate);

if ($check['jumlah_kategori'] > 0) {

    $response = array(
        'status' => 'error',
        'message' => 'Kategori sudah ada'
    );

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();

} else {
    // Jika kategori belum ada, lakukan proses update data
    $update = mysqli_query($conn, "UPDATE kategori SET nama_kategori = '$nm_kategori', keterangan = '$keterangan' WHERE id = '$id'");

    if ($update) {
        // Jika update berhasil, set session success dan kembali ke halaman sebelumnya
        $response = array(
            'status' => 'success',
            'message' => 'Data kategori berhasil diperbarui'
        );
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();

    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Data kategori gagal diperbarui'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}

?>