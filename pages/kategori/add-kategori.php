<?php

include '../../config/koneksi.php';

$nm_kategori = $_POST['nm_kategori'];
$keterangan = $_POST['keterangan'];

// Periksa apakah nama kategori sudah ada di database
$validate = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS jumlah_kategori FROM kategori WHERE nama_kategori = '$nm_kategori'"
);

$check = mysqli_fetch_array($validate);

if ($check['jumlah_kategori'] > 0) {
    // Jika kategori sudah ada, tampilkan pesan dan kembali ke halaman sebelumnya
    $response = array(
        'success' => false,
        'message' => 'Kategori sudah ada'
    );

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    // Jika kategori belum ada, lakukan proses insert data
    // PERBAIKAN: Ganti $nama_kategori menjadi $nm_kategori
    $insert = mysqli_query($conn, "INSERT INTO kategori (nama_kategori, keterangan) VALUES ('$nm_kategori', '$keterangan')");

    if ($insert) {
        // Jika insert berhasil, set session success dan kembali ke halaman sebelumnya
        $response = array(
            'success' => true,
            'message' => 'Data kategori berhasil ditambahkan'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        // Jika insert gagal, set session error dan kembali ke halaman sebelumnya
        $response = array(
            'success' => false,
            'message' => 'Data kategori gagal ditambahkan'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}