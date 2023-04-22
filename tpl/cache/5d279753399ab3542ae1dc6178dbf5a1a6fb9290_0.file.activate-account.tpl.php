<?php
/* Smarty version 4.2.1, created on 2023-04-22 20:39:11
  from 'C:\Users\luigi\OneDrive\Web\repo_logbook\logbook\tpl\activate-account.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_644429cf814d42_46916919',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5d279753399ab3542ae1dc6178dbf5a1a6fb9290' => 
    array (
      0 => 'C:\\Users\\luigi\\OneDrive\\Web\\repo_logbook\\logbook\\tpl\\activate-account.tpl',
      1 => 1682188735,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_644429cf814d42_46916919 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="de">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $_smarty_tpl->tpl_vars['sitename']->value;?>
</title>
    <link rel=icon href=https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6/svgs/solid/car.svg>

    <!-- Custom fonts for this template-->
    <link href="../resources/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../resources/css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <?php if ((isset($_smarty_tpl->tpl_vars['logo']->value))) {?><img src="<?php echo $_smarty_tpl->tpl_vars['logo']->value;?>
" alt="Client Logo" style="margin: 20px; max-width: 200px; max-height: auto;"><?php }?>
                                        <h1 class="h4 text-gray-900 mb-4"><?php echo $_smarty_tpl->tpl_vars['mail']->value;?>
 <br />Kennwort setzen</h1>
                                    </div>
                                    <form class="user" id="pwdForm" method="post">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="inpPwd-1" placeholder="Passwort eingeben" name="inpPwd-1" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="inpPwd-2" placeholder="Erneut eingeben" name="inpPwd-2" required>
                                        </div>
                                        <button type="submit" name="btnPassword" id="btnPassword" class="btn btn-primary btn-user btn-block">Speichern</button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
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

</body>
<?php echo '<script'; ?>
>
    
    "use strict";

    $(document).ready(function(){
        $.ajaxSetup({ cache: false }); // or iPhones don't get fresh data
    });

    
    $( "#btnPassword" ).click(function() {
        var pwd1 = document.getElementById('inpPwd-1').value;
        var pwd2 = document.getElementById('inpPwd-2').value;
        var form = document.getElementById('pwdForm').innerHTML;

        $.ajax({
            type: 'POST',
            url: 'resources/php/functions/main-functions.php?',      
            data: "changePwd=true&activation_token=<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
&mail=<?php echo $_smarty_tpl->tpl_vars['mail']->value;?>
&inpPwd1="+pwd1+"&inpPwd2="+pwd2,  
            success: function (response) {
                document.getElementById('pwdForm').innerHTML = form + response;
                location.reload();
                return;
            },
            error: function () {
                document.getElementById('pwdForm').innerHTML = form + response;
                location.reload();
                return;

            }
        });
    });
    
<?php echo '</script'; ?>
>
</html><?php }
}
