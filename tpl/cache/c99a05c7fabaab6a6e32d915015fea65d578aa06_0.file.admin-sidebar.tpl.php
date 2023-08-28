<?php
/* Smarty version 4.2.1, created on 2023-08-28 18:31:21
  from 'C:\Users\luigi\OneDrive\Web\repo_logbook\logbook\tpl\admin-sidebar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64eccbd9dd3cf6_71030524',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c99a05c7fabaab6a6e32d915015fea65d578aa06' => 
    array (
      0 => 'C:\\Users\\luigi\\OneDrive\\Web\\repo_logbook\\logbook\\tpl\\admin-sidebar.tpl',
      1 => 1693235954,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64eccbd9dd3cf6_71030524 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
            <i class="fa-solid fa-car"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo $_smarty_tpl->tpl_vars['sitename']->value;?>
</div>
    </a>
    <?php if ($_smarty_tpl->tpl_vars['admin']->value == true) {?>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item" id="element1">
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
    <li class="nav-item" id="element2">
        <a class="nav-link" href="index.php?view=admin-users">
            <i class="fas fa-fw fa-table"></i>
            <span>Benutzer</span></a>
    </li>

    <!-- Nav Item - Cars -->
    <li class="nav-item" id="element3">
        <a class="nav-link" href="index.php?view=admin-cars">
            <i class="fas fa-fw fa-car"></i>
            <span>Autos</span></a>
    </li>
    <?php }?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Get Back -->
    <div class="sidebar-heading">
        Menu
    </div>
    <li class="nav-item">
        <a class="nav-link" href="index.php?view=mobile">
            <i class="fas fa-solid fa-rotate-left"></i>
            <span>Zurück zur Mobile-Seite</span></a>
    </li>

</ul>
<!-- End of Sidebar -->
<?php }
}
