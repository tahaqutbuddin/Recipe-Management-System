<?php
require '../includes/class.login.php';
$google = new GoogleLogin;
if(isset($_GET["code"]))
{
    if($google->googleLogin()==true)
    {
        header('Location: ../dashboard/form.php');
    }else
    {
       header("Location:../login.php?error=7");
    }
}
?>