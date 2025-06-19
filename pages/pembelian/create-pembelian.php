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

    <title>EOQ - Tambah Pembelian | PT Wings Group</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Select2 -->
    <link rel="stylesheet" href="../../vendor/select2/select2-bootstrap4.css">
    <link rel="stylesheet" href="../../vendor/select2/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="../../css/select2.min.css">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="../../css/sweetalert2.min.css">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />

    <!-- Wings Theme CSS -->
    <link rel="stylesheet" href="style-create.css">

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
                                    <i class="fas fa-plus-circle fa-2x me-3"></i>
                                    Tambah Transaksi Pembelian
                                </h4>
                                <p class="mb-0 opacity-75">
                                    Buat transaksi pembelian baru untuk produk PT Wings Group Indonesia
                                </p>
                            </div>
                            <div class="d-none d-lg-block">
                                <i class="fas fa-clipboard-list fa-3x opacity-25"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="card mb-3 shadow card-stats">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-shopping-cart me-2"></i> Form Transaksi Pembelian
                            </h6>
                        </div>

                        <?php
                        function generateKodeTrans()
                        {
                            $prefix = 'KD-TRS-B';
                            $random_number = mt_rand(0, 99999999999);
                            $random_number_padded = str_pad($random_number, 11, '0', STR_PAD_LEFT);
                            $product_code = $prefix . $random_number_padded;
                            return $product_code;
                        }

                        include '../../config/koneksi.php';

                        $data_produk = mysqli_query($conn, "SELECT p.*, s.nama_satuan FROM produk AS p INNER JOIN satuan AS s ON p.satuan_id = s.id");
                        $data_supplier = mysqli_query($conn, "SELECT * FROM supplier");

                        ?>

                        <div class="card-body">
                            <form action="add-pembelian.php" method="POST">
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <label for="kd_transaksi" class="form-label">
                                            <i class="fas fa-barcode me-1"></i> Kode Transaksi
                                        </label>
                                        <input type="text" class="form-control" id="kd_transaksi" name="kd_transaksi"
                                            value="<?= generateKodeTrans() ?>" readonly required>
                                        <small class="form-text text-muted">Kode transaksi akan digenerate
                                            otomatis</small>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="tgl" class="form-label">
                                            <i class="fas fa-calendar me-1"></i> Tanggal Pembelian
                                        </label>
                                        <input type="date" class="form-control" id="tgl" name="tgl"
                                            value="<?= date('Y-m-d') ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="user" class="form-label">
                                            <i class="fas fa-user me-1"></i> PIC (Person In Charge)
                                        </label>
                                        <input type="text" id="user_id" name="user_id"
                                            value="<?php echo $_SESSION['id']; ?>">
                                        <input type="text" class="form-control" id="user" name="user"
                                            value="<?php echo $_SESSION['name'] ?? $_SESSION['username']; ?>" readonly
                                            required>
                                        <small class="form-text text-muted">User yang bertanggung jawab atas transaksi
                                            ini</small>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="supplier_id" class="form-label">
                                            <i class="fas fa-truck me-1"></i> Supplier
                                        </label>
                                        <select class="form-control supplier" id="supplier_id" name="supplier_id"
                                            aria-label="Default select example" required>
                                            <option selected disabled value="">-- Pilih Supplier --</option>
                                            <?php
                                            while ($sup = mysqli_fetch_array($data_supplier)) {
                                            ?>
                                            <option value="<?php echo $sup['id']; ?>">
                                                <?php echo $sup['kode_sup']; ?> -
                                                <?php echo $sup['nama_sup']; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="keterangan">
                                                <i class="fas fa-file-alt me-1"></i> Keterangan
                                            </label>
                                            <input class="form-control" type="text" name="keterangan" id="keterangan"
                                                placeholder="Masukkan keterangan transaksi (opsional)">
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="font-weight-bold text-primary">
                                                <i class="fas fa-list me-2"></i> Detail Produk
                                            </h6>
                                            <button type="button" class="btn btn-primary btn-sm" id="tambahRow">
                                                <i class="fas fa-plus me-1"></i> Tambah Item
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataBeli" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th width="35%"><i class="fas fa-box me-1"></i> Produk</th>
                                                        <th width="15%"><i class="fas fa-balance-scale me-1"></i> Satuan
                                                        </th>
                                                        <th width="20%"><i class="fas fa-money-bill-wave me-1"></i>
                                                            Harga
                                                        </th>
                                                        <th width="15%"><i class="fas fa-sort-numeric-up me-1"></i> Qty
                                                            Masuk</th>
                                                        <th width="15%"><i class="fas fa-cogs me-1"></i> Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center text-muted">
                                                        <td colspan="5" class="py-4">
                                                            <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                                                            Belum ada item yang ditambahkan
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <a href="index.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Simpan Transaksi
                            </button>
                        </div>
                        </form>
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

    <!-- Select2 -->
    <script src="../../js/select2.min.js"></script>

    <!-- Script untuk fungsi crud -->
    <script>
    $(document).ready(function() {

        $('.supplier').select2({
            theme: 'bootstrap4',
            placeholder: '-- Pilih Supplier --',
            allowClear: true
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

        function deleteRow(button) {
            button.closest("tr").remove();

            // Jika tidak ada row lagi, tampilkan pesan kosong
            if ($("#dataBeli tbody tr").length === 0) {
                $("#dataBeli tbody").html(`
                <tr class="text-center text-muted">
                    <td colspan="5" class="py-4">
                        <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                        Belum ada item yang ditambahkan
                    </td>
                </tr>
            `);
            }
        }

        function formatRupiah(angka) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp ' + rupiah;
        }

        $("#tambahRow").click(function() {
            var tableBody = $("#dataBeli tbody");

            // Hapus pesan kosong jika ada
            if (tableBody.find('.text-muted').length) {
                tableBody.empty();
            }

            // Mengirim permintaan AJAX untuk mendapatkan opsi select
            $.ajax({
                url: 'get-data.php',
                method: 'GET',
                beforeSend: function() {
                    $("#tambahRow").prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin me-1"></i> Loading...');
                },
                success: function(data) {
                    try {
                        data = JSON.parse(data);
                        console.log('Data produk loaded:', data);

                        var newRow = $("<tr>");
                        var uniqueId = 'produk_select_' + Date.now() + '_' + Math.floor(Math
                            .random() * 1000);

                        newRow.html(`
                        <td>
                            <select class="form-control produk-select" id="${uniqueId}" name="produk_id[]" required>
                                <option value="">-- Pilih Produk --</option>
                                ${data.map(item => `<option value="${item.id}" data-satuan="${item.satuan_id}" data-nama="${item.nama_satuan}" data-harga="${item.harga}">${item.kode_produk} - ${item.nama_produk}</option>`).join('')}
                            </select>
                        </td>
                        <td>
                            <input type="hidden" class="form-control satuan-id" name="satuan_id[]">
                            <input type="text" class="form-control nama-satuan" readonly placeholder="Satuan akan muncul">
                        </td>
                        <td>
                            <input type="hidden" class="form-control harga-hidden" name="harga[]">
                            <input type="text" class="form-control harga-display" readonly placeholder="Harga akan muncul">
                        </td>
                        <td>
                            <input type="number" class="form-control qty" min="1" name="qty[]" placeholder="Jumlah" required>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm delete-row" title="Hapus item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `);

                        tableBody.append(newRow);

                        // Inisialisasi Select2 untuk element yang baru dibuat
                        var newSelect = $('#' + uniqueId);

                        // Tunggu DOM ready kemudian inisialisasi Select2
                        setTimeout(function() {
                            // Destroy existing select2 if any
                            if (newSelect.hasClass('select2-hidden-accessible')) {
                                newSelect.select2('destroy');
                            }

                            // Initialize Select2
                            newSelect.select2({
                                theme: 'bootstrap4',
                                placeholder: '-- Pilih Produk --',
                                allowClear: true,
                                width: '100%'
                            });

                            console.log('Select2 initialized for:', uniqueId);

                            // Event listener untuk Select2 selection
                            newSelect.on('select2:select', function(e) {
                                console.log('Product selected via Select2');
                                handleProductSelection($(this));
                            });

                            // Event listener untuk Select2 clear
                            newSelect.on('select2:clear', function(e) {
                                console.log('Product selection cleared');
                                clearProductData($(this));
                            });

                            // Fallback: Event listener untuk native change (jika Select2 gagal)
                            newSelect.on('change', function() {
                                console.log(
                                    'Product selected via native change event'
                                );
                                if ($(this).val()) {
                                    handleProductSelection($(this));
                                } else {
                                    clearProductData($(this));
                                }
                            });

                        }, 150); // Delay untuk memastikan DOM ready

                        // Event listener untuk tombol hapus
                        newRow.find(".delete-row").on('click', function() {
                            // Destroy Select2 before removing row
                            var selectElement = newRow.find('.produk-select');
                            if (selectElement.hasClass(
                                    'select2-hidden-accessible')) {
                                selectElement.select2('destroy');
                            }
                            deleteRow($(this));
                        });

                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memproses data produk: ' +
                                e.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', {
                        xhr: xhr,
                        status: status,
                        error: error,
                        responseText: xhr.responseText
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat memuat data produk: ' + error
                    });
                },
                complete: function() {
                    $("#tambahRow").prop('disabled', false).html(
                        '<i class="fas fa-plus me-1"></i> Tambah Item');
                }
            });
        });

        // Fungsi untuk menangani pemilihan produk
        function handleProductSelection(selectElement) {
            var row = selectElement.closest("tr");
            var satuanInput = row.find(".satuan-id");
            var namaSatuanInput = row.find(".nama-satuan");
            var hargaHidden = row.find(".harga-hidden");
            var hargaDisplay = row.find(".harga-display");

            // Ambil data dari option yang dipilih
            var selectedOption = selectElement.find("option:selected");
            var productId = selectElement.val();
            var satuan = selectedOption.data("satuan");
            var namaSatuan = selectedOption.data("nama");
            var harga = selectedOption.data("harga");

            console.log('Product selection data:', {
                productId: productId,
                productText: selectedOption.text(),
                satuan: satuan,
                namaSatuan: namaSatuan,
                harga: harga
            });

            if (productId && satuan && namaSatuan && harga) {
                // Set nilai ke input
                satuanInput.val(satuan);
                namaSatuanInput.val(namaSatuan);
                hargaHidden.val(harga);
                hargaDisplay.val(formatRupiah(harga));

                console.log('Data successfully set to inputs');
            } else {
                console.warn('Missing product data:', {
                    satuan,
                    namaSatuan,
                    harga
                });
            }
        }

        // Fungsi untuk membersihkan data produk
        function clearProductData(selectElement) {
            var row = selectElement.closest("tr");
            row.find(".satuan-id").val('');
            row.find(".nama-satuan").val('');
            row.find(".harga-hidden").val('');
            row.find(".harga-display").val('');
        }

        // Validasi form sebelum submit
        $('form').on('submit', function(e) {
            var hasItems = $("#dataBeli tbody tr").length > 0 && !$("#dataBeli tbody .text-muted")
                .length;

            if (!hasItems) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Minimal harus ada satu item produk dalam transaksi!'
                });
                return false;
            }

            // Validasi tambahan: pastikan semua select produk terisi
            var emptySelects = 0;
            var invalidData = 0;

            $('.produk-select').each(function() {
                var productId = $(this).val();
                var row = $(this).closest("tr");
                var qty = row.find('.qty').val();

                if (!productId || productId === '') {
                    emptySelects++;
                }

                if (!qty || qty <= 0) {
                    invalidData++;
                }
            });

            if (emptySelects > 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Semua produk harus dipilih sebelum menyimpan transaksi!'
                });
                return false;
            }

            if (invalidData > 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Semua quantity harus diisi dengan nilai yang valid!'
                });
                return false;
            }

            // Debug: Log semua data yang akan dikirim
            console.log('=== FORM SUBMISSION DATA ===');
            $('.produk-select').each(function(index) {
                var row = $(this).closest("tr");
                console.log('Item ' + (index + 1) + ':', {
                    productId: $(this).val(),
                    productText: $(this).find('option:selected').text(),
                    satuanId: row.find('.satuan-id').val(),
                    satuan: row.find('.nama-satuan').val(),
                    harga: row.find('.harga-hidden').val(),
                    qty: row.find('.qty').val()
                });
            });
            console.log('=== END FORM DATA ===');
        });
    });
    </script>

</body>

</html>