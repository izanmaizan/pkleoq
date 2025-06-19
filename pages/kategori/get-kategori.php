<?php

include '../../config/koneksi.php';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    $id = $_POST['id'];
    $sql = "SELECT * FROM kategori WHERE id = $id";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}

?>