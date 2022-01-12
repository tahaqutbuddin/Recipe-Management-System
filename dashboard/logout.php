<?php
session_start();
include_once '../includes/class.login.php';
if(isset($_SESSION["google_access_token"]))
{
    $google = new GoogleLogin;
    $google->logout();
    unset($google);
}
else if(isset($_SESSION["facebook_access_token"]))
{
    $fb = new FacebookLogin;
    $fb->logout();
    unset($fb);
}
else
{
    $obj = new login;
    $obj->logout();
    unset($obj);
}
?>