<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-book"></i>
            </div>
            <div class="sidebar-brand-text mx-3">PERPUSTAKAN</div>
        </a>



        <!-- QUERY MENU -->
        <?php
        $role_id = $this->session->userdata('role_id');
        $queryMenu = "SELECT `user_menu`. `id`, `menu`
          FROM `user_menu` JOIN `user_access_menu`
          ON `user_menu`.`id` = `user_access_menu`.`menu_id`
          WHERE `user_access_menu`.`role_id` = `role_id`
          ORDER BY `user_access_menu`.`menu_id` ASC
           ";
        $menu = $this->db->query($queryMenu)->result_array();
        ?>


        <!-- LOOPING MENU -->
        <?php foreach ($menu as $m) : ?>
            <div class="sidebar-heading">
                <?= $m['menu']; ?>
            </div>

            <!-- SIAPKAN SUB-MENU SESUAI MENU-->
            <?php
            $menuId = $m['id'];
            $querySubMenu = "SELECT *
          FROM `user_sub_menu` JOIN `user_menu`
          ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
          WHERE `user_sub_menu`.`menu_id` = $menuId
          AND `user_sub_menu`.`is_active` = 1
          ";
            $subMenu = $this->db->query($querySubMenu)->result_array();
            ?>
            <?php foreach ($subMenu as $sm) : ?>

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= $sm['url']; ?>">
                        <i class="<?= $sm['icon']; ?>"></i>
                        <span><?= $sm['title']; ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <!-- Divider Dashboard -->
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/index'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>


        <!-- Master Buku -->
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Master Buku</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Master Buku:</h6>
                    <a class="collapse-item fas fa-fw fa-book" href="<?= base_url('admin/buku'); ?>"> Data Buku</a>
                    <a class="collapse-item fas fa-fw fa-th-list" href="<?= base_url('admin/kategori'); ?>"> Kategori Buku</a>
                    <a class="collapse-item fas fa-fw fa-th-list" href="<?= base_url('admin/peminjaman'); ?>"> Peminjaman Buku</a>
                </div>
            </div>
        </li>

        <!-- Divider Perpustakaan -->
        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/anggota'); ?>">
                <i class="fas fa-fw fa-sign-out-alt fa-fw"></i>
                <span>Anggota Perpustakaan</span></a>
        </li>

        <!-- Divider Logout -->
        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
                <i class="fas fa-fw fa-sign-out-alt fa-fw"></i>
                <span>Logout</span></a>
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

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $users['email']; ?></span>
                            <img class="img-profile rounded-circle" src="<?= base_url('assets/img/profile') . $users['image']; ?>">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                My Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('auth/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->