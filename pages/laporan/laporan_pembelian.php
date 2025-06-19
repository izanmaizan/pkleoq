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
    <meta name="description" content="Laporan Pembelian - Sistem EOQ PT Wings Group Indonesia">
    <meta name="author" content="PT Wings Group Indonesia">

    <title>EOQ - Laporan Pembelian | PT Wings Group</title>

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

    <!-- Wings Theme CSS for Laporan -->
    <link rel="stylesheet" href="style-laporan.css">

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

            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#report" aria-expanded="true"
                    aria-controls="report">
                    <i class="fas fa-fw fa-chart-line"></i>
                    <span>Laporan</span>
                </a>
                <div id="report" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Jenis Laporan:</h6>
                        <a class="collapse-item" href="../laporan/laporan_produk.php">
                            <i class="fas fa-pills me-2"></i>Laporan Produk
                        </a>
                        <a class="collapse-item active" href="laporan_pembelian.php">
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

            <li class="nav-item">
                <a class="nav-link" href="../eoq/index.php">
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
                                    <i class="fas fa-shopping-cart fa-2x me-3"></i>
                                    Laporan Transaksi Pembelian
                                </h4>
                                <p class="mb-0 opacity-75">
                                    Laporan komprehensif transaksi pembelian PT Wings Group Indonesia
                                </p>
                            </div>
                            <div class="d-none d-lg-block">
                                <i class="fas fa-file-invoice fa-3x opacity-25"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold">
                                    <i class="fas fa-shopping-bag me-2"></i> Laporan Pembelian
                                </h6>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-light mr-2">
                                        <i class="fas fa-calendar me-1"></i> <?= date('d F Y'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <?php
                        include '../../config/koneksi.php';

                        if (isset($_GET['dari']) && isset($_GET['sampai'])) {
                            $dari = $_GET['dari'];
                            $sampai = $_GET['sampai'];

                            // QUERY DIPERBAIKI - menggunakan subquery untuk menghindari GROUP BY error
                            $query = mysqli_query(
                                $conn,
                                "SELECT 
                                    tp.id,
                                    tp.kode_transaksi, 
                                    tp.tanggal, 
                                    u.nama, 
                                    tp.keterangan 
                                FROM transaksi_pembelian AS tp 
                                INNER JOIN user AS u ON tp.user_id = u.id
                                WHERE tp.tanggal BETWEEN '$dari' AND '$sampai'
                                AND tp.id IN (
                                    SELECT MIN(id) 
                                    FROM transaksi_pembelian 
                                    WHERE tanggal BETWEEN '$dari' AND '$sampai'
                                    GROUP BY kode_transaksi
                                )
                                ORDER BY tp.tanggal DESC"
                            );
                        } else {
                            // QUERY DIPERBAIKI - menggunakan subquery untuk menghindari GROUP BY error
                            $query = mysqli_query(
                                $conn,
                                "SELECT 
                                    tp.id,
                                    tp.kode_transaksi, 
                                    tp.tanggal, 
                                    u.nama, 
                                    tp.keterangan 
                                FROM transaksi_pembelian AS tp 
                                INNER JOIN user AS u ON tp.user_id = u.id
                                WHERE tp.id IN (
                                    SELECT MIN(id) 
                                    FROM transaksi_pembelian 
                                    GROUP BY kode_transaksi
                                )
                                ORDER BY tp.tanggal DESC"
                            );
                        }
                        ?>

                        <div class="card-body">
                            <!-- Filter Form -->
                            <div class="filter-section mb-4 p-3 bg-light rounded">
                                <form action="" method="GET">
                                    <div class="row align-items-end">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dari" class="font-weight-bold">
                                                    <i class="fas fa-calendar-alt me-1"></i> Tanggal Dari
                                                </label>
                                                <input type="date" class="form-control" id="dari" name="dari"
                                                    value="<?= isset($_GET['dari']) ? $_GET['dari'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="sampai" class="font-weight-bold">
                                                    <i class="fas fa-calendar-alt me-1"></i> Tanggal Sampai
                                                </label>
                                                <input type="date" class="form-control" id="sampai" name="sampai"
                                                    value="<?= isset($_GET['sampai']) ? $_GET['sampai'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="filter-buttons d-flex gap-2 flex-wrap">
                                                    <button type="submit" class="btn btn-primary btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-search"></i>
                                                        </span>
                                                        <span class="text">Cari</span>
                                                    </button>
                                                    <a href="laporan_pembelian.php"
                                                        class="btn btn-secondary btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-redo"></i>
                                                        </span>
                                                        <span class="text">Reset</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Export Buttons -->
                            <div class="export-section mb-4">
                                <div class="export-buttons">
                                    <a href="../reports/export-pembelian-excel.php?dari=<?= isset($dari) ? $dari : '' ?>&sampai=<?= isset($sampai) ? $sampai : '' ?>"
                                        class="btn btn-success btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-file-excel"></i>
                                        </span>
                                        <span class="text">Export Excel</span>
                                    </a>
                                    <a href="../reports/export-pembelian-pdf.php?dari=<?= isset($dari) ? $dari : '' ?>&sampai=<?= isset($sampai) ? $sampai : '' ?>"
                                        class="btn btn-secondary btn-icon-split btn-sm" target="_blank">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-file-pdf"></i>
                                        </span>
                                        <span class="text">Export PDF</span>
                                    </a>
                                    <button class="btn btn-info btn-icon-split btn-sm" onclick="window.print()">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-print"></i>
                                        </span>
                                        <span class="text">Print</span>
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="tbl_pembelian" class="table table-hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="50"><i class="fas fa-hashtag me-1"></i> No</th>
                                            <th><i class="fas fa-barcode me-1"></i> Kode Transaksi</th>
                                            <th><i class="fas fa-calendar me-1"></i> Tanggal Pembelian</th>
                                            <th><i class="fas fa-user me-1"></i> PIC</th>
                                            <th><i class="fas fa-file-alt me-1"></i> Keterangan</th>
                                            <th width="120"><i class="fas fa-cogs me-1"></i> Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($data = mysqli_fetch_array($query)) { ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><code class="text-primary"><?= $data['kode_transaksi'] ?></code></td>
                                            <td>
                                                <span class="font-weight-bold">
                                                    <?= date('d F Y', strtotime($data['tanggal'])) ?>
                                                </span>
                                            </td>
                                            <td><span class="text-muted"><?= $data['nama'] ?></span></td>
                                            <td><?= $data['keterangan'] ? $data['keterangan'] : '<span class="text-muted">-</span>' ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-outline-info btn-sm" id="btn-detail"
                                                    data-kode="<?= $data['kode_transaksi'] ?>">
                                                    <i class="fas fa-eye me-1"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Transaksi</th>
                                            <th>Tanggal Pembelian</th>
                                            <th>PIC</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
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

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h6 class="modal-title title text-white" id="detailModalLabel">
                        <i class="fas fa-info-circle me-2"></i> Detail Transaksi Pembelian
                    </h6>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!-- Konten modal -->
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless detail-info-table">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold text-primary">
                                            <i class="fas fa-barcode me-2"></i> Kode Transaksi
                                        </td>
                                        <td>:</td>
                                        <td><span id="kodeTransaksi" class="font-weight-bold"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold text-primary">
                                            <i class="fas fa-calendar me-2"></i> Tanggal Transaksi
                                        </td>
                                        <td>:</td>
                                        <td><span id="tglTransaksi" class="font-weight-bold"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold text-primary">
                                            <i class="fas fa-user me-2"></i> User PIC
                                        </td>
                                        <td>:</td>
                                        <td><span id="pic" class="font-weight-bold"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless detail-info-table">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold text-primary">
                                            <i class="fas fa-truck me-2"></i> Supplier
                                        </td>
                                        <td>:</td>
                                        <td><span id="supplier" class="font-weight-bold"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold text-primary">
                                            <i class="fas fa-file-alt me-2"></i> Keterangan
                                        </td>
                                        <td>:</td>
                                        <td><span id="keterangan" class="font-weight-bold"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover detail-items-table" id="detailTable">
                            <thead>
                                <tr>
                                    <th width="50"><i class="fas fa-hashtag me-1"></i> No</th>
                                    <th><i class="fas fa-box me-1"></i> Produk</th>
                                    <th><i class="fas fa-warehouse me-1"></i> Stock Masuk</th>
                                    <th><i class="fas fa-money-bill-wave me-1"></i> Harga</th>
                                    <th><i class="fas fa-calculator me-1"></i> Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="detailTableBody">
                            </tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <td class="text-center font-weight-bold" colspan="4">
                                        <i class="fas fa-calculator me-2"></i> Total Pembelian
                                    </td>
                                    <td class="font-weight-bold text-success" id="totalHarga"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Tutup
                    </button>
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

    <!-- Script untuk fungsi laporan -->
    <script>
    $(document).ready(function() {
        // Initialize DataTable with Wings theme
        $('#tbl_pembelian').DataTable({
            lengthChange: true,
            processing: false,
            language: {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            responsive: true,
            order: [
                [2, 'desc']
            ], // Sort by tanggal
            pageLength: 25,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ]
        });

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
    });

    $(document).on('click', '#btn-detail', function() {
        var kode = $(this).data('kode');

        // Show loading state
        var originalHtml = $(this).html();
        $(this).html('<i class="fas fa-spinner fa-spin"></i> Loading...').prop('disabled', true);

        $.ajax({
            url: '../pembelian/detail-pembelian.php',
            type: 'POST',
            data: {
                kode: kode
            },
            dataType: 'json',
            success: function(data) {
                var tgl = new Date(data[0].tanggal);
                var dd = String(tgl.getDate()).padStart(2, '0');
                var mm = String(tgl.getMonth() + 1).padStart(2, '0');
                var yyyy = tgl.getFullYear();
                var formattedDate = dd + ' ' + getMonthName(mm) + ' ' + yyyy;

                // Mengisi data ke dalam modal detail
                $('#detailModal').modal('show');
                $('#kodeTransaksi').html(data[0].kode_transaksi);
                $('#tglTransaksi').html(formattedDate);
                $('#pic').html(data[0].nama);
                $('#keterangan').html(data[0].keterangan || 'Tidak ada keterangan');
                $('#supplier').html(data[0].kode_sup + ' - ' + data[0].nama_sup);

                // Membuat tabel detail items
                var tableRows = '';
                var no = 1;
                var totalHarga = 0;

                for (var i = 0; i < data.length; i++) {
                    var rowData = data[i];

                    tableRows += '<tr>';
                    tableRows += '<td>' + no++ + '</td>';
                    tableRows += '<td><span class="font-weight-bold">' + rowData.nama_produk +
                        '</span></td>';
                    tableRows += '<td><span class="text-primary font-weight-bold">' + rowData
                        .stock_in + ' ' + rowData.nama_satuan + '</span></td>';
                    tableRows += '<td><span class="text-success font-weight-bold">' + rowData
                        .harga + '</span></td>';
                    tableRows += '<td><span class="text-info font-weight-bold">' + rowData
                        .total_harga + '</span></td>';
                    tableRows += '</tr>';

                    totalHarga += parseFloat(rowData.total_harga.replace(/[^0-9.-]+/g, ""));
                }

                $('#detailTable tbody').html(tableRows);
                $('#totalHarga').html(formatRupiah(totalHarga, 'Rp '));
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal memuat detail transaksi'
                });
            },
            complete: function() {
                // Restore button state
                $('#btn-detail[data-kode="' + kode + '"]').html(originalHtml).prop('disabled',
                    false);
            }
        });
    });

    function getMonthName(month) {
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        return monthNames[month - 1];
    }

    function formatRupiah(angka, prefix) {
        var number_string = angka.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix === undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }
    </script>

</body>

</html>