<?php
include_once 'class.login.php';
if (isset($_POST['email'],$_POST["pass"],$_POST["signin"])) 
{
    if (strlen($_POST['email']) || (strlen($_POST['pass']) > 1))
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
        $password = hash('sha512',$password);
        $log = new login;
        $result = $log->login($email, $password);
        if (is_bool($result)) 
        {
            if($result==true)
            {
                if(!empty($_POST["remember"])) 
                {
                    $log->rememberUser($email);
                }
                // Login success
                if(isset($_SESSION["adminname"]))
                {
                    unset($log);
                    header('Location: ../siteadmin/index.php');
                }else
                {
                    unset($log);
                    header('Location: ../dashboard/form.php');
                }
            }else if($result==false)
            {
                // Login failed 
                unset($log);
                $error_msg = "Please enter details correctly.";
                header('Location: ../login.php?error=1');
            }
        }else if(is_string($result))
        {
            unset($log);
            if($result == "account blocked")
            {
                header('Location: ../login.php?error=2');
            }else if($result == "incorrect password")
            {   
                header('Location: ../login.php?error=3');
            }else if($result == "no user exists")
            {
               header('Location: ../login.php?error=4');
            }else if($result=="inactive")
            {
               header('Location: ../login.php?error=5');
            }else if($result=="incorrect email")
            {
               header('Location: ../login.php?error=6');
            }else
            {
                header('Location: ../login.php?error=1');
            }
        } 
    }
    else 
    {
        // Login failed 
        header('Location: ../login.php?error=1');
    }
}else if(isset($_POST["facebook_login"]))
{
    $log = new FacebookLogin;
    if($log->facebook_login())
    {
        unset($log);
        header('Location: ../dashboard/form.php');
    }
}
else if(isset($_POST["google_login"]))
{
    $google = new GoogleLogin;
    $url = $google->createGoogleOAuthURL();
    if($url!=false)
    {
        unset($google);
        header("location: ".$url);
    }else
    {
        header("location: ../login.php");
    }
}else if(isset($_POST["forgetPassword"],$_POST["email"]))
{
    if (strlen($_POST['email'])>1)
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if($email)
        {
            $log = new login;
            $result =  $log->checkUser($email);
            if(is_bool($result))
            {
                unset($log);
                header('Location: ../forgot-password.php?error=1');
            } 
            else if(is_string($result))
            {
                unset($log);
                if($result == "no user exists")
                {
                    header('Location: ../forgot-password.php?error=2');
                }else if($result=="inactive")
                {
                    header('Location: ../forgot-password.php?error=3');
                }
            }
        }else
        {
            $error = "<p>Ungültige E-Mail-Adresse Bitte geben Sie eine gültige E-Mail-Adresse ein!</p>";
        }
    }
}else if(isset($_POST["resetPassword"],$_POST["email"],$_POST["password"],$_POST["confirmPwd"]))
{
    if (strlen($_POST['email'])>1)
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $cpassword = filter_input(INPUT_POST, 'confirmPwd', FILTER_SANITIZE_STRING);
        if($email)
        {
            $log = new login; 
            $result = $log->resetPassword($email,$password,$cpassword); 
            if(is_bool($result))
            {
                if($result)
                {
                    unset($log);
                    header('Location: ../login.php');
                }else
                {
                    header("location: reset-password.php?error=1");    
                }
            }else if(is_string($result))
            {
                $_SESSION['error_string'] = $result;
                header("location: reset-password.php?error=2");
            } 
        }else
        {
            header("location: reset-password.php?error=3");
        }
    }
}
 else {
    // The correct POST variables were not sent to this page. 
    echo 'ungültige Anfrage';
}
?>