<?php

include '../../config/koneksi.php';

$nm_satuan = $_POST['nm_satuan'];
$keterangan = $_POST['keterangan'];

// Periksa apakah nama satuan sudah ada di database
$validate = mysqli_query(
    $conn, "SELECT COUNT(*) AS jumlah_satuan FROM satuan WHERE nama_satuan = '$nm_satuan'"
);

$check = mysqli_fetch_array($validate);

if ($check['jumlah_satuan'] > 0) {
    // Jika satuan sudah ada, tampilkan pesan dan kembali ke halaman sebelumnya
    $response = array(
        'success' => false,
        'message' => 'Satuan sudah ada'
    );
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();

} else {
    // Jika satuan belum ada, lakukan proses insert data
    $insert = mysqli_query($conn, "INSERT INTO satuan (nama_satuan, keterangan) VALUES ('$nm_satuan', '$keterangan')");

    if ($insert) {
        // Jika insert berhasil, set session success dan kembali ke halaman sebelumnya
        $response = array(
            'success' => true,
            'message' => 'Data satuan berhasil ditambahkan'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();

    } else {
        // Jika insert gagal, set session error dan kembali ke halaman sebelumnya
        $response = array(
            'success' => false,
            'message' => 'Data satuan gagal ditambahkan'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}

?>