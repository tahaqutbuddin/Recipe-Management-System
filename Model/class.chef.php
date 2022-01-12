<?php
require_once __DIR__ . '/../includes/class.connect.php';
class chef
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
    // PROFILE page functions -- USER-- start
    public function checkChefExistsUsingNormalLogin($chef_email)
    {
        $query = $this->conn->prepare("SELECT * FROM `members` WHERE `email` = :em LIMIT 1 ");
        $query->bindParam(':em',$chef_email,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            return true;
        }else
        {
            return false;
        }
    }
    public function checkChefExistsUsingSocialLogin($chef_email)
    {
        $query = $this->conn->prepare("SELECT * FROM `social_login` WHERE `email` = :em LIMIT 1 ");
        $query->bindParam(':em',$chef_email,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            return true;
        }else
        {
            return false;
        }
    }

    public function checkCompleteDataExists($columnName,$chef_email)
    {
        $query = $this->conn->prepare("SELECT * FROM `complete_members` WHERE `$columnName` = :em LIMIT 1 ");
        $query->bindParam(':em',$chef_email,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            return true;
        }else
        {
            return false;
        }
    }
    public function fetchChefProperties($chef_email,$property)
    {
        if($this->checkChefExistsUsingNormalLogin($chef_email) == true)
        {
            $query = $this->conn->prepare("SELECT * FROM `members` WHERE `members`.`email` = :em LIMIT 1 ");
            $query->bindParam(':em',$chef_email,PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0)
            {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {
                    if(!isset($row[$property]))
                    {
                        if($this->checkCompleteDataExists("email",$chef_email) == true)
                        {
                            $query2 = $this->conn->prepare("SELECT * FROM `complete_members` WHERE `email` = :em LIMIT 1 ");
                            $query2->bindParam(':em',$chef_email,PDO::PARAM_STR);
                            $query2->execute();
                            if($query2->rowCount() > 0)
                            {
                                $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                foreach($result2 as $row2)
                                {
                                    if((strlen($row2[$property]) > 0))
                                    {
                                        return htmlspecialchars_decode($row2[$property],ENT_COMPAT);
                                    }else 
                                    { 
                                        if($property == "avatar")
                                        {
                                            if(preg_match('/dashboard/',$_SERVER["REQUEST_URI"]))
                                            {
                                                return "assets/img/avatars/dummy.png";
                                            }else
                                            {
                                                return "../dashboard/assets/img/avatars/dummy.png";
                                            }
                                            
                                        }else
                                        {
                                            return ""; 
                                        }
                                    }
                                }
                            }else 
                            { 
                                if($property == "avatar")
                                {
                                    if(preg_match('/dashboard/',$_SERVER["REQUEST_URI"]))
                                    {
                                        return "assets/img/avatars/dummy.png";
                                    }else
                                    {
                                        return "../dashboard/assets/img/avatars/dummy.png";
                                    }
                                }else
                                {
                                    return ""; 
                                }
                            }
                        }else 
                        { 
                            if($property == "avatar")
                            {
                                if(preg_match('/dashboard/',$_SERVER["REQUEST_URI"]))
                                {
                                    return "assets/img/avatars/dummy.png";
                                }else
                                {
                                    return "../dashboard/assets/img/avatars/dummy.png";
                                }
                            }else
                            {
                                return ""; 
                            }
                        }
                    }else 
                    { 
                        if(strlen($row[$property]) > 0)
                        {
                            return htmlspecialchars_decode($row[$property],ENT_COMPAT); 
                        }else { return ""; }
                    }
                }
            }
        }else if($this->checkChefExistsUsingSocialLogin($chef_email) == true)
        {
            $query = $this->conn->prepare("SELECT * FROM `social_login` WHERE `email` = :em LIMIT 1 ");
            $query->bindParam(':em',$chef_email,PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0)
            {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {
                    if(!isset($row[$property]))
                    {
                        if($this->checkCompleteDataExists("email",$chef_email) == true)
                        {
                            $query2 = $this->conn->prepare("SELECT * FROM `complete_members` WHERE `email` = :em LIMIT 1 ");
                            $query2->bindParam(':em',$chef_email,PDO::PARAM_STR);
                            $query2->execute();
                            if($query2->rowCount() > 0)
                            {
                                $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                foreach($result2 as $row2)
                                {
                                    if(strlen($row2[$property]) > 0)
                                    {
                                        return htmlspecialchars_decode($row2[$property],ENT_COMPAT); 
                                    }else 
                                    { 
                                        if($property == "avatar")
                                        {
                                            if(preg_match('/dashboard/',$_SERVER["REQUEST_URI"]))
                                            {
                                                return "assets/img/avatars/dummy.png";
                                            }else
                                            {
                                                return "../dashboard/assets/img/avatars/dummy.png";
                                            }
                                        }else
                                        {
                                            return ""; 
                                        }
                                    }
                                }
                            }else 
                            { 
                                if($property == "avatar")
                                {
                                    if(preg_match('/dashboard/',$_SERVER["REQUEST_URI"]))
                                    {
                                        return "assets/img/avatars/dummy.png";
                                    }else
                                    {
                                        return "../dashboard/assets/img/avatars/dummy.png";
                                    }
                                }else
                                {
                                    return ""; 
                                }
                            }
                        }
                    }else 
                    { 
                        if(strlen($row[$property]) > 0)
                        {
                            return htmlspecialchars_decode($row[$property],ENT_COMPAT); 
                        }else { return ""; }
                    }
                }
            }
        }
    }

    public function saveProfileData($check,$chef_email)
    {
            if($check == "user_settings")
            {
                if($this->checkChefExistsUsingNormalLogin($chef_email))
                {
                    if($this->updateUserSettingsOfProfilePage("members",$chef_email) == true)
                    {
                        return true;
                    }else { return false; }
                }else if($this->checkChefExistsUsingSocialLogin($chef_email) == true)
                {
                    if($this->updateUserSettingsOfProfilePage("social_login",$chef_email) == true)
                    {
                        return true;
                    }else { return false; }
                }

            }else if($check == "contact_details")
            {
                if($this->checkCompleteDataExists("email",$chef_email) == true)
                {
                    if($this->updateChefCompleteData($chef_email) == true)
                    {
                        return true;
                    }else
                    {
                        return false;
                    }
                }else
                {
                    if($this->insertChefCompleteData($chef_email) == true)
                    {
                        return true;
                    }else
                    {
                        return false;
                    }
                }
            }else if($check == "image")
            {
                if(preg_match('/dashboard/',$_SERVER["REQUEST_URI"]))
                {
                    $target_path = "assets/img/avatars/"; 
                }else
                {
                    $target_path = "../dashboard/assets/img/avatars/";  
                }
                // Loop to get individual element from the array
                $validextensions = array("jpeg", "jpg", "png","svg","webp");      // Extensions which are allowed.
                $ext = explode('.', basename($_FILES['avatar']['name']));   // Explode file name from dot(.)
                $file_extension = end($ext); // Store extensions in the variable.
                $md5_name = md5(uniqid()) . "." . $ext[count($ext) - 1];
                $checkExtension = strtolower($ext[count($ext) - 1]);
                if( ($checkExtension == "jpeg") || ($checkExtension == "jpg") || ($checkExtension == "png") || ($checkExtension == "svg") || ($checkExtension == "webp"))
                {
                    $target_path = $target_path . $md5_name;     // Set the target path with a new name of image.
                    if (($_FILES["avatar"]["size"] < 5000000)  && in_array($file_extension, $validextensions)) 
                    {
                        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_path)) 
                        {
                            if($this->updateChefAvatar($chef_email,$md5_name) == true)
                            {
                                return true;
                            }else { return 1; }
                        } else 
                        {     
                            return 2; // file was not moved
                        }
                    } else 
                    {    
                        return 3; //Invalid type and size
                    }
                }else
                {
                    return false;
                }
            }else if($check == "about_chef")
            {
                if($this->checkCompleteDataExists("email",$chef_email) == true)
                {
                    if($this->updateChefCompleteData($chef_email) == true)
                    {
                        return true;
                    }else
                    {
                        return false;
                    }
                }else
                {
                    if($this->insertChefCompleteData($chef_email) == true)
                    {
                        return true;
                    }else
                    {
                        return false;
                    }
                }
            }
    }

    public function updateUserSettingsOfProfilePage($table_name ,$chef_email)
    {
        $sql = "UPDATE `$table_name` SET ";
        foreach($_POST as  $key=>$value)
        {
            if($key == "save_settings1" || $key == "save_settings2" || $key == "image")
            {
                continue;
            }else if($key == "birth_date")
            {
                $this->updateChefBirthData($chef_email,$key,$value);
            }else
            {
                if(strlen($value) > 1)
                {
                    $sql .= " `$key` = '".htmlentities($value)."', ";
                }   
            }
        }
        $sql = substr($sql, 0, -2);
        $sql .=  " WHERE `email` = :em ";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':em',$chef_email,PDO::PARAM_STR);
        if($query->execute() > 0)
        {
            return true;
        }
    }

    public function insertChefCompleteData($chef_email)
    {
        extract($_POST);
        $query = $this->conn->prepare("INSERT INTO `complete_members`(`email`,`about_me`,`postal_code`,`address`,`city`,`country`,`continent`,`avatar`,`birth_date`) VALUES (:mid,:me,:pc,:ad,:ci,:cou,:con,:ava,:bd); ");
        $query->bindParam(':mid',$chef_email,PDO::PARAM_STR);
        $query->bindParam(':me',$about_me,PDO::PARAM_STR);
        $query->bindParam(':pc',$postal_code,PDO::PARAM_STR);
        $query->bindParam(':ad',$address,PDO::PARAM_STR);
        $query->bindParam(':ci',$city,PDO::PARAM_STR);
        $query->bindParam(':cou',$country,PDO::PARAM_STR);
        $query->bindParam(':con',$continent,PDO::PARAM_STR);
        $query->bindParam(':ava',$avatar,PDO::PARAM_STR);
        $query->bindParam(':bd',$birth_date,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            return true;
        }else
        {
            return false;
        }
    }
    public function updateChefCompleteData($chef_email)
    {
        $cnt = 1;
        $sql = 'UPDATE `complete_members` SET ';
        foreach($_POST as  $key=>$value)
        {
            if($key == "save_settings1" || $key == "save_settings2" || $key == "image" || $key == "about_chef")
            {
                continue;
            }
            $value = htmlentities($value);
            if((count($_POST) -1 ) == $cnt)
            {
                $sql .= " `$key` = '$value' ";
            }else
            {
                $sql .= " `$key` = '$value', ";
            }  
            $cnt++;
        }
        $sql .= " WHERE `email` = :em ";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':em',$chef_email,PDO::PARAM_STR);
        if($query->execute() > 0)
        {
            return true;
        }
    }

    public function updateChefBirthData($chef_email,$key,$value)
    {
        if($this->checkCompleteDataExists("email",$chef_email) == true)
        {
            $query = $this->conn->prepare("UPDATE `complete_members` SET `$key`=:val  WHERE `email` = :em ");
            $query->bindParam(':val',$value,PDO::PARAM_STR);
            $query->bindParam(':em',$chef_email,PDO::PARAM_STR);
            if($query->execute() > 0)
            {
                return true;
            }else { return false; }
        }else
        {
            $query = $this->conn->prepare("INSERT INTO `complete_members`(`email`,`birth_date`) VALUES(:em,:val) ");
            $query->bindParam(':em',$chef_email,PDO::PARAM_STR);
            $query->bindParam(':val',$value,PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0)
            {
                return true;
            }else { return false; }
        }
    }

    public function updateChefAvatar($chef_email,$name)
    {
        $sql = "UPDATE `complete_members` SET `avatar`=:avatar  WHERE `email` = :mid ";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':avatar',$name,PDO::PARAM_STR);
        $query->bindParam(':mid',$chef_email,PDO::PARAM_STR);
        if($query->execute() > 0)
        {
            return true;
        }
    }

   // PROFILE page function -- User --end


    
    public function fetchAllChefs()
    {
        $arr = array();
        $query = $this->conn->prepare("SELECT * FROM `members`");
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $chef_email = htmlentities($row["email"]);
                $check = "";
                if((intval($row["active"]) == 0))
                {
                    $check = "inactive";
                }else if((intval($row["active"] == 1)) && (intval($row["block"] == 1)))
                {
                    $check="block";
                }else if(intval($row["active"] == 1))
                {
                    $check = "active";
                }
                if($this->checkCompleteDataExists("email",$chef_email) == true) 
                {
                    $query1 = $this->conn->prepare("SELECT * FROM `complete_members` WHERE `email`=:em ");
                    $query1->bindParam(":em",$chef_email,PDO::PARAM_STR);
                    $query1->execute();
                    if($query1->rowCount() > 0)
                    {
                        $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result1 as $row1)
                        {
                            array_push($arr, array(
                                0 => $row["id"],
                                1 => htmlspecialchars_decode($row["first_name"],ENT_COMPAT), 
                                2 => htmlspecialchars_decode($row["last_name"],ENT_COMPAT),
                                3 => htmlspecialchars_decode($row["email"],ENT_COMPAT),
                                4 => htmlentities($row1["birth_date"]),
                                5 => htmlspecialchars_decode($row["city"],ENT_COMPAT), 
                                6 => htmlspecialchars_decode($row["country"],ENT_COMPAT), 
                                7 => htmlentities($check)
                            ));
                        }
                    }  
                }else
                {
                    array_push($arr, array(
                        0 => $row["id"],
                        1 => htmlspecialchars_decode($row["first_name"],ENT_COMPAT), 
                        2 => htmlspecialchars_decode($row["last_name"],ENT_COMPAT),
                        3 => htmlspecialchars_decode($row["email"],ENT_COMPAT),
                        4 => "",
                        5 => "",
                        6 => "",
                        7 => htmlentities($check)
                    ));
                } 
            }
        }
        $query21 = $this->conn->prepare("SELECT * FROM `social_login`");
        $query21->execute();
        if($query21->rowCount() > 0)
        {
            $result21 = $query21->fetchAll(PDO::FETCH_ASSOC);
            foreach($result21 as $row21)
            {
                $email = $row21["email"];
                $check = "";
                if((intval($row21["active"]) == 0))
                {
                    $check = "inactive";
                }else if((intval($row21["active"] == 1)) && (intval($row21["block"] == 1)))
                {
                    $check="block";
                }else if(intval($row21["active"] == 1))
                {
                    $check = "active";
                }
                if($this->checkCompleteDataExists("email",$email) == true) 
                {
                    $query22 = $this->conn->prepare("SELECT * FROM `complete_members` WHERE `email`=:em ");
                    $query22->bindParam(":em",$email,PDO::PARAM_STR);
                    $query22->execute();
                    if($query22->rowCount() > 0)
                    {
                        $result22 = $query22->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result22 as $row22)
                        {
                            array_push($arr, array(
                                0 => $row21["id"],
                                1 => htmlspecialchars_decode($row21["first_name"],ENT_COMPAT), 
                                2 => htmlspecialchars_decode($row21["last_name"],ENT_COMPAT),
                                3 => htmlspecialchars_decode($row21["email"],ENT_COMPAT),
                                4 => htmlentities($row22["birth_date"]),
                                5 => htmlspecialchars_decode($row22["city"],ENT_COMPAT), 
                                6 => htmlspecialchars_decode($row22["country"],ENT_COMPAT), 
                                7 => htmlentities($check)
                            ));
                        }
                    }
                }else
                {
                    array_push($arr, array(
                        0 => $row21["id"],
                        1 => htmlspecialchars_decode($row21["first_name"],ENT_COMPAT), 
                        2 => htmlspecialchars_decode($row21["last_name"],ENT_COMPAT),
                        3 => htmlspecialchars_decode($row21["email"],ENT_COMPAT),
                        4 => "",
                        5 => "",
                        6 => "",
                        7 => htmlentities($check)
                    ));
                }   
            }
        }
        return json_encode($arr);
    }

    // PROFILE page function -- Admin --start
    public function blockChef($chef_email)
    {
        if($this->checkChefExistsUsingNormalLogin($chef_email) == true)
        {
            $query = $this->conn->prepare("UPDATE `members` SET `block` = '1' WHERE `email` = :em ");
            $query->bindParam(":em",$chef_email,PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0)
            {
                return true;
            }else { return false; }
        }else if($this->checkChefExistsUsingSocialLogin($chef_email) == true)
        {
            $query = $this->conn->prepare("UPDATE `social_login` SET `block` = '1' WHERE `email` = :em ");
            $query->bindParam(":em",$chef_email,PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0)
            {
                return true;
            }else { return false; }
        }
    }
    public function unblockChef($chef_email)
    {
        if($this->checkChefExistsUsingNormalLogin($chef_email) == true)
        {
            $query = $this->conn->prepare("UPDATE `members` SET `block` = '0' WHERE `email` = :em ");
            $query->bindParam(":em",$chef_email,PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0)
            {
                return true;
            }else { return false; }
        }else if($this->checkChefExistsUsingSocialLogin($chef_email) == true)
        {
            $query = $this->conn->prepare("UPDATE `social_login` SET `block` = '0' WHERE `email` = :em ");
            $query->bindParam(":em",$chef_email,PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0)
            {
                return true;
            }else { return false; }
        }
    } 
    public function deletechef($chef_email)
    {
        if($this->checkChefExistsUsingNormalLogin($chef_email) == true)
        {
            if($this->checkCompleteDataExists("email",$chef_email) == true)
            {
                $query = $this->conn->prepare("DELETE FROM `complete_members` WHERE `email` = :em ");
                $query->bindParam(":em",$chef_email,PDO::PARAM_STR);
                $query->execute();
                if($query->rowCount() > 0)
                {
                        $query1 = $this->conn->prepare("DELETE FROM `members` WHERE `email` = :em ");
                        $query1->bindParam(":em",$chef_email,PDO::PARAM_INT);
                        $query1->execute();
                        if($query1->rowCount() > 0)
                        {   
                            return true;
                        }else { return false; }
                }else { return false; }
            }else
            {
                $query = $this->conn->prepare("DELETE FROM `members` WHERE `email` = :em ");
                $query->bindParam(":em",$chef_email,PDO::PARAM_STR);
                $query->execute();
                if($query->rowCount() > 0)
                {
                    return true;
                }else { return false; }
            }
        }else if($this->checkChefExistsUsingSocialLogin($chef_email) == true)
        {
            if($this->checkCompleteDataExists("email",$chef_email) == true)
            {
                $query = $this->conn->prepare("DELETE FROM `complete_members` WHERE `email` = :em ");
                $query->bindParam(":em",$chef_email,PDO::PARAM_STR);
                $query->execute();
                if($query->rowCount() > 0)
                {
                    $query1 = $this->conn->prepare("DELETE FROM `social_login` WHERE `email` = :em ");
                    $query1->bindParam(":em",$chef_email,PDO::PARAM_STR);
                    $query1->execute();
                    if($query1->rowCount() > 0)
                    {   
                        return true;
                    }else { return false; }                    
                }else { return false; }
            }else
            {
                $query = $this->conn->prepare("DELETE FROM `social_login` WHERE `email` = :em ");
                $query->bindParam(":em",$chef_email,PDO::PARAM_STR);
                $query->execute();
                if($query->rowCount() > 0)
                {
                    return true;
                }else { return false; }
            }
        }
    }
    // PROFILE page function -- Admin --end

    // Form Page of User Dashboard -- start
    public function checkRecipeForCurrentChef($chef_email)
    {
        $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `chef_email` = :em AND `status`='incomplete' ");
        $query->bindParam(":em",$chef_email,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $recipe_id = $row["recipe_id"];
            }
            return $recipe_id;
        }else { return false; }
    }

    // Form Page of user's Dashboard --end
}

?>