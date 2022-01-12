<?php
require 'class.register.php';
if(isset($_GET['email']) && isset($_GET["hash"]))
{
    $verify = new registration;
    if($verify->verifyAccount($_GET["email"],$_GET["hash"]) == true)
    {
        unset($verify);
        header('location: ../login.php');
    }else
    {
        unset($verify);
        echo 'Inkorrekter Link. Ihr Konto kann nicht überprüft werden';
    }
}
?>