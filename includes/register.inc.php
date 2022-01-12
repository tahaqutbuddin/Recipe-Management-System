<?php
require_once "class.register.php";
$obj = new registration;
$error = $obj->validate_registration();
if(is_bool($error))
{
    unset($obj);
    $_SESSION["registration_status"] = "<p class='alert alert-success'>Registrierung erfolgreich abgeschlossen. Überprüfen Sie Ihre E-Mails auf Bestätigung Link</p>";
}else if(is_string($error))
{
    unset($obj);
    $_SESSION["registration_status"] = $error;
}
?>