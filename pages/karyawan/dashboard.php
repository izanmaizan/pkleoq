<!-- pages/karyawan/dashboard.php  -->
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

    <title>EOQ - Dashboard Karyawan | PT Wings Group</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Wings Theme CSS for Karyawan -->
    <link rel="stylesheet" href="style.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon">
                    <img src="../../logo.svg" alt="Logo" style="width: 100px; height: auto;">
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Transaksi
            </div>

            <!-- Nav Item - Pembelian -->
            <li class="nav-item">
                <a class="nav-link" href="../pembelian/index.php">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Pembelian</span></a>
            </li>

            <!-- Nav Item - Penjualan -->
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

            <!-- Nav Item - Laporan (hanya pembelian dan penjualan) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#report" aria-expanded="true"
                    aria-controls="report">
                    <i class="fas fa-fw fa-chart-line"></i>
                    <span>Laporan</span>
                </a>
                <div id="report" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Jenis Laporan:</h6>
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
                                    <img src="../../logo.svg" alt="Logo" style="width: 80px; height: auto;">
                                    Dashboard Karyawan - Sistem EOQ
                                </h4>
                                <p class="mb-0 opacity-75">
                                    Halo, <strong><?= $_SESSION['name'] ?? $_SESSION['username']; ?></strong>!
                                    Kelola transaksi pembelian dan penjualan PT Wings Group Gudang Cabang Muara Bungo
                                </p>
                            </div>
                            <div class="d-none d-lg-block">
                                <i class="fas fa-user-tie fa-3x opacity-25"></i>
                            </div>
                        </div>
                    </div>

                    <?php
                    include '../../config/koneksi.php';

                    // Query untuk statistik yang diizinkan untuk karyawan
                    $queryBeli = mysqli_query($conn, "SELECT COUNT(*) AS total_row FROM ( SELECT kode_transaksi FROM transaksi_pembelian GROUP BY kode_transaksi ) AS subquery");
                    $queryJual = mysqli_query($conn, "SELECT COUNT(*) AS total_row FROM ( SELECT kd_transaksi FROM transaksi_penjualan GROUP BY kd_transaksi ) AS subquery");

                    // Query untuk data tambahan transaksi
                    $queryTotalNilaiPembelian = mysqli_query($conn, "SELECT SUM(total_harga) AS total_pembelian FROM transaksi_pembelian WHERE MONTH(tanggal) = MONTH(CURRENT_DATE()) AND YEAR(tanggal) = YEAR(CURRENT_DATE())");
                    $queryTotalNilaiPenjualan = mysqli_query($conn, "SELECT SUM(total_harga) AS total_penjualan FROM transaksi_penjualan WHERE MONTH(tanggal) = MONTH(CURRENT_DATE()) AND YEAR(tanggal) = YEAR(CURRENT_DATE())");

                    // Query untuk transaksi terbaru
                    $queryTransaksiBaru = mysqli_query($conn, "
                        SELECT 'Pembelian' as type, kode_transaksi as kode, tanggal, total_harga 
                        FROM transaksi_pembelian 
                        WHERE id IN (SELECT MIN(id) FROM transaksi_pembelian GROUP BY kode_transaksi)
                        UNION ALL
                        SELECT 'Penjualan' as type, kd_transaksi as kode, tanggal, total_harga 
                        FROM transaksi_penjualan 
                        WHERE id IN (SELECT MIN(id) FROM transaksi_penjualan GROUP BY kd_transaksi)
                        ORDER BY tanggal DESC 
                        LIMIT 8
                    ");

                    // Fetch data
                    $totalBeli = mysqli_fetch_assoc($queryBeli);
                    $totalJual = mysqli_fetch_assoc($queryJual);
                    $nilaiPembelian = mysqli_fetch_assoc($queryTotalNilaiPembelian);
                    $nilaiPenjualan = mysqli_fetch_assoc($queryTotalNilaiPenjualan);

                    $totalBeli = $totalBeli['total_row'];
                    $totalJual = $totalJual['total_row'];
                    $pembelianBulanIni = $nilaiPembelian['total_pembelian'] ?? 0;
                    $penjualanBulanIni = $nilaiPenjualan['total_penjualan'] ?? 0;
                    ?>

                    <!-- Content Row - Statistics Cards -->
                    <div class="row">

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2 card-stats">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                <i class="fas fa-shopping-cart me-1"></i>Total Pembelian
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo number_format($totalBeli) ?></div>
                                            <div class="small text-muted mb-2">Bulan ini: Rp
                                                <?php echo number_format($pembelianBulanIni) ?></div>
                                            <div class="mt-2">
                                                <a href="../pembelian/index.php" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye me-1"></i> Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shopping-cart stats-icon text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2 card-stats">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                <i class="fas fa-cash-register me-1"></i>Total Penjualan
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo number_format($totalJual) ?></div>
                                            <div class="small text-muted mb-2">Bulan ini: Rp
                                                <?php echo number_format($penjualanBulanIni) ?></div>
                                            <div class="mt-2">
                                                <a href="../penjualan/index.php" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-eye me-1"></i> Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cash-register stats-icon text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2 card-stats">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                <i class="fas fa-chart-line me-1"></i>Laporan Pembelian
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <i class="fas fa-file-alt fa-2x"></i>
                                            </div>
                                            <div class="small text-muted mb-2">Akses laporan pembelian</div>
                                            <div class="mt-2">
                                                <a href="../laporan/laporan_pembelian.php"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fas fa-file-alt me-1"></i> Buka Laporan
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-alt stats-icon text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2 card-stats">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                <i class="fas fa-chart-bar me-1"></i>Laporan Penjualan
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <i class="fas fa-chart-bar fa-2x"></i>
                                            </div>
                                            <div class="small text-muted mb-2">Akses laporan penjualan</div>
                                            <div class="mt-2">
                                                <a href="../laporan/laporan_penjualan.php"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-chart-bar me-1"></i> Buka Laporan
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chart-bar stats-icon text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row - Transaksi Terbaru -->
                    <div class="row">

                        <!-- Transaksi Terbaru -->
                        <div class="col-xl-12">
                            <div class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-history me-2"></i>Transaksi Terbaru
                                    </h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Aksi Cepat:</div>
                                            <a class="dropdown-item" href="../pembelian/index.php">
                                                <i class="fas fa-shopping-cart me-2"></i>Semua Pembelian
                                            </a>
                                            <a class="dropdown-item" href="../penjualan/index.php">
                                                <i class="fas fa-cash-register me-2"></i>Semua Penjualan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th><i class="fas fa-tag me-1"></i>Jenis</th>
                                                    <th><i class="fas fa-barcode me-1"></i>Kode</th>
                                                    <th><i class="fas fa-calendar me-1"></i>Tanggal</th>
                                                    <th><i class="fas fa-money-bill-wave me-1"></i>Nilai</th>
                                                    <th><i class="fas fa-cog me-1"></i>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (mysqli_num_rows($queryTransaksiBaru) > 0): ?>
                                                <?php while ($transaksi = mysqli_fetch_assoc($queryTransaksiBaru)): ?>
                                                <tr>
                                                    <td>
                                                        <span
                                                            class="badge badge-<?php echo $transaksi['type'] == 'Pembelian' ? 'info' : 'warning' ?>">
                                                            <i
                                                                class="fas fa-<?php echo $transaksi['type'] == 'Pembelian' ? 'shopping-cart' : 'cash-register' ?> me-1"></i>
                                                            <?php echo $transaksi['type'] ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <code class="text-dark"><?php echo $transaksi['kode'] ?></code>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            <?php echo date('d/m/Y', strtotime($transaksi['tanggal'])) ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <span class="font-weight-bold text-success">
                                                            Rp <?php echo number_format($transaksi['total_harga']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="../<?php echo strtolower($transaksi['type']) ?>/index.php"
                                                            class="btn btn-sm btn-outline-<?php echo $transaksi['type'] == 'Pembelian' ? 'info' : 'warning' ?>">
                                                            <i class="fas fa-eye me-1"></i>Lihat
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">
                                                        <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                                                        Belum ada transaksi
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
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
                            (Karyawan)
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
                        <i class="fas fa-sign-out-alt me-2"></i>Konfirmasi Logout
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
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <a class="btn btn-danger" href="../auth/endSession.php">
                        <i class="fas fa-sign-out-alt me-1"></i>Ya, Logout
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

    <script>
    $(document).ready(function() {
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

        // Add ripple effect to buttons
        $('.btn').on('click', function(e) {
            var ripple = $('<span class="btn-ripple"></span>');
            $(this).append(ripple);

            setTimeout(function() {
                ripple.remove();
            }, 600);
        });

        // Stats counter animation
        $('.card-stats .h5').each(function() {
            var $this = $(this);
            var countTo = parseInt($this.text().replace(/,/g, ''));

            if (!isNaN(countTo)) {
                $({
                    countNum: 0
                }).animate({
                    countNum: countTo
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.floor(this.countNum).toLocaleString());
                    },
                    complete: function() {
                        $this.text(countTo.toLocaleString());
                    }
                });
            }
        });
    });
    </script>

</body>

</html>