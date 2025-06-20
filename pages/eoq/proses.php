<?php
include '../../config/koneksi.php';

// ============================================================================
// TAHAP 1: SETUP RESPONSE DAN VALIDASI INPUT
// ============================================================================

// Set header untuk JSON response
header('Content-Type: application/json');

try {
    // Validasi parameter GET
    if (!isset($_GET['dari']) || !isset($_GET['sampai'])) {
        throw new Exception("Parameter tanggal dari dan sampai diperlukan");
    }

    $dari = $_GET['dari'];
    $sampai = $_GET['sampai'];

    // Validasi format tanggal
    if (empty($dari) || empty($sampai)) {
        throw new Exception("Tanggal dari dan sampai harus diisi");
    }

    // Validasi logika tanggal
    if ($dari > $sampai) {
        throw new Exception("Tanggal 'dari' tidak boleh lebih besar dari tanggal 'sampai'");
    }

    // ============================================================================
    // TAHAP 2: QUERY DATABASE UNTUK MENGAMBIL DATA TRANSAKSI PENJUALAN
    // ============================================================================

    // PERBAIKAN: Pastikan supplier di-join dan diambil dengan benar
    $query = mysqli_query(
        $conn,
        "SELECT 
        MIN(tp.id) as id,
        COALESCE(p.biaya_penyimpanan, 1000) as biaya_penyimpanan,
        p.nama_produk, 
        MIN(tp.harga) as harga,
        s.nama_satuan,
        COALESCE(NULLIF(TRIM(sup.nama_sup), ''), 'Unknown Supplier') as nama_sup, -- ← PERBAIKAN
        sup.id as supplier_id,
        SUM(tp.stock_out) as stock_out,
        SUM(CAST(tp.stock_out AS DECIMAL) * CAST(tp.harga AS DECIMAL)) as pendapatan
    FROM transaksi_penjualan AS tp 
    INNER JOIN produk AS p ON tp.produk_id = p.id
    INNER JOIN user AS u ON tp.user_id = u.id
    INNER JOIN satuan AS s ON tp.satuan_id = s.id
    LEFT JOIN supplier AS sup ON tp.sup_id = sup.id  -- ← UBAH ke LEFT JOIN
    WHERE tp.tanggal BETWEEN '$dari' AND '$sampai'
    GROUP BY p.id, p.nama_produk, p.biaya_penyimpanan, s.nama_satuan, sup.nama_sup, sup.id
    ORDER BY pendapatan DESC"
    );

    // Cek apakah query berhasil dieksekusi
    if (!$query) {
        throw new Exception("Error pada query database: " . mysqli_error($conn));
    }

    // Cek apakah ada data hasil query
    if (mysqli_num_rows($query) == 0) {
        throw new Exception("Tidak ada data transaksi penjualan dalam rentang tanggal yang dipilih");
    }

    // ============================================================================
    // TAHAP 3: PENGOLAHAN DATA DARI DATABASE
    // ============================================================================

    $datas = array();

    // Loop untuk mengambil semua data dan validasi
    while ($data = mysqli_fetch_assoc($query)) {
        // Validasi dan normalisasi data numerik
        $data['stock_out'] = max(1, (int)$data['stock_out']);
        $data['harga'] = max(1, (int)$data['harga']);
        $data['pendapatan'] = (float)$data['pendapatan'];
        $data['biaya_penyimpanan'] = max(100, (int)$data['biaya_penyimpanan']);

        // PERBAIKAN SUPPLIER: Pastikan nama_sup tidak kosong
        if (empty($data['nama_sup']) || $data['nama_sup'] === null || trim($data['nama_sup']) === '') {
            $data['nama_sup'] = 'Unknown Supplier';
        } else {
            $data['nama_sup'] = trim($data['nama_sup']);
            // Jika masih berupa angka, ganti dengan Unknown
            if (is_numeric($data['nama_sup']) || $data['nama_sup'] === '0') {
                $data['nama_sup'] = 'Unknown Supplier';
            }
        }

        // Debug log
        error_log("Product: " . $data['nama_produk'] . " | Supplier: " . $data['nama_sup'] . " | Supplier ID: " . ($data['supplier_id'] ?? 'NULL'));

        $datas[] = $data;
    }


    // Pastikan ada data yang valid setelah pengolahan
    if (empty($datas)) {
        throw new Exception("Data transaksi kosong setelah validasi");
    }

    // ============================================================================
    // TAHAP 4: PERHITUNGAN EOQ UNTUK SETIAP PRODUK
    // ============================================================================

    // Inisialisasi array untuk menyimpan hasil perhitungan
    $data_eoq_all = array();           // Array untuk menyimpan nilai EOQ optimal
    $data_frequency_all = array();     // Array untuk menyimpan frekuensi pemesanan per tahun
    $data_total_cost_all = array();    // Array untuk menyimpan total biaya EOQ
    $data_setup_cost_all = array();    // Array untuk menyimpan biaya pemesanan per produk

    // Loop untuk menghitung EOQ setiap produk
    for ($i = 0; $i < count($datas); $i++) {

        // ====================================================================
        // TAHAP 4.1: EKSTRAK DATA UNTUK PERHITUNGAN
        // ====================================================================

        $demand = (int)$datas[$i]['stock_out'];                    // D = Demand (permintaan tahunan)
        $harga_produk = (int)$datas[$i]['harga'];                  // Harga produk per unit
        $holding_cost = (int)$datas[$i]['biaya_penyimpanan'];      // H = Holding cost (biaya penyimpanan per unit)

        // ====================================================================
        // TAHAP 4.2: HITUNG SETUP COST (BIAYA PEMESANAN)
        // ====================================================================

        // Formula: Setup Cost = 12% × Harga Produk
        // Alasan: Biaya administratif dan logistik proporsional dengan nilai produk
        $setup_cost = $harga_produk * 0.12;

        // Pastikan setup cost minimal Rp 100 untuk perhitungan yang realistis
        $setup_cost = max(100, $setup_cost);

        // Simpan setup cost ke array
        $data_setup_cost_all[] = $setup_cost;

        // ====================================================================
        // TAHAP 4.3: HITUNG EOQ MENGGUNAKAN FORMULA STANDAR
        // ====================================================================

        // Formula EOQ: EOQ = √((2 × D × S) / H)
        // Dimana:
        // D = Demand (permintaan tahunan)
        // S = Setup cost (biaya pemesanan = 12% × harga)
        // H = Holding cost (biaya penyimpanan per unit)

        // Hitung komponen dalam akar kuadrat
        $eoq_numerator = 2 * $demand * $setup_cost;    // 2 × D × S
        $eoq_calculation = $eoq_numerator / $holding_cost;  // (2 × D × S) / H

        // Hitung akar kuadrat untuk mendapatkan EOQ
        $eoq_value = sqrt($eoq_calculation);

        // Bulatkan ke bilangan bulat terdekat (minimal 1 unit)
        $eoq_rounded = max(1, round($eoq_value));

        // Simpan hasil EOQ ke array
        $data_eoq_all[] = $eoq_rounded;

        // ====================================================================
        // TAHAP 4.4: HITUNG FREKUENSI PEMESANAN PER TAHUN
        // ====================================================================

        // Formula Frekuensi: Frequency = D / EOQ
        // Menunjukkan berapa kali harus melakukan pemesanan dalam setahun
        $frequency = $demand / $eoq_rounded;
        $frequency_rounded = max(1, round($frequency));  // Minimal 1 kali per tahun

        // Simpan frekuensi ke array
        $data_frequency_all[] = $frequency_rounded;

        // ====================================================================
        // TAHAP 4.5: HITUNG TOTAL COST EOQ
        // ====================================================================

        // Formula Total Cost EOQ: Total Cost = √(2 × D × S × H)
        // Menunjukkan total biaya optimal dengan menggunakan EOQ
        $total_cost_calculation = 2 * $demand * $setup_cost * $holding_cost;
        $total_cost_eoq = sqrt($total_cost_calculation);

        // Simpan total cost ke array
        $data_total_cost_all[] = $total_cost_eoq;

        // ====================================================================
        // TAHAP 4.6: LOG PERHITUNGAN UNTUK DEBUGGING (OPSIONAL)
        // ====================================================================

        // Log supplier untuk debugging
        error_log("EOQ Calculation - Product: " . $datas[$i]['nama_produk'] .
            " | Supplier: " . $datas[$i]['nama_sup'] .
            " | D: $demand | S: $setup_cost | H: $holding_cost | EOQ: $eoq_rounded");
    }

    // ============================================================================
    // TAHAP 5: VALIDASI HASIL AKHIR
    // ============================================================================

    // Pastikan semua array hasil memiliki panjang yang sama dengan data produk
    if (
        count($data_eoq_all) !== count($datas) ||
        count($data_frequency_all) !== count($datas) ||
        count($data_total_cost_all) !== count($datas) ||
        count($data_setup_cost_all) !== count($datas)
    ) {
        throw new Exception("Inkonsistensi dalam perhitungan EOQ - jumlah data tidak sama");
    }

    // Validasi tidak ada nilai 0 atau negatif dalam hasil
    for ($i = 0; $i < count($data_eoq_all); $i++) {
        if ($data_eoq_all[$i] <= 0) {
            throw new Exception("EOQ tidak valid untuk produk: " . $datas[$i]['nama_produk']);
        }
        if ($data_frequency_all[$i] <= 0) {
            throw new Exception("Frekuensi tidak valid untuk produk: " . $datas[$i]['nama_produk']);
        }
        if ($data_total_cost_all[$i] <= 0) {
            throw new Exception("Total cost tidak valid untuk produk: " . $datas[$i]['nama_produk']);
        }
        if ($data_setup_cost_all[$i] <= 0) {
            throw new Exception("Setup cost tidak valid untuk produk: " . $datas[$i]['nama_produk']);
        }
    }

    // ============================================================================
    // TAHAP 6: PERHITUNGAN STATISTIK AGREGAT
    // ============================================================================

    $total_products = count($datas);
    $total_demand = array_sum(array_column($datas, 'stock_out'));
    $total_eoq = array_sum($data_eoq_all);
    $total_frequency = array_sum($data_frequency_all);
    $total_cost_eoq = array_sum($data_total_cost_all);
    $total_setup_cost = array_sum($data_setup_cost_all);

    // Hitung rata-rata
    $avg_eoq = $total_products > 0 ? round($total_eoq / $total_products, 2) : 0;
    $avg_setup_cost = $total_products > 0 ? round($total_setup_cost / $total_products, 2) : 0;
    $avg_frequency = $total_products > 0 ? round($total_frequency / $total_products, 2) : 0;

    // Hitung nilai maksimum dan minimum
    $max_eoq = !empty($data_eoq_all) ? max($data_eoq_all) : 0;
    $min_eoq = !empty($data_eoq_all) ? min($data_eoq_all) : 0;
    $max_setup_cost = !empty($data_setup_cost_all) ? max($data_setup_cost_all) : 0;
    $min_setup_cost = !empty($data_setup_cost_all) ? min($data_setup_cost_all) : 0;

    // ============================================================================
    // TAHAP 7: PERSIAPAN DATA UNTUK DEBUGGING DAN DOKUMENTASI
    // ============================================================================

    // Ambil contoh perhitungan dari produk pertama untuk dokumentasi
    $sample_product = !empty($datas) ? $datas[0] : null;
    $sample_setup_cost = !empty($data_setup_cost_all) ? $data_setup_cost_all[0] : 0;
    $sample_eoq = !empty($data_eoq_all) ? $data_eoq_all[0] : 0;
    $sample_frequency = !empty($data_frequency_all) ? $data_frequency_all[0] : 0;

    // Buat langkah-langkah perhitungan untuk dokumentasi
    $calculation_steps = array();
    if ($sample_product) {
        $calculation_steps = array(
            'step_1_setup_cost' => number_format($sample_product['harga'], 0, ',', '.') . ' × 12% = ' . number_format($sample_setup_cost, 0, ',', '.'),
            'step_2_formula' => 'EOQ = √((2 × ' . $sample_product['stock_out'] . ' × ' . number_format($sample_setup_cost, 0, ',', '.') . ') / ' . number_format($sample_product['biaya_penyimpanan'], 0, ',', '.') . ')',
            'step_3_calculation' => 'EOQ = √(' . number_format(2 * $sample_product['stock_out'] * $sample_setup_cost, 0, ',', '.') . ' / ' . number_format($sample_product['biaya_penyimpanan'], 0, ',', '.') . ')',
            'step_4_result' => 'EOQ = ' . $sample_eoq . ' unit',
            'step_5_frequency' => 'Frequency = ' . $sample_product['stock_out'] . ' / ' . $sample_eoq . ' = ' . $sample_frequency . ' kali/tahun'
        );
    }

    // ============================================================================
    // TAHAP 8: RETURN RESPONSE JSON DENGAN SEMUA DATA DAN METADATA
    // ============================================================================

    echo json_encode(array(
        'success' => true,
        'message' => 'Perhitungan EOQ berhasil diproses',

        // Data utama
        'data' => $datas,
        'data_eoq_all' => $data_eoq_all,
        'data_frequency_all' => $data_frequency_all,
        'data_total_cost_all' => $data_total_cost_all,
        'data_setup_cost_all' => $data_setup_cost_all,

        // Statistik agregat
        'statistics' => array(
            'total_products' => $total_products,
            'total_demand' => $total_demand,
            'total_eoq' => $total_eoq,
            'total_frequency' => $total_frequency,
            'total_cost_eoq' => round($total_cost_eoq, 2),
            'total_setup_cost' => round($total_setup_cost, 2),
            'avg_eoq' => $avg_eoq,
            'avg_setup_cost' => $avg_setup_cost,
            'avg_frequency' => $avg_frequency,
            'max_eoq' => $max_eoq,
            'min_eoq' => $min_eoq,
            'max_setup_cost' => round($max_setup_cost, 2),
            'min_setup_cost' => round($min_setup_cost, 2)
        ),

        // Informasi metodologi perhitungan
        'calculation_info' => array(
            'setup_cost_method' => 'Per produk berdasarkan 12% dari harga produk',
            'setup_cost_formula' => 'Setup Cost = Harga Produk × 0.12 (12%)',
            'eoq_formula' => 'EOQ = √((2 × D × S) / H)',
            'frequency_formula' => 'Frequency = D / EOQ',
            'total_cost_formula' => 'Total Cost = √(2 × D × S × H)',
            'parameters' => array(
                'D' => 'Demand (permintaan tahunan dari total penjualan)',
                'S' => 'Setup cost/Order cost (12% dari harga produk, minimal Rp 100)',
                'H' => 'Holding cost (biaya penyimpanan per unit, minimal Rp 100)'
            ),
            'explanation' => array(
                'setup_cost_reasoning' => 'Biaya pemesanan dihitung sebesar 12% dari harga produk karena biaya ini mencerminkan biaya administratif, logistik, dan overhead yang proporsional dengan nilai produk.',
                'percentage_basis' => 'Persentase 12% digunakan sebagai standar industri untuk biaya pemesanan relatif terhadap nilai produk.',
                'minimum_setup_cost' => 'Biaya pemesanan minimal adalah Rp 100 untuk memastikan perhitungan yang realistis.',
                'minimum_holding_cost' => 'Biaya penyimpanan minimal adalah Rp 100 untuk menghindari pembagian dengan nilai yang terlalu kecil.',
                'rounding_method' => 'Semua hasil EOQ dibulatkan ke bilangan bulat terdekat dengan minimal 1 unit.'
            )
        ),

        // Data untuk debugging dan verifikasi
        'debug_info' => array(
            'query_rows' => mysqli_num_rows($query),
            'date_range' => array(
                'dari' => $dari,
                'sampai' => $sampai
            ),
            'sample_calculation' => array(
                'product_name' => $sample_product ? $sample_product['nama_produk'] : 'No data',
                'product_price' => $sample_product ? $sample_product['harga'] : 0,
                'supplier_name' => $sample_product ? $sample_product['nama_sup'] : 'No supplier',
                'setup_cost_12_percent' => $sample_setup_cost,
                'demand' => $sample_product ? $sample_product['stock_out'] : 0,
                'holding_cost' => $sample_product ? $sample_product['biaya_penyimpanan'] : 0,
                'eoq_result' => $sample_eoq,
                'frequency_result' => $sample_frequency,
                'calculation_steps' => $calculation_steps
            ),
            'validation_checks' => array(
                'all_eoq_positive' => min($data_eoq_all) > 0,
                'all_frequency_positive' => min($data_frequency_all) > 0,
                'all_setup_cost_positive' => min($data_setup_cost_all) > 0,
                'data_consistency' => count($data_eoq_all) === count($datas),
                'all_suppliers_valid' => array_reduce($datas, function ($carry, $item) {
                    return $carry && !empty($item['nama_sup']) && $item['nama_sup'] !== '0';
                }, true)
            )
        ),

        // Timestamp dan versi
        'metadata' => array(
            'calculation_timestamp' => date('Y-m-d H:i:s'),
            'version' => '2.1 - Fixed Supplier Version',
            'algorithm' => 'Standard EOQ Formula with Dynamic Setup Cost and Proper Supplier Join'
        )
    ), JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // ============================================================================
    // TAHAP 9: ERROR HANDLING DAN RESPONSE
    // ============================================================================

    // Log error untuk debugging (opsional)
    error_log("EOQ Calculation Error: " . $e->getMessage());

    // Return error response
    echo json_encode(array(
        'success' => false,
        'error' => $e->getMessage(),
        'error_code' => 'CALCULATION_ERROR',
        'timestamp' => date('Y-m-d H:i:s'),
        'debug_info' => array(
            'input_dari' => isset($dari) ? $dari : 'not set',
            'input_sampai' => isset($sampai) ? $sampai : 'not set',
            'query_executed' => isset($query) ? 'yes' : 'no',
            'data_count' => isset($datas) ? count($datas) : 0
        )
    ), JSON_PRETTY_PRINT);
} finally {
    // ============================================================================
    // TAHAP 10: CLEANUP DAN TUTUP KONEKSI
    // ============================================================================

    // Tutup koneksi database jika ada
    if (isset($conn) && $conn) {
        mysqli_close($conn);
    }
}