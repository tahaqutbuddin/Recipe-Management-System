<?php
require_once 'class.login.php';
if(isset($_GET['action'],$_GET['email'],$_GET['key']))
{
    $obj = new login;
    $result = $obj->verifyResetLink($_GET['email'],$_GET['key']);
    if(is_bool($result))
    {
        unset($obj);
    }else if(is_string($result))
    {
        unset($obj);
        if($result=="expired")
        {
            die('<h2>Link abgelaufen</h2><p>Der Link ist abgelaufen. Sie versuchen, den abgelaufenen Link zu verwenden, der nur 24 Stunden (1 Tage nach Anfrage) gültig ist.');
            exit;
        }else if($result=="invalid")
        {
            die('
            Der Link ist ungültig / abgelaufen. Entweder haben Sie nicht den richtigen Link aus der E-Mail kopiert oder Sie haben den Schlüssel bereits verwendet. In diesem Fall ist er deaktiviert.');
            exit;
        }
    }
}
else 
{
    header('Location: ../login.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Passwort zurücksetzen</title>
    <link rel="stylesheet" href="../loginfiles/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../loginfiles/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../loginfiles/css/styles.min.css">
</head>

<body class="bg-gradient-primary" style="background: rgb(255,163,164);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-password-image" style="background: url('../loginfiles/img/food.jpg') center / cover;"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                <?php
                                    if(isset($_GET["error"]))
                                    {
                                        $error_msg = '';
                                        $error = $_GET["error"];
                                        if( intval($error) == 1)
                                        {
                                            $error_msg .= '<p class="alert alert-danger">Fehlereinstellung im Passwort</p>';
                                        }
                                        else if(intval($error) == 2)
                                        {
                                            $error_msg .= '<p class="alert alert-danger">'.$_SESSION['error_string'].'</p>';
                                            unset($_SESSION['error_string']);
                                        }
                                        else if(intval($error) == 3)
                                        {
                                            $error_msg .= '<p class="alert alert-danger">Ungültige E-Mail-Adresse Bitte geben Sie eine gültige E-Mail-Adresse ein!</p>';
                                        }
                                        echo $error_msg;
                                    }
                                ?>
                                    <div class="text-center">
                                        <h4 class="text-dark mb-2">Neues Passwort einrichten</h4>
                                    </div>
                                    <form class="user" method="POST" role="form" action="process_login.php">
                                        <div class="form-group">
                                            <label style="font-weight: bold;">E-Mail-Addresse</label>
                                            <input class="form-control form-control-user" name="email" type="email" id="exampleInputEmail" aria-describedby="emailHelp" value="<?php if(isset($_GET['email'])){echo $_GET['email'];};?>" >
                                        </div>
                                        <div class="form-group">
                                            <label style="font-weight: bold;">Neues Passwort</label>
                                            <input class="form-control form-control-user" name="password" type="text" id="exampleInputEmail" aria-describedby="emailHelp" >
                                        </div>
                                        <div class="form-group">
                                            <label style="font-weight: bold;">Bestätige neues Passwort</label>
                                            <input class="form-control form-control-user" name="confirmPwd" type="text" id="exampleInputEmail" aria-describedby="emailHelp" >
                                        </div>
                                        <button class="btn btn-primary btn-block text-white btn-user" id="button-forget" type="submit" style="color: var(--red);" name="resetPassword">Passwort zurücksetzen</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../loginfiles/js/jquery.min.js"></script>
    <script src="../loginfiles/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="../loginfiles/js/script.min.js"></script>
</body>

</html>