<?php
require_once 'class.connect.php';
require_once 'functions.php';

class registration extends dbConnect
{
    private $conn;
    function __construct() 
    {  
        try
        {
            $obj = new dbConnect;
            $this->conn = $obj->connect();
        }catch(PDOException $ex)
        {
            echo 'Error:'.$ex->getMessage();
        }  
    } 

    function validate_registration()
    {
        $error_msg = "";
        if (isset($_POST['first_name'],$_POST["last_name"], $_POST['email'] , $_POST["pass"] , $_POST["confirmpwd"])) 
        {
            // Sanitize and validate the data passed in
            $first = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
            $last = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
             // Not a valid email
                $error_msg .= '<p class="alert alert-danger">Die von Ihnen eingegebene E-Mail-Adresse ist ungültig</p>';
            }
            $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
            $c_password = filter_input(INPUT_POST,'confirmpwd',FILTER_SANITIZE_STRING);
            if(strlen($password)<10)
            {
                $error_msg .= '<p class="alert alert-danger">Das Passwort sollte mindestens 10 Zeichen lang sein.</p>';
            }else if($password!=$c_password)
            {
                $error_msg .= '<p class="alert alert-danger">Beide Passwörter stimmen nicht überein.</p>';
            }

            $password = hash('sha512',$password);
            if (strlen($password) != 128) 
            {
                $error_msg .= '<p class="alert alert-danger">Ungültige Passwortkonfiguration.</p>';
            }

            try
            {
                $stmt = $this->conn->prepare("SELECT * FROM `members` WHERE `email` = :email LIMIT 1");
                if ($stmt) 
                { 
                    $stmt->bindParam(':email', $email,PDO::PARAM_STR);
                    $stmt->execute();
                    if ($stmt->rowCount() == 1) 
                    {
                        $error_msg .= '<p class="alert alert-danger">Benutzer mit dieser E-Mail-Adresse existiert bereits.</p>';
                    }
                } else 
                {
                    $error_msg .= '<p class="alert alert-danger">Interner Fehler. Wenden Sie sich an die Behörden, um Unterstützung zu erhalten.</p>';
                }
        
                $stmt2 = $this->conn->prepare("SELECT * FROM `social_login` WHERE `email` = :email LIMIT 1");
                if ($stmt2) 
                {
                    $stmt2->bindParam(':email', $email,PDO::PARAM_STR);
                    $stmt2->execute();
                    if ($stmt2->rowCount() == 1) 
                    {
                        $error_msg .= '<p class="alert alert-danger">Diese E-Mail wurde bereits mit der Social Login-Funktion verwendet. Sie können diese E-Mail nicht zum Anmelden verwenden</p>';
                    }
                } 
                else 
                {
                    $error_msg .= '<p class="alert alert-danger">Interner Fehler. Wenden Sie sich an die Behörden, um Unterstützung zu erhalten.</p>';
                }

                if (empty($error_msg)) 
                {
                    if($this->insertUser($first,$last,$email,$password))
                    {
                        if($this->send_verification_link($first,$last,$email))
                        {
                            return true;
                        }
                    }
                }else 
                {
                    return $error_msg;
                }
            }catch(PDOException $ex)
            {
                echo 'Error:'.$ex->getMessage();
            }
        }
    }
    
    function insertUser($first,$last,$email,$password)
    {
        try
        {
            $password = password_hash($password, PASSWORD_BCRYPT);
            if ($insert_stmt = $this->conn->prepare("INSERT INTO `members` (`first_name`, `last_name`, `email`, `password`) VALUES (:first, :last, :email, :pass)")) 
            {
                $insert_stmt->bindParam(':first',$first,PDO::PARAM_STR);
                $insert_stmt->bindParam(':last',$last,PDO::PARAM_STR);
                $insert_stmt->bindParam(':email',$email,PDO::PARAM_STR);
                $insert_stmt->bindParam(':pass',$password,PDO::PARAM_STR);
                
                // Execute the prepared query.
                if ($insert_stmt->execute()) 
                {
                    return true;
                }else
                {
                    header('Location: ../error.php?err=Registration failure: INSERT');
                }
            }else
            {
                return false;
            }
        }catch(PDOException $ex)
        {
            echo 'Error:'.$ex->getMessage();
        } 

    }

    function send_verification_link($first,$last,$email)
    {
        $hash = md5(rand(0,1000));
        $to      = $email; // Send email to our user
        try
        {
            $sql = "UPDATE `members` SET `hash`=? WHERE `email`=? ";
            $stmt= $this->conn->prepare($sql);
            $stmt->execute([$hash,$email]);
            if($stmt)
            {
                $subject = 'Anmeldung | Überprüfung'; // Give the email a subject 
                $message = '
                <br/>
                Danke für\'s Registrieren!<br/>
                Ihr Konto wurde erstellt. Sie können sich mit den folgenden Anmeldeinformationen anmelden, nachdem Sie Ihr Konto aktiviert haben, indem Sie auf die unten stehende URL klicken.
                <br/><br/>
                ------------------------<br/>
                Vorname: '.$first.'<br/>
                Nachname: '.$last.'<br/>
                E-mail: '.$email.'<br/>
                ------------------------
                <br/><br/>
                Bitte klicken Sie auf diesen Link, um Ihr Konto zu aktivieren:<br/>
                http://chef.flavourflip.de/includes/verify.php?email='.$email.'&hash='.$hash.'
                
                '; // Our message above including the link
                $alt = "Dies ist eine vom Administrator generierte E-Mail. Bitte kontaktieren Sie den Administrator für eine erfolgreiche Registrierung";
                if(sendMail($to, $subject, $message, $alt)==true)
                {
                    return true;
                }
            }else
            {
                return false;
            }
        }catch(PDOException $ex)
        {
            echo 'Error:'.$ex->getMessage();
        }
    }

    public function verifyAccount($email,$hashcode)
    {
        try
        {
            $query = $this->conn->prepare("SELECT * FROM `members` WHERE `email` = :email AND `hash` = :hash LIMIT 1");
            if ($query) 
            {
                $query->bindParam(':email', $email,PDO::PARAM_STR);
                $query->bindParam(':hash', $hashcode,PDO::PARAM_STR);
                $query->execute();
                if($query->rowCount()>0)
                {
                    $query2= "UPDATE `members` SET `active`=? WHERE `email`=? ";
                    $result= $this->conn->prepare($query2);
                    $result->execute(['1',$email]);
                    if($result)
                    {
                        return true;
                    }else
                    {
                        return false;
                    }
                }else
                {
                    return false;
                }
            }else
            {
                false;
            }
        }catch(PDOException $ex)
        {
            echo 'Error:'.$ex->getMessage();
        }
    }


}

?>