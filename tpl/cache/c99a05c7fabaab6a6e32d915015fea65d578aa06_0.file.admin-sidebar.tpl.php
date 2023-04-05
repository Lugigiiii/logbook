<?php
/* Smarty version 4.2.1, created on 2023-04-05 22:05:58
  from 'C:\Users\luigi\OneDrive\Web\repo_logbook\logbook\tpl\admin-sidebar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_642dd4a65b9688_53879283',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c99a05c7fabaab6a6e32d915015fea65d578aa06' => 
    array (
      0 => 'C:\\Users\\luigi\\OneDrive\\Web\\repo_logbook\\logbook\\tpl\\admin-sidebar.tpl',
      1 => 1680725157,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642dd4a65b9688_53879283 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fa-solid fa-car"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo $_smarty_tpl->tpl_vars['sitename']->value;?>
</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="/index.php?view=admin">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Fahrtenbuch</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Verwaltung
    </div>

    <!-- Nav Item - Users -->
    <li class="nav-item active">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Benutzer</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar --><?php }
}
