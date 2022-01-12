<?php
include_once 'includes/class.login.php';
$login = new login;
if(isset($_COOKIE["chef_login"]))
{
    if($login->checkRememberUser() == true)
    {
        header('Location: dashboard/index.php');
    }
}

if(isset($_SESSION["user_email"]) || (isset($_SESSION["facebook_access_token"])) || (isset($_SESSION["google_access_token"])))
{
    header("Location: dashboard/index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Anmeldung</title>
    <link rel="stylesheet" href="./loginfiles/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="./loginfiles/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="./loginfiles/css/styles.min.css">
</head>

<body class="bg-gradient-primary" style="background: #ffa3a4;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background: url('./loginfiles/img/food.webp') center / cover;"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                <?php
                                if (isset($_GET['error'])) 
                                {
                                    $error = $_GET["error"];
                                    if($error == 2)
                                    {
                                        $error_msg = '<p class="alert alert-danger">Ihr Konto wurde aufgrund zu vieler Versuche gesperrt.</p>';
                                    }else if($error == 3)
                                    {   
                                        $error_msg = '<p class="alert alert-danger">Bitte geben Sie ein korrektes Passwort ein</p>';
                                    }else if($error == 4)
                                    {
                                        $error_msg = '<p class="alert alert-danger">Mit diesem Konto ist kein Benutzer vorhanden</p>';
                                    }else if($error==5)
                                    {
                                        $error_msg = '<p class="alert alert-danger">Dein Profil ist nicht bestätigt. Bitte verifizieren sie ihr Konto</p>';
                                    }else if($error==6)
                                    {
                                        $error_msg = '<p class="alert alert-danger">Bitte geben Sie Email richtig ein</p>';
                                    }else
                                    {
                                        $error_msg =  '<p class="alert alert-danger">Fehler beim Anmelden</p>';
                                    }
                                    echo $error_msg;
                                    unset($_GET["error"]);
                                }
                                ?>
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Willkommen zurück!</h4>
                                    </div>
                                    <form class="user" method="POST" role="form" action="includes/process_login.php">
                                        <div class="form-group">
                                            <label style="font-weight: bold;">E-Mail-Addresse</label>
                                            <input class="form-control form-control-user email-validate" type="email" name="email" id="exampleInputEmail" aria-describedby="emailHelp">
                                            <small style="color:red"></small>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-weight: bold;">Passwort</label>
                                            <input class="form-control form-control-user password-validate" type="password" id="examplePasswordInput" name="pass">
                                            <small style="color:red"></small>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <div class="form-check">
                                                    <input class="form-check-input custom-control-input" type="checkbox" name="remember" value="checked" id="formCheck-1">
                                                    <label class="form-check-label custom-control-label" for="formCheck-1">Mich erinnern</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-block text-white btn-user" id="login-button" name="signin" type="submit" style="background: #fe9e9f;border-color: #FFA3A4;color: rgb(0,0,0)!important;">Anmeldung</button>
                                        <hr>
                                        <button class="btn btn-primary btn-block text-white btn-google btn-user" role="submit" name="google_login" ><i class="fab fa-google"></i>&nbsp; Melden Sie sich mit Google an</button>
                                        <button class="btn btn-primary btn-block text-white btn-facebook btn-user" role="submit" name="facebook_login" ><i class="fab fa-facebook-f"></i>&nbsp;Mit Facebook einloggen</button>
                                        <hr>
                                    </form>
                                    <?php
                                        if ($login->isLogin() == true) 
                                        {
                                            echo '<p>Momentan angemeldet '.htmlentities($_SESSION['username']).'.</p>';
                                            echo '<p>Möchten Sie den Benutzer wechseln? <a href="includes/logout.php">Ausloggen</a>.</p>';
                                        } else {
                                            echo '<div class="text-center"><a class="small" href="./forgot-password.php">Passwort vergessen?</a></div>';
                                            echo '<div class="text-center"><a class="small" href="./register.php">Ein Konto erstellen!</a></div>';
                                        }
                                        unset($login);
                                        ?> 
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
    <script src="./loginfiles/js/customJquery.js"></script>
</body>

</html>