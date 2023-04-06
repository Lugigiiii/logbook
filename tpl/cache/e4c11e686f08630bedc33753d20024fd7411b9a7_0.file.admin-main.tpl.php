<?php
/* Smarty version 4.2.1, created on 2023-04-06 21:55:36
  from 'C:\Users\luigi\OneDrive\Web\repo_logbook\logbook\tpl\admin-main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_642f23b8eb99a9_22907133',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e4c11e686f08630bedc33753d20024fd7411b9a7' => 
    array (
      0 => 'C:\\Users\\luigi\\OneDrive\\Web\\repo_logbook\\logbook\\tpl\\admin-main.tpl',
      1 => 1680810933,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin-sidebar.tpl' => 1,
    'file:admin-topbar.tpl' => 1,
  ),
),false)) {
function content_642f23b8eb99a9_22907133 (Smarty_Internal_Template $_smarty_tpl) {
?><body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php $_smarty_tpl->_subTemplateRender("file:admin-sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php $_smarty_tpl->_subTemplateRender("file:admin-topbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Fahrtenbuch <?php echo $_smarty_tpl->tpl_vars['companyname']->value;?>
</h1>

                    <!-- DataTable -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Eingetragene Fahrten</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Datum</th>
                                            <th>Start</th>
                                            <th>Ende</th>
                                            <th>Fahrzeug</th>
                                            <th>Kilometer</th>
                                            <th>Strecke</th>
                                            <th>Mitarbeiter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

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
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <?php echo '<script'; ?>
 src="../resources/vendor/jquery/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="../resources/vendor/bootstrap/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>

    <!-- Core plugin JavaScript-->
    <?php echo '<script'; ?>
 src="../resources/vendor/jquery-easing/jquery.easing.min.js"><?php echo '</script'; ?>
>

    <!-- Custom scripts for all pages-->
    <?php echo '<script'; ?>
 src="../resources/js/sb-admin-2.min.js"><?php echo '</script'; ?>
>

    <!-- Page level plugins -->
    <?php echo '<script'; ?>
 src="../resources/vendor/datatables/jquery.dataTables.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="../resources/vendor/datatables/dataTables.bootstrap4.min.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
>
        $(document).ready( function () {
            $('#dataTable').DataTable({
                data:<?php echo $_smarty_tpl->tpl_vars['data']->value;?>

            });
        } );
    <?php echo '</script'; ?>
>
</body><?php }
}
