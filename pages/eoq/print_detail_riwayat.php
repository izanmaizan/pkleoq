<?php
session_start();
include '../../config/koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit;
}

// Validasi parameter ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID riwayat tidak valid'); window.close();</script>";
    exit;
}

$riwayat_id = (int)$_GET['id'];

try {
    // Query untuk mengambil header riwayat
    $header_query = "SELECT 
                        r.id,
                        r.tanggal_dari,
                        r.tanggal_sampai,
                        r.tanggal_perhitungan,
                        r.total_produk,
                        r.total_demand,
                        r.total_eoq,
                        r.avg_eoq,
                        r.max_eoq,
                        r.min_eoq,
                        r.total_setup_cost,
                        r.avg_setup_cost,
                        r.total_cost_eoq,
                        r.keterangan,
                        r.status,
                        u.username,
                        u.nama as nama_user
                     FROM riwayat_eoq r 
                     LEFT JOIN user u ON r.user_id = u.id 
                     WHERE r.id = $riwayat_id";

    $header_result = mysqli_query($conn, $header_query);

    if (!$header_result || mysqli_num_rows($header_result) == 0) {
        throw new Exception("Riwayat tidak ditemukan");
    }

    $header_data = mysqli_fetch_assoc($header_result);

    // Query untuk mengambil detail produk
    $detail_query = "SELECT 
                        nama_produk,
                        demand_tahunan,
                        harga_produk,
                        biaya_pemesanan,
                        biaya_penyimpanan,
                        eoq_optimal,
                        frekuensi_pesan,
                        interval_hari,
                        total_cost_eoq,
                        supplier,
                        nilai_penjualan
                     FROM riwayat_eoq_detail 
                     WHERE riwayat_eoq_id = $riwayat_id
                     ORDER BY eoq_optimal DESC, nama_produk ASC";

    $detail_result = mysqli_query($conn, $detail_query);
    $detail_data = array();

    if ($detail_result) {
        while ($row = mysqli_fetch_assoc($detail_result)) {
            $detail_data[] = $row;
        }
    }
} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "'); window.close();</script>";
    exit;
}

// Format tanggal
$tanggal_perhitungan = date('d/m/Y H:i', strtotime($header_data['tanggal_perhitungan']));
$periode_dari = date('d/m/Y', strtotime($header_data['tanggal_dari']));
$periode_sampai = date('d/m/Y', strtotime($header_data['tanggal_sampai']));

// Format currency
function formatCurrency($amount)
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Riwayat EOQ - <?= $tanggal_perhitungan ?></title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 20px;
        font-size: 12px;
        line-height: 1.4;
        color: #333;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 3px solid #dc2626;
        padding-bottom: 20px;
    }

    .header h1 {
        color: #dc2626;
        margin: 0;
        font-size: 24px;
        font-weight: bold;
    }

    .header h2 {
        color: #666;
        margin: 5px 0;
        font-size: 16px;
        font-weight: normal;
    }

    .company-info {
        margin: 10px 0;
        font-size: 14px;
        color: #666;
    }

    .info-section {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        gap: 20px;
    }

    .info-box {
        flex: 1;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        background-color: #f9f9f9;
    }

    .info-box h3 {
        margin: 0 0 10px 0;
        color: #dc2626;
        font-size: 14px;
        font-weight: bold;
        border-bottom: 1px solid #dc2626;
        padding-bottom: 5px;
    }

    .info-table {
        width: 100%;
        margin-top: 10px;
    }

    .info-table td {
        padding: 3px 0;
        vertical-align: top;
    }

    .info-table td:first-child {
        font-weight: bold;
        width: 40%;
        color: #555;
    }

    .info-table td:last-child {
        color: #333;
    }

    .detail-section {
        margin-top: 30px;
    }

    .detail-section h3 {
        color: #dc2626;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 15px;
        border-bottom: 2px solid #dc2626;
        padding-bottom: 5px;
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        font-size: 11px;
    }

    .detail-table th {
        background-color: #dc2626;
        color: white;
        padding: 8px 5px;
        text-align: center;
        font-weight: bold;
        border: 1px solid #b91c1c;
    }

    .detail-table td {
        padding: 6px 5px;
        text-align: center;
        border: 1px solid #ddd;
        vertical-align: middle;
    }

    .detail-table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .detail-table tbody tr:hover {
        background-color: #fff5f5;
    }

    .text-right {
        text-align: right !important;
    }

    .text-left {
        text-align: left !important;
    }

    .font-bold {
        font-weight: bold;
    }

    .text-red {
        color: #dc2626;
    }

    .text-green {
        color: #059669;
    }

    .text-blue {
        color: #0284c7;
    }

    .summary-box {
        background-color: #fff5f5;
        border: 2px solid #dc2626;
        border-radius: 8px;
        padding: 15px;
        margin: 20px 0;
    }

    .summary-box h4 {
        margin: 0 0 10px 0;
        color: #dc2626;
        font-size: 14px;
    }

    .summary-stats {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 15px;
    }

    .stat-item {
        text-align: center;
        flex: 1;
        min-width: 120px;
    }

    .stat-value {
        font-size: 16px;
        font-weight: bold;
        color: #dc2626;
        display: block;
    }

    .stat-label {
        font-size: 10px;
        color: #666;
        margin-top: 2px;
    }

    .footer {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
        text-align: center;
        color: #666;
        font-size: 10px;
    }

    .print-info {
        margin-top: 10px;
        font-size: 9px;
        color: #999;
    }

    /* Print styles */
    @media print {
        body {
            margin: 0;
            padding: 15px;
        }

        .info-section {
            flex-direction: column;
        }

        .info-box {
            margin-bottom: 15px;
        }

        .detail-table {
            font-size: 10px;
        }

        .detail-table th,
        .detail-table td {
            padding: 4px 3px;
        }

        .no-print {
            display: none;
        }

        /* Ensure colors print correctly */
        .detail-table th {
            background-color: #dc2626 !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
        }

        .summary-box {
            background-color: #fff5f5 !important;
            -webkit-print-color-adjust: exact;
        }
    }

    @page {
        margin: 1cm;
        size: A4;
    }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>DETAIL RIWAYAT PERHITUNGAN EOQ</h1>
        <h2>Economic Order Quantity Analysis Report</h2>
        <div class="company-info">
            <strong>PT Wings Group Indonesia - Cabang Muara Bungo</strong><br>
            Jl. Lintas Sumatera KM 10, Muara Bungo, Jambi
        </div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <!-- Info Perhitungan -->
        <div class="info-box">
            <h3>📊 Informasi Perhitungan</h3>
            <table class="info-table">
                <tr>
                    <td>Tanggal Perhitungan:</td>
                    <td><strong><?= $tanggal_perhitungan ?></strong></td>
                </tr>
                <tr>
                    <td>Periode Data:</td>
                    <td><strong><?= $periode_dari ?> - <?= $periode_sampai ?></strong></td>
                </tr>
                <tr>
                    <td>User/Admin:</td>
                    <td><strong><?= htmlspecialchars($header_data['username'] ?: 'System') ?></strong></td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td><strong class="text-green">✓ <?= ucfirst($header_data['status']) ?></strong></td>
                </tr>
                <tr>
                    <td>ID Riwayat:</td>
                    <td><strong><?= $header_data['id'] ?></strong></td>
                </tr>
            </table>
        </div>

        <!-- Statistik Hasil -->
        <div class="info-box">
            <h3>📈 Statistik Hasil EOQ</h3>
            <table class="info-table">
                <tr>
                    <td>Total Produk:</td>
                    <td><strong class="text-blue"><?= number_format($header_data['total_produk']) ?> produk</strong>
                    </td>
                </tr>
                <tr>
                    <td>Total Demand:</td>
                    <td><strong class="text-blue"><?= number_format($header_data['total_demand']) ?> unit</strong></td>
                </tr>
                <tr>
                    <td>Total EOQ:</td>
                    <td><strong class="text-red"><?= number_format($header_data['total_eoq']) ?> unit</strong></td>
                </tr>
                <tr>
                    <td>Rata-rata EOQ:</td>
                    <td><strong class="text-red"><?= number_format($header_data['avg_eoq'], 2) ?> unit</strong></td>
                </tr>
                <tr>
                    <td>Total Cost EOQ:</td>
                    <td><strong class="text-green"><?= formatCurrency($header_data['total_cost_eoq']) ?></strong></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Summary Box -->
    <div class="summary-box">
        <h4>📋 Ringkasan Analisis EOQ</h4>
        <div class="summary-stats">
            <div class="stat-item">
                <span class="stat-value"><?= number_format($header_data['total_produk']) ?></span>
                <div class="stat-label">Total Produk</div>
            </div>
            <div class="stat-item">
                <span class="stat-value"><?= number_format($header_data['min_eoq']) ?></span>
                <div class="stat-label">EOQ Minimum</div>
            </div>
            <div class="stat-item">
                <span class="stat-value"><?= number_format($header_data['max_eoq']) ?></span>
                <div class="stat-label">EOQ Maksimum</div>
            </div>
            <div class="stat-item">
                <span class="stat-value"><?= formatCurrency($header_data['avg_setup_cost']) ?></span>
                <div class="stat-label">Avg Setup Cost</div>
            </div>
            <div class="stat-item">
                <span class="stat-value"><?= formatCurrency($header_data['total_cost_eoq']) ?></span>
                <div class="stat-label">Total Cost EOQ</div>
            </div>
        </div>
    </div>

    <!-- Detail Products -->
    <div class="detail-section">
        <h3>📦 Detail Perhitungan EOQ Per Produk</h3>

        <?php if (!empty($detail_data)): ?>
        <table class="detail-table">
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 25%;">Nama Produk</th>
                    <th style="width: 8%;">Demand<br>(Unit)</th>
                    <th style="width: 10%;">Harga<br>Produk</th>
                    <th style="width: 10%;">Biaya<br>Setup</th>
                    <th style="width: 10%;">Biaya<br>Simpan</th>
                    <th style="width: 8%;">EOQ<br>Optimal</th>
                    <th style="width: 7%;">Frekuensi<br>/Tahun</th>
                    <th style="width: 8%;">Interval<br>(Hari)</th>
                    <th style="width: 10%;">Total Cost<br>EOQ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $total_nilai_penjualan = 0;
                    $total_biaya_setup = 0;
                    $total_biaya_simpan = 0;
                    foreach ($detail_data as $index => $item):
                        $total_nilai_penjualan += $item['nilai_penjualan'];
                        $total_biaya_setup += $item['biaya_pemesanan'];
                        $total_biaya_simpan += $item['biaya_penyimpanan'];
                    ?>
                <tr>
                    <td class="font-bold"><?= $index + 1 ?></td>
                    <td class="text-left">
                        <strong><?= htmlspecialchars($item['nama_produk']) ?></strong><br>
                        <small style="color: #666;">Supplier: <?= htmlspecialchars($item['supplier']) ?></small>
                    </td>
                    <td class="font-bold text-blue"><?= number_format($item['demand_tahunan']) ?></td>
                    <td class="text-right"><?= formatCurrency($item['harga_produk']) ?></td>
                    <td class="text-right"><?= formatCurrency($item['biaya_pemesanan']) ?></td>
                    <td class="text-right"><?= formatCurrency($item['biaya_penyimpanan']) ?></td>
                    <td class="font-bold text-red"><?= number_format($item['eoq_optimal']) ?></td>
                    <td class="text-center"><?= $item['frekuensi_pesan'] ?>x</td>
                    <td class="text-center"><?= $item['interval_hari'] ?></td>
                    <td class="text-right text-green font-bold"><?= formatCurrency($item['total_cost_eoq']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="background-color: #dc2626; color: white; font-weight: bold;">
                    <td colspan="3" class="text-left">TOTAL KESELURUHAN</td>
                    <td class="text-right"><?= formatCurrency($total_nilai_penjualan) ?></td>
                    <td class="text-right"><?= formatCurrency($total_biaya_setup) ?></td>
                    <td class="text-right"><?= formatCurrency($total_biaya_simpan) ?></td>
                    <td class="text-center"><?= number_format($header_data['total_eoq']) ?></td>
                    <td colspan="2" class="text-center">SUMMARY</td>
                    <td class="text-right"><?= formatCurrency($header_data['total_cost_eoq']) ?></td>
                </tr>
            </tfoot>
        </table>
        <?php else: ?>
        <div style="text-align: center; padding: 40px; color: #666;">
            <strong>Tidak ada detail produk yang tersedia</strong>
        </div>
        <?php endif; ?>
    </div>

    <!-- Keterangan -->
    <?php if (!empty($header_data['keterangan'])): ?>
    <div class="detail-section">
        <h3>📝 Keterangan</h3>
        <div
            style="background-color: #f0f9ff; border: 1px solid #0284c7; border-radius: 6px; padding: 15px; color: #0c4a6e;">
            <?= nl2br(htmlspecialchars($header_data['keterangan'])) ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Metodologi -->
    <div class="detail-section">
        <h3>🧮 Metodologi Perhitungan</h3>
        <div style="background-color: #fffbeb; border: 1px solid #f59e0b; border-radius: 6px; padding: 15px;">
            <p><strong>Formula EOQ yang digunakan:</strong></p>
            <div style="text-align: center; font-size: 16px; font-weight: bold; color: #dc2626; margin: 10px 0;">
                EOQ = √((2 × D × S) / H)
            </div>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><strong>D</strong> = Demand (permintaan tahunan dari total penjualan)</li>
                <li><strong>S</strong> = Setup cost/Order cost (12% dari harga produk, minimal Rp 100)</li>
                <li><strong>H</strong> = Holding cost (biaya penyimpanan per unit, minimal Rp 100)</li>
            </ul>
            <p><strong>Catatan:</strong> Biaya pemesanan dihitung sebesar 12% dari harga produk sesuai standar
                operasional PT Wings Group.</p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div>
            <strong>PT Wings Group Indonesia - Cabang Muara Bungo</strong><br>
            Sistem EOQ (Economic Order Quantity) v2.0<br>
            Copyright © 2025 - All Rights Reserved
        </div>
        <div class="print-info">
            Laporan dicetak pada: <?= date('d/m/Y H:i:s') ?> |
            User: <?= htmlspecialchars($_SESSION['username']) ?> |
            ID Riwayat: <?= $riwayat_id ?>
        </div>
    </div>

    <!-- Print JavaScript -->
    <script>
    // Auto print when page loads
    window.onload = function() {
        // Small delay to ensure page is fully rendered
        setTimeout(function() {
            window.print();
        }, 500);
    };

    // Close window after printing (optional)
    window.onafterprint = function() {
        // Uncomment the line below if you want to auto-close after printing
        // window.close();
    };
    </script>

    <!-- Print Button (visible on screen, hidden when printing) -->
    <div class="no-print" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
        <button onclick="window.print()" style="
            background-color: #dc2626; 
            color: white; 
            border: none; 
            padding: 10px 20px; 
            border-radius: 5px; 
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        ">
            🖨️ Cetak Laporan
        </button>
        <button onclick="window.close()" style="
            background-color: #6b7280; 
            color: white; 
            border: none; 
            padding: 10px 20px; 
            border-radius: 5px; 
            cursor: pointer;
            font-weight: bold;
            margin-left: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        ">
            ❌ Tutup
        </button>
    </div>
</body>

</html>

<?php
// Close database connection
if (isset($conn)) {
    mysqli_close($conn);
}
?>