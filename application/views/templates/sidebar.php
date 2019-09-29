<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fab fa-linux"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Tux page</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- QUERY MENU -->

    <?php

    $roleId = $this->session->userdata('role_id');

    $menuQuery = "SELECT `user_menu`.*
                FROM `user_menu` JOIN `user_access_menu` 
                ON `user_access_menu`.`menu_id` = `user_menu`.`id` 
                WHERE `user_access_menu`.`role_id` = $roleId 
                ORDER BY `user_access_menu`.`menu_id` ASC";

    $menu = $this->db->query($menuQuery)->result_array();

    // LOOPING MENU

    foreach ($menu as $m) : ?>

        <!-- Heading -->
        <div class="sidebar-heading">
            <?= $m['menu']; ?>
        </div>

        <!-- SUB MENU QUERY -->
        <?php
        // $menuId = $m['id'];
        $subMenuQuery = "SELECT * FROM `user_sub_menu` WHERE `menu_id` = {$m['id']} AND `is_active` = 1 ";

        $subMenu = $this->db->query($subMenuQuery)->result_array();


        foreach ($subMenu as $sm) : ?>
            <!-- Nav Item - Dashboard -->
            <?php if ($sm['title'] == $title) : ?>
                <li class="nav-item active">
                <?php else : ?>
                <li class="nav-item">
                <?php endif; ?>
                <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
                    <i class="<?= $sm['icon']; ?>"></i>
                    <span><?= $sm['title']; ?></span></a>
            </li>
        <?php endforeach; ?>

        <!-- Divider -->
        <hr class="sidebar-divider mt-3">

    <?php endforeach; ?>

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-fw"></i>
            <span>Logout</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->