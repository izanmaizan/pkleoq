<?php
// Kode ini akan mengambil detail produk berdasarkan ID dan mengembalikan respons dalam format JSON

// Pastikan parameter id disediakan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // conn ke database
    include '../../config/koneksi.php';

    // Kueri untuk mendapatkan detail produk dari database
    $query = "SELECT p.id, p.nama_produk, p.kode_produk, p.stock, p.harga, p.keterangan, k.nama_kategori, s.nama_satuan, sup.nama_sup 
                FROM produk as p 
                JOIN kategori AS k ON p.kategori_id = k.id
                JOIN satuan AS s ON p.satuan_id = s.id 
                JOIN supplier AS sup ON p.sup_id = sup.id
                WHERE p.id = '$id'";
    $result = mysqli_query($conn, $query);

    // Buat array untuk menyimpan hasil
    $response = array();

    // Periksa apakah produk ditemukan
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Masukkan detail produk ke dalam array respons
        $response['id'] = $row['id'];
        $response['kode_produk'] = $row['kode_produk'];
        $response['nama_produk'] = $row['nama_produk'];
        $response['harga'] = $row['harga'];
        $response['stock'] = $row['stock'];
        $response['satuan'] = $row['nama_satuan'];
        $response['nama_kategori'] = $row['nama_kategori'];
        $response['nama_sup'] = $row['nama_sup'];
        $response['keterangan'] = $row['keterangan'];

        // Ubah array respons menjadi format JSON dan kirimkan
        echo json_encode($response);
    } else {
        // Jika produk tidak ditemukan, kirimkan respons error
        $response['error'] = true;
        $response['message'] = 'Produk tidak ditemukan';
        echo json_encode($response);
    }
} else {
    // Jika parameter id tidak ditemukan, kirimkan respons error
    $response['error'] = true;
    $response['message'] = 'Parameter id tidak ditemukan';
    echo json_encode($response);
}