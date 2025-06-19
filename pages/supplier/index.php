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

    <title>EOQ - Supplier | PT Wings Group</title>

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
                        <a class="collapse-item active" href="../supplier/index.php">
                            <i class="fas fa-truck me-2"></i> Supplier
                        </a>
                        <a class="collapse-item" href="../produk/index.php">
                            <i class="fas fa-boxes me-2"></i> Produk
                        </a>
                        <a class="collapse-item" href="../kategori/index.php">
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
                                    <i class="fas fa-truck fa-2x me-3"></i>
                                    Manajemen Data Supplier
                                </h4>
                                <p class="mb-0 opacity-75">
                                    Kelola data supplier PT Wings Group Indonesia dengan mudah dan efisien
                                </p>
                            </div>
                            <div class="d-none d-lg-block">
                                <i class="fas fa-shipping-fast fa-3x opacity-25"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold">
                                    <i class="fas fa-truck me-2"></i> Data Supplier
                                </h6>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-light mr-2">
                                        <i class="fas fa-database me-1"></i> Total Data
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <button class="btn btn-primary btn-icon-split shadow-sm" id="btnAdd">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                    <span class="text">Tambah Supplier</span>
                                </button>

                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <span class="text-muted small">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Kelola data supplier untuk transaksi pembelian
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover" id="tblSupplier" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="50"><i class="fas fa-hashtag me-1"></i> No</th>
                                            <th><i class="fas fa-barcode me-1"></i> Kode Supplier</th>
                                            <th><i class="fas fa-building me-1"></i> Nama Supplier</th>
                                            <th><i class="fas fa-map-marker-alt me-1"></i> Alamat</th>
                                            <th><i class="fas fa-phone me-1"></i> No. HP</th>
                                            <th width="100"><i class="fas fa-cogs me-1"></i> Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Supplier</th>
                                            <th>Nama Supplier</th>
                                            <th>Alamat</th>
                                            <th>No. HP</th>
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

    <!-- Modal Supplier -->
    <div class="modal fade" id="modalSupp" tabindex="-1" role="dialog" aria-labelledby="modalSuppLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSuppLabel">
                        <i class="fas fa-truck me-2"></i> Form Supplier
                    </h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formSupplier">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="id" id="id" hidden>
                                    <input type="text" name="action" id="action" hidden>
                                    <label for="kd_supplier" class="form-label font-weight-bold">
                                        <i class="fas fa-barcode me-1"></i> Kode Supplier
                                    </label>
                                    <input type="text" name="kd_supplier" id="kd_supplier" class="form-control"
                                        readonly>
                                    <small class="form-text text-muted">Kode supplier akan digenerate otomatis</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_supplier" class="form-label font-weight-bold">
                                        <i class="fas fa-building me-1"></i> Nama Supplier
                                    </label>
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control"
                                        placeholder="Masukkan nama supplier">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_hp" class="form-label font-weight-bold">
                                        <i class="fas fa-phone me-1"></i> No. Handphone
                                    </label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control"
                                        placeholder="Contoh: 081234567890">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alamat" class="form-label font-weight-bold">
                                        <i class="fas fa-map-marker-alt me-1"></i> Alamat Supplier
                                    </label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3"
                                        placeholder="Masukkan alamat lengkap supplier"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" form="formSupplier" class="btn btn-primary" id="btnAction">
                        <i class="fas fa-save me-1"></i> Simpan
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

    <!-- Script untuk fungsi crud -->
    <script>
    $(document).ready(function() {
        tblSupplier();

        $('#modalSupp').on('hidden.bs.modal', function(e) {
            formReset();
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

    $('#formSupplier').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        if (formData.get('action') == 'add') {
            $.ajax({
                method: 'POST',
                url: 'add-supplier.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    $('#modalSupp').modal('hide');

                    //toast
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });

                    $('#tblSupplier').DataTable().ajax.reload();
                    formReset();
                },
                error: function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            });
        } else if (formData.get('action') == 'update') {

            $.ajax({
                method: 'POST',
                url: 'update-supplier.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    $('#modalSupp').modal('hide');

                    //toast
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });

                    $('#tblSupplier').DataTable().ajax.reload();
                    formReset();
                },
                error: function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            });
        }
    });

    $(document).on('click', '#btnAdd', function() {

        $('#modalSuppLabel').html('<i class="fas fa-plus me-2"></i> Tambah Supplier');
        $('#modalSupp').modal('show');
        $('#btnAction').html('<i class="fas fa-save me-1"></i> Simpan');

        $('#kd_supplier').val(generateKodeSupplier());
        $('#action').val('add');
    });

    $(document).on('click', '#btn-edit', function() {

        var id = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "get-supplier.php?id=" + id,
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {

                $('#modalSuppLabel').html('<i class="fas fa-edit me-2"></i> Edit Supplier');
                $('#modalSupp').modal('show');
                $('#btnAction').html('<i class="fas fa-save me-1"></i> Update');

                $('#id').val(data.id);
                $('#kd_supplier').val(data.kode_sup);
                $('#nama_supplier').val(data.nama_sup);
                $('#no_hp').val(data.no_hp);
                $('#alamat').val(data.alamat);
                $('#action').val('update');
            },
            error: function(data) {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message
                });
            }
        });
    });

    $(document).on('click', '#btn-hapus', function() {

        var id = $(this).data('id');

        Swal.fire({
            title: 'Konfirmasi Hapus Data',
            text: "Apakah Anda yakin ingin menghapus data supplier ini?",
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
                    url: "delete-supplier.php",
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

                        $('#tblSupplier').DataTable().ajax.reload();
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menghapus data'
                        });
                    }
                });
            }
        })
    })

    function formReset() {
        $('#id').val('');
        $('#kd_supplier').val('');
        $('#nama_supplier').val('');
        $('#no_hp').val('');
        $('#alamat').val('');
        $('#action').val('add');
    }

    function generateKodeSupplier() {
        const prefix = 'KD-SUP';
        const random_number = Math.floor(Math.random() * 1000000); // generate random number between 0 and 999999
        const random_number_padded = random_number.toString().padStart(6, '0'); // pad the number with leading zeros
        const supplier_code = prefix + random_number_padded;
        return supplier_code;
    }

    function tblSupplier() {
        $("#tblSupplier").DataTable({
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
                url: "supplier-datatables.php",
            },
            columns: [{
                    data: null,
                    sortable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: "kd_supplier",
                    name: "kd_supplier",
                    render: function(data, type, row) {
                        return '<code class="text-primary">' + data + '</code>';
                    }
                },
                {
                    data: "nama_supplier",
                    name: "nama_supplier",
                    render: function(data, type, row) {
                        return '<span class="font-weight-bold">' + data + '</span>';
                    }
                },
                {
                    data: "alamat",
                    name: "alamat",
                    render: function(data, type, row) {
                        if (data.length > 50) {
                            return '<span title="' + data + '">' + data.substring(0, 50) + '...</span>';
                        }
                        return data;
                    }
                },
                {
                    data: "no_hp",
                    name: "no_hp",
                    render: function(data, type, row) {
                        return '<span class="text-muted"><i class="fas fa-phone me-1"></i> ' + data +
                            '</span>';
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