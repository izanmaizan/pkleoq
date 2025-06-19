<?php

include '../../config/koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "SELECT * FROM supplier WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($query);

    // Mengembalikan respons dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    $response = array(
        'status' => 'error',
        'message' => 'ID supplier tidak ditemukan'
    );
}

// Menutup koneksi
mysqli_close($conn);

?>