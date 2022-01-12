<?php
include_once 'config.php';
include(dirname(__DIR__).'/vendor/autoload.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = true;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id(true);    // regenerated the session, delete the old one. 
}

function esc_url($url) {
  
    if ('' == $url) {
        return $url;
    }
  
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\x80-\xff]|i', '', $url);
  
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
  
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
  
    $url = str_replace(';//', '://', $url);
  
    $url = htmlentities($url);
  
    $url = str_replace('&amp;', '&', $url);
    $url = str_replace("'", '', $url);
  
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function sendMail($receiver , $subject , $message , $altMessage )
{
    $receiver = htmlspecialchars_decode($receiver,ENT_COMPAT);;
    $subject = htmlspecialchars_decode($subject,ENT_COMPAT);;
    $message = htmlspecialchars_decode($message,ENT_COMPAT);
    $altMessage = htmlspecialchars_decode($altMessage,ENT_COMPAT);
    //PHPMailer Object
    $mail = new PHPMailer(true); //Argument true in constructor enables exceptions
    try 
    {
        $mail->isSMTP();                                       // Set mailer to use SMTP  
        $mail->Host = 'w01aef2e.kasserver.com';                       // Specify main and backup SMTP servers  
        $mail->SMTPAuth = true;                                // Enable SMTP authentication  
        $mail->Username = 'kontakt@flavourflip.de';                                // your SMTP username  
        $mail->Password = 'doswyv-4bonPo-racpop';                                  // your SMTP password  
        $mail->SMTPSecure = 'tls';                             // Enable TLS encryption, `ssl` also accepted  
        $mail->Port = 587;                  

        $mail->setFrom('kontakt@flavourflip.de', 'Admin Support');  
        $mail->addAddress($receiver); 

        //Send HTML or Plain Text email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = $altMessage;
        if(!$mail->send()) 
        {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            return false;
        } 
        else 
        {
            return true;
        }

    } catch (Exception $e) 
    {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}

?>