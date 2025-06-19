<?php

// Include file koneksi.php
include '../../config/koneksi.php';

// Periksa apakah ada data POST yang dikirimkan
if (isset($_POST['kode'])) {
    // Ambil nilai Kode dari data POST
    $kode_transaksi = $_POST['kode'];

    // Hindari SQL Injection dengan menggunakan parameterized query
    $query = mysqli_prepare($conn, "SELECT tp.id, tp.harga, tp.stock_in, tp.kode_transaksi, tp.keterangan, tp.tanggal, tp.total_harga, u.nama, s.nama_satuan, sup.kode_sup, sup.nama_sup, p.nama_produk
    FROM `transaksi_pembelian` AS tp
    JOIN user AS u ON tp.user_id = u.id
    JOIN satuan AS s ON tp.satuan_id = s.id
    JOIN supplier AS sup ON tp.sup_id = sup.id
    JOIN produk AS p ON tp.produk_id = p.id 
    WHERE tp.kode_transaksi = ?");

    // Bind parameter
    mysqli_stmt_bind_param($query, 's', $kode_transaksi);

    // Eksekusi query
    mysqli_stmt_execute($query);

    // Ambil hasil query
    $result = mysqli_stmt_get_result($query);

    // Buat array untuk menampung hasil
    $datas = array();

    // Periksa apakah query berhasil dieksekusi
    if ($result) {
        // Ambil setiap baris hasil dan tambahkan ke dalam array
        while ($row = mysqli_fetch_assoc($result)) {
            $datas[] = $row;
        }

        // Encode data dalam format JSON
        $json_data = json_encode($datas);

        // Keluarkan data dalam format JSON
        echo $json_data;
    } else {
        // Jika query gagal dieksekusi, keluarkan pesan kesalahan
        echo json_encode(array('error' => 'Gagal mengambil data transaksi_pembelian'));
    }

    // Tutup statement
    mysqli_stmt_close($query);
} else {
    // Jika tidak ada data POST yang dikirimkan, keluarkan pesan kesalahan
    echo json_encode(array('error' => 'Kode transaksi tidak ditemukan'));
}