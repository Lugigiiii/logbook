<?php
/* Smarty version 4.2.1, created on 2023-06-10 22:04:57
  from 'C:\Users\luigi\OneDrive\Web\repo_logbook\logbook\tpl\admin-topbar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_6484d769ece509_88753006',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '30a5399e875ac2dcd3e678ff26e4ab85763b15c7' => 
    array (
      0 => 'C:\\Users\\luigi\\OneDrive\\Web\\repo_logbook\\logbook\\tpl\\admin-topbar.tpl',
      1 => 1683486461,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6484d769ece509_88753006 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <form class="form-inline">
        <i class="fa fa-bars toggler" id="switchMobile"></i>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_smarty_tpl->tpl_vars['username']->value;?>
</span>
                <img class="img-profile rounded-circle"
                    src="../resources/img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Abmelden
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar --><?php }
}
