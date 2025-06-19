<?php

include '../../config/koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM produk WHERE id = $id";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($query);
 
    header('Content-Type: application/json');
    echo json_encode($data);
}

?>