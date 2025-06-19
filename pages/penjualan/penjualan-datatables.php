<?php
// Include file koneksi.php untuk menghubungkan ke database
include '../../config/koneksi.php';

// Set header JSON di awal
header('Content-Type: application/json');

try {
    // Query untuk mengambil data penjualan dengan GROUP BY yang benar
    $sql = "SELECT 
        MIN(tp.id) as id,
        tp.kd_transaksi, 
        MIN(tp.tanggal) as tanggal, 
        MIN(u.nama) as nama, 
        MIN(tp.keterangan) as keterangan 
    FROM transaksi_penjualan AS tp 
    INNER JOIN user AS u ON tp.user_id = u.id
    GROUP BY tp.kd_transaksi
    ORDER BY MIN(tp.tanggal) DESC";

    $query = mysqli_query($conn, $sql);

    // Memeriksa jika query berhasil dieksekusi
    if (!$query) {
        throw new Exception("Gagal menjalankan query: " . mysqli_error($conn));
    }

    $data = array();
    while ($row = mysqli_fetch_assoc($query)) {
        // Format tanggal dengan pengecekan yang lebih baik
        $tanggal_formatted = '-';
        if (!empty($row['tanggal']) && $row['tanggal'] != '0000-00-00') {
            $tanggal = DateTime::createFromFormat('Y-m-d', $row['tanggal']);
            if ($tanggal !== false) {
                $tanggal_formatted = $tanggal->format('d-m-Y');
            } else {
                // Coba format lain jika gagal
                $tanggal = DateTime::createFromFormat('Y-m-d H:i:s', $row['tanggal']);
                if ($tanggal !== false) {
                    $tanggal_formatted = $tanggal->format('d-m-Y');
                }
            }
        }

        // Memformat data sesuai kebutuhan DataTables
        $data[] = array(
            'kode_transaksi' => $row['kd_transaksi'],
            'tanggal' => $tanggal_formatted,
            'nama' => $row['nama'] ? $row['nama'] : 'Unknown User',
            'keterangan' => $row['keterangan'] ? $row['keterangan'] : '-',
            'aksi' => '<a href="javascript:void(0)" id="btn-detail" class="btn btn-sm btn-outline-info mr-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Detail" data-kode="' . $row['kd_transaksi'] . '" data-id="' . $row['id'] . '"><i class="fas fa-eye"></i></a>'
        );
    }

    // Mengirimkan data dalam format JSON yang sesuai dengan DataTables
    echo json_encode(array('data' => $data));
} catch (Exception $e) {
    // Jika terjadi error, kirim response error
    echo json_encode(array(
        'error' => $e->getMessage(),
        'data' => array()
    ));
} finally {
    // Menutup koneksi
    if (isset($conn)) {
        mysqli_close($conn);
    }
}