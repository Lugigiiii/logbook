<?php
/* Smarty version 4.2.1, created on 2023-06-12 21:41:56
  from 'C:\Users\luigi\OneDrive\Web\repo_logbook\logbook\tpl\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64877504052027_93997358',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '923a21640e6bdaa7c3dddc680aa345d503715e30' => 
    array (
      0 => 'C:\\Users\\luigi\\OneDrive\\Web\\repo_logbook\\logbook\\tpl\\login.tpl',
      1 => 1684424783,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64877504052027_93997358 (Smarty_Internal_Template $_smarty_tpl) {
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
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Hey! Bitte anmelden</h1>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['logo']->value))) {?><img src="<?php echo $_smarty_tpl->tpl_vars['logo']->value;?>
" alt="Client Logo" style="margin: 20px; max-width: 200px; max-height: auto;"><?php }?>
                                    </div>
                                    <form class="user" id="loginForm" method="post" action="resources/php/functions/main-functions.php">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="inpUsername" aria-describedby="username"
                                                placeholder="Benutzername" name="inpUsername">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="inpPassword" placeholder="Passwort" name="inpPassword">
                                        </div>
                                        <button type="submit" name="btnLogin" class="btn btn-primary btn-user btn-block">Login</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                    </div>
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
    /*
    $(document).ready(function(){
        $.ajaxSetup({ cache: false }); // or iPhones don't get fresh data
    });

    
    $( "#btnLogin" ).click(function() {
        var uname = document.getElementById('inpUsername').value;
        var pwd = document.getElementById('inpPassword').value;  

        $.ajax({
            type: 'POST',
            url: 'resources/php/functions/main-functions.php?',      
            data: "inpUsername="+uname+"&inpPassword="+pwd,
            dataType: 'HTML',
            success: function (response) {
                console.log("ok");
            },
            error: function () {
                console.log("error");
                alert("Unable to perform login");
            }
        });

        $(location).prop('href', '/index.php?view=loggedin');
        location.reload();
    });
    */


    if (typeof navigator.serviceWorker !== 'undefined') {
        navigator.serviceWorker.register('/sw.js')
    }

<?php echo '</script'; ?>
>

</html><?php }
}
