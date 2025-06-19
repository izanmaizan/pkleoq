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
    <meta name="description" content="Sistem EOQ - Economic Order Quantity PT Wings Group Indonesia">
    <meta name="author" content="PT Wings Group Indonesia">

    <title>EOQ - Kategori | PT Wings Group</title>

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

    <!-- Wings Theme CSS -->
    <style>
    :root {
        --wings-primary: #dc2626;
        --wings-secondary: #64748b;
        --wings-success: #059669;
        --wings-warning: #d97706;
        --wings-danger: #dc2626;
        --wings-info: #0284c7;
        --wings-gray-50: #f8fafc;
        --wings-gray-100: #f1f5f9;
        --wings-gray-200: #e2e8f0;
        --wings-gray-300: #cbd5e1;
        --wings-gray-800: #1e293b;
        --wings-gray-900: #0f172a;
        --wings-red: #dc2626;
        --wings-white: #ffffff;
    }

    body {
        font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
            sans-serif;
        background-color: var(--wings-gray-50);
        color: var(--wings-gray-800);
    }

    .sidebar {
        background: linear-gradient(135deg, var(--wings-red) 0%, #b91c1c 100%);
    }

    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .sidebar .nav-link:hover {
        color: white;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        margin: 0 10px;
    }

    .sidebar .nav-link.active {
        color: white !important;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        margin: 0 10px;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
    }

    .card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: linear-gradient(135deg, var(--wings-red) 0%, #b91c1c 100%);
        color: white;
        border-bottom: none;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.25rem 1.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--wings-red) 0%, #b91c1c 100%);
        border: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    .btn-secondary {
        background-color: var(--wings-secondary);
        border-color: var(--wings-secondary);
        border-radius: 8px;
        font-weight: 500;
    }

    .welcome-text {
        background: linear-gradient(135deg, var(--wings-red) 0%, #b91c1c 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
    }

    .table th {
        background-color: var(--wings-gray-100);
        border: none;
        font-weight: 600;
        color: var(--wings-gray-800);
        padding: 1rem 0.75rem;
    }

    .table td {
        border: none;
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }

    .table tbody tr {
        border-bottom: 1px solid var(--wings-gray-200);
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: var(--wings-gray-50);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        border: 2px solid var(--wings-gray-200);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--wings-red);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    .btn-outline-primary {
        color: var(--wings-red);
        border-color: var(--wings-red);
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-outline-primary:hover {
        background-color: var(--wings-red);
        border-color: var(--wings-red);
        transform: translateY(-1px);
    }

    .btn-outline-danger {
        color: var(--wings-danger);
        border-color: var(--wings-danger);
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-outline-danger:hover {
        background-color: var(--wings-danger);
        border-color: var(--wings-danger);
        transform: translateY(-1px);
    }

    .topbar {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .sidebar-brand {
        padding: 1.5rem 1rem;
    }

    .sidebar-divider {
        border-color: rgba(255, 255, 255, 0.15);
    }

    .sidebar-heading {
        color: rgba(255, 255, 255, 0.6);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
    }

    .collapse-header {
        color: var(--wings-gray-600) !important;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .collapse-item {
        color: var(--wings-gray-700) !important;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .collapse-item:hover {
        color: var(--wings-red) !important;
        background-color: var(--wings-gray-50);
        transform: translateX(5px);
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid var(--wings-gray-200);
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: var(--wings-red) !important;
        border: 1px solid var(--wings-red) !important;
        border-radius: 6px;
    }

    .text-primary {
        color: var(--wings-red) !important;
    }

    .bg-primary {
        background: linear-gradient(135deg,
                var(--wings-red) 0%,
                #b91c1c 100%) !important;
    }

    .border-left-primary {
        border-left: 4px solid var(--wings-red) !important;
    }

    .card-stats {
        animation: fadeInUp 0.5s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 40px, 0);
        }

        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    .bg-danger {
        background-color: var(--wings-danger) !important;
    }

    .form-card {
        background: white;
        border: 1px solid var(--wings-gray-200);
    }

    .table-card {
        background: white;
        border: 1px solid var(--wings-gray-200);
    }

    .card-footer {
        background-color: var(--wings-gray-50);
        border-top: 1px solid var(--wings-gray-200);
        border-radius: 0 0 12px 12px;
    }

    .form-group label {
        font-weight: 600;
        color: var(--wings-gray-800);
        margin-bottom: 0.5rem;
    }

    /* Focus states */
    .btn:focus,
    .form-control:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    .swal2-popup-custom {
        border-radius: 12px;
    }

    /* Enhanced table styling */
    .table tbody tr:hover {
        background-color: var(--wings-gray-50);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    /* Form enhancements */
    .form-control:invalid {
        border-color: var(--wings-danger);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    /* Print styles */
    @media print {

        .sidebar,
        .topbar,
        .btn,
        .card-footer {
            display: none !important;
        }

        .content-wrapper {
            margin-left: 0 !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
    }
    </style>

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
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Data Master</span>
                </a>
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Kelola Data:</h6>
                        <a class="collapse-item" href="../supplier/index.php">
                            <i class="fas fa-truck me-2"></i> Supplier
                        </a>
                        <a class="collapse-item" href="../produk/index.php">
                            <i class="fas fa-boxes me-2"></i> Produk
                        </a>
                        <a class="collapse-item active" href="index.php">
                            <i class="fas fa-tags me-2"></i> Kategori
                        </a>
                        <a class="collapse-item" href="../satuan/index.php">
                            <i class="fas fa-balance-scale me-2"></i> Satuan
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
                            <i class="fas fa-pills me-2"></i> Laporan Produk
                        </a>
                        <a class="collapse-item" href="../laporan/laporan_pembelian.php">
                            <i class="fas fa-shopping-bag me-2"></i> Laporan Pembelian
                        </a>
                        <a class="collapse-item" href="../laporan/laporan_penjualan.php">
                            <i class="fas fa-chart-bar me-2"></i> Laporan Penjualan
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
                                    <i class="fas fa-tags fa-2x me-3"></i>
                                    Manajemen Kategori Produk
                                </h4>
                                <p class="mb-0 opacity-75">
                                    Kelola kategori produk PT Wings Group untuk klasifikasi yang efektif
                                </p>
                            </div>
                            <div class="d-none d-lg-block">
                                <i class="fas fa-layer-group fa-3x opacity-25"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="card form-card card-stats shadow">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold">
                                        <i class="fas fa-plus-circle me-2"></i> Form Kategori
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form id="formKategori">
                                        <div class="form-group">
                                            <input type="text" id="id" name="id" hidden>
                                            <input type="text" id="action" name="action" value="add" hidden>
                                            <label for="nm_kategori">
                                                <i class="fas fa-tag me-1"></i> Nama Kategori
                                            </label>
                                            <input type="text" class="form-control" id="nm_kategori" name="nm_kategori"
                                                placeholder="Masukkan nama kategori">
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan">
                                                <i class="fas fa-file-alt me-1"></i> Keterangan
                                            </label>
                                            <textarea class="form-control" id="keterangan" name="keterangan" rows="4"
                                                placeholder="Masukkan keterangan kategori (opsional)"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" form="formKategori" class="btn btn-primary btn-sm"
                                        id="btnSimpan">
                                        <i class="fas fa-save me-1"></i> Simpan
                                    </button>
                                    <button type="reset" form="formKategori" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-redo me-1"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-7">
                            <div class="card table-card card-stats shadow">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold">
                                            <i class="fas fa-list me-2"></i> Daftar Kategori
                                        </h6>
                                        <span class="badge badge-light">
                                            <i class="fas fa-database me-1"></i> Data Master
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="tblKategori" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="50"><i class="fas fa-hashtag me-1"></i> No</th>
                                                    <th><i class="fas fa-tag me-1"></i> Nama Kategori</th>
                                                    <th><i class="fas fa-file-alt me-1"></i> Keterangan</th>
                                                    <th width="100"><i class="fas fa-cogs me-1"></i> Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Kategori</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
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

    <!-- Script untuk fungsi crud -->
    <script>
    $(document).ready(function() {
        tblKategori();

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

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
    });

    $('#formKategori').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        if (formData.get('action') == 'add') {
            $.ajax({
                method: 'POST',
                url: 'add-kategori.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {

                    if (data.success == true) {
                        //toast
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });
                    } else {
                        //toast
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        });
                    }

                    $('#tblKategori').DataTable().ajax.reload();
                    formReset();
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    // Menampilkan notifikasi error jika terdapat pesan
                    let errorMessage = 'Terjadi kesalahan.';
                    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                        errorMessage = jqXHR.responseJSON.message;
                    }

                    Toast.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            });
        } else if (formData.get('action') == 'update') {

            $.ajax({
                method: 'POST',
                url: 'update-kategori.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    $('#btnSimpan').html('<i class="fas fa-save me-1"></i> Simpan');

                    //toast
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });

                    $('#tblKategori').DataTable().ajax.reload();
                    formReset();
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    // Menampilkan notifikasi error jika terdapat pesan
                    let errorMessage = 'Terjadi kesalahan.';
                    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                        errorMessage = jqXHR.responseJSON.message;
                    }

                    Toast.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            });
        }
    });

    $(document).on('click', '#btn-edit', function() {

        var id = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "get-kategori.php",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                $('#btnSimpan').html('<i class="fas fa-save me-1"></i> Update');

                $('#id').val(data.id);
                $('#nm_kategori').val(data.nama_kategori);
                $('#keterangan').val(data.keterangan);
                $('#action').val('update');
            },
            error: function(data) {

                Toast.fire({
                    icon: 'error',
                    text: data.message
                });
            }
        });
    });

    $(document).on('click', '#btn-hapus', function() {

        var id = $(this).data('id');

        Swal.fire({
            title: 'Konfirmasi Hapus Data',
            text: "Apakah Anda yakin ingin menghapus kategori ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times me-1"></i> Batal',
            customClass: {
                popup: 'swal2-popup-custom'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "delete-kategori.php",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {

                        //toast
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });

                        $('#tblKategori').DataTable().ajax.reload();
                    },
                    error: function() {
                        Toast.fire({
                            icon: 'error',
                            text: 'Terjadi kesalahan saat menghapus data'
                        });
                    }
                });
            }
        })
    })

    function formReset() {
        $('#id').val('');
        $('#nm_kategori').val('');
        $('#keterangan').val('');
        $('#action').val('add');
        $('#btnSimpan').html('<i class="fas fa-save me-1"></i> Simpan');
    }

    function tblKategori() {
        $("#tblKategori").DataTable({
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
            ajax: {
                url: "kategori-datatables.php",
            },
            columns: [{
                    data: null,
                    sortable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: "nama_kategori",
                    name: "nama_kategori",
                    render: function(data, type, row) {
                        return '<span class="font-weight-bold text-primary"><i class="fas fa-tag me-2"></i> ' +
                            data + '</span>';
                    }
                },
                {
                    data: "keterangan",
                    name: "keterangan",
                    render: function(data, type, row) {
                        if (data && data.length > 50) {
                            return '<span title="' + data + '">' + data.substring(0, 50) + '...</span>';
                        }
                        return data || '<span class="text-muted">Tidak ada keterangan</span>';
                    }
                },
                {
                    data: "aksi",
                    name: "aksi",
                    orderable: false,
                    searchable: false
                }
            ],
            responsive: true,
            order: [
                [1, 'asc']
            ],
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ]
        });
    }
    </script>


</body>

</html>