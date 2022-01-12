<?php
    session_start();
    require_once 'functions.php';
    require_once 'class.connect.php';
    include(dirname(__DIR__).'/googlelogin/vendor/autoload.php');
    require_once __DIR__ . '/../facebooklogin/Facebook/autoload.php';

class login extends dbConnect
{
    protected $conn = NULL;
    private $email;
    private $password;
    private $first_name;
    private $last_name;
    function __construct() 
    {
        try
        {
            $obj = new dbConnect;
            $this->conn = $obj->connect();  
        }catch(PDOException $ex)
        {
            die($ex->getMessage());
            exit;
        }  
    }  

    public function login($email, $password) 
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            return "incorrect email";
        }else
        {
            $this->email = htmlentities($email);
            $this->password = htmlentities($password);
            $message = "";
            try
            {
                // Using prepared statements means that SQL injection is not possible. 
                    $query = $this->conn->prepare("SELECT * FROM `members` WHERE `email` = :email LIMIT 1");
                    $query->bindParam(':email', $this->email , PDO::PARAM_STR);  // Bind "$email" to parameter.
                    $query->execute();    // Execute the prepared query.
                    if ($query->rowCount() == 1) 
                    {
                        $result = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result as $row)
                        {
                            $user_id = $row["id"];
                            $db_password = $row["password"];
                            $first_name  = htmlspecialchars_decode($row["first_name"],ENT_COMPAT);
                            $last_name  = htmlspecialchars_decode($row["last_name"],ENT_COMPAT);
                            if ($this->check_brute($user_id) == true) // check login if attempts are > 3 or not.
                            {
                                if($this->blockUserAccount($user_id,$email,$first_name,$last_name) == true) //suspend user account and send email
                                {
                                    return "account blocked";
                                }else
                                {
                                    return false;
                                }
                            } 
                            else 
                            {
                                if (password_verify($this->password, $db_password)) 
                                {
                                    if($row["active"] == '1')  // when account is active
                                    {
                                        if($row["block"] == "1")
                                        {
                                            return "account blocked";
                                        }else
                                        {
                                            //Password is Correct
                                            $user_browser = $_SERVER['HTTP_USER_AGENT'];
                                            $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                                            $_SESSION['user_email'] = $this->email;
                                            $this->first_name  = preg_replace("/[^a-zA-Z0-9_\-]+/","",    $first_name );
                                            $this->last_name  = preg_replace("/[^a-zA-Z0-9_\-]+/","",    $last_name );
                                            $_SESSION['username'] =    ucfirst($first_name);
                                            $_SESSION['login_string'] = hash('sha512', $db_password . $user_browser);
                                            return true;
                                        }
                                    } 
                                    else 
                                    {
                                        return "inactive";
                                    }
                                } 
                                else 
                                {
                                    // Password is not correct
                                    $now = time();
                                    $this->conn->query("INSERT INTO `login_attempts`(user_id, time) VALUES ('$user_id', '$now')");
                                    return "incorrect password";
                                }
                            }
                        }
                    }else 
                    {
                        $query1 = $this->conn->prepare("SELECT * FROM `site_admin` WHERE `email` = :email LIMIT 1");
                        $query1->bindParam(':email', $this->email , PDO::PARAM_STR);  // Bind "$email" to parameter.
                        $query1->execute();    // Execute the prepared query.
                        if ($query1->rowCount() > 0) 
                        {
                            $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);
                            foreach($result1 as $row1)
                            {
                                $db_password = $row1["password"];
                                $first_name  = htmlspecialchars_decode($row["first_name"],ENT_COMPAT);
                                if (password_verify($this->password, $db_password) ) 
                                {
                                    if(intval($row1["status"]) == 1)  // when account is active
                                    {
                                        //Password is Correct
                                        $user_browser = $_SERVER['HTTP_USER_AGENT'];
                                        $_SESSION['admin_email'] = $this->email;
                                        $this->first_name  = preg_replace("/[^a-zA-Z0-9_\-]+/","",    $first_name );
                                        $_SESSION['adminname'] =    ucfirst($first_name);
                                        $_SESSION['login_string'] = hash('sha512', $db_password . $user_browser);
                                        return true;
                                    }else 
                                    {
                                        return "inactive";
                                    }
                                }else
                                {
                                    return "incorrect password";
                                } 
                            }
                        }else
                        {
                            return "no user exists";
                        }
                    }
            }catch(PDOException $ex)
            {
                echo 'Error:'.$ex->getMessage();
            }
        }
    }
    
    private function check_brute($user_id) 
    {
        $now = time();
        $valid_attempts = $now - (0.5 * 60 * 60);  // login attempts in last half hour.
        try
        {
            if ($stmt = $this->conn->prepare("SELECT `time`  FROM `login_attempts` WHERE `user_id` = :userid  AND `time` > '$valid_attempts'")) 
            {
                $stmt->bindParam(':userid', $user_id , PDO::PARAM_INT);
                $stmt->execute();
        
                // If there have been more than 3 failed logins 
                if ($stmt->rowCount() == 3) 
                {
                    return true;
                } else 
                {
                    return false;
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
    private function blockUserAccount($user_id,$email,$first,$last)
    {
        try
        {
            $query = $this->conn->prepare("UPDATE `members` SET `block`='1' WHERE `email`=? AND `id`=? ");
            $query->execute([$email,$user_id]);
            if($query)
            {
                $subject = "Kontosperrung";
                $message = "Ihr Konto wurde vom Administrator wegen Überschreitung der Anmeldelimits gesperrt<br/>
                -------------------------<br/>
                
                Vorname: $first<br/>
                Nachname: $last<br/>
                E-mail: $email<br/>
                --------------------------<br/>
                <br/><br/>
                Wenden Sie sich an den Administrator, um weitere Unterstützung zu erhalten.
                ";
                $alt = "Dies ist eine vom Administrator generierte Nachricht zur vorübergehenden Sperrung Ihres Kontos. Bitte kontaktieren Sie den Administrator für weitere Informationen";
                if(sendMail($email,$subject,$message,$alt)==true)
                {
                    return true;   
                }
                return true;
            }
            else
            {
                return false;
            }
        }catch(PDOException $ex)
        {
            echo 'Error'.$ex->getMessage();
        }
    }

    function isLogin() 
    {
        // Check if all session variables are set 
        if (isset($_SESSION['user_email'], $_SESSION['username'], $_SESSION['login_string'])) 
        {
            $user_id = $_SESSION['user_email'];
            $login_string = $_SESSION['login_string'];
            $username = $_SESSION['username'];
    
            $user_browser = $_SERVER['HTTP_USER_AGENT'];
            try
            {
                if ($stmt = $this->conn->prepare("SELECT `password` FROM `members` WHERE `id` = :id LIMIT 1")) 
                {
                    // Bind "$user_id" to parameter. 
                    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
                    $stmt->execute();   // Execute the prepared query.
                    $result = $stmt->fetch();
                    extract($result);
                    if ($stmt->rowCount() == 1) 
                    {
                        // If the user exists get variables from result.
                        $login_check = hash('sha512', $password . $user_browser);
        
                        if (hash_equals($login_check, $login_string) ){
                            // Logged In!!!! 
                            return true;
                        } else {
                            // Not logged in 
                            return false;
                        }
                    } else {
                        // Not logged in 
                        return false;
                    }
                } else {
                    // Not logged in 
                    return false;
                }
            }catch(PDOException $ex)
            {
                echo 'Error'.$ex->getMessage();
            }
        }
        else if(isset($_SESSION["google_access_token"]))
        {
            return true;
        }else if(isset($_SESSION["facebook_access_token"]))
        {
            return true;
        }
            else {
            // Not logged in 
            return false;
        }
    }

    public function logout()
    {        
        
        $_SESSION = array();    // Unset all session values 
        $params = session_get_cookie_params();  // get session parameters

        // Delete the actual cookie. 
        setcookie(session_name(),'', time() - 42000, 
            $params["path"], 
            $params["domain"], 
            $params["secure"], 
            $params["httponly"]);
        session_destroy();      // Destroy session
        header('Location: ../login.php');
    }

    public function checkUser($email)
    {
        try
        {
            if ($stmt = $this->conn->prepare("SELECT * FROM `members` WHERE `email` = :email LIMIT 1")) 
            {
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();   // Execute the prepared query.
                $result = $stmt->fetch();
                extract($result);
                if ($stmt->rowCount() == 1) 
                {
                    if($active == '1')
                    {
                        if($this->generateTokenForReset($email)==true)
                        {
                            return true;
                        }
                    }else
                    {
                        return "inactive";
                    }
                }else 
                {
                    return "no user exists";
                }
            }
        }catch(PDOException $ex)
        {
            echo 'Error:'.$ex->getMessage();
        }
    }
    private function generateTokenForReset($email)
    {
        $expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
        $expDate = date("Y-m-d H:i:s",$expFormat);
        $key = md5((2418*2).$email);
        $addKey = substr(md5(uniqid(rand(),1)),3,10);
        $key = $key . $addKey;
        try
        {
            $query = $this->conn->prepare("INSERT INTO `password_reset_temp` (`email`,`key`,`expDate`) VALUES (:email,:key,:date)");
            $query->bindParam(':email',$email,PDO::PARAM_STR);
            $query->bindParam(':key',$key,PDO::PARAM_STR);
            $query->bindParam(':date',$expDate,PDO::PARAM_STR);
            $result = $query->execute();
            if($result)
            {
                if($this->sendEmailNotification($email,$key)==true)
                {
                    return true;
                }
            }
        }catch(PDOException $ex)
        {
            echo 'Error:'.$ex->getMessage();
        }
    }
    private function sendEmailNotification($email,$key)
    {
        $subject = 'Passwort-Wiederherstellung'; // Give the email a subject 
        $message='<p>Lieber Nutzer,</p>';
        $message.='<p>Bitte klicken Sie auf den folgenden Link, um Ihr Passwort zurückzusetzen.</p>';
        $message.='<p>-------------------------------------------------------------</p>';
        $message.='<p><a href="http://chef.flavourflip.de/includes/reset-password.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">Klicken Sie hier, um das Passwort zurückzusetzen</a></p>'; 
        $message.='<p>-------------------------------------------------------------</p>';
        $message.='<p>Bitte kopieren Sie den gesamten Link in Ihren Browser. Der Link läuft aus Sicherheitsgründen nach 1 Tag ab.</p>';
        $message.='<p>Wenn Sie diese E-Mail mit dem vergessenen Passwort nicht angefordert haben, ist keine Aktion erforderlich. Ihr Passwort wird nicht zurückgesetzt. Möglicherweise möchten Sie sich jedoch in Ihr Konto einloggen und Ihr Sicherheitskennwort ändern, wie es möglicherweise jemand erraten hat.</p><br/><br/>';   
        $message.='<p>Vielen Dank,</p>';
        $message.='<p>Administrator</p>';
         // Our message above including the link
        $alt = "Dies ist eine vom Administrator generierte E-Mail. Bitte kontaktieren Sie den Administrator für die Passwortwiederherstellung";
        if(sendMail($email, $subject, $message, $alt)==true)
        {
            return true;
        }
    }

    public function verifyResetLink($email,$key)
    {
        try
        {
            if ($stmt = $this->conn->prepare("SELECT * FROM `password_reset_temp` WHERE `email` = :email AND `key`=:key LIMIT 1")) 
            {
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':key', $key, PDO::PARAM_STR);
                $stmt->execute();   // Execute the prepared query.
                if ($stmt->rowCount() == 1) 
                {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $expDate = $row['expDate'];
                    $curDate = date("Y-m-d H:i:s");
                    if ($expDate >= $curDate)
                    {
                        if($this->deleteResetTempKey($email))
                        {
                            return true;
                        } 
                    }else
                    {
                        return "expired";
                    }
                    
                }else
                {
                    return "invalid";
                }
            }
        }catch(PDOException $ex)
        {
            echo 'Error'.$ex->getMessage();
        }
    }
    public function resetPassword($email,$pass,$cpass)
    {
        $error = "";
        if(strlen($pass)<10)
        {
            $error .= 'Das Passwort sollte mindestens 10 Zeichen lang sein.';
        }else if($pass!=$cpass)
        {
            $error .= 'Beide Passwörter stimmen nicht überein.';
        }

        $pass = hash('sha512',$pass);
        if (strlen($pass) != 128) 
        {
            $error .= 'Ungültige Passwortkonfiguration.';
        }

        if(empty($error))
        {
            try
            {
                $stmt = $this->conn->prepare("SELECT * FROM `members` WHERE `email` = :email LIMIT 1");
                if ($stmt) 
                { 
                    $stmt->bindParam(':email', $email,PDO::PARAM_STR);
                    $stmt->execute();
                    if ($stmt->rowCount() == 1) 
                    {
                        if($this->updatePassword($email,$pass)==true)
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
                    return false;
                }
            }catch(PDOException $ex)
            {
                echo 'Error:'.$ex->getMessage();
            }
        }
        else
        {
            return $error;
        }
    }
    private function deleteResetTempKey($email)
    {
        try
        {
            $query= "DELETE FROM `password_reset_temp` WHERE `email`=? ";
            $result= $this->conn->prepare($query);
            $result->execute([$email]);
            if($result)
            {
                return true;
            }
            return false;
        }catch(PDOException $ex)
        {
            echo 'Error:'.$ex->getMessage();
        }
    }
    private function updatePassword($email,$pass)
    {   
        try
        {
            $password = password_hash($pass, PASSWORD_BCRYPT);    
            $query= "UPDATE `members` SET `password`=? WHERE `email`=? ";
            $result= $this->conn->prepare($query);
            $result->execute([$password,$email]);
            if($result)
            {
                return true;
            }else
            {
                return false;
            }
        }catch(PDOException $ex)
        {
            echo 'Error:'.$ex->getMessage();
        }
    }

    public function rememberUser($email)
    {
        $query = $this->conn->prepare("UPDATE `members` SET `remember`='1' WHERE `email` = :email ");
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        if($query->execute())
        {
            if($query->rowCount() > 0)
            {
                setcookie('chef_login',$email,time() + (86400 * 30) , '/');
            }
        }
    }
    
    public function checkRememberUser()
    {   
        if(isset($_COOKIE["chef_login"]))
        {
            try
            {
                if ($stmt = $this->conn->prepare("SELECT * FROM `members` WHERE `email` = :email LIMIT 1")) 
                {
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->execute();   // Execute the prepared query.
                    if ($stmt->rowCount() == 1) 
                    {
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result as $row)
                        {
                            if($row['active'] == '1' && $row["remember"] == 1)
                            {
                                    return true;
                            }else
                            {
                                return false;
                            }
                        }
                    }else 
                    {
                        return false;
                    }
                }
            }catch(PDOException $ex)
            {
                echo 'Error:'.$ex->getMessage();
            }
        }else
        {
            return false;
        }
    }
}


class GoogleLogin extends login
{
    private $google_client = NULL;
    private $table;
    function __construct()
    {
        try
        {
            parent::__construct();
            $this->table = 'social_login';
            $this->google_client = new Google_Client();
            $this->google_client->setClientId(GOOGLE_CLIENT_ID);
            $this->google_client->setClientSecret(GOOGLE_CLIENT_SECRET);
            $this->google_client->setRedirectUri(GOOGLE_REDIRECT_URL);
            $this->google_client->addScope('email');
            $this->google_client->addScope('profile');
        }catch(PDOException $ex)
        {
            echo 'Error:'.$ex->getMessage();
        }
    }
    function getGoogleClient()
    {
        return $this->google_client;
    }
    function googleLogin()
    {
        if (isset($_GET['code'])) 
        {
            $token = $this->google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
            if(!isset($token['error']))
            {
                $this->google_client->setAccessToken($token['access_token']);
                $_SESSION['google_access_token'] = $token['access_token'];
                $google_service = new Google_Service_Oauth2($this->google_client);
                $data = $google_service->userinfo->get();
                $userData = array(); 
                $userData['oauth_uid']  = !empty($data['id'])?$data['id']:''; 
                $userData['first_name'] = !empty($data['given_name'])?$data['given_name']:''; 
                $userData['last_name']  = !empty($data['family_name'])?$data['family_name']:''; 
                $userData['email']       = !empty($data['email'])?$data['email']:''; 
                $userData['gender']       = !empty($data['gender'])?$data['gender']:'N/A'; 
                $userData['avatar']       = !empty($data['picture'])?$data['picture']:'NULL'; 
                $userData['oauth_provider'] = 'google';
                if($this->insertProfileInDatabase($userData)==true)
                {
                    $_SESSION["username"] =  $userData['first_name'];
                    $_SESSION["user_email"] =  $userData['email'];
                    return true;
                }else 
                {
                    return false;
                }
            }
        }
    }
    private function insertProfileInDatabase($data)
    {
        $insert = $update = NULL;
        if(!empty($data))
        { 
            try
            {
                // Check whether the user already exists in the database 
                $checkQuery = "SELECT * FROM ".$this->table." WHERE `oauth_provider` = '".$data['oauth_provider']."' AND `oauth_uid` = '".$data['oauth_uid']."'"; 
                $checkResult = $this->conn->query($checkQuery); 
                
                if($checkResult->rowCount() > 0)
                { 
                    // Add modified time to the data array 
                    if(!array_key_exists('modified',$data)){ 
                        $data['modified'] = date("Y-m-d H:i:s"); 
                    } 
                    // Prepare column and value format 
                    $colvalSet = ''; 
                    $i = 0; 
                    foreach($data as $key=>$val)
                    { 
                        $pre = ($i > 0)?", ":" "; 
                        $colvalSet .= $pre.$key."='".htmlentities($val)."'"; 
                        $i++; 
                    } 
                    $whereSql = " WHERE `oauth_provider` = '".$data['oauth_provider']."' AND `oauth_uid` = '".$data['oauth_uid']."'"; 
                    
                    // Update user data in the database 
                    $query = "UPDATE `".$this->table."` SET ".$colvalSet.$whereSql; 
                    $update = $this->conn->query($query); 
                }else
                { 
                    // Add created time to the data array 
                    if(!array_key_exists('created',$data))
                    { 
                            $data['created'] = date("Y-m-d H:i:s"); 
                    } 
                    // Prepare column and value format 
                    $columns = $values = ''; 
                    $i = 0; 
                    foreach($data as $key=>$val)
                    { 
                        if($key!='' && $val!='')
                        {
                            $pre = ($i > 0)?", ":" "; 
                            $columns .= $pre.$key; 
                            $values  .= $pre."'".htmlentities($val)."'"; 
                        }
                        $i++; 
                    } 
                            
                    // Insert user data in the database 
                    
                    $query = "INSERT INTO `".$this->table."` (".$columns.") VALUES (".$values.")"; 
                    $insert = $this->conn->query($query); 
                    
                }
                
            }catch(PDOException $ex)
            {
                echo 'Error:'.$ex->getMessage();
            }
        } 
        // Return 
        return ($insert || $update)?true:false; 
    } 
    function createGoogleOAuthURL()
    {
        if(!isset($_SESSION['google_access_token']))
        {
            return $this->google_client->createAuthUrl();
        }
        return false;
    }
    public function logout()
    {
        if($this->google_client!=NULL)
        {
            $this->google_client->revokeToken();
            session_destroy();
            header('location: ../index.php');
        }
    }
}

class FacebookLogin extends login
{
    private $facebook_client = NULL;
    private $table;
    function __construct()
    {
        try
        {
            parent::__construct();
            $this->table = 'social_login';
            $this->facebook_client = new Facebook\Facebook([
            'app_id' => FB_APP_ID,
                'app_secret' => FB_APP_SECRET,
                    'default_graph_version' => FB_APP_VERSION,
                ]);
        }catch(PDOException $ex)
        {
            echo 'Error:'.$ex->getMessage();
        }
    }

    public function facebook_login()
    {
        $helper = $this->facebook_client->getRedirectLoginHelper();
        $permissions = ['email','public_profile']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(FB_REDIRECT_URL, $permissions);
        header('Location:'.$loginUrl);
    }

    public function getFBClient()
    {
        return $this->facebook_client;
    }

    public function createLongLiveAccessToken($accessToken)
    {
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        $oAuth2Client = $this->facebook_client->getOAuth2Client();
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        $this->facebook_client->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    public function validateData($fbUser)
    {
        // Getting user's profile data
        $fbUserData = array();
        $fbUserData['oauth_uid']  = !empty($fbUser['id'])?$fbUser['id']:'';
        $fbUserData['first_name'] = !empty($fbUser['first_name'])?$fbUser['first_name']:'';
        $fbUserData['last_name']  = !empty($fbUser['last_name'])?$fbUser['last_name']:'';
        $fbUserData['email']      = !empty($fbUser['email'])?$fbUser['email']:'';
        $fbUserData['gender']     = !empty($fbUser['gender'])?$fbUser['gender']:'-';
        $fbUserData['avatar']    = !empty($fbUser['picture']['url'])?$fbUser['picture']['url']:'';
        $fbUserData['oauth_provider'] = 'facebook';
        if($this->insertIntoDatabase($fbUserData)==true)
        {
            $_SESSION["username"] =  $fbUserData['first_name'];
            $_SESSION["user_email"] = $fbUserData['email'];
            return true;
        }
        return false;
    }

    private function insertIntoDatabase($data)
    {
        if(!empty($data)){ 
            try
            {

                // Check whether the user already exists in the database 
                $checkQuery = "SELECT * FROM ".$this->table." WHERE `oauth_provider` = '".$data['oauth_provider']."' AND `oauth_uid` = '".$data['oauth_uid']."'"; 
                $checkResult = $this->conn->query($checkQuery); 
                
                // Add modified time to the data array 
                if(!array_key_exists('modified',$data)){ 
                    $data['modified'] = date("Y-m-d H:i:s"); 
                } 
                
                if($checkResult->rowCount() > 0){ 
                    // Prepare column and value format 
                    $colvalSet = ''; 
                    $i = 0; 
                    foreach($data as $key=>$val){ 
                        $pre = ($i > 0)?', ':''; 
                        $colvalSet .= $pre.$key."='".htmlentities($val)."'"; 
                        $i++; 
                    } 
                    $whereSql = " WHERE `oauth_provider` = '".$data['oauth_provider']."' AND `oauth_uid` = '".$data['oauth_uid']."'"; 
                    
                    // Update user data in the database 
                    $query = "UPDATE ".$this->table." SET ".$colvalSet.$whereSql; 
                    $update = $this->conn->query($query); 
                }else{ 
                    // Add created time to the data array 
                    if(!array_key_exists('created',$data)){ 
                        $data['created'] = date("Y-m-d H:i:s"); 
                    } 
                    
                    // Prepare column and value format 
                    $columns = $values = ''; 
                    $i = 0; 
                    foreach($data as $key=>$val){ 
                        $pre = ($i > 0)?', ':''; 
                        $columns .= $pre.$key; 
                        $values  .= $pre."'".htmlentities($val)."'"; 
                        $i++; 
                    } 
                    
                    // Insert user data in the database 
                    $query = "INSERT INTO ".$this->table." (".$columns.") VALUES (".$values.")"; 
                    $insert = $this->conn->query($query); 
                }
            }catch(PDOException $ex)
            {
                echo 'Error:'.$ex->getMessage();
            } 
        } 
        return ($insert || $update)?true:false; 
    }
    public function logout()
    {
        if($this->facebook_client!=NULL)
        {
            unset($_SESSION['facebook_access_token']);
            unset($_SESSION['userData']);
            session_destroy();
            header('location: ../index.php');
        }
       
    }

}

?>