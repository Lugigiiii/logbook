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
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Sign-in {$sitename}</h1>
                                        {if isset($logo)}<img src="{$logo}" alt="Client Logo" style="margin: 20px; max-width: 200px; max-height: auto;">{/if}
                                        <div id="alert"></div>
                                    </div>
                                    <form class="user" id="loginForm" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="inpUsername" aria-describedby="username"
                                                placeholder="Benutzername" name="inpUsername">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="inpPassword" placeholder="Passwort" name="inpPassword">
                                        </div>
                                        <button type="button" name="btnLogin" id="btnLogin" class="btn btn-primary btn-user btn-block">Login</button>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="../resources/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../resources/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../resources/js/sb-admin-2.min.js"></script>
    {literal}

    <script>

        $(document).ready(function() {
            $('#loginForm').keypress(function(e){if(e.which==13){e.preventDefault();$('#loginForm').find('#btnLogin').click();}});

            $("#btnLogin").click(function() {
                var uname = document.getElementById('inpUsername').value;
                var pwd = document.getElementById('inpPassword').value;  
    
                $.ajax({
                    type: 'POST',
                    url: '../resources/php/functions/main-functions.php?',      
                    //data: "inpUsername="+uname+"&inpPassword="+pwd,
                    data : {
                        inpUsername: uname,
                        inpPassword: pwd
                    },
                    dataType: 'json'
                })
                .done(function(data, textStatus, jqXHR){
                        if (data.status === 'success') {
                            //console.log('Authentication successful:', data.message);
                            document.getElementById("alert").innerHTML = '<div class="alert alert-success" role="alert">Anmeldung erfolgreich.</div>';
                            location.reload();
                        } else {
                            document.getElementById("alert").innerHTML = '<div class="alert alert-danger" role="alert">Benutzername oder Kennwort falsch.</div>';
                            document.getElementById("loginForm").reset();
                        }
                })
                .fail(function(jqXHR, textStatus, errorThrown){
                    console.log('AJAX Error:', textStatus); // Log the error status
                    console.log('Error details:', errorThrown); // Log the error details
                });
    
            });
        });
        
    
    
        if (typeof navigator.serviceWorker !== 'undefined') {
            navigator.serviceWorker.register('/sw.js')
        }
    
    </script>
    {/literal}

</body>
</html>