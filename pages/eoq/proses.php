<?php
include '../../config/koneksi.php';

// Set header untuk JSON response
header('Content-Type: application/json');

try {
    if (isset($_GET['dari']) && isset($_GET['sampai'])) {
        $dari = $_GET['dari'];
        $sampai = $_GET['sampai'];

        // Validasi format tanggal
        if (empty($dari) || empty($sampai)) {
            throw new Exception("Tanggal dari dan sampai harus diisi");
        }

        $query = mysqli_query(
            $conn,
            "SELECT 
                MIN(tp.id) as id,
                COALESCE(p.biaya_penyimpanan, 1000) as biaya_penyimpanan,
                p.nama_produk, 
                MIN(tp.harga) as harga,
                s.nama_satuan,
                sup.nama_sup,
                SUM(tp.stock_out) as stock_out,
                SUM(CAST(tp.stock_out AS DECIMAL) * CAST(tp.harga AS DECIMAL)) as pendapatan
            FROM transaksi_penjualan AS tp 
            INNER JOIN produk AS p ON tp.produk_id = p.id
            INNER JOIN user AS u ON tp.user_id = u.id
            INNER JOIN satuan AS s ON tp.satuan_id = s.id
            INNER JOIN supplier AS sup ON tp.sup_id = sup.id
            WHERE tp.tanggal BETWEEN '$dari' AND '$sampai'
            GROUP BY p.id, p.nama_produk, p.biaya_penyimpanan, s.nama_satuan, sup.nama_sup
            ORDER BY pendapatan DESC"
        );

        // Cek apakah query berhasil
        if (!$query) {
            throw new Exception("Error pada query: " . mysqli_error($conn));
        }

        // Inisialisasi array
        $datas = array();

        // Cek apakah ada data
        if (mysqli_num_rows($query) == 0) {
            throw new Exception("Tidak ada data transaksi penjualan dalam rentang tanggal yang dipilih");
        }

        while ($data = mysqli_fetch_assoc($query)) {
            // Pastikan data numerik dengan validasi
            $data['stock_out'] = max(1, (int)$data['stock_out']); // Minimal 1
            $data['harga'] = max(1, (int)$data['harga']); // Minimal 1
            $data['pendapatan'] = (float)$data['pendapatan'];
            $data['biaya_penyimpanan'] = max(1000, (int)$data['biaya_penyimpanan']); // Minimal 1000 untuk biaya simpan

            $datas[] = $data;
        }

        // Pastikan ada data sebelum melanjutkan perhitungan
        if (empty($datas)) {
            throw new Exception("Data transaksi kosong");
        }

        // HITUNG EOQ UNTUK SEMUA PRODUK
        $data_eoq_all = array();
        $data_frequency_all = array();
        $data_total_cost_all = array();

        for ($i = 0; $i < count($datas); $i++) {
            $biaya_penyimpanan = max(1000, (int)$datas[$i]['biaya_penyimpanan']); // Minimal 1000
            $stock_out = max(1, (int)$datas[$i]['stock_out']); // Minimal 1
            $setup_cost = 50000; // Biaya pemesanan tetap

            // Hitung EOQ dengan formula yang benar: EOQ = √((2 × D × S) / H)
            if ($biaya_penyimpanan > 0 && $stock_out > 0) {
                // Rumus EOQ
                $eoq_calculation = (2 * $stock_out * $setup_cost) / $biaya_penyimpanan;
                $eoq_value = sqrt($eoq_calculation);
                $eoq_rounded = max(1, round($eoq_value)); // Minimal EOQ = 1
                $data_eoq_all[] = $eoq_rounded;

                // Hitung frekuensi pemesanan (berapa kali pesan per tahun)
                $frequency = max(1, round($stock_out / $eoq_rounded)); // Minimal 1 kali per tahun
                $data_frequency_all[] = $frequency;

                // Hitung Total Cost EOQ = √(2 × D × S × H)
                $total_cost_eoq = sqrt(2 * $stock_out * $setup_cost * $biaya_penyimpanan);
                $data_total_cost_all[] = $total_cost_eoq;
            } else {
                // Fallback values jika ada masalah dengan data
                $fallback_eoq = max(1, round($stock_out / 12)); // EOQ = 1/12 dari demand tahunan
                $data_eoq_all[] = $fallback_eoq;
                $data_frequency_all[] = 12; // 12 kali per tahun (monthly)

                // Fallback total cost
                $fallback_total_cost = sqrt(2 * $stock_out * $setup_cost * 1000); // Menggunakan biaya simpan minimal
                $data_total_cost_all[] = $fallback_total_cost;
            }
        }

        // Validasi final untuk memastikan tidak ada nilai 0
        for ($i = 0; $i < count($data_eoq_all); $i++) {
            if ($data_eoq_all[$i] <= 0) {
                $data_eoq_all[$i] = max(1, round($datas[$i]['stock_out'] / 12));
            }
            if ($data_frequency_all[$i] <= 0) {
                $data_frequency_all[$i] = 12;
            }
            if ($data_total_cost_all[$i] <= 0) {
                $data_total_cost_all[$i] = sqrt(2 * $datas[$i]['stock_out'] * 50000 * 1000);
            }
        }

        // PERHITUNGAN STATISTIK EOQ
        $total_products = count($datas);
        $total_demand = array_sum(array_column($datas, 'stock_out'));
        $total_eoq = array_sum($data_eoq_all);
        $total_frequency = array_sum($data_frequency_all);
        $total_cost_eoq = array_sum($data_total_cost_all);
        $avg_eoq = $total_products > 0 ? round($total_eoq / $total_products) : 0;

        // Perhitungan efisiensi (optional)
        $max_eoq = !empty($data_eoq_all) ? max($data_eoq_all) : 0;
        $min_eoq = !empty($data_eoq_all) ? min($data_eoq_all) : 0;

        // Return JSON response dengan semua data EOQ
        echo json_encode(array(
            'success' => true,
            'data' => $datas,
            'data_eoq_all' => $data_eoq_all,
            'data_frequency_all' => $data_frequency_all,
            'data_total_cost_all' => $data_total_cost_all,
            'statistics' => array(
                'total_products' => $total_products,
                'total_demand' => $total_demand,
                'total_eoq' => $total_eoq,
                'total_frequency' => $total_frequency,
                'total_cost_eoq' => $total_cost_eoq,
                'avg_eoq' => $avg_eoq,
                'max_eoq' => $max_eoq,
                'min_eoq' => $min_eoq
            ),
            'calculation_info' => array(
                'setup_cost' => 50000,
                'formula' => 'EOQ = √((2 × D × S) / H)',
                'frequency_formula' => 'Frequency = D / EOQ',
                'total_cost_formula' => 'Total Cost = √(2 × D × S × H)',
                'parameters' => array(
                    'D' => 'Demand (permintaan tahunan)',
                    'S' => 'Setup cost / Order cost (biaya pemesanan)',
                    'H' => 'Holding cost (biaya penyimpanan per unit)'
                )
            ),
            'debug_info' => array(
                'total_rows' => mysqli_num_rows($query),
                'sample_eoq_calculation' => array(
                    'product' => !empty($datas) ? $datas[0]['nama_produk'] : 'No data',
                    'demand' => !empty($datas) ? $datas[0]['stock_out'] : 0,
                    'setup_cost' => 50000,
                    'holding_cost' => !empty($datas) ? $datas[0]['biaya_penyimpanan'] : 1000,
                    'eoq_result' => !empty($data_eoq_all) ? $data_eoq_all[0] : 0,
                    'frequency_result' => !empty($data_frequency_all) ? $data_frequency_all[0] : 0
                )
            )
        ));
    } else {
        throw new Exception("Parameter tanggal dari dan sampai diperlukan");
    }
} catch (Exception $e) {
    // Return error response
    echo json_encode(array(
        'success' => false,
        'error' => $e->getMessage()
    ));
}

// Tutup koneksi
if (isset($conn)) {
    mysqli_close($conn);
}