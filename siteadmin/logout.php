<?php
require '../Model/class.admin.php';
if(isset($_SESSION["admin_email"],$_SESSION["adminname"]))
{
    $obj = new admin;
    if($obj->logout() == true)
    {
        header("Location: ../login.php");
    }   
}else
{
    header("Location:../login.php");
}
?>