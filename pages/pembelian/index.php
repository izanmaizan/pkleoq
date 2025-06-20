<!-- pages/pembelian/index.php   -->
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

    <title>EOQ - Pembelian | PT Wings Group</title>

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
    <link rel="stylesheet" href="<?php echo ($_SESSION['role'] == 1) ? '../karyawan/style.css' : 'style-index.css'; ?>">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="<?php echo ($_SESSION['role'] == 1) ? '../karyawan/dashboard.php' : '../admin/dashboard.php'; ?>">
                <div class="sidebar-brand-icon">
                    <img src="../../logo.svg" alt="Logo" style="width: 100px; height: auto;">
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link"
                    href="<?php echo ($_SESSION['role'] == 1) ? '../karyawan/dashboard.php' : '../admin/dashboard.php'; ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <?php if ($_SESSION['role'] != 1): ?>
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
            <?php endif; ?>

            <!-- Heading -->
            <div class="sidebar-heading">
                Transaksi
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
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
                        <?php if ($_SESSION['role'] != 1): ?>
                        <a class="collapse-item" href="../laporan/laporan_produk.php">
                            <i class="fas fa-pills me-2"></i> Laporan Produk
                        </a>
                        <?php endif; ?>
                        <a class="collapse-item" href="../laporan/laporan_pembelian.php">
                            <i class="fas fa-shopping-bag me-2"></i> Laporan Pembelian
                        </a>
                        <a class="collapse-item" href="../laporan/laporan_penjualan.php">
                            <i class="fas fa-chart-bar me-2"></i> Laporan Penjualan
                        </a>
                    </div>
                </div>
            </li>

            <?php if ($_SESSION['role'] != 1): ?>
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
            <?php endif; ?>

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
                                    Manajemen Transaksi Pembelian
                                </h4>
                                <p class="mb-0 opacity-75">
                                    Kelola transaksi pembelian produk PT Wings Group Indonesia
                                </p>
                            </div>
                            <div class="d-none d-lg-block">
                                <i class="fas fa-truck-loading fa-3x opacity-25"></i>
                            </div>
                        </div>
                    </div>

                    <?php
                    if (isset($_SESSION['success'])) {
                        echo '
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><strong>' . $_SESSION['success'] . '</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                                ';
                        // Hapus pesan notifikasi agar tidak ditampilkan kembali
                        unset($_SESSION['success']);
                    }
                    ?>

                    <!-- Content -->
                    <div class="card shadow card-stats">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-shopping-cart me-2"></i> Data Transaksi Pembelian
                            </h6>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-light mr-2">
                                    <i class="fas fa-database me-1"></i> Data Pembelian
                                </span>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <a href="create-pembelian.php" class="btn btn-primary btn-sm btn-icon-split"
                                    id="btnAdd">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                    <span class="text">Tambah Transaksi</span>
                                </a>

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
                                <table class="table table-hover" id="tblPembelian" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="50"><i class="fas fa-hashtag me-1"></i> No</th>
                                            <th><i class="fas fa-barcode me-1"></i> Kode Transaksi</th>
                                            <th><i class="fas fa-calendar me-1"></i> Tanggal Pembelian</th>
                                            <th><i class="fas fa-user me-1"></i> PIC</th>
                                            <th><i class="fas fa-file-alt me-1"></i> Keterangan</th>
                                            <th width="100"><i class="fas fa-cogs me-1"></i> Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h6 class="modal-title title text-white" id="staticBackdropLabel">
                        <i class="fas fa-info-circle me-2"></i> Detail Transaksi Pembelian
                    </h6>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold text-primary" width="40%">
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
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold text-primary" width="40%">
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
                        <table class="table table-bordered" id="detailTable">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Produk</th>
                                    <th>Stok Masuk</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="detailTableBody">
                            </tbody>
                            <tfoot>
                                <tr class="bg-light">
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

    <!-- Script untuk fungsi crud -->
    <script>
    $(document).ready(function() {
        tblPembelian();

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

    $(document).on('click', '#btn-detail', function() {
        var kode = $(this).data('kode');

        $.ajax({
            url: 'detail-pembelian.php',
            type: 'POST',
            data: {
                kode: kode
            },
            dataType: 'json',
            success: function(data) {
                console.log('Detail data received:', data);

                if (data && data.length > 0) {
                    // Format tanggal dengan pengecekan yang lebih baik
                    var formattedDate = 'Tanggal tidak valid';

                    if (data[0].tanggal && data[0].tanggal !== '0000-00-00') {
                        try {
                            // Coba parse tanggal
                            var tgl = new Date(data[0].tanggal);

                            // Periksa apakah tanggal valid
                            if (!isNaN(tgl.getTime())) {
                                var dd = String(tgl.getDate()).padStart(2, '0');
                                var mm = String(tgl.getMonth() + 1).padStart(2, '0');
                                var yyyy = tgl.getFullYear();
                                formattedDate = dd + '-' + mm + '-' + yyyy;
                            } else {
                                // Jika gagal, coba format manual
                                if (data[0].tanggal.includes('-')) {
                                    var parts = data[0].tanggal.split('-');
                                    if (parts.length >= 3) {
                                        formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                                    }
                                }
                            }
                        } catch (e) {
                            console.error('Error formatting date:', e);
                            formattedDate = data[0].tanggal; // Fallback ke tanggal asli
                        }
                    }

                    // Mengisi data ke dalam modal detail
                    $('#detailModal').modal('show');
                    $('#kodeTransaksi').html(data[0].kode_transaksi || '-');
                    $('#tglTransaksi').html(formattedDate);
                    $('#pic').html(data[0].nama || 'Unknown User');

                    if (!data[0].keterangan || data[0].keterangan === '') {
                        $('#keterangan').html(
                            '<span class="text-muted">Tidak ada keterangan</span>');
                    } else {
                        $('#keterangan').html(data[0].keterangan);
                    }

                    $('#supplier').html((data[0].kode_sup || '') + ' - ' + (data[0].nama_sup ||
                        'Unknown Supplier'));

                    // Membuat variabel untuk menyimpan hasil yang akan ditampilkan
                    var tableRows = '';
                    var no = 1;
                    var totalHarga = 0;

                    // Loop untuk setiap baris data yang diterima
                    for (var i = 0; i < data.length; i++) {
                        var rowData = data[i];

                        // Menambahkan baris data ke variabel tableRows
                        tableRows += '<tr>';
                        tableRows += '<td class="text-center">' + no++ + '</td>';
                        tableRows += '<td><span class="font-weight-bold">' + (rowData.nama_produk ||
                            '-') + '</span></td>';
                        tableRows += '<td><span class="badge badge-info">' + (rowData.stock_in ||
                            '0') + ' ' + (rowData.nama_satuan || '') + '</span></td>';
                        tableRows += '<td><span class="text-success font-weight-bold">' +
                            formatRupiah(rowData.harga || 0, 'Rp ') + '</span></td>';
                        tableRows += '<td><span class="text-success font-weight-bold">' +
                            formatRupiah(rowData.total_harga || 0, 'Rp ') + '</span></td>';
                        tableRows += '</tr>';

                        totalHarga += parseFloat(rowData.total_harga || 0);
                    }

                    // Memasukkan baris-baris data ke dalam tabel dengan id 'detailTable'
                    $('#detailTable tbody').html(tableRows);

                    // Menampilkan total harga pada bagian akhir tabel
                    $('#totalHarga').html(formatRupiah(totalHarga, 'Rp '));
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Data tidak ditemukan',
                        text: 'Data transaksi tidak ditemukan atau kosong'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Ajax Error:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText
                });
                Toast.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan',
                    text: 'Tidak dapat mengambil data detail transaksi: ' + error
                });
            }
        });
    });

    $(document).on('click', '#btn-hapus', function() {

        var id = $(this).data('id');

        Swal.fire({
            title: 'Konfirmasi Hapus Data',
            text: "Apakah Anda yakin ingin menghapus transaksi pembelian ini?",
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
                    url: "delete-pembelian.php",
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

                        $('#tblPembelian').DataTable().ajax.reload();
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

    function tblPembelian() {
        $("#tblPembelian").DataTable({
            lengthChange: true,
            processing: true,
            serverSide: false,
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
                },
                "processing": "Memuat data..."
            },
            ajax: {
                url: "pembelian-datatables.php",
                type: "GET",
                dataType: "json",
                error: function(xhr, error, thrown) {
                    console.error('DataTables Ajax Error:');
                    console.error('Status:', xhr.status);
                    console.error('Response:', xhr.responseText);
                    console.error('Error:', error);
                    console.error('Thrown:', thrown);

                    // Tampilkan pesan error yang lebih informatif
                    Toast.fire({
                        icon: 'error',
                        title: 'Error loading data',
                        text: 'Silakan cek console untuk detail error'
                    });
                }
            },
            columns: [{
                    data: null,
                    sortable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: "kode_transaksi",
                    name: "kode_transaksi",
                    render: function(data, type, row) {
                        return '<code class="text-primary">' + data + '</code>';
                    }
                },
                {
                    data: "tanggal",
                    name: "tanggal",
                    render: function(data, type, row) {
                        // Data sudah diformat di server, langsung tampilkan
                        if (data && data !== '-' && data !== 'Invalid Date') {
                            return '<span class="text-muted">' + data + '</span>';
                        } else {
                            return '<span class="text-danger">Tanggal tidak valid</span>';
                        }
                    }
                },
                {
                    data: "nama",
                    name: "nama",
                    render: function(data, type, row) {
                        return '<span class="font-weight-bold">' + (data || 'Unknown User') + '</span>';
                    }
                },
                {
                    data: "keterangan",
                    name: "keterangan",
                    render: function(data, type, row) {
                        if (!data || data === '' || data === null || data === '-') {
                            return '<span class="text-muted font-italic">Tidak ada keterangan</span>';
                        }
                        if (data.length > 50) {
                            return '<span title="' + data + '">' + data.substring(0, 50) + '...</span>';
                        }
                        return data;
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
                [2, 'desc']
            ], // Order by tanggal descending
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