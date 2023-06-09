<!DOCTYPE html>
<html lang="de">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{$sitename}</title>
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
                                        {if isset($logo)}<img src="{$logo}" alt="Client Logo" style="margin: 20px; max-width: 200px; max-height: auto;">{/if}
                                        <h1 class="h4 text-gray-900 mb-4">{$mail} <br />Kennwort setzen</h1>
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
    <script src="../resources/vendor/jquery/jquery.min.js"></script>
    <script src="../resources/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../resources/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../resources/js/sb-admin-2.min.js"></script>

</body>
<script>
    
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
            data: "changePwd=true&activation_token={$token}&mail={$mail}&inpPwd1="+pwd1+"&inpPwd2="+pwd2,  
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
    
</script>
</html>