<?php

include '../../config/koneksi.php';

$kd_transaksi = $_POST['kd_transaksi'];
$tgl = $_POST['tgl'];
$user_id = $_POST['user_id'];
$produk_ids = $_POST['produk_id'];
$stock_outs = $_POST['qty'];
$satuan_ids = $_POST['satuan_id'];
$supplier_id = $_POST['supplier_id'];
$hargas = $_POST['harga'];
$totals = $_POST['subtotal'];
$keterangan = $_POST['keterangan'];

// Inisialisasi variabel total
$total = 0;

for ($i = 0; $i < count($produk_ids); $i++) {
    $produk_id = $produk_ids[$i];
    $satuan_id = $satuan_ids[$i];
    $harga = $hargas[$i];
    $stock_out = $stock_outs[$i];

    // Hilangkan tanda pemisah harga
    $harga = str_replace('.', '', $hargas[$i]);

    // Hitung total harga untuk setiap transaksi
    $total = $harga * $stock_out;

    // Lakukan query untuk menyimpan transaksi penjualan
    $insert = mysqli_query($conn, "INSERT INTO transaksi_penjualan
    (produk_id, user_id, satuan_id, harga, stock_out, sup_id, keterangan, kd_transaksi, total_harga, tanggal) VALUES ('$produk_id', '$user_id', '$satuan_id', '$harga', '$stock_out', '$supplier_id', '$keterangan', '$kd_transaksi', '$total', '$tgl')");

    // Lakukan query untuk memperbarui stok produk
    $update_stock = mysqli_query($conn, "UPDATE produk SET stock = stock - $stock_out WHERE id = $produk_id");
}

if ($insert && $update_stock) {
    // Jika insert dan update berhasil, set session success dan kembali ke halaman sebelumnya
    session_start();
    $_SESSION['success'] = "Data berhasil ditambahkan";
    header("location:index.php");
    exit();
} else {
    // Jika insert atau update gagal, set session error dan kembali ke halaman sebelumnya
    session_start();
    $_SESSION['error'] = "Data gagal ditambahkan";
    header("location:create-penjualan.php");
    exit();
}