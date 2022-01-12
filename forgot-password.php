<?php
include_once 'includes/class.login.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Passwort vergessen</title>
    <link rel="stylesheet" href="loginfiles/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="loginfiles/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="loginfiles/css/styles.min.css">
</head>

<body class="bg-gradient-primary" style="background: rgb(255,163,164);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-password-image" style="background: url('./loginfiles/img/food.webp') center / cover;"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                <?php
                                if(isset($_GET["error"]))
                                    {
                                        $error_msg = $_GET["error"];
                                        if($error_msg == 1)
                                        {
                                            echo '<p class="alert alert-success">Für weitere Anweisungen wurde eine E-Mail gesendet.</p>';
                                        }else if($error_msg==2)
                                        {
                                            echo '<p class="alert alert-danger">Benutzer mit dieser E-Mail-Adresse existiert nicht.</p>';
                                        }else if($error_msg==3)
                                        {
                                            echo '<p class="alert alert-danger">Konto ist inaktiv oder gesperrt.</p>';
                                        }
                                    }
                                ?>
                                    <div class="text-center">
                                        <h4 class="text-dark mb-2">Passwort vergessen?</h4>
                                        <p class="mb-4">Wir verstehen es, es passiert etwas. Geben Sie einfach unten Ihre E-Mail-Adresse ein und wir senden Ihnen einen Link zum Zurücksetzen Ihres Passworts!</p>
                                    </div>
                                    <form class="user" method="POST" role="form" action="includes/process_login.php">
                                        <div class="form-group">
                                            <label style="font-weight: bold;">E-Mail-Addresse</label>
                                            <input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" name="email">
                                        </div>
                                        <button class="btn btn-primary btn-block text-white btn-user" id="button-forget" type="submit" style="color: var(--red);" name="forgetPassword">Passwort vergessen</button>
                                    </form>
                                    <div class="text-center">
                                        <hr><a class="small" href="./register.html">Ein Konto erstellen!</a>
                                    </div>
                                    <div class="text-center"><a class="small" href="./login.php">Sie haben bereits ein Konto? Anmeldung!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./loginfiles/js/jquery.min.js"></script>
    <script src="./loginfiles/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="./loginfiles/js/script.min.js"></script>
</body>

</html>