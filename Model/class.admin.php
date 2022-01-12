<?php

require_once __DIR__ . '/../includes/class.connect.php';
class admin
{
    private $conn = NULL;

    public function __construct()
    {
        try{
            $obj = new dBConnect;
            $this->conn = $obj->connect();

        }catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    public function fetchAllAdmins()
    {
        $arr = array();
        $query = $this->conn->prepare("SELECT * FROM `site_admin` ");
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                array_push($arr, array(
                    0 => $row["id"],
                    1 => htmlspecialchars_decode($row["first_name"],ENT_COMPAT), 
                    2 => htmlspecialchars_decode($row["last_name"],ENT_COMPAT),
                    3 => htmlspecialchars_decode($row["email"],ENT_COMPAT),
                    4 => htmlspecialchars_decode($row["status"],ENT_COMPAT) 
                ));
            }
            return json_encode($arr);
        }else
        {
            return false;
        }
    }

    public function validateNewAdmin()
    {
        if(isset($_POST["email"],$_POST["first_name"],$_POST["last_name"],$_POST["password"]))
        {
            $error_msg = '';
            $first = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
            $last = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
                    $error_msg .= '<p class="alert alert-danger">Die von Ihnen eingegebene E-Mail-Adresse ist ungültig</p>';
            }
            
            if(strlen($password)<10)
            {
                $error_msg .= '<p class="alert alert-danger">Das Passwort sollte mindestens 10 Zeichen lang sein.</p>';
            }

            $regex_text = "/^[a-zA-ZäöüßÄÖÜ]+$/";
            $regex_email = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
            $regex_password = "/^(?=.*[A-Za-zäöüßÄÖÜ])(?=.*\d)[A-Za-zäöüßÄÖÜ\d]{10,}$/";
            if((preg_match($regex_text,$first) == 0) && (preg_match($regex_text,$last) == 0) )
            {
                $error_msg .= '<p class="alert alert-danger">Ungültiges Format für Vor- oder Nachnamen</p>';
            }
            if(preg_match($regex_email,$email) == 0)
            {
                $error_msg .= '<p class="alert alert-danger">Ungültiges Format für E-Mail</p>';
            }
            if(preg_match($regex_password,$password) == 0)
            {
                $error_msg .= '<p class="alert alert-danger">Ungültiges Format für Passwort</p>';
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
                        $error_msg .= '<p class="alert alert-danger">E-Mail Bereits vom Küchenchef übernommen.</p>';
                    }
                } else 
                {
                    $error_msg .= '<p class="alert alert-danger">Interner Fehler. Wenden Sie sich an die Behörden, um Unterstützung zu erhalten.</p>';
                }

                $stmt1 = $this->conn->prepare("SELECT * FROM `social_login` WHERE `email` = :email LIMIT 1");
                if ($stmt1) 
                { 
                    $stmt1->bindParam(':email', $email,PDO::PARAM_STR);
                    $stmt1->execute();
                    if ($stmt1->rowCount() == 1) 
                    {
                        $error_msg .= '<p class="alert alert-danger">E-Mail Bereits vom Küchenchef übernommen.</p>';
                    }
                } else 
                {
                    $error_msg .= '<p class="alert alert-danger">Interner Fehler. Wenden Sie sich an die Behörden, um Unterstützung zu erhalten.</p>';
                }

                $stmt2 = $this->conn->prepare("SELECT * FROM `site_admin` WHERE `email` = :email LIMIT 1");
                if ($stmt2) 
                { 
                    $stmt2->bindParam(':email', $email,PDO::PARAM_STR);
                    $stmt2->execute();
                    if ($stmt2->rowCount() == 1) 
                    {
                        $error_msg .= '<p class="alert alert-danger">Der Administrator mit dieser E-Mail-Adresse ist bereits vorhanden.</p>';
                    }
                } else 
                {
                    $error_msg .= '<p class="alert alert-danger">Interner Fehler. Wenden Sie sich an die Behörden, um Unterstützung zu erhalten.</p>';
                }

                if (strlen($error_msg) == 0) 
                {
                    if($this->insertNewAdmin($first,$last,$email,$password))
                    {
                        return true;
                    }
                }else if(strlen($error_msg) > 0)
                {
                    return $error_msg;
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

    function insertNewAdmin($first,$last,$email,$password)
    {
        try
        {
            $password = password_hash($password, PASSWORD_BCRYPT);
            if ($insert_stmt = $this->conn->prepare("INSERT INTO `site_admin` (`first_name`, `last_name`, `email`, `password`, `status`) VALUES (:first, :last, :email, :pass, :stat)")) 
            {
                $status = 1;
                $insert_stmt->bindParam(':first',$first,PDO::PARAM_STR);
                $insert_stmt->bindParam(':last',$last,PDO::PARAM_STR);
                $insert_stmt->bindParam(':email',$email,PDO::PARAM_STR);
                $insert_stmt->bindParam(':pass',$password,PDO::PARAM_STR);
                $insert_stmt->bindParam(':stat',$status,PDO::PARAM_STR);
                
                // Execute the prepared query.
                if ($insert_stmt->execute()) 
                {
                    if($insert_stmt->rowCount() > 0)
                    {
                        return true;
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

    public function deleteAdmin()
    {
        if(isset($_POST["admin_id"]))
        {
            $admin_id = $_POST["admin_id"];
            $query = $this->conn->prepare("DELETE FROM `site_admin` WHERE `id` = :aid ");
            $query->bindParam(":aid",$admin_id,PDO::PARAM_INT);
            $query->execute();
            if($query->rowCount() > 0)
            {
                return true;
            }else
            {
                return false;
            }
            
        }

    }

    public function saveAdmin()
    {
        if(isset($_POST["admin_id"],$_POST["first_name"],$_POST["last_name"],$_POST["email"],$_POST["status"]))
        {
            extract($_POST);
            $regex_text = "/^[a-zA-ZäöüßÄÖÜ]+$/";
            $error_msg = "";
            if((preg_match($regex_text,$first_name) == 0) && (preg_match($regex_text,$last_name) == 0) )
            {
                $error_msg .= '<p class="alert alert-danger">Ungültiges Format für Vor- oder Nachnamen</p>';
            }

            if(strlen($error_msg) == 0)
            {         
                $query = $this->conn->prepare("UPDATE `site_admin` SET `first_name`=:first,`last_name`=:last,`status`=:stat WHERE `id` = :id ");
                $query->bindParam(":id",$admin_id,PDO::PARAM_STR);
                $query->bindParam(":first",$first_name,PDO::PARAM_STR);
                $query->bindParam(":last",$last_name,PDO::PARAM_STR);
                $query->bindParam(":stat",$status,PDO::PARAM_STR);
                if($query->execute())
                {
                    return true;
                }else { return false; }
            }else { return $error_msg; }
        }else { return false; }
    }
    public function fetchAdminProperties($admin_email,$property)
    {
        $query = $this->conn->prepare("SELECT * FROM `site_admin` WHERE `email` = :em LIMIT 1 ");
        $query->bindParam(':em',$admin_email,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                if(isset($row[$property]))
                {
                    return htmlspecialchars_decode($row[$property],ENT_COMPAT);
                }else { return ""; }
            }
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
        return true;
    }

    // ADmin Panel -- Index Page -- start
    public function totalChefs()
    {
        $count = 0;
        $query = $this->conn->query("SELECT COUNT(id) as id FROM `members` WHERE `active` = '1' ");
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $count = intval($row["id"]);
                $query1 = $this->conn->query("SELECT COUNT(id) as id FROM `social_login` WHERE `active` = '1' ");
                if($query1->rowCount() > 0)
                {
                    $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result1 as $row1)
                    {
                        $count += intval($row1["id"]);
                    }
                    return $count;
                }else { return $count; }
            }
        }else { return $count;}
    }

    public function totalRecipes()
    {
        $count = 0;
        $query = $this->conn->query("SELECT COUNT(recipe_id) as total FROM `main_recipe` WHERE `status` = 'complete' ");
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $count = intval($row["total"]);
            }
            return $count;
        }else { return $count;}
    }

    public function totalAdmins()
    {
        $count = 0;
        $query = $this->conn->query("SELECT COUNT(id) as total FROM `site_admin` WHERE `status` = '1' ");
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $count = intval($row["total"]);
            }
            return $count;
        }else { return $count;}
    }

    public function totalIngredients()
    {
        $count = 0;
        $arr = array("supermarket_meat","supermarket_animal_products","supermarket_dairy_products","supermarket_legumes","supermarket_vegetables","supermarket_starch","supermarket_fruits","supermarket_herbs","supermarket_juices","fancies_spices","fancies_breadcrumbs","fancies_nuts","fancies_oils","fancies_spice_paste","fancies_driedfruits","utils");
        for($i = 0;$i < count($arr); $i++)
        {
            $table_name = $arr[$i];
            $query = $this->conn->query("SELECT COUNT(id) as total FROM `$table_name` ");
            if($query->rowCount() > 0)
            {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {
                    $count += intval($row["total"]);
                }
            }
        }
        return $count;
    }
    // Admin Panel -- Index Page -- end

}

?>