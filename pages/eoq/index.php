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
                                            <p class="text-muted mb-2">Formula matematika untuk menghitung kuantitas
                                                pemesanan optimal yang meminimalkan total biaya inventory</p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="eoq-formula-card">
                                                        <h6><i class="fas fa-square-root-alt me-1"></i> Formula EOQ:
                                                        </h6>
                                                        <div class="formula-display">
                                                            EOQ = √((2 × D × S) / H)
                                                        </div>
                                                        <small class="text-muted">
                                                            <strong>D</strong> = Demand (permintaan tahunan)<br>
                                                            <strong>S</strong> = Setup/Order cost (biaya pemesanan)<br>
                                                            <strong>H</strong> = Holding cost (biaya penyimpanan per
                                                            unit)
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="eoq-benefits-card">
                                                        <h6><i class="fas fa-chart-line me-1"></i> Komponen Biaya:</h6>
                                                        <ul class="benefits-list">
                                                            <li><strong>Biaya Pemesanan (S):</strong> Rp 50.000 per
                                                                pesanan</li>
                                                            <li><strong>Biaya Penyimpanan (H):</strong> Sesuai data
                                                                produk</li>
                                                            <li><strong>Total Cost EOQ:</strong> √(2 × D × S × H)</li>
                                                            <li><strong>Frekuensi:</strong> D / EOQ kali per tahun</li>
                                                        </ul>
                                                    </div>
                                                </div>
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

                                    <div class="table-responsive mb-4">
                                        <table class="table table-hover eoq-primary-table" id="eoqAllTable">
                                            <thead>
                                                <tr>
                                                    <th width="50"><i class="fas fa-hashtag me-1"></i> No</th>
                                                    <th><i class="fas fa-box me-1"></i> Nama Produk</th>
                                                    <th><i class="fas fa-chart-bar me-1"></i> Demand (D)</th>
                                                    <th><i class="fas fa-truck me-1"></i> Biaya Pesan (S)</th>
                                                    <th><i class="fas fa-warehouse me-1"></i> Biaya Simpan (H)</th>
                                                    <th><i class="fas fa-calculator me-1"></i> EOQ Optimal</th>
                                                    <th><i class="fas fa-redo me-1"></i> Frekuensi/Tahun</th>
                                                    <th><i class="fas fa-money-bill-wave me-1"></i> Total Cost EOQ</th>
                                                    <th><i class="fas fa-calendar me-1"></i> Interval (Hari)</th>
                                                    <th><i class="fas fa-dollar-sign me-1"></i> Nilai Penjualan</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-eoq-all">
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- EOQ Summary Statistics -->
                                    <div class="eoq-summary-cards">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="summary-card cost-savings">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-chart-pie fa-2x mb-2"></i>
                                                        <h6>Total Produk</h6>
                                                        <span id="total-products">0 produk</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="summary-card avg-eoq">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-boxes fa-2x mb-2"></i>
                                                        <h6>Rata-rata EOQ</h6>
                                                        <span id="avg-eoq">0 unit</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="summary-card total-frequency">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-sync-alt fa-2x mb-2"></i>
                                                        <h6>Total Frekuensi</h6>
                                                        <span id="total-frequency">0 kali</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="summary-card working-capital">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-money-bill-wave fa-2x mb-2"></i>
                                                        <h6>Total Cost EOQ</h6>
                                                        <span id="total-cost-eoq">Rp 0</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- EOQ Implementation Guidelines -->
                                <div class="analysis-section mb-4 implementation-guide">
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
                                                        <span class="kpi-target">Rp 50.000 per pesanan</span>
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
                                </div>

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

    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Sweet Alert -->
    <script src="../../js/sweetalert2.all.min.js"></script>

    <!-- Script untuk fungsi EOQ -->
    <script>
    $(document).ready(function() {
        var allProductData;
        var allEoqData;
        var allFrequencyData;

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

        $('#dataForm').submit(function(event) {
            event.preventDefault(); // Menghentikan submit form default

            // Validasi input tanggal
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

            // Tampilkan loading
            Swal.fire({
                title: 'Menghitung EOQ...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Mengirimkan permintaan AJAX
            $.ajax({
                type: 'GET',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    Swal.close(); // Tutup loading

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

                    allProductData = response.data;
                    allEoqData = response.data_eoq_all;
                    allFrequencyData = response.data_frequency_all;

                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Perhitungan EOQ berhasil diproses",
                        timer: 2000,
                        showConfirmButton: false,
                        confirmButtonColor: "#dc2626"
                    });

                    // Smooth scroll to results
                    $('html, body').animate({
                        scrollTop: $("#result").offset().top - 100
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    Swal.close(); // Tutup loading

                    console.error('AJAX Error:', xhr.responseText);

                    let errorMessage = "Sepertinya terjadi kesalahan. Silakan coba lagi.";

                    // Coba parse response untuk mendapatkan error message yang lebih spesifik
                    try {
                        let response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            errorMessage = response.error;
                        }
                    } catch (e) {
                        // Jika tidak bisa parse JSON, gunakan pesan default
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

        function updateEOQTables(response) {
            var data = response.data;
            var data_eoq_all = response.data_eoq_all;
            var data_frequency_all = response.data_frequency_all;
            var data_total_cost_all = response.data_total_cost_all;

            //buat format rupiah
            var formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });

            var allEoqTable = buildAllEoqTable(data, data_eoq_all, data_frequency_all, data_total_cost_all,
                formatter);
            $('#data-eoq-all').html(allEoqTable);

            // Update summary statistics
            updateSummaryStats(data, data_eoq_all, data_frequency_all, data_total_cost_all, formatter);

            // Initialize DataTable
            if (!$.fn.DataTable.isDataTable('#eoqAllTable')) {
                $('#eoqAllTable').DataTable({
                    "pageLength": 25,
                    "lengthMenu": [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "Semua"]
                    ],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                    },
                    "order": [
                        [5, "desc"]
                    ], // Sort by EOQ column
                    "columnDefs": [{
                            "orderable": false,
                            "targets": 0
                        } // Disable sorting for No column
                    ]
                });
            }
        }

        function buildAllEoqTable(data, data_eoq_all, data_frequency_all, data_total_cost_all, formatter) {
            var html = '';
            $.each(data, function(index, item) {
                var demand = Math.max(1, parseInt(item.stock_out) || 1);
                var setupCost = 50000;
                var holdingCost = Math.max(1000, parseInt(item.biaya_penyimpanan) || 1000);
                var eoqValue = Math.max(1, parseInt(data_eoq_all[index]) || 1);
                var frequency = Math.max(1, parseInt(data_frequency_all[index]) || 1);
                var totalCostEOQ = parseFloat(data_total_cost_all[index]) || 0;

                // Calculate interval days
                var intervalDays = Math.round(365 / frequency);
                if (!isFinite(intervalDays) || intervalDays <= 0) {
                    intervalDays = Math.round(365 / 12); // Default to monthly
                }

                html += `<tr>
                    <td>${index + 1}</td>
                    <td><span class="font-weight-bold">${item.nama_produk}</span></td>
                    <td><span class="demand-value">${demand.toLocaleString('id-ID')} unit</span></td>
                    <td><span class="cost-value">Rp 50.000</span></td>
                    <td><span class="cost-value">${formatter.format(holdingCost)}</span></td>
                    <td><span class="eoq-value-primary">${eoqValue.toLocaleString('id-ID')} unit</span></td>
                    <td><span class="frequency-value">${frequency} kali</span></td>
                    <td><span class="total-cost-value">${formatter.format(Math.round(totalCostEOQ))}</span></td>
                    <td><span class="interval-value">${intervalDays} hari</span></td>
                    <td><span class="sales-value">${formatter.format(item.pendapatan)}</span></td>
                </tr>`;
            });
            return html;
        }

        function updateSummaryStats(data, data_eoq_all, data_frequency_all, data_total_cost_all, formatter) {
            var totalProducts = data.length;
            var totalEoq = 0;
            var totalFrequency = 0;
            var totalCostEoq = 0;

            $.each(data_eoq_all, function(index, eoqValue) {
                totalEoq += parseInt(eoqValue) || 0;
            });

            $.each(data_frequency_all, function(index, freqValue) {
                totalFrequency += parseInt(freqValue) || 0;
            });

            $.each(data_total_cost_all, function(index, costValue) {
                totalCostEoq += parseFloat(costValue) || 0;
            });

            var avgEoq = totalProducts > 0 ? Math.round(totalEoq / totalProducts) : 0;

            $('#total-products').text(totalProducts + ' produk');
            $('#avg-eoq').text(avgEoq.toLocaleString('id-ID') + ' unit');
            $('#total-frequency').text(totalFrequency + ' kali/tahun');
            $('#total-cost-eoq').text(formatter.format(totalCostEoq));
        }

        function dataToSave(allProductData, allEoqData, allFrequencyData) {
            var dataToSave = [];
            $.each(allProductData, function(index, d) {
                var intervalDays = Math.round(365 / (allFrequencyData[index] || 12));

                dataToSave.push({
                    'nama_produk': d.nama_produk,
                    'demand_tahunan': d.stock_out,
                    'biaya_pemesanan': 50000,
                    'biaya_penyimpanan': d.biaya_penyimpanan,
                    'eoq_optimal': allEoqData[index],
                    'frekuensi_pesan': allFrequencyData[index],
                    'interval_hari': intervalDays,
                    'supplier': d.nama_sup,
                    'nilai_penjualan': d.pendapatan
                });
            });
            return dataToSave;
        }

        $('#btnPrint').click(function() {
            if (!allProductData || !allEoqData || !allFrequencyData) {
                Swal.fire({
                    icon: "warning",
                    title: "Peringatan",
                    text: "Silakan hitung EOQ terlebih dahulu sebelum mencetak laporan",
                    confirmButtonColor: "#dc2626"
                });
                return;
            }

            var combinedData = dataToSave(allProductData, allEoqData, allFrequencyData);
            var jsonString = JSON.stringify(combinedData);
            var encodedData = encodeURIComponent(jsonString);

            // ubah format dari menjadi hari, bulan, dan tahun
            var dari = $('#dari').val();
            var sampai = $('#sampai').val();

            // Show success message
            Swal.fire({
                icon: "success",
                title: "Laporan Sedang Disiapkan",
                text: "Laporan EOQ akan dibuka di tab baru",
                timer: 2000,
                showConfirmButton: false
            });

            window.open('../reports/export-eoq-pdf.php?data=' + encodedData + '&dari=' + dari +
                '&sampai=' + sampai);
        });
    });
    </script>

</body>

</html>