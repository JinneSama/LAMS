<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Store the current page so we can return after login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: /lams/security/login.php"); // or login.html if you must
    exit;
}
define('BASE_URL', '/lams');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'LAMS' ?></title>
    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/dist/css/adminlte.min.css">
    <script src="https://cdn.syncfusion.com/ej2/25.2.3/dist/ej2.min.js"></script>
    <script src="https://cdn.syncfusion.com/ej2/25.2.3/dist/ej2-pdf-export.min.js"></script>
    <link href="https://cdn.syncfusion.com/ej2/25.2.3/material.css" rel="stylesheet">
    <script src="https://cdn.syncfusion.com/ej2/25.2.3/dist/ej2-grids.min.js"></script>
    <script src="https://cdn.syncfusion.com/ej2/25.2.3/dist/ej2-toolbar.min.js"></script>
    <script>
        ej.base.registerLicense('Ngo9BigBOggjHTQxAR8/V1NBaF1cWmhIfEx1RHxQdld5ZFRHallYTnNWUj0eQnxTdEBjXn1ZcHxVT2JeWUZ1W0lfZg=='); // Replace with your actual license key
    </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= BASE_URL ?>/images/ama2.png" alt="AdminLTELogo" height="60" width="120">
        </div>
        <?php
        include 'Navigations/NavBar.php';
        include 'Navigations/Sidebar.php';
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active"><?= $title ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?= $content ?>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

        <?php include 'Navigations/Footer.php'; ?>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- jQuery -->
    <script src="<?= BASE_URL ?>/plugins/jquery/jquery.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= BASE_URL ?>/dist/js/adminlte.js"></script>
    <script src="<?= BASE_URL ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="<?= BASE_URL ?>/dist/js/pages/dashboard.js"></script>
</body>

</html>