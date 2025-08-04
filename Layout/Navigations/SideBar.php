<?php
$current_page = $_SERVER['REQUEST_URI'];
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= BASE_URL ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">LAMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= BASE_URL ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <?php
                        $typeView = isset($_SESSION['usertype']) ? htmlspecialchars($_SESSION['usertype']) : 'Guest';
                        $userView = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';

                        echo "$userView ($typeView)";
                    ?>
                </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- HOME Section -->
                <li class="nav-item <?= strpos($current_page, '/Attendance') !== false || strpos($current_page, '/Attendance') !== false ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= strpos($current_page, '/index.html') !== false || strpos($current_page, '/Attendance') !== false ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            HOME
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= BASE_URL ?>/Attendance/Dashboard" class="nav-link <?= strpos($current_page, '/Attendance/Dashboard') !== false ? 'active' : '' ?>">
                                <i class="fas fa-tachometer-alt nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= BASE_URL ?>/Attendance/AttendanceList" class="nav-link <?= strpos($current_page, '/Attendance/AttendanceList') !== false ? 'active' : '' ?>">
                                <i class="fas fa-calendar-check nav-icon"></i>
                                <p>Attendance</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- MANAGE Section -->
                <li class="nav-item <?= strpos($current_page, '/manage/') !== false ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= strpos($current_page, '/manage/') !== false ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            MANAGE
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                            if($typeView == 'Administrator'){
                                include 'UserManage.php';
                            }
                        ?>
                        <li class="nav-item">
                            <a href="<?= BASE_URL ?>/manage/courses" class="nav-link <?= strpos($current_page, '/manage/courses') !== false ? 'active' : '' ?>">
                                <i class="fas fa-book nav-icon"></i>
                                <p>Courses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= BASE_URL ?>/manage/students" class="nav-link <?= strpos($current_page, '/manage/students') !== false ? 'active' : '' ?>">
                                <i class="fas fa-user-graduate nav-icon"></i>
                                <p>Students</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- TOOLS Section -->
                <li class="nav-item <?= strpos($current_page, '/tools/') !== false || $current_page === BASE_URL . '/' ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= strpos($current_page, '/tools/') !== false || $current_page === BASE_URL . '/' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>
                            TOOLS
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= BASE_URL ?>/" class="nav-link <?= $current_page === '/' || $current_page === BASE_URL . '/' ? 'active' : '' ?>">
                                <i class="fas fa-qrcode nav-icon"></i>
                                <p>QR Scanner</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
