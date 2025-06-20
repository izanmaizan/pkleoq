<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Analisis EOQ - Sistem EOQ PT Wings Group Indonesia">
    <meta name="author" content="PT Wings Group Indonesia">

    <title>EOQ - Economic Order Quantity | PT Wings Group</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- MathJax for formula display -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/3.2.2/es5/tex-mml-chtml.min.js"></script>

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="../../css/sweetalert2.min.css">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />

    <!-- Wings Theme CSS for EOQ -->
    <link rel="stylesheet" href="style.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../admin/dashboard.php">
                <div class="sidebar-brand-icon">
                    <img src="../../logo.svg" alt="Logo" style="width: 100px; height: auto;">
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../admin/dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Master Data
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Data Master</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Kelola Data:</h6>
                        <a class="collapse-item" href="../supplier/index.php">
                            <i class="fas fa-truck me-2"></i>Supplier
                        </a>
                        <a class="collapse-item" href="../produk/index.php">
                            <i class="fas fa-boxes me-2"></i>Produk
                        </a>
                        <a class="collapse-item" href="../kategori/index.php">
                            <i class="fas fa-tags me-2"></i>Kategori
                        </a>
                        <a class="collapse-item" href="../satuan/index.php">
                            <i class="fas fa-balance-scale me-2"></i>Satuan
                        </a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Transaksi
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="../pembelian/index.php">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Pembelian</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="../penjualan/index.php">
                    <i class="fas fa-fw fa-cash-register"></i>
                    <span>Penjualan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Laporan
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#report" aria-expanded="true"
                    aria-controls="report">
                    <i class="fas fa-fw fa-chart-line"></i>
                    <span>Laporan</span>
                </a>
                <div id="report" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Jenis Laporan:</h6>
                        <a class="collapse-item" href="../laporan/laporan_produk.php">
                            <i class="fas fa-pills me-2"></i>Laporan Produk
                        </a>
                        <a class="collapse-item" href="../laporan/laporan_pembelian.php">
                            <i class="fas fa-shopping-bag me-2"></i>Laporan Pembelian
                        </a>
                        <a class="collapse-item" href="../laporan/laporan_penjualan.php">
                            <i class="fas fa-chart-bar me-2"></i>Laporan Penjualan
                        </a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Analisis
            </div>

            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-calculator"></i>
                    <span>Economic Order Quantity</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small text-capitalize">
                                    <i class="fas fa-user-circle me-1"></i>
                                    <?= $_SESSION['username']; ?>
                                </span>
                                <img class="img-profile rounded-circle" src="../../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Welcome Banner -->
                    <div class="welcome-text">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="mb-1">
                                    <i class="fas fa-calculator fa-2x me-3"></i>
                                    Analisis Economic Order Quantity (EOQ)
                                </h4>
                                <p class="mb-0 opacity-75">
                                    Sistem perhitungan kuantitas pemesanan optimal untuk meminimalkan total biaya
                                    inventory PT Wings Group Indonesia
                                </p>
                            </div>
                            <div class="d-none d-lg-block">
                                <i class="fas fa-chart-area fa-3x opacity-25"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold">
                                    <i class="fas fa-analytics me-2"></i> Analisis Economic Order Quantity (EOQ)
                                </h6>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-light mr-2">
                                        <i class="fas fa-calculator me-1"></i> Formula EOQ
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Input Section -->
                            <div class="input-section mb-4 p-3 bg-light rounded">
                                <form id="dataForm" action="proses.php" method="GET">
                                    <div class="row align-items-end">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dari" class="font-weight-bold">
                                                    <i class="fas fa-calendar-alt me-1"></i> Tanggal Dari
                                                </label>
                                                <input type="date" class="form-control" id="dari" name="dari" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="sampai" class="font-weight-bold">
                                                    <i class="fas fa-calendar-alt me-1"></i> Tanggal Sampai
                                                </label>
                                                <input type="date" class="form-control" id="sampai" name="sampai"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-calculator"></i>
                                                    </span>
                                                    <span class="text">Hitung EOQ</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Results Section -->
                            <div id="result" style="display: none;">
                                <!-- EOQ Formula Section -->
                                <div class="analysis-section mb-4 eoq-primary">
                                    <div class="section-header">
                                        <h4><i class="fas fa-square-root-alt me-2"></i> FORMULA ECONOMIC ORDER QUANTITY
                                            (EOQ)</h4>
                                        <div class="eoq-description">
                                            <p class="text-muted mb-3">Formula matematika untuk menghitung kuantitas
                                                pemesanan optimal yang meminimalkan total biaya inventory</p>

                                            <!-- Formula EOQ dengan MathJax -->
                                            <div class="eoq-formula-display">
                                                <div class="formula-title mb-3">
                                                    <h5><i class="fas fa-square-root-alt me-2"></i>Formula EOQ:</h5>
                                                </div>
                                                <div class="math-formula-container">
                                                    $$EOQ = \sqrt{\frac{2 \times D \times S}{H}}$$
                                                </div>
                                                <div class="formula-parameters mt-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="parameter-item">
                                                                <strong>D</strong> = Demand (permintaan tahunan)
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="parameter-item">
                                                                <strong>S</strong> = Setup/Order cost (biaya pemesanan)
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="parameter-item">
                                                                <strong>H</strong> = Holding cost (biaya penyimpanan)
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Penjelasan biaya pemesanan yang disederhanakan -->
                                            <div class="setup-cost-info mt-3 p-3 bg-warning-light rounded">
                                                <h6><i class="fas fa-info-circle me-2"></i>Ketentuan Biaya Pemesanan
                                                </h6>
                                                <p class="mb-0">
                                                    <strong>Biaya pemesanan ditetapkan sebesar 12% dari harga
                                                        produk</strong>
                                                    untuk mencakup biaya administratif dan logistik sesuai standar
                                                    operasional.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- EOQ Calculation Results - SEMUA DATA -->
                                <div class="analysis-section mb-4 eoq-primary">
                                    <div class="section-header">
                                        <h4><i class="fas fa-calculator me-2"></i> HASIL PERHITUNGAN EOQ - SEMUA PRODUK
                                        </h4>
                                        <p class="text-muted">Hasil perhitungan EOQ untuk seluruh produk berdasarkan
                                            data penjualan periode yang dipilih</p>
                                    </div>

                                    <!-- UBAH: Tidak menggunakan DataTable, menggunakan table biasa dengan accordion -->
                                    <div class="eoq-results-container">
                                        <div class="table-responsive mb-4">
                                            <table class="table table-hover eoq-primary-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 30px;"><i class="fas fa-hashtag me-1"></i>No
                                                        </th>
                                                        <th style="width: 250px;"><i class="fas fa-box me-1"></i> Nama
                                                            Produk</th>
                                                        <th style="width: 100px;"><i class="fas fa-chart-bar me-1"></i>
                                                            Demand (D)</th>
                                                        <th style="width: 120px;"><i class="fas fa-truck me-1"></i>
                                                            Biaya Pesan (S)</th>
                                                        <th style="width: 120px;"><i class="fas fa-warehouse me-1"></i>
                                                            Biaya Simpan (H)</th>
                                                        <th style="width: 120px;"><i class="fas fa-calculator me-1"></i>
                                                            EOQ Optimal</th>
                                                        <th style="width: 80px;"><i class="fas fa-eye me-1"></i> Detail
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="data-eoq-all">
                                                    <!-- Data akan diisi oleh JavaScript -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- EOQ Implementation Guidelines -->
                                <!-- <div class="analysis-section mb-4 implementation-guide">
                                    <div class="section-header">
                                        <h5><i class="fas fa-cogs me-2"></i> Panduan Implementasi EOQ</h5>
                                        <p class="text-muted">Rekomendasi praktis untuk penerapan hasil analisis EOQ</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="implementation-card">
                                                <h6><i class="fas fa-clipboard-list me-2"></i> Langkah Implementasi</h6>
                                                <ol class="implementation-steps">
                                                    <li>Gunakan nilai EOQ sebagai panduan kuantitas pemesanan optimal
                                                    </li>
                                                    <li>Sesuaikan frekuensi pemesanan berdasarkan hasil perhitungan</li>
                                                    <li>Monitor interval pemesanan sesuai hasil EOQ</li>
                                                    <li>Evaluasi total cost EOQ vs current cost</li>
                                                    <li>Review dan update perhitungan secara berkala</li>
                                                </ol>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="monitoring-card">
                                                <h6><i class="fas fa-chart-area me-2"></i> Parameter EOQ</h6>
                                                <div class="kpi-list">
                                                    <div class="kpi-item">
                                                        <span class="kpi-name">Biaya Pemesanan (S):</span>
                                                        <span class="kpi-target">12% dari harga produk</span>
                                                    </div>
                                                    <div class="kpi-item">
                                                        <span class="kpi-name">Biaya Penyimpanan (H):</span>
                                                        <span class="kpi-target">Sesuai data produk</span>
                                                    </div>
                                                    <div class="kpi-item">
                                                        <span class="kpi-name">Demand (D):</span>
                                                        <span class="kpi-target">Data penjualan periode</span>
                                                    </div>
                                                    <div class="kpi-item">
                                                        <span class="kpi-name">EOQ Optimal:</span>
                                                        <span class="kpi-target">√((2×D×S)/H)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <!-- Action Buttons -->
                                <div class="text-center action-buttons">
                                    <button type="button" class="btn btn-success btn-icon-split" id="btnPrint">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-print"></i>
                                        </span>
                                        <span class="text">Cetak Laporan EOQ</span>
                                    </button>
                                    <button type="button" class="btn btn-info btn-icon-split"
                                        onclick="window.location.reload()">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-redo"></i>
                                        </span>
                                        <span class="text">Hitung Ulang</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Content -->

                    <!-- Riwayat Perhitungan EOQ Section -->
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold">
                                    <i class="fas fa-history me-2"></i> Riwayat Perhitungan EOQ
                                </h6>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-info mr-2">
                                        <i class="fas fa-clock me-1"></i> <span id="total-riwayat">0</span> Perhitungan
                                    </span>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="refresh-riwayat">
                                        <i class="fas fa-sync-alt"></i> Refresh
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Filter Section -->
                            <div class="filter-section mb-4 p-3 bg-light rounded">
                                <div class="row align-items-end">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="filter-dari" class="font-weight-bold">
                                                <i class="fas fa-calendar-alt me-1"></i> Filter Dari
                                            </label>
                                            <input type="date" class="form-control form-control-sm" id="filter-dari">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="filter-sampai" class="font-weight-bold">
                                                <i class="fas fa-calendar-alt me-1"></i> Filter Sampai
                                            </label>
                                            <input type="date" class="form-control form-control-sm" id="filter-sampai">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="filter-limit" class="font-weight-bold">
                                                <i class="fas fa-list me-1"></i> Tampilkan
                                            </label>
                                            <select class="form-control form-control-sm" id="filter-limit">
                                                <option value="10">10 Data Terakhir</option>
                                                <option value="25">25 Data Terakhir</option>
                                                <option value="50">50 Data Terakhir</option>
                                                <option value="100">100 Data Terakhir</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-sm" id="filter-riwayat">
                                                <i class="fas fa-search me-1"></i> Filter
                                            </button>
                                            <button type="button" class="btn btn-secondary btn-sm ml-2"
                                                id="reset-filter">
                                                <i class="fas fa-undo me-1"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Riwayat Table -->
                            <div class="table-responsive">
                                <table class="table table-hover" id="riwayat-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px;"><i class="fas fa-hashtag me-1"></i>No</th>
                                            <th style="width: 150px;"><i class="fas fa-calendar me-1"></i>Tanggal
                                                Perhitungan</th>
                                            <th style="width: 120px;"><i class="fas fa-calendar-week me-1"></i>Periode
                                                Data</th>
                                            <th style="width: 80px;"><i class="fas fa-box me-1"></i>Total Produk</th>
                                            <th style="width: 100px;"><i class="fas fa-chart-bar me-1"></i>Total Demand
                                            </th>
                                            <th style="width: 100px;"><i class="fas fa-calculator me-1"></i>Avg EOQ</th>
                                            <th style="width: 120px;"><i class="fas fa-money-bill-wave me-1"></i>Total
                                                Cost</th>
                                            <th style="width: 80px;"><i class="fas fa-user me-1"></i>User</th>
                                            <th style="width: 120px;"><i class="fas fa-cogs me-1"></i>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="riwayat-tbody">
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <div class="loading-spinner">
                                                    <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                                    <p class="mt-2 text-muted">Memuat data riwayat...</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="pagination-info">
                                    <small class="text-muted">
                                        Menampilkan <span id="showing-from">0</span> - <span id="showing-to">0</span>
                                        dari <span id="total-records">0</span> data
                                    </small>
                                </div>
                                <nav aria-label="Riwayat pagination">
                                    <ul class="pagination pagination-sm mb-0" id="riwayat-pagination">
                                        <!-- Pagination akan diisi oleh JavaScript -->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Detail Riwayat -->
                    <div class="modal fade" id="modalDetailRiwayat" tabindex="-1" role="dialog"
                        aria-labelledby="modalDetailRiwayatLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="modalDetailRiwayatLabel">
                                        <i class="fas fa-info-circle me-2"></i>Detail Riwayat Perhitungan EOQ
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="modal-detail-content">
                                    <!-- Content akan diisi oleh JavaScript -->
                                    <div class="text-center py-4">
                                        <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                        <p class="mt-2 text-muted">Memuat detail...</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fas fa-times me-1"></i> Tutup
                                    </button>
                                    <button type="button" class="btn btn-primary" id="print-detail">
                                        <i class="fas fa-print me-1"></i> Cetak Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Konfirmasi Hapus -->
                    <div class="modal fade" id="modalHapusRiwayat" tabindex="-1" role="dialog"
                        aria-labelledby="modalHapusRiwayatLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="modalHapusRiwayatLabel">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center mb-3">
                                        <i class="fas fa-question-circle fa-3x text-warning"></i>
                                    </div>
                                    <p class="text-center">Apakah Anda yakin ingin menghapus riwayat perhitungan ini?
                                    </p>
                                    <p class="text-center text-muted small">Data yang sudah dihapus tidak dapat
                                        dikembalikan.</p>
                                    <div id="hapus-detail-info" class="alert alert-info">
                                        <!-- Info riwayat yang akan dihapus -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fas fa-times me-1"></i> Batal
                                    </button>
                                    <button type="button" class="btn btn-danger" id="konfirmasi-hapus">
                                        <i class="fas fa-trash me-1"></i> Ya, Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>
                            <img src="../../logo.svg" alt="Logo" style="width: 30px; height: auto;">
                            Copyright &copy; <strong>PT Wings Group cabang Muara Bungo</strong> 2025 - Sistem EOQ v1.0
                        </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fas fa-sign-out-alt me-2"></i> Konfirmasi Logout
                    </h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-question-circle fa-3x text-warning"></i>
                    </div>
                    <p class="text-center">Apakah Anda yakin ingin keluar dari sistem?</p>
                    <p class="text-center text-muted small">Pastikan semua pekerjaan sudah tersimpan sebelum logout.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <a class="btn btn-danger" href="../auth/endSession.php">
                        <i class="fas fa-sign-out-alt me-1"></i> Ya, Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Sweet Alert -->
    <script src="../../js/sweetalert2.all.min.js"></script>

    <!-- Script untuk fungsi EOQ -->
    <script>
    // Script untuk fungsi EOQ dengan Accordion Animation System
    // Global variables
    window.currentPage = 1;
    window.currentRiwayatId = null;
    window.allProductData = null;
    window.allEoqData = null;
    window.allFrequencyData = null;
    window.allSetupCostData = null;
    window.allTotalCostData = null;

    $(document).ready(function() {
        // Add custom easing functions
        $.easing.easeOutCubic = function(x, t, b, c, d) {
            return c * ((t = t / d - 1) * t * t + 1) + b;
        };

        $.easing.easeInCubic = function(x, t, b, c, d) {
            return c * (t /= d) * t * t + b;
        };

        $.easing.easeInOutCubic = function(x, t, b, c, d) {
            if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
            return c / 2 * ((t -= 2) * t * t + 2) + b;
        };

        // Add CSS untuk animasi effects
        $('<style>').text(`
        .highlight-detail {
            background: linear-gradient(135deg, #fff5f5 0%, #fef2f2 100%) !important;
            border-left: 4px solid var(--wings-red) !important;
            animation: highlightPulse 2s ease-in-out;
        }

        @keyframes highlightPulse {
            0%, 100% { 
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); 
            }
            50% { 
                box-shadow: 0 8px 25px rgba(220, 38, 38, 0.2); 
            }
        }

        .hover-effect {
            background: linear-gradient(135deg, var(--wings-gray-50) 0%, rgba(220, 38, 38, 0.01) 100%) !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(220, 38, 38, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .shimmer-effect {
            position: relative;
            overflow: hidden;
        }

        .shimmer-effect::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: rotate(45deg);
            animation: shimmer-slide 1s ease-in-out;
        }

        @keyframes shimmer-slide {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .animate-in-view {
            animation: subtleBounce 0.4s ease-out;
        }

        @keyframes subtleBounce {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        .in-viewport .detail-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .loading-detail {
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    `).appendTo('head');

        // Add loading animation to cards
        $('.card').each(function(index) {
            $(this).css('animation-delay', (index * 0.1) + 's');
        });

        // Enhanced button hover effects
        $('.btn').hover(
            function() {
                $(this).addClass('shadow-lg');
            },
            function() {
                $(this).removeClass('shadow-lg');
            }
        );

        // Load riwayat data on page load
        loadRiwayatData();

        // Set default filter dates (last 30 days)
        var today = new Date();
        var lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
        $('#filter-sampai').val(today.toISOString().split('T')[0]);
        $('#filter-dari').val(lastMonth.toISOString().split('T')[0]);

        // Form submission handler
        $('#dataForm').submit(function(event) {
            event.preventDefault();

            var dari = $('#dari').val();
            var sampai = $('#sampai').val();

            if (!dari || !sampai) {
                Swal.fire({
                    icon: "warning",
                    title: "Peringatan",
                    text: "Silakan isi tanggal dari dan sampai terlebih dahulu",
                    confirmButtonColor: "#dc2626"
                });
                return;
            }

            if (dari > sampai) {
                Swal.fire({
                    icon: "warning",
                    title: "Peringatan",
                    text: "Tanggal 'dari' tidak boleh lebih besar dari tanggal 'sampai'",
                    confirmButtonColor: "#dc2626"
                });
                return;
            }

            Swal.fire({
                title: 'Menghitung EOQ...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: 'GET',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    Swal.close();

                    if (response.success === false) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: response.error || "Terjadi kesalahan pada server",
                            confirmButtonColor: "#dc2626"
                        });
                        return;
                    }

                    $("#result").show();
                    updateEOQTables(response);

                    // Render MathJax setelah content dimuat
                    if (typeof MathJax !== 'undefined') {
                        MathJax.typesetPromise();
                    }

                    window.allProductData = response.data;
                    window.allEoqData = response.data_eoq_all;
                    window.allFrequencyData = response.data_frequency_all;
                    window.allSetupCostData = response.data_setup_cost_all;
                    window.allTotalCostData = response.data_total_cost_all;

                    // ======= SIMPAN RIWAYAT EOQ =======
                    // Simpan hasil perhitungan ke riwayat (pindahkan ke dalam success handler)
                    var dateRange = {
                        dari: dari,
                        sampai: sampai
                    };

                    // Panggil function untuk menyimpan riwayat
                    saveEOQHistory(response, dateRange);

                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Perhitungan EOQ berhasil diproses dan disimpan ke riwayat",
                        timer: 2000,
                        showConfirmButton: false,
                        confirmButtonColor: "#dc2626"
                    });

                    $('html, body').animate({
                        scrollTop: $("#result").offset().top - 100
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    Swal.close();
                    console.error('AJAX Error:', xhr.responseText);

                    let errorMessage = "Sepertinya terjadi kesalahan. Silakan coba lagi.";

                    try {
                        let response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            errorMessage = response.error;
                        }
                    } catch (e) {
                        console.error('JSON Parse Error:', e);
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: errorMessage,
                        confirmButtonColor: "#dc2626"
                    });
                }
            });
        });

        // Console log untuk debugging
        console.log('EOQ System with Accordion Animation initialized successfully!');
    });

    // Event handlers untuk riwayat
    $(document).on('click', '#refresh-riwayat', function() {
        loadRiwayatData();
    });

    $(document).on('click', '#filter-riwayat', function() {
        window.currentPage = 1;
        loadRiwayatData();
    });

    $(document).on('click', '#reset-filter', function() {
        $('#filter-dari').val('');
        $('#filter-sampai').val('');
        $('#filter-limit').val('10');
        window.currentPage = 1;
        loadRiwayatData();
    });

    $(document).on('click', '.btn-detail-riwayat', function() {
        var riwayatId = $(this).data('id');
        showDetailRiwayat(riwayatId);
    });

    $(document).on('click', '.btn-hapus-riwayat', function() {
        var riwayatId = $(this).data('id');
        var tanggal = $(this).data('tanggal');
        var periode = $(this).data('periode');
        showHapusRiwayat(riwayatId, tanggal, periode);
    });

    $(document).on('click', '#konfirmasi-hapus', function() {
        hapusRiwayat(window.currentRiwayatId);
    });

    $(document).on('click', '#print-detail', function() {
        printDetailRiwayat();
    });

    // Update EOQ Tables
    function updateEOQTables(response) {
        var data = response.data;
        var data_eoq_all = response.data_eoq_all;
        var data_frequency_all = response.data_frequency_all;
        var data_total_cost_all = response.data_total_cost_all;
        var data_setup_cost_all = response.data_setup_cost_all;

        window.allProductData = data;
        window.allEoqData = data_eoq_all;
        window.allFrequencyData = data_frequency_all;
        window.allTotalCostData = data_total_cost_all;
        window.allSetupCostData = data_setup_cost_all;

        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });

        var allEoqTable = buildAllEoqTable(data, data_eoq_all, data_frequency_all, data_total_cost_all,
            data_setup_cost_all, formatter);
        $('#data-eoq-all').html(allEoqTable);
    }

    // Build EOQ Table with Accordion
    function buildAllEoqTable(data, data_eoq_all, data_frequency_all, data_total_cost_all, data_setup_cost_all,
        formatter) {
        var html = '';
        $.each(data, function(index, item) {
            var demand = Math.max(1, parseInt(item.stock_out) || 1);
            var setupCost = parseFloat(data_setup_cost_all[index]) || (item.harga * 0.12);
            var holdingCost = Math.max(1000, parseInt(item.biaya_penyimpanan) || 1000);
            var eoqValue = Math.max(1, parseInt(data_eoq_all[index]) || 1);
            var frequency = Math.max(1, parseInt(data_frequency_all[index]) || 1);
            var totalCostEOQ = parseFloat(data_total_cost_all[index]) || 0;
            var intervalDays = Math.round(365 / frequency);

            var productName = item.nama_produk;

            // BARIS DATA UTAMA
            html += `<tr class="main-row" data-index="${index}">
            <td class="text-center" style="width: 30px;"><strong>${index + 1}</strong></td>
            <td class="text-left" style="width: 250px;">
                <span class="font-weight-bold" title="${item.nama_produk}">
                    ${productName}
                </span>
            </td>
            <td class="text-center" style="width: 100px;">
                <span class="demand-value">
                    ${demand.toLocaleString('id-ID')}
                </span>
            </td>
            <td class="text-center" style="width: 120px;">
                <span class="cost-value setup-cost">
                    ${formatter.format(setupCost)}
                    <small>(12%)</small>
                </span>
            </td>
            <td class="text-center" style="width: 120px;">
                <span class="cost-value">
                    ${formatter.format(holdingCost)}
                </span>
            </td>
            <td class="text-center" style="width: 120px;">
                <span class="eoq-value-primary">
                    ${eoqValue.toLocaleString('id-ID')}
                </span>
            </td>
            <td class="text-center" style="width: 80px;">
                <button type="button" class="btn btn-sm btn-outline-primary toggle-detail" data-index="${index}" 
                        aria-expanded="false" aria-controls="detail-${index}" title="Lihat detail analisis EOQ">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </td>
        </tr>`;

            // BARIS DETAIL (TERSEMBUNYI)
            html += `<tr class="detail-row" id="detail-${index}" style="display: none;" role="region" 
             aria-labelledby="detail-header-${index}">
            <td colspan="7" class="detail-content">
                <div class="product-detail-container">
                    <div class="detail-header" id="detail-header-${index}">
                        <h5><i class="fas fa-info-circle me-2"></i>Detail Analisis EOQ - ${item.nama_produk}</h5>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <h6><i class="fas fa-box me-2"></i>Informasi Produk</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><strong>Nama Produk:</strong></td>
                                        <td>${item.nama_produk}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Supplier:</strong></td>
                                        <td>${item.nama_sup}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Harga Produk:</strong></td>
                                        <td>${formatter.format(item.harga)}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <h6><i class="fas fa-calculator me-2"></i>Parameter EOQ</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><strong>Demand (D):</strong></td>
                                        <td>${demand.toLocaleString('id-ID')} unit</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Biaya Pesan (S):</strong></td>
                                        <td>${formatter.format(setupCost)}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Biaya Simpan (H):</strong></td>
                                        <td>${formatter.format(holdingCost)}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="detail-card result-card">
                                <h6><i class="fas fa-chart-line me-2"></i>Hasil Perhitungan</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><strong>EOQ Optimal:</strong></td>
                                        <td class="text-primary font-weight-bold">${eoqValue.toLocaleString('id-ID')} unit</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Frekuensi/Tahun:</strong></td>
                                        <td>${frequency} kali per tahun</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Interval (Hari):</strong></td>
                                        <td>${intervalDays} hari</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card financial-card">
                                <h6><i class="fas fa-money-bill-wave me-2"></i>Analisis Biaya</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><strong>Total Cost EOQ:</strong></td>
                                        <td class="text-success font-weight-bold">${formatter.format(Math.round(totalCostEOQ))}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nilai Penjualan:</strong></td>
                                        <td>${formatter.format(item.pendapatan)}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="detail-card formula-card">
                                <h6><i class="fas fa-square-root-alt me-2"></i>Formula Perhitungan</h6>
                                <div class="formula-display-detail">
                                    EOQ = √((2 × D × S) / H)
                                </div>
                                <div class="calculation-example">
                                    <small class="text-muted">
                                        <strong>Perhitungan untuk produk ini:</strong><br>
                                        EOQ = √((2 × ${demand.toLocaleString('id-ID')} × ${formatter.format(setupCost)}) / ${formatter.format(holdingCost)})<br>
                                        EOQ = <strong>${eoqValue.toLocaleString('id-ID')} unit</strong>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-actions mt-3 text-center">
                        <button type="button" class="btn btn-secondary btn-sm toggle-detail" data-index="${index}"
                                title="Tutup detail">
                            <i class="fas fa-chevron-up me-1"></i> Tutup Detail
                        </button>
                    </div>
                </div>
            </td>
        </tr>`;
        });
        return html;
    }

    // Event handler untuk toggle detail dengan animasi enhanced
    $(document).on('click', '.toggle-detail', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var index = $(this).data('index');
        var detailRow = $('#detail-' + index);
        var mainRow = $(this).closest('.main-row');
        var icon = $(this).find('i');
        var button = $(this);

        // Disable button sementara untuk mencegah multiple clicks
        button.prop('disabled', true);

        // Add ripple effect
        addRippleEffect(button, e);

        if (detailRow.is(':visible')) {
            // Tutup detail dengan animasi
            closeDetailWithAnimation(detailRow, mainRow, icon, button);
        } else {
            // Tutup semua detail lain terlebih dahulu
            closeAllDetails().then(() => {
                // Buka detail yang diklik dengan animasi
                openDetailWithAnimation(detailRow, mainRow, icon, button, index);
            });
        }
    });

    // Function untuk menutup detail dengan animasi
    function closeDetailWithAnimation(detailRow, mainRow, icon, button) {
        // Add closing animation class
        detailRow.addClass('animating-up');

        // Animate icon rotation
        icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        button.removeClass('rotating').attr('aria-expanded', 'false');

        // Remove active state from main row
        mainRow.removeClass('active');

        // Hide with animation
        detailRow.slideUp(400, 'easeInOutCubic', function() {
            detailRow.removeClass('animating-up active');
            button.prop('disabled', false);
        });
    }

    // Function untuk membuka detail dengan animasi
    function openDetailWithAnimation(detailRow, mainRow, icon, button, index) {
        // Add active state to main row
        mainRow.addClass('active');

        // Animate icon rotation
        icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        button.addClass('rotating').attr('aria-expanded', 'true');

        // Add opening animation class
        detailRow.addClass('animating-down active');

        // Show with animation
        detailRow.slideDown(500, 'easeOutCubic', function() {
            detailRow.removeClass('animating-down');
            button.prop('disabled', false);

            // Trigger staggered animation for detail cards
            animateDetailCards(detailRow);

            // Scroll to detail dengan smooth animation
            setTimeout(() => {
                scrollToDetail(detailRow);
            }, 100);
        });
    }

    // Function untuk menutup semua detail
    function closeAllDetails() {
        return new Promise((resolve) => {
            var openDetails = $('.detail-row:visible');

            if (openDetails.length === 0) {
                resolve();
                return;
            }

            var closePromises = [];

            openDetails.each(function() {
                var detailRow = $(this);
                var mainRow = detailRow.prev('.main-row');
                var toggleButton = mainRow.find('.toggle-detail');
                var icon = toggleButton.find('i');

                var promise = new Promise((resolveClose) => {
                    // Remove active states
                    mainRow.removeClass('active');
                    detailRow.removeClass('active');
                    icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
                    toggleButton.removeClass('rotating').attr('aria-expanded', 'false');

                    // Animate close
                    detailRow.addClass('animating-up');
                    detailRow.slideUp(300, 'easeInCubic', function() {
                        detailRow.removeClass('animating-up');
                        resolveClose();
                    });
                });

                closePromises.push(promise);
            });

            Promise.all(closePromises).then(() => {
                resolve();
            });
        });
    }

    // Function untuk animasi detail cards dengan staggered effect
    function animateDetailCards(detailRow) {
        var cards = detailRow.find('.detail-card');

        cards.each(function(index) {
            var card = $(this);

            // Reset animation
            card.css({
                'opacity': '0',
                'transform': 'translateY(20px) scale(0.98)'
            });

            // Animate with delay
            setTimeout(() => {
                card.css({
                    'transition': 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)',
                    'opacity': '1',
                    'transform': 'translateY(0) scale(1)'
                });
            }, index * 100 + 200);
        });

        // Animate formula display
        var formulaDisplay = detailRow.find('.formula-display-detail');
        if (formulaDisplay.length) {
            setTimeout(() => {
                formulaDisplay.addClass('shimmer-effect');
                setTimeout(() => {
                    formulaDisplay.removeClass('shimmer-effect');
                }, 1000);
            }, 800);
        }
    }

    // Function untuk smooth scroll ke detail
    function scrollToDetail(detailRow) {
        var targetOffset = detailRow.offset().top - 120;

        $('html, body').animate({
            scrollTop: targetOffset
        }, {
            duration: 600,
            easing: 'easeOutCubic',
            complete: function() {
                // Add subtle highlight effect
                detailRow.addClass('highlight-detail');
                setTimeout(() => {
                    detailRow.removeClass('highlight-detail');
                }, 2000);
            }
        });
    }

    // Function untuk ripple effect
    function addRippleEffect(button, event) {
        var ripple = $('<span class="ripple"></span>');

        var size = Math.max(button.outerWidth(), button.outerHeight());
        var x = event.pageX - button.offset().left - size / 2;
        var y = event.pageY - button.offset().top - size / 2;

        ripple.css({
            width: size,
            height: size,
            left: x,
            top: y
        });

        button.append(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    // Add hover effects untuk main rows
    $(document).on('mouseenter', '.main-row', function() {
        if (!$(this).hasClass('active')) {
            $(this).addClass('hover-effect');
        }
    });

    $(document).on('mouseleave', '.main-row', function() {
        $(this).removeClass('hover-effect');
    });

    // Add keyboard navigation
    $(document).on('keydown', '.toggle-detail', function(e) {
        if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
            e.preventDefault();
            $(this).trigger('click');
        }
    });

    // Performance optimization: Debounce scroll events
    let scrollTimeout;
    $(window).on('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            // Update visible detail animations
            $('.detail-row:visible').each(function() {
                var detailRow = $(this);
                var rect = this.getBoundingClientRect();
                var isVisible = rect.top < window.innerHeight && rect.bottom > 0;

                if (isVisible && !detailRow.hasClass('in-viewport')) {
                    detailRow.addClass('in-viewport');
                    // Trigger subtle animations for cards dalam viewport
                    detailRow.find('.detail-card').each(function(index) {
                        var card = $(this);
                        setTimeout(() => {
                            card.addClass('animate-in-view');
                        }, index * 50);
                    });
                }
            });
        }, 100);
    });

    // Print button handler
    $('#btnPrint').click(function() {
        if (!window.allProductData || !window.allEoqData || !window.allFrequencyData) {
            Swal.fire({
                icon: "warning",
                title: "Peringatan",
                text: "Silakan hitung EOQ terlebih dahulu sebelum mencetak laporan",
                confirmButtonColor: "#dc2626"
            });
            return;
        }

        var combinedData = dataToSave(window.allProductData, window.allEoqData, window.allFrequencyData, window
            .allSetupCostData);
        var jsonString = JSON.stringify(combinedData);
        var encodedData = encodeURIComponent(jsonString);

        var dari = $('#dari').val();
        var sampai = $('#sampai').val();

        Swal.fire({
            icon: "success",
            title: "Laporan Sedang Disiapkan",
            text: "Laporan EOQ akan dibuka di tab baru",
            timer: 2000,
            showConfirmButton: false
        });

        window.open('../reports/export-eoq-pdf.php?data=' + encodedData + '&dari=' + dari + '&sampai=' +
            sampai);
    });

    // Data save function
    function dataToSave(allProductData, allEoqData, allFrequencyData, allSetupCostData) {
        var dataToSave = [];
        $.each(allProductData, function(index, d) {
            var intervalDays = Math.round(365 / (allFrequencyData[index] || 12));
            var setupCost = allSetupCostData ? allSetupCostData[index] : (d.harga * 0.12);

            // PERBAIKAN SUPPLIER: Pastikan supplier name valid dan tidak kosong
            var supplierName = 'Unknown Supplier'; // Default

            // Debug log data asli
            console.log(`Product ${index} (${d.nama_produk}) original data:`, {
                nama_sup: d.nama_sup,
                supplier_id: d.supplier_id,
                typeof_nama_sup: typeof d.nama_sup
            });

            // Cek nama_sup terlebih dahulu
            if (d.nama_sup && typeof d.nama_sup === 'string') {
                var cleanSupplier = d.nama_sup.trim();

                // Pastikan bukan angka, kosong, atau '0'
                if (cleanSupplier !== '' && cleanSupplier !== '0' && cleanSupplier !== 'null' && !(/^\d+$/.test(
                        cleanSupplier))) {
                    supplierName = cleanSupplier;
                    console.log(`Product ${index}: Using nama_sup = "${supplierName}"`);
                } else {
                    console.log(`Product ${index}: nama_sup invalid ("${cleanSupplier}"), using default`);
                }
            } else {
                console.log(`Product ${index}: nama_sup not found or not string, using default`);
            }

            // Final log
            console.log(`Product ${index}: Final supplier = "${supplierName}"`);

            dataToSave.push({
                'nama_produk': d.nama_produk,
                'demand_tahunan': d.stock_out,
                'biaya_pemesanan': setupCost,
                'biaya_penyimpanan': d.biaya_penyimpanan,
                'eoq_optimal': allEoqData[index],
                'frekuensi_pesan': allFrequencyData[index],
                'interval_hari': intervalDays,
                'supplier': supplierName, // ← PERBAIKAN: Gunakan supplierName yang sudah divalidasi
                'nama_sup': d.nama_sup, // ← TAMBAHAN: Kirim juga nama_sup asli untuk backup
                'nilai_penjualan': d.pendapatan,
                'harga_produk': d.harga
            });
        });

        // Debug log final data
        console.log('Final dataToSave:', dataToSave);

        return dataToSave;
    }



    // Function untuk load data riwayat
    function loadRiwayatData(page = 1) {
        window.currentPage = page;

        var filterDari = $('#filter-dari').val();
        var filterSampai = $('#filter-sampai').val();
        var limit = $('#filter-limit').val();

        // Show loading
        $('#riwayat-tbody').html(`
        <tr>
            <td colspan="9" class="text-center py-4">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                    <p class="mt-2 text-muted">Memuat data riwayat...</p>
                </div>
            </td>
        </tr>
    `);

        $.ajax({
            type: 'GET',
            url: 'get_riwayat.php',
            data: {
                page: page,
                limit: limit,
                filter_dari: filterDari,
                filter_sampai: filterSampai
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    displayRiwayatData(response.data);
                    updatePagination(response.pagination);
                    updateRiwayatInfo(response.pagination);
                } else {
                    showErrorRiwayat(response.message || 'Gagal memuat data riwayat');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading riwayat:', error);
                showErrorRiwayat('Terjadi kesalahan saat memuat data riwayat');
            }
        });
    }

    // Function untuk menampilkan data riwayat
    function displayRiwayatData(data) {
        var html = '';
        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });

        if (data.length === 0) {
            html = `
            <tr>
                <td colspan="9" class="text-center py-4">
                    <div class="no-data">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada riwayat perhitungan EOQ</p>
                        <small class="text-muted">Lakukan perhitungan EOQ untuk melihat riwayat</small>
                    </div>
                </td>
            </tr>
        `;
        } else {
            $.each(data, function(index, item) {
                var rowNumber = ((window.currentPage - 1) * parseInt($('#filter-limit').val())) + index + 1;
                var tanggalPerhitungan = new Date(item.tanggal_perhitungan).toLocaleString('id-ID', {
                    year: 'numeric',
                    month: 'short',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                var periode =
                    `${new Date(item.tanggal_dari).toLocaleDateString('id-ID')} - ${new Date(item.tanggal_sampai).toLocaleDateString('id-ID')}`;

                html += `
                <tr class="riwayat-row" data-id="${item.id}">
                    <td class="text-center"><strong>${rowNumber}</strong></td>
                    <td>
                        <div class="tanggal-info">
                            <strong>${tanggalPerhitungan}</strong>
                            <br><small class="text-muted">${getTimeAgo(item.tanggal_perhitungan)}</small>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-info periode-badge">${periode}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-primary">${item.total_produk}</span>
                    </td>
                    <td class="text-center">
                        <span class="demand-badge">${parseInt(item.total_demand).toLocaleString('id-ID')}</span>
                    </td>
                    <td class="text-center">
                        <span class="eoq-badge">${parseFloat(item.avg_eoq).toLocaleString('id-ID')}</span>
                    </td>
                    <td class="text-center">
                        <span class="cost-badge">${formatter.format(item.total_cost_eoq)}</span>
                    </td>
                    <td class="text-center">
                        <span class="user-badge">${item.username || 'System'}</span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-info btn-detail-riwayat" 
                                    data-id="${item.id}" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-riwayat" 
                                    data-id="${item.id}" 
                                    data-tanggal="${tanggalPerhitungan}"
                                    data-periode="${periode}"
                                    title="Hapus Riwayat">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            });
        }

        $('#riwayat-tbody').html(html);
    }

    // Function untuk menampilkan error
    function showErrorRiwayat(message) {
        $('#riwayat-tbody').html(`
        <tr>
            <td colspan="9" class="text-center py-4">
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
                    <p class="text-warning">${message}</p>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="loadRiwayatData()">
                        <i class="fas fa-redo me-1"></i> Coba Lagi
                    </button>
                </div>
            </td>
        </tr>
    `);
    }

    // Function untuk update pagination
    function updatePagination(pagination) {
        var html = '';

        if (pagination.total_pages > 1) {
            // Previous button
            if (pagination.current_page > 1) {
                html += `
                <li class="page-item">
                    <a class="page-link" href="#" onclick="loadRiwayatData(${pagination.current_page - 1})">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            `;
            }

            // Page numbers
            var startPage = Math.max(1, pagination.current_page - 2);
            var endPage = Math.min(pagination.total_pages, pagination.current_page + 2);

            for (var i = startPage; i <= endPage; i++) {
                var activeClass = (i === pagination.current_page) ? 'active' : '';
                html += `
                <li class="page-item ${activeClass}">
                    <a class="page-link" href="#" onclick="loadRiwayatData(${i})">${i}</a>
                </li>
            `;
            }

            // Next button
            if (pagination.current_page < pagination.total_pages) {
                html += `
                <li class="page-item">
                    <a class="page-link" href="#" onclick="loadRiwayatData(${pagination.current_page + 1})">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            `;
            }
        }

        $('#riwayat-pagination').html(html);
    }

    // Function untuk update info riwayat
    function updateRiwayatInfo(pagination) {
        $('#total-riwayat').text(pagination.total_records);
        $('#showing-from').text(pagination.from);
        $('#showing-to').text(pagination.to);
        $('#total-records').text(pagination.total_records);
    }

    // Function untuk menampilkan detail riwayat
    // function showDetailRiwayat(riwayatId) {
    //     $('#modalDetailRiwayat').modal('show');

    //     // Reset content
    //     $('#modal-detail-content').html(`
    //     <div class="text-center py-4">
    //         <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
    //         <p class="mt-2 text-muted">Memuat detail...</p>
    //     </div>
    // `);

    //     $.ajax({
    //         type: 'GET',
    //         url: 'get_detail_riwayat.php',
    //         data: {
    //             id: riwayatId
    //         },
    //         dataType: 'json',
    //         success: function(response) {
    //             if (response.success) {
    //                 displayDetailRiwayat(response.data);
    //             } else {
    //                 $('#modal-detail-content').html(`
    //                 <div class="alert alert-danger">
    //                     <i class="fas fa-exclamation-triangle me-2"></i>
    //                     ${response.message || 'Gagal memuat detail riwayat'}
    //                 </div>
    //             `);
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             $('#modal-detail-content').html(`
    //             <div class="alert alert-danger">
    //                 <i class="fas fa-exclamation-triangle me-2"></i>
    //                 Terjadi kesalahan saat memuat detail riwayat
    //             </div>
    //         `);
    //         }
    //     });
    // }

    // versi testing detail riwayat  
    function showDetailRiwayat(riwayatId) {
        console.log('showDetailRiwayat called with ID:', riwayatId);

        $('#modalDetailRiwayat').modal('show');

        // Reset content
        $('#modal-detail-content').html(`
        <div class="text-center py-4">
            <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
            <p class="mt-2 text-muted">Memuat detail...</p>
        </div>
    `);

        $.ajax({
            type: 'GET',
            url: 'get_detail_riwayat.php',
            data: {
                id: riwayatId
            },
            dataType: 'json',
            beforeSend: function() {
                console.log('Sending request to get_detail_riwayat.php with ID:', riwayatId);
            },
            success: function(response) {
                console.log('Response received:', response);

                if (response.success) {
                    displayDetailRiwayat(response.data);
                } else {
                    console.error('API returned error:', response.message);
                    $('#modal-detail-content').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Error:</strong> ${response.message || 'Gagal memuat detail riwayat'}<br>
                        <small>Debug Info: ${JSON.stringify(response.debug_info || {})}</small>
                    </div>
                `);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error Details:');
                console.error('Status:', status);
                console.error('Error:', error);
                console.error('Response Text:', xhr.responseText);
                console.error('Status Code:', xhr.status);

                let errorMessage = 'Terjadi kesalahan saat memuat detail riwayat';
                let debugInfo = '';

                try {
                    let response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                    if (response.debug_info) {
                        debugInfo = JSON.stringify(response.debug_info, null, 2);
                    }
                } catch (e) {
                    console.error('Failed to parse error response:', e);
                    debugInfo = `Raw response: ${xhr.responseText}`;
                }

                $('#modal-detail-content').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>AJAX Error:</strong> ${errorMessage}<br>
                    <strong>Status:</strong> ${xhr.status} ${status}<br>
                    <strong>Error:</strong> ${error}<br>
                    <details class="mt-2">
                        <summary>Debug Information</summary>
                        <pre style="font-size: 11px; max-height: 200px; overflow-y: auto;">${debugInfo}</pre>
                    </details>
                </div>
            `);
            }
        });
    }


    // Function untuk menampilkan detail dalam modal
    function displayDetailRiwayat(data) {
        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });

        var tanggalPerhitungan = new Date(data.header.tanggal_perhitungan).toLocaleString('id-ID');
        var periode =
            `${new Date(data.header.tanggal_dari).toLocaleDateString('id-ID')} - ${new Date(data.header.tanggal_sampai).toLocaleDateString('id-ID')}`;

        var html = `
        <!-- Header Info -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="info-card">
                    <h6><i class="fas fa-info-circle me-2"></i>Informasi Perhitungan</h6>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td><strong>Tanggal Perhitungan:</strong></td>
                            <td>${tanggalPerhitungan}</td>
                        </tr>
                        <tr>
                            <td><strong>Periode Data:</strong></td>
                            <td>${periode}</td>
                        </tr>
                        <tr>
                            <td><strong>User:</strong></td>
                            <td>${data.header.username || 'System'}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td><span class="badge badge-success">${data.header.status}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-card">
                    <h6><i class="fas fa-chart-bar me-2"></i>Statistik Hasil</h6>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td><strong>Total Produk:</strong></td>
                            <td>${data.header.total_produk}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Demand:</strong></td>
                            <td>${parseInt(data.header.total_demand).toLocaleString('id-ID')}</td>
                        </tr>
                        <tr>
                            <td><strong>Rata-rata EOQ:</strong></td>
                            <td>${parseFloat(data.header.avg_eoq).toLocaleString('id-ID')}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Cost:</strong></td>
                            <td>${formatter.format(data.header.total_cost_eoq)}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Detail Products -->
        <div class="detail-products">
            <h6><i class="fas fa-list me-2"></i>Detail Per Produk</h6>
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Demand</th>
                            <th>EOQ Optimal</th>
                            <th>Frekuensi</th>
                            <th>Biaya Setup</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
    `;

        if (data.details && data.details.length > 0) {
            $.each(data.details, function(index, item) {
                // PERBAIKAN SUPPLIER: Pastikan supplier tidak menampilkan '0'
                var supplierDisplay = item.supplier;
                if (!supplierDisplay || supplierDisplay === '0' || supplierDisplay === '' || supplierDisplay ===
                    'null') {
                    supplierDisplay = 'Unknown Supplier';
                }

                html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.nama_produk}</td>
                            <td class="text-center">${parseInt(item.demand_tahunan).toLocaleString('id-ID')}</td>
                            <td class="text-center"><strong>${parseInt(item.eoq_optimal).toLocaleString('id-ID')}</strong></td>
                            <td class="text-center">${item.frekuensi_pesan}x/tahun</td>
                            <td class="text-center">${formatter.format(item.biaya_pemesanan)}</td>
                            <td class="text-center">${formatter.format(item.total_cost_eoq)}</td>
                        </tr>
            `;
            });
        } else {
            html += `
                        <tr>
                            <td colspan="8" class="text-center py-3">
                                <em class="text-muted">Tidak ada detail produk</em>
                            </td>
                        </tr>
        `;
        }

        html += `
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Keterangan -->
        ${data.header.keterangan ? `
        <div class="mt-4">
            <h6><i class="fas fa-sticky-note me-2"></i>Keterangan</h6>
            <div class="alert alert-info">
                ${data.header.keterangan}
            </div>
        </div>
        ` : ''}
    `;

        $('#modal-detail-content').html(html);
        window.currentRiwayatId = data.header.id;
    }

    // Function untuk menampilkan modal hapus
    function showHapusRiwayat(riwayatId, tanggal, periode) {
        window.currentRiwayatId = riwayatId;

        $('#hapus-detail-info').html(`
        <strong>Tanggal Perhitungan:</strong> ${tanggal}<br>
        <strong>Periode Data:</strong> ${periode}
    `);

        $('#modalHapusRiwayat').modal('show');
    }

    // Function untuk hapus riwayat
    function hapusRiwayat(riwayatId) {
        console.log('Menghapus riwayat dengan ID:', riwayatId);

        // Disable button dan show loading
        $('#konfirmasi-hapus').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menghapus...');

        $.ajax({
            type: 'POST',
            url: 'hapus_riwayat.php',
            data: {
                id: riwayatId
            },
            dataType: 'json',
            beforeSend: function() {
                console.log('Mengirim request hapus riwayat...');
            },
            success: function(response) {
                console.log('Response hapus riwayat:', response);

                $('#modalHapusRiwayat').modal('hide');

                if (response && response.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Riwayat berhasil dihapus",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Reload riwayat data
                    setTimeout(() => {
                        loadRiwayatData(window.currentPage);
                    }, 500);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: response.message || "Gagal menghapus riwayat",
                        confirmButtonColor: "#dc2626"
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error menghapus riwayat:');
                console.error('Status:', status);
                console.error('Error:', error);
                console.error('Response Text:', xhr.responseText);

                $('#modalHapusRiwayat').modal('hide');

                let errorMessage = "Terjadi kesalahan saat menghapus riwayat";

                // Try to parse error response
                try {
                    let response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.error('Failed to parse error response:', e);
                }

                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: errorMessage,
                    confirmButtonColor: "#dc2626"
                });
            },
            complete: function() {
                // Reset button state
                $('#konfirmasi-hapus').prop('disabled', false).html(
                    '<i class="fas fa-trash me-1"></i> Ya, Hapus');
            }
        });
    }


    // Function untuk print detail
    function printDetailRiwayat() {
        if (!window.currentRiwayatId) {
            Swal.fire({
                icon: "warning",
                title: "Peringatan",
                text: "Tidak ada data yang dipilih untuk dicetak"
            });
            return;
        }

        window.open(`print_detail_riwayat.php?id=${window.currentRiwayatId}`, '_blank');
    }

    // Function untuk menyimpan riwayat setelah perhitungan EOQ berhasil
    function saveEOQHistory(eoqData, dateRange) {
        // Validasi data input
        if (!eoqData || !eoqData.data || !dateRange) {
            console.warn('Data tidak lengkap untuk menyimpan riwayat');
            return;
        }

        // Validasi statistics
        if (!eoqData.statistics) {
            console.warn('Statistics data tidak tersedia');
            return;
        }

        console.log('Menyimpan riwayat EOQ...', {
            products: eoqData.data.length,
            dateRange: dateRange,
            sample_product: eoqData.data[0]
        });

        var historyData = {
            tanggal_dari: dateRange.dari,
            tanggal_sampai: dateRange.sampai,
            statistics: eoqData.statistics,
            products: []
        };

        // Prepare product data dengan validasi supplier yang diperbaiki
        try {
            $.each(eoqData.data, function(index, product) {
                // Validasi data produk
                if (!product || !product.nama_produk) {
                    console.warn('Product data invalid at index', index);
                    return true; // continue
                }

                var setupCost = 0;
                var eoqValue = 0;
                var frequency = 0;
                var totalCost = 0;

                // Safely get values with fallback
                if (eoqData.data_setup_cost_all && eoqData.data_setup_cost_all[index]) {
                    setupCost = parseFloat(eoqData.data_setup_cost_all[index]);
                } else {
                    setupCost = parseFloat(product.harga) * 0.12;
                }

                if (eoqData.data_eoq_all && eoqData.data_eoq_all[index]) {
                    eoqValue = parseInt(eoqData.data_eoq_all[index]);
                }

                if (eoqData.data_frequency_all && eoqData.data_frequency_all[index]) {
                    frequency = parseInt(eoqData.data_frequency_all[index]);
                }

                if (eoqData.data_total_cost_all && eoqData.data_total_cost_all[index]) {
                    totalCost = parseFloat(eoqData.data_total_cost_all[index]);
                }

                var intervalDays = frequency > 0 ? Math.round(365 / frequency) : 0;

                // PERBAIKAN SUPPLIER - Lebih permisif dalam menangani data supplier
                var supplierName = '';

                // Debug: Log semua kemungkinan field supplier
                console.log(`Product ${index} all supplier fields:`, {
                    nama_sup: product.nama_sup,
                    supplier: product.supplier,
                    sup_name: product.sup_name,
                    supplier_name: product.supplier_name,
                    kode_sup: product.kode_sup
                });

                // Prioritas 1: Cek field 'nama_sup'
                if (product.nama_sup && product.nama_sup !== null && product.nama_sup !== undefined) {
                    var cleanNamaSup = String(product.nama_sup).trim();
                    if (cleanNamaSup !== '' && cleanNamaSup !== '0' && cleanNamaSup !== 'null') {
                        supplierName = cleanNamaSup;
                    }
                }

                // Prioritas 2: Cek field 'supplier'
                if (!supplierName && product.supplier && product.supplier !== null && product.supplier !==
                    undefined) {
                    var cleanSupplier = String(product.supplier).trim();
                    if (cleanSupplier !== '' && cleanSupplier !== '0' && cleanSupplier !== 'null') {
                        supplierName = cleanSupplier;
                    }
                }

                // Prioritas 3: Cek field lain yang mungkin mengandung nama supplier
                if (!supplierName) {
                    var supplierFields = ['sup_name', 'supplier_name', 'nama_supplier'];
                    for (var i = 0; i < supplierFields.length; i++) {
                        var field = supplierFields[i];
                        if (product[field] && product[field] !== null && product[field] !== undefined) {
                            var cleanField = String(product[field]).trim();
                            if (cleanField !== '' && cleanField !== '0' && cleanField !== 'null') {
                                supplierName = cleanField;
                                break;
                            }
                        }
                    }
                }

                // Jika masih kosong, gunakan default berdasarkan produk atau supplier ID
                if (!supplierName) {
                    if (product.sup_id && product.sup_id !== '0') {
                        supplierName = `Supplier ID: ${product.sup_id}`;
                    } else {
                        supplierName = 'Unknown Supplier';
                    }
                }

                // Debug: Log hasil akhir supplier
                console.log(`Product ${index} final supplier:`, {
                    original_nama_sup: product.nama_sup,
                    final_supplier: supplierName,
                    sup_id: product.sup_id
                });

                var productData = {
                    nama_produk: product.nama_produk || 'Unknown Product',
                    demand_tahunan: parseInt(product.stock_out) || 0,
                    harga_produk: parseFloat(product.harga) || 0,
                    biaya_pemesanan: setupCost,
                    biaya_penyimpanan: parseFloat(product.biaya_penyimpanan) || 0,
                    eoq_optimal: eoqValue,
                    frekuensi_pesan: frequency,
                    interval_hari: intervalDays,
                    total_cost_eoq: totalCost,
                    supplier: supplierName, // Ini yang akan digunakan utama
                    nama_sup: product.nama_sup, // Backup untuk debugging
                    sup_id: product.sup_id, // ID supplier untuk query database
                    nilai_penjualan: parseFloat(product.pendapatan) || 0
                };

                historyData.products.push(productData);
            });

            console.log('History data prepared:', {
                productsCount: historyData.products.length,
                statistics: historyData.statistics,
                sampleProduct: historyData.products[0] || 'No products',
                allSuppliers: historyData.products.map(p => ({
                    nama_produk: p.nama_produk,
                    supplier: p.supplier,
                    sup_id: p.sup_id
                }))
            });

            // Kirim data ke server
            $.ajax({
                type: 'POST',
                url: 'save_riwayat.php',
                data: {
                    history_data: JSON.stringify(historyData)
                },
                dataType: 'json',
                timeout: 15000, // 15 second timeout
                beforeSend: function() {
                    console.log('Mengirim data riwayat ke server...');
                    console.log('Data being sent:', historyData);
                },
                success: function(response) {
                    console.log('Response save riwayat:', response);

                    if (response && response.success) {
                        console.log('Riwayat EOQ berhasil disimpan');

                        // Refresh riwayat data tanpa notifikasi
                        setTimeout(() => {
                            loadRiwayatData(1);
                        }, 1000);
                    } else {
                        console.error('Gagal menyimpan riwayat:', response.message);
                        // Show error to user if it's critical
                        if (response.debug_info) {
                            console.error('Debug info:', response.debug_info);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error saving history:');
                    console.error('Status:', status);
                    console.error('Error:', error);
                    console.error('Response Text:', xhr.responseText);

                    // Try to parse error response
                    try {
                        var errorResponse = JSON.parse(xhr.responseText);
                        console.error('Parsed error:', errorResponse);
                    } catch (e) {
                        console.error('Could not parse error response');
                    }
                }
            });

        } catch (e) {
            console.error('Error preparing history data:', e);
        }
    }


    // Helper function untuk menghitung waktu yang lalu
    function getTimeAgo(dateString) {
        var now = new Date();
        var date = new Date(dateString);
        var diffMs = now - date;
        var diffMins = Math.floor(diffMs / 60000);
        var diffHours = Math.floor(diffMs / 3600000);
        var diffDays = Math.floor(diffMs / 86400000);

        if (diffMins < 60) {
            return diffMins <= 1 ? 'Baru saja' : diffMins + ' menit yang lalu';
        } else if (diffHours < 24) {
            return diffHours + ' jam yang lalu';
        } else if (diffDays < 7) {
            return diffDays + ' hari yang lalu';
        } else {
            return date.toLocaleDateString('id-ID');
        }
    }

    // Initialize tooltips if Bootstrap is available
    if (typeof $().tooltip === 'function') {
        $('[title]').tooltip({
            placement: 'top',
            trigger: 'hover'
        });
    }
    </script>

</body>

</html>