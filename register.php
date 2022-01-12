<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Ein Konto erstellen!</title>
    <link rel="stylesheet" href="./loginfiles/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="./loginfiles/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="./loginfiles/css/styles.min.css">
</head>

<body class="bg-gradient-primary" style="background: #FFA3A4;">
    <div class="container">
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-flex">
                        <div class="flex-grow-1 bg-register-image" style="background: url('./loginfiles/img/food.webp') center / cover;"></div>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Ein Konto erstellen!</h4>
                            </div>
                            <?php
                            if (!empty($error_msg)) 
                            {
                                echo $error_msg;
                            }
                            if(isset($_SESSION["registration_status"]))
                            {
                                echo $_SESSION["registration_status"];
                                unset($_SESSION["registration_status"]);
                            }
                        ?>
                            <form class="user" method="POST" action="<?= esc_url($_SERVER['REQUEST_URI']); ?>" role="form">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label style="color: rgb(133, 135, 150);font-weight: bold;">Vorname</label>
                                        <input class="form-control form-control-user text-validate" type="text" id="exampleFirstName" name="first_name" maxlength="30">
                                        <small style="color:red"></small>
                                    </div>
                                    <div class="col-sm-6">
                                        <label style="font-weight: bold;">Nachname</label>
                                        <input class="form-control form-control-user text-validate" type="text" id="exampleFirstName"  name="last_name" maxlength="30">
                                        <small style="color:red"></small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="font-weight: bold;">E-Mail-Addresse</label>
                                    <input class="form-control form-control-user email-validate" type="email" id="exampleInputEmail" aria-describedby="emailHelp"  name="email">
                                    <small style="color:red"></small>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label style="font-weight: bold;">Passwort</label>
                                        <input class="form-control form-control-user password-validate" type="password" id="examplePasswordInput" name="pass">
                                        <small style="color:red"></small>
                                    </div>
                                    <div class="col-sm-6">
                                        <label style="font-weight: bold;">Passwort wiederholen</label>
                                        <input class="form-control form-control-user cnfmpass" type="password" id="exampleRepeatPasswordInput" name="confirmpwd">
                                        <small style="color:red"></small>
                                    </div>
                                </div>
                                <div class="col">
                                    <button class="btn btn-primary btn-block text-white btn-user col-md-12" id="register-button" name="signup" type="submit" style="background: #FFA3A4;border-color: #FFA3A4;color: rgb(0,0,0)!important;">Account registrieren</button>
                                </div>
                                <hr>
                            </form>
                            <div class="text-center"><a class="small" href="./login.php">Sie haben bereits ein Konto? Anmeldung!</a></div>
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
    <script src="./loginfiles/js/customJquery.js"></script>
</body>
</html>