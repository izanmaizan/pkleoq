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

    <title>EOQ - Produk | PT Wings Group</title>

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
                        <a class="collapse-item" href="../supplier/index.php">
                            <i class="fas fa-truck me-2"></i>Supplier
                        </a>
                        <a class="collapse-item active" href="index.php">
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
                                    <i class="fas fa-boxes fa-2x me-3"></i>
                                    Manajemen Data Produk
                                </h4>
                                <p class="mb-0 opacity-75">
                                    Kelola data produk PT Wings Group Indonesia dengan sistem EOQ yang terintegrasi
                                </p>
                            </div>
                            <div class="d-none d-lg-block">
                                <i class="fas fa-industry fa-3x opacity-25"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold">
                                    <i class="fas fa-boxes me-2"></i> Data Produk
                                </h6>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-light mr-2">
                                        <i class="fas fa-warehouse me-1"></i> Inventory Management
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                                <div class="d-flex align-items-center mb-2 mb-md-0">
                                    <button class="btn btn-primary btn-icon-split shadow-sm me-2" id="btnAdd">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text">Tambah Produk</span>
                                    </button>
                                </div>

                                <div class="export-buttons">
                                    <a href="../reports/export-produk-pdf.php"
                                        class="btn btn-secondary btn-icon-split btn-sm" target="_blank">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-file-pdf"></i>
                                        </span>
                                        <span class="text">Export PDF</span>
                                    </a>
                                    <a href="../reports/export-produk-excel.php"
                                        class="btn btn-success btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-file-excel"></i>
                                        </span>
                                        <span class="text">Export Excel</span>
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover" id="tblproduk" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="50"><i class="fas fa-hashtag me-1"></i> No</th>
                                            <th><i class="fas fa-barcode me-1"></i> Kode Produk</th>
                                            <th><i class="fas fa-box me-1"></i> Nama Produk</th>
                                            <th><i class="fas fa-money-bill-wave me-1"></i> Harga</th>
                                            <th><i class="fas fa-warehouse me-1"></i> Stok</th>
                                            <th><i class="fas fa-balance-scale me-1"></i> Satuan</th>
                                            <th><i class="fas fa-calculator me-1"></i> Biaya Simpan</th>
                                            <th width="120"><i class="fas fa-cogs me-1"></i> Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Satuan</th>
                                            <th>Biaya Simpan</th>
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

    <!-- Modal Produk -->
    <div class="modal fade" id="modalproduk" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="modalprodukLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalprodukLabel">
                        <i class="fas fa-boxes me-2"></i> Form Produk
                    </h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Produk yang Diperbaiki -->
                    <form id="formproduk">
                        <!-- Field hidden yang diperlukan -->
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="action" name="action" value="add">

                        <div class="row">
                            <!-- Field yang hilang: Kode Produk -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode_produk" class="font-weight-bold">
                                        <i class="fas fa-barcode me-1"></i> Kode Produk
                                    </label>
                                    <input class="form-control" id="kode_produk" name="kode_produk" type="text"
                                        placeholder="Kode produk akan digenerate otomatis" readonly />
                                </div>
                            </div>

                            <!-- Field yang hilang: Nama Produk -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_produk" class="font-weight-bold">
                                        <i class="fas fa-box me-1"></i> Nama Produk
                                    </label>
                                    <input class="form-control" id="nama_produk" name="nama_produk" type="text"
                                        placeholder="Masukkan nama produk" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Field yang hilang: Supplier -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="supplier" class="font-weight-bold">
                                        <i class="fas fa-truck me-1"></i> Supplier
                                    </label>
                                    <select class="form-control" id="supplier" name="supplier" required>
                                        <option selected disabled value="0">-- Pilih Supplier --</option>
                                        <?php
                                        include '../../config/koneksi.php';
                                        $sql = "SELECT * FROM supplier";
                                        $query = mysqli_query($conn, $sql);
                                        while ($data = mysqli_fetch_assoc($query)) {
                                            echo "<option value='" . $data['id'] . "'>" . $data['nama_sup'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kategori" class="font-weight-bold">
                                        <i class="fas fa-tags me-1"></i> Kategori Produk
                                    </label>
                                    <select class="form-control" id="kategori" name="kategori" required>
                                        <option selected disabled value="0">-- Pilih Kategori --</option>
                                        <?php
                                        include '../../config/koneksi.php';
                                        $sql = "SELECT * FROM kategori";
                                        $query = mysqli_query($conn, $sql);
                                        while ($data = mysqli_fetch_assoc($query)) {
                                            echo "<option value='" . $data['id'] . "'>" . $data['nama_kategori'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="satuan" class="font-weight-bold">
                                        <i class="fas fa-balance-scale me-1"></i> Satuan
                                    </label>
                                    <select class="form-control" id="satuan" name="satuan" required>
                                        <option selected disabled value="0">-- Pilih Satuan --</option>
                                        <?php
                                        include '../../config/koneksi.php';
                                        $sql = "SELECT * FROM satuan";
                                        $query = mysqli_query($conn, $sql);
                                        while ($data = mysqli_fetch_assoc($query)) {
                                            echo "<option value='" . $data['id'] . "'>" . $data['nama_satuan'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stock" class="font-weight-bold">
                                        <i class="fas fa-warehouse me-1"></i> Stok Awal
                                    </label>
                                    <input class="form-control" id="stock" name="stock" type="number"
                                        placeholder="Masukkan jumlah stok" min="0" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="harga" class="font-weight-bold">
                                        <i class="fas fa-money-bill-wave me-1"></i> Harga Produk
                                    </label>
                                    <input class="form-control" id="harga" name="harga" type="text" placeholder="Rp 0"
                                        onkeyup="formatRupiah(this)" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="biaya_penyimpanan" class="font-weight-bold">
                                        <i class="fas fa-calculator me-1"></i> Biaya Penyimpanan
                                    </label>
                                    <input class="form-control" id="biaya_penyimpanan" name="biaya_penyimpanan"
                                        type="text" placeholder="Rp 0" onkeyup="formatRupiah(this)" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan" class="font-weight-bold">
                                        <i class="fas fa-file-alt me-1"></i> Keterangan
                                    </label>
                                    <textarea class="form-control" placeholder="Masukkan keterangan produk (opsional)"
                                        id="keterangan" name="keterangan" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" form="formproduk" class="btn btn-primary" id="btnAction">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white" id="detailModalLabel">
                        <i class="fas fa-info-circle me-2"></i> Detail Produk
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody id="detailTableBody">
                                <!-- Data akan diisi via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
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
        tblproduk();

        $('#modalproduk').on('hidden.bs.modal', function(e) {
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

    // Perbaikan fungsi submit form
    $('#formproduk').on('submit', function(e) {
        e.preventDefault();

        // Validasi form sebelum submit
        var kode_produk = $('#kode_produk').val();
        var nama_produk = $('#nama_produk').val();
        var supplier = $('#supplier').val();
        var kategori = $('#kategori').val();
        var satuan = $('#satuan').val();
        var stock = $('#stock').val();
        var harga = $('#harga').val();
        var biaya_penyimpanan = $('#biaya_penyimpanan').val();
        var action = $('#action').val();

        // Validasi client-side
        if (!nama_produk || supplier == '0' || kategori == '0' || satuan == '0' || !stock || !harga || !
            biaya_penyimpanan) {
            Toast.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: 'Mohon lengkapi semua field yang wajib diisi!'
            });
            return false;
        }

        // Bersihkan format rupiah sebelum mengirim
        var harga_clean = harga.replace(/[^0-9]/g, '');
        var biaya_clean = biaya_penyimpanan.replace(/[^0-9]/g, '');

        // Buat FormData
        var formData = new FormData();
        formData.append('kode_produk', kode_produk);
        formData.append('nama_produk', nama_produk);
        formData.append('supplier', supplier);
        formData.append('kategori', kategori);
        formData.append('satuan', satuan);
        formData.append('stock', stock);
        formData.append('harga', harga_clean);
        formData.append('biaya_penyimpanan', biaya_clean);
        formData.append('keterangan', $('#keterangan').val());
        formData.append('action', action);

        // Jika update, tambahkan ID
        if (action == 'update') {
            formData.append('id', $('#id').val());
        }

        // Debug: log data yang akan dikirim
        console.log('Data yang akan dikirim:');
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        if (action == 'add') {
            $.ajax({
                method: 'POST',
                url: 'add-produk.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    // Tampilkan loading
                    $('#btnAction').html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...')
                        .prop('disabled', true);
                },
                success: function(data) {
                    console.log('Response dari server:', data);

                    if (data.status == 'success') {
                        $('#modalproduk').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message
                        });
                        $('#tblproduk').DataTable().ajax.reload();
                        formReset();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Periksa kembali data yang anda masukkan!'
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
                        title: 'Terjadi kesalahan!',
                        text: 'Error: ' + error + '. Periksa console untuk detail.'
                    });
                },
                complete: function() {
                    // Kembalikan tombol ke state normal
                    $('#btnAction').html('<i class="fas fa-save me-1"></i> Simpan').prop('disabled',
                        false);
                }
            });

        } else if (action == 'update') {
            $.ajax({
                method: 'POST',
                url: 'update-produk.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#btnAction').html(
                        '<i class="fas fa-spinner fa-spin me-1"></i> Mengupdate...').prop(
                        'disabled', true);
                },
                success: function(data) {
                    console.log('Response dari server:', data);

                    $('#modalproduk').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message
                    });
                    $('#tblproduk').DataTable().ajax.reload();
                    formReset();
                },
                error: function(xhr, status, error) {
                    console.error('Ajax Error:', {
                        status: status,
                        error: error,
                        responseText: xhr.responseText
                    });

                    Toast.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan!',
                        text: 'Error: ' + error + '. Periksa console untuk detail.'
                    });
                },
                complete: function() {
                    $('#btnAction').html('<i class="fas fa-save me-1"></i> Update').prop('disabled',
                        false);
                }
            });
        }
    });

    $(document).on('click', '#btnAdd', function() {
        $('#modalprodukLabel').html('<i class="fas fa-plus me-2"></i> Tambah Produk');
        $('#modalproduk').modal('show');
        $('#btnAction').html('<i class="fas fa-save me-1"></i> Simpan');

        // Reset form dan set action
        formReset();
        $('#kode_produk').val(generateKodeproduk());
        $('#action').val('add');
    });


    $(document).on('click', '#btn-edit', function() {

        var id = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "get-produk.php?id=" + id,
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {

                $('#modalprodukLabel').html('<i class="fas fa-edit me-2"></i> Edit Produk');
                $('#modalproduk').modal('show');
                $('#btnAction').html('<i class="fas fa-save me-1"></i> Update');

                $('#id').val(data.id);
                $('#kode_produk').val(data.kode_produk);
                $('#nama_produk').val(data.nama_produk);
                $('#kategori').val(data.kategori_id);
                $('#satuan').val(data.satuan_id);
                $('#stock').val(data.stock);
                $('#harga').val(data.harga);
                $('#biaya_penyimpanan').val(data.biaya_penyimpanan);
                $('#supplier').val(data.sup_id);
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

    $(document).on('click', '#btn-detail', function(e) {
        e.preventDefault();
        console.log('Detail button clicked'); // Debug log

        var id = $(this).data('id');
        console.log('Product ID:', id); // Debug log

        if (!id) {
            Toast.fire({
                icon: 'error',
                title: 'Error',
                text: 'ID produk tidak ditemukan'
            });
            return;
        }

        // Tambahkan loading state
        var originalHtml = $(this).html();
        $(this).html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

        $.ajax({
            url: 'detail-produk.php',
            type: 'GET',
            data: {
                id: id
            },
            dataType: 'json',
            timeout: 10000,
            beforeSend: function() {
                console.log('Sending AJAX request to detail-produk.php with ID:', id);
            },
            success: function(response) {
                console.log('Response received:', response);

                if (response && !response.error) {
                    // Clear previous data
                    $('#detailTableBody').empty();

                    // Helper function untuk format rupiah display
                    function formatRupiahDisplay(value) {
                        if (!value || value === 0) return 'Rp 0';
                        return 'Rp ' + parseInt(value).toLocaleString('id-ID');
                    }

                    // Populate table with new data
                    var tableContent = `
                    <tr>
                        <td class="font-weight-bold text-primary" width="30%">
                            <i class="fas fa-barcode me-2"></i> Kode Produk
                        </td>
                        <td>${response.kode_produk || '-'}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-primary">
                            <i class="fas fa-box me-2"></i> Nama Produk
                        </td>
                        <td>${response.nama_produk || '-'}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-primary">
                            <i class="fas fa-money-bill-wave me-2"></i> Harga
                        </td>
                        <td>${formatRupiahDisplay(response.harga)}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-primary">
                            <i class="fas fa-warehouse me-2"></i> Stok
                        </td>
                        <td>${response.stock || '0'} ${response.satuan || ''}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-primary">
                            <i class="fas fa-balance-scale me-2"></i> Satuan
                        </td>
                        <td>${response.satuan || '-'}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-primary">
                            <i class="fas fa-tags me-2"></i> Kategori
                        </td>
                        <td>${response.nama_kategori || '-'}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-primary">
                            <i class="fas fa-truck me-2"></i> Supplier
                        </td>
                        <td>${response.nama_sup || '-'}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-primary">
                            <i class="fas fa-calculator me-2"></i> Biaya Penyimpanan
                        </td>
                        <td>${formatRupiahDisplay(response.biaya_penyimpanan)}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-primary">
                            <i class="fas fa-file-alt me-2"></i> Keterangan
                        </td>
                        <td>${response.keterangan || 'Tidak ada keterangan'}</td>
                    </tr>
                `;

                    $('#detailTableBody').html(tableContent);

                    // Show modal
                    $('#detailModal').modal('show');
                } else {
                    console.error('Error in response:', response);
                    Toast.fire({
                        icon: 'error',
                        title: 'Gagal memuat data',
                        text: response.message || 'Data tidak ditemukan'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error Details:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    statusCode: xhr.status
                });

                var errorMessage = 'Tidak dapat mengambil data detail produk';

                if (xhr.status === 404) {
                    errorMessage = 'File detail-produk.php tidak ditemukan';
                } else if (xhr.status === 500) {
                    errorMessage = 'Terjadi kesalahan pada server';
                } else if (status === 'timeout') {
                    errorMessage = 'Koneksi timeout, coba lagi';
                }

                Toast.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan',
                    text: errorMessage
                });
            },
            complete: function() {
                // Restore button state untuk semua tombol detail dengan ID yang sama
                $('button[data-id="' + id + '"]#btn-detail, a[data-id="' + id + '"]#btn-detail')
                    .html(originalHtml)
                    .prop('disabled', false);
            }
        });
    });

    $(document).on('click', '#btn-hapus', function() {

        var id = $(this).data('id');

        Swal.fire({
            title: 'Konfirmasi Hapus Data',
            text: "Apakah Anda yakin ingin menghapus data produk ini?",
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
                    url: "delete-produk.php",
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

                        $('#tblproduk').DataTable().ajax.reload();
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
        $('#kode_produk').val('');
        $('#nama_produk').val('');
        $('#supplier').val('0');
        $('#kategori').val('0');
        $('#satuan').val('0');
        $('#stock').val('');
        $('#harga').val('');
        $('#biaya_penyimpanan').val('');
        $('#keterangan').val('');
        $('#action').val('add');

        // Reset validasi form jika ada
        $('#formproduk')[0].reset();
    }


    function generateKodeproduk() {
        const prefix = 'KD-PRD';
        const random_number = Math.floor(Math.random() * 1000000);
        const random_number_padded = random_number.toString().padStart(6, '0');
        const produk_code = prefix + random_number_padded;
        return produk_code;
    }

    function formatRupiah(element) {
        var angka = element.value.replace(/[^,\d]/g, '');
        var split = angka.split(',');
        var sisa = split[0].length % 3;
        var rupiah = split[0].substr(0, sisa);
        var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        element.value = rupiah ? 'Rp ' + rupiah : '';
    }


    function tblproduk() {
        $("#tblproduk").DataTable({
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
                url: "produk-datatables.php",
            },
            columns: [{
                    data: null,
                    sortable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: "kode_produk",
                    name: "kode_produk",
                    render: function(data, type, row) {
                        return '<code class="text-primary">' + data + '</code>';
                    }
                },
                {
                    data: "nama_produk",
                    name: "nama_produk",
                    render: function(data, type, row) {
                        return '<span class="font-weight-bold">' + data + '</span>';
                    }
                },
                {
                    data: "harga",
                    name: "harga",
                    render: function(data, type, row) {
                        return '<span class="text-success font-weight-bold">' + data + '</span>';
                    }
                },
                {
                    data: "stok",
                    name: "stok",
                    render: function(data, type, row) {
                        let badgeClass = 'stock-high';
                        if (data < 10) badgeClass = 'stock-low';
                        else if (data < 50) badgeClass = 'stock-medium';

                        return '<span class="stock-badge ' + badgeClass + '">' + data + '</span>';
                    }
                },
                {
                    data: "satuan",
                    name: "satuan",
                    render: function(data, type, row) {
                        return '<span class="text-muted">' + data + '</span>';
                    }
                },
                {
                    data: "biaya_simpan",
                    name: "biaya_simpan",
                    render: function(data, type, row) {
                        return '<span class="text-warning font-weight-bold">' + data + '</span>';
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