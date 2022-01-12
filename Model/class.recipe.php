<?php
require_once __DIR__ . '/../includes/class.connect.php';
class recipe
{ 
    private $conn = NULL;
    private $recipe_id = 0;

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

    
    // FORM functions -- start

    public function fetchDataForIngredients($ingre_section, $ingre_type)
    {
        $arr = array();
        if($ingre_section == "supermarket")
        {
            $table_name = "supermarket_".$ingre_type;
            $sql = "SELECT * FROM `$table_name`";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if($query->rowCount() > 0)
            {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {
                    array_push($arr, array(
                        "id" => $row["id"],
                        "title" => htmlspecialchars_decode($row["description"],ENT_COMPAT)
                    ));
                }
                return json_encode($arr);
            }else
            {
                return false;
            }
        }else if($ingre_section == "fancies")
        {
            $table_name = "fancies_".$ingre_type;
            $sql = "SELECT * FROM `$table_name`";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if($query->rowCount() > 0)
            {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {
                    array_push($arr, array(
                        "id" => $row["id"],
                        "title" => htmlspecialchars_decode($row["description"],ENT_COMPAT)
                    ));
                }
                return json_encode($arr);
            }else
            {
                return false;
            }
        }
    }
    public function fetchDataForUtils()
    {
        $arr = array();
        $sql = "SELECT * FROM `utils` ";
        $query = $this->conn->prepare($sql);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                array_push($arr, array(
                    "id" => $row["id"],
                    "title" => htmlspecialchars_decode($row["description"],ENT_COMPAT)
                ));
            }
            return json_encode($arr);
        }else
        {
            return false;
        }
       
    }
    public function insertUtil($value)
    {
        $sql = "INSERT INTO `utils`(`description`) VALUES(:d) ;";
        $query = $this->conn->prepare($sql);
        $value = strtolower($value);
        $query->bindParam(":d",$value,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            return true;
        }
    }

    public function deleteUtil($ingre_id)
    {
        $query = $this->conn->prepare("DELETE FROM `utils` WHERE `id`= :id");
        $query->bindParam(":id",$ingre_id,PDO::PARAM_INT);
        $query->execute();
        if($query->rowCount() > 0)
        {
            return true;
        }
    }

    public function insertIngredients($ingre_type,$table_name,$value)
    {
        $table = htmlentities($ingre_type).'_'.htmlentities($table_name);
        $value = strtolower($value);
        $sql = $this->conn->prepare("SELECT * FROM `$table` WHERE `description`=:d ");
        $sql->bindParam(":d",$value,PDO::PARAM_STR);
        $sql->execute();
        if($sql->rowCount() == 0)
        {
            $query = $this->conn->prepare("INSERT INTO `$table`(`description`) VALUES(:d); ");
            $query->bindParam(":d",$value,PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0)
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

    }

    public function fetchAllIngredients($ingre_type,$table_name)
    {
        $arr = array();
        $table = $ingre_type."_".$table_name;
        $sql = "SELECT * FROM `$table` ";
        $query = $this->conn->prepare($sql);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                array_push($arr, array(
                    0 => $row["id"],
                    1 => htmlspecialchars_decode(ucfirst($row["description"]),ENT_COMPAT)
                ));
            }
            return json_encode($arr);
        }else 
        {
            return false;
        }
        
    }

    public function deleteIngredients($ingre_type,$table_name,$ingre_id)
    {
        $table = htmlentities($ingre_type)."_".htmlentities($table_name);
        $query = $this->conn->prepare("DELETE FROM `$table` WHERE `id`= :id");
        $query->bindParam(":id",$ingre_id,PDO::PARAM_INT);
        $query->execute();
        if($query->rowCount() > 0)
        {
            return true;
        }
    }


    public function updateRecipeStatus($chef_email,$status)
    {
        $query = $this->conn->prepare("UPDATE `main_recipe` SET `status`=:st, `created_at` = NOW() WHERE `chef_email` = :em  AND `status`='incomplete' ");
        $query->bindParam(':st',$status,PDO::PARAM_STR);
        $query->bindParam(':em',$chef_email,PDO::PARAM_STR);
        if($query->execute() > 0)
        {
            return true;
        }
    }
    public function saveFormDataCheckbox($value,$valueToCheck,$table_name,$type,$values,$status)
    {
        $values = implode(',',$values);
        if($value == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id` = :em AND `status`=:st LIMIT 1 ");
        }else if($value == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `chef_email` = :em AND `status`=:st LIMIT 1 ");
        }
        $query->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() == 0)
        {
            $query1 = $this->conn->prepare("INSERT INTO `$table_name`(`chef_email`,`$type`) VALUES(:em , :val);");
            $query1->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
            $query1->bindParam(":val",$values,PDO::PARAM_STR);
            $query1->execute();
            if($query1->rowCount() == 0)
            {
                return true;
            }
        }else
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $recipe_id = 0;
            foreach($result as $row)
            {
                $recipe_id = $row["recipe_id"];
                $query2 = $this->conn->prepare("UPDATE `$table_name` SET `$type` = :val WHERE `recipe_id` =:id ");
                $query2->bindParam(":val",$values,PDO::PARAM_STR);
                $query2->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                if($query2->execute())
                {
                    return true;
                }
            }
        }
    }

    public function saveNutritionalInfo($value,$valueToCheck,$table_name,$values,$status)
    {
        $calorie = isset($values[0]) ? $values[0] :  0;
        $fat = isset($values[1]) ? $values[1] :  0;
        $carbo = isset($values[2]) ? $values[2] :  0;
        $protein = isset($values[3]) ? $values[3] :  0;
        if($value == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `recipe_id` = :em AND `status`=:st LIMIT 1 ");
        }else if($value == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `chef_email` = :em AND `status`=:st LIMIT 1 ");
        }
        $query->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $recipe_id = 0;
            foreach($result as $row)
            {
                $recipe_id = $row["recipe_id"];
                $query1 = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id` = :id ");
                $query1->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                $query1->execute();
                if($query1->rowCount() > 0)
                {
                    $query3 = $this->conn->prepare("UPDATE `$table_name` SET `calorie` = :ca , `fat` = :fa , `carbohydrates` = :car , `protein` = :pr WHERE `recipe_id` = :id; ");
                    $query3->bindParam(":ca",$calorie,PDO::PARAM_INT);
                    $query3->bindParam(":fa",$fat,PDO::PARAM_INT);
                    $query3->bindParam(":car",$carbo,PDO::PARAM_INT);
                    $query3->bindParam(":pr",$protein,PDO::PARAM_INT);
                    $query3->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                    $query3->execute();
                    if($query3->rowCount() > 0)
                    { 
                        return true;
                    }
                }else if($query->rowCount() > 0)
                {
                    $query2 = $this->conn->prepare("INSERT INTO `$table_name`(`recipe_id`,`calorie`,`fat`,`carbohydrates`,`protein`) VALUES(:id , :ca, :fa, :car, :pr);");
                    $query2->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                    $query2->bindParam(":ca",$calorie,PDO::PARAM_INT);
                    $query2->bindParam(":fa",$fat,PDO::PARAM_INT);
                    $query2->bindParam(":car",$carbo,PDO::PARAM_INT);
                    $query2->bindParam(":pr",$protein,PDO::PARAM_INT);
                    $query2->execute();
                    if($query2->rowCount() == 0)
                    {
                        return true;
                    }
                }
            }
        }
    }
    public function saveTechnicalDetails($value,$valueToCheck,$table_name,$values,$status)
    {
        $prep = isset($values[0]) ? $values[0] :  0;
        $cook = isset($values[1]) ? $values[1] :  0;
        if($value == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id` = :em AND `status`=:st LIMIT 1 ");
        }else if($value == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `chef_email` = :em AND `status`=:st LIMIT 1 ");
        }
        $query->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() == 0)
        {
            $query1 = $this->conn->prepare("INSERT INTO `$table_name`(`chef_email`,`prep_time`,`cooking_time`) VALUES(:em , :val1 : val2);");
            $query1->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
            $query1->bindParam(":val1",$prep,PDO::PARAM_INT);
            $query1->bindParam(":val2",$cook,PDO::PARAM_INT);
            $query1->execute();
            if($query1->rowCount() == 0)
            {
                return true;
            }
        }else
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $recipe_id = 0;
            foreach($result as $row)
            {
                $recipe_id = $row["recipe_id"];
                $query2 = $this->conn->prepare("UPDATE `$table_name` SET `prep_time` = :val1 , `cooking_time` = :val2 WHERE `recipe_id` =:id ");
                $query2->bindParam(":val1",$prep,PDO::PARAM_INT);
                $query2->bindParam(":val2",$cook,PDO::PARAM_INT);
                $query2->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                if($query2->execute())
                {
                    return true;
                }
            }
        }
    }

    public function saveDiffAndSharp($value,$valueToCheck,$table_name,$values,$status)
    {
        $diff = isset($values[0]) ? $values[0] :  1;
        $sharp = isset($values[1]) ? $values[1] :  1;
        if($value == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id` = :em AND `status`=:st LIMIT 1 ");
        }else if($value == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `chef_email` = :em AND `status`=:st LIMIT 1 ");
        }
        $query->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() == 0)
        {
            $query1 = $this->conn->prepare("INSERT INTO `$table_name`(`chef_email`,`difficulty`,`sharpness`) VALUES(:em , :val1 : val2);");
            $query1->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
            $query1->bindParam(":val1",$diff,PDO::PARAM_INT);
            $query1->bindParam(":val2",$sharp,PDO::PARAM_INT);
            $query1->execute();
            if($query1->rowCount() == 0)
            {
                return true;
            }
        }else
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $recipe_id = 0;
            foreach($result as $row)
            {
                $recipe_id = $row["recipe_id"];
                $query2 = $this->conn->prepare("UPDATE `$table_name` SET `difficulty` = :val1 , `sharpness` = :val2 WHERE `recipe_id` =:id ");
                $query2->bindParam(":val1",$diff,PDO::PARAM_INT);
                $query2->bindParam(":val2",$sharp,PDO::PARAM_INT);
                $query2->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                if($query2->execute())
                {
                    return true;
                }
            }
        }
    }

    public function saveSupermarketIngredients($value,$valueToCheck,$table_name,$values,$status)
    {
        $meat = isset($values[0]) ? $values[0] :  "";
        $animal = isset($values[1]) ? $values[1] :  "";
        $dairy = isset($values[2]) ? $values[2] :  "";
        $legumes = isset($values[3]) ? $values[3] :  "";
        $vegetables = isset($values[4]) ? $values[4] :  "";
        $starch = isset($values[5]) ? $values[5] :  "";
        $fruit = isset($values[6]) ? $values[6] :  "";
        $herbs = isset($values[7]) ? $values[7] :  "";
        $juices = isset($values[8]) ? $values[8] :  "";
        if($value == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `recipe_id` = :em AND `status`=:st LIMIT 1 ");
        }else if($value == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `chef_email` = :em AND `status`=:st LIMIT 1 ");
        }
        $query->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $recipe_id = 0;
            foreach($result as $row)
            {
                $recipe_id = $row["recipe_id"];
                $query1 = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id` = :id ");
                $query1->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                $query1->execute();
                if($query1->rowCount() > 0)
                {
                    $query2 = $this->conn->prepare("UPDATE `$table_name` SET `meat` = :val1 , `animal_products`= :val2 , `dairy_products` = :val3, `legumes` = :val4, `vegetables` = :val5, `starch` = :val6 , `fruit` = :val7, `herbs` = :val8, `juices` = :val9 WHERE `recipe_id` =:id ");
                    $query2->bindParam(":val1",$meat,PDO::PARAM_STR);
                    $query2->bindParam(":val2",$animal,PDO::PARAM_STR);
                    $query2->bindParam(":val3",$dairy,PDO::PARAM_STR);
                    $query2->bindParam(":val4",$legumes,PDO::PARAM_STR);
                    $query2->bindParam(":val5",$vegetables,PDO::PARAM_STR);
                    $query2->bindParam(":val6",$starch,PDO::PARAM_STR);
                    $query2->bindParam(":val7",$fruit,PDO::PARAM_STR);
                    $query2->bindParam(":val8",$herbs,PDO::PARAM_STR);
                    $query2->bindParam(":val9",$juices,PDO::PARAM_STR);
                    $query2->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                    if($query2->execute())
                    {
                        return true;
                    }
                }else if($query1->rowCount() == 0)
                {
                    $query2 = $this->conn->prepare("INSERT INTO `$table_name`(`recipe_id`, `meat`, `animal_products`, `dairy_products`, `legumes`, `vegetables`, `starch`, `fruit`, `herbs`, `juices`) VALUES (:id,:val1,:val2,:val3,:val4,:val5,:val6,:val7,:val8,:val9)");
                    $query2->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                    $query2->bindParam(":val1",$meat,PDO::PARAM_STR);
                    $query2->bindParam(":val2",$animal,PDO::PARAM_STR);
                    $query2->bindParam(":val3",$dairy,PDO::PARAM_STR);
                    $query2->bindParam(":val4",$legumes,PDO::PARAM_STR);
                    $query2->bindParam(":val5",$vegetables,PDO::PARAM_STR);
                    $query2->bindParam(":val6",$starch,PDO::PARAM_STR);
                    $query2->bindParam(":val7",$fruit,PDO::PARAM_STR);
                    $query2->bindParam(":val8",$herbs,PDO::PARAM_STR);
                    $query2->bindParam(":val9",$juices,PDO::PARAM_STR);
                    $query2->execute();
                    if($query2->rowCount() == 0)
                    {
                        return true;
                    }
                }
            }
        }
    }
    public function saveFanciesIngredients($value,$valueToCheck,$table_name,$values,$status)
    {
        $spices = isset($values[0]) ? $values[0] :  "";
        $breadcrumbs = isset($values[1]) ? $values[1] :  "";
        $nuts = isset($values[2]) ? $values[2] :  "";
        $oils = isset($values[3]) ? $values[3] :  "";
        $spice_paste = isset($values[4]) ? $values[4] :  "";
        $driedfruits = isset($values[5]) ? $values[5] :  "";
        
        if($value == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `recipe_id` = :em AND `status`=:st LIMIT 1 ");
        }else if($value == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `chef_email` = :em AND `status`=:st LIMIT 1 ");
        }
        $query->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $recipe_id = 0;
            foreach($result as $row)
            {
                $recipe_id = $row["recipe_id"];
                $query1 = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id` = :id ");
                $query1->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                $query1->execute();
                if($query1->rowCount() > 0)
                {
                    $query2 = $this->conn->prepare("UPDATE `$table_name` SET `spices` = :val1 , `breadcrumbs`=:val2 , `nuts` = :val3, `oils` = :val4, `spice_paste` = :val5, `driedfruits` = :val6 WHERE `recipe_id` =:id ");
                    $query2->bindParam(":val1",$spices,PDO::PARAM_STR);
                    $query2->bindParam(":val2",$breadcrumbs,PDO::PARAM_STR);
                    $query2->bindParam(":val3",$nuts,PDO::PARAM_STR);
                    $query2->bindParam(":val4",$oils,PDO::PARAM_STR);
                    $query2->bindParam(":val5",$spice_paste,PDO::PARAM_STR);
                    $query2->bindParam(":val6",$driedfruits,PDO::PARAM_STR);
                    $query2->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                    if($query2->execute())
                    {
                        return true;
                    }
                }else if($query1->rowCount() == 0)
                {
                    $query2 = $this->conn->prepare("INSERT INTO `$table_name`(`recipe_id`, `spices`, `breadcrumbs`, `nuts`, `oils`, `spice_paste`, `driedfruits`) VALUES (:id,:val1,:val2,:val3,:val4,:val5,:val6)");
                    $query2->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                    $query2->bindParam(":val1",$spices,PDO::PARAM_STR);
                    $query2->bindParam(":val2",$breadcrumbs,PDO::PARAM_STR);
                    $query2->bindParam(":val3",$nuts,PDO::PARAM_STR);
                    $query2->bindParam(":val4",$oils,PDO::PARAM_STR);
                    $query2->bindParam(":val5",$spice_paste,PDO::PARAM_STR);
                    $query2->bindParam(":val6",$driedfruits,PDO::PARAM_STR);
                    $query2->execute();
                    if($query2->rowCount() == 0)
                    {
                        return true;
                    }
                }
            }
        }
    }

    public function saveUtils($value,$valueToCheck,$table_name,$values,$status)
    {
        $utils = implode(',',$values);
        if($value == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id` = :em AND `status`=:st LIMIT 1 ");
        }else if($value == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `chef_email` = :em AND `status`=:st LIMIT 1 ");
        }
        $query->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $recipe_id = 0;
            foreach($result as $row)
            {
                $recipe_id = $row["recipe_id"];
                $query2 = $this->conn->prepare("UPDATE `$table_name` SET `utils` = :val1 WHERE `recipe_id` =:id ");
                $query2->bindParam(":val1",$utils,PDO::PARAM_STR);
                $query2->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                if($query2->execute())
                {
                    return true;
                }
            }
        }
        else if($query->rowCount() == 0)
        {
            $query2 = $this->conn->prepare("INSERT INTO `$table_name`(`chef_email`,`utils`) VALUES (:em , :val1); ");
            $query2->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
            $query2->bindParam(":val1",$utils,PDO::PARAM_STR);
            $query2->execute();
            if($query2->rowCount() == 0)
            {
                return true;
            }
        }
    }
    public function saveCookingImagesInFolder( )
    {
        $arr = array();
        $flag = false;
        if(isset($_FILES['cooking_image']))
        {
            if(preg_match('/dashboard/',$_SERVER["REQUEST_URI"]))
            {
                $target_path = "assets/img/cookingsteps/";
            }else
            {
                $target_path = "../dashboard/assets/img/cookingsteps/";
            }
            
            $validextensions = array("jpeg", "jpg", "png","svg","webp");      // Extensions which are allowed.
            for($i = 0; $i < count($_FILES["cooking_image"]["name"]);$i++)
            {
                if(strlen($_FILES["cooking_image"]["name"][$i]) > 0)
                {
                    $md5_name = "";
                    $ext = explode('.', basename(strtolower($_FILES["cooking_image"]['name'][$i])));   // Explode file name from dot(.)
                    $file_extension = end($ext); // Store extensions in the variable.
                    $md5_name = md5(uniqid()) . "." . $ext[count($ext) - 1];
                    $checkExtension = strtolower($ext[count($ext) - 1]);
                    if( ($checkExtension == "jpeg") || ($checkExtension == "jpg") || ($checkExtension == "png") || ($checkExtension == "svg") || ($checkExtension == "webp"))
                    {
                        $target_path = $target_path . $md5_name;     // Set the target path with a new name of image.
                        if (($_FILES["cooking_image"]["size"][$i] < 5000000)  && in_array($file_extension, $validextensions)) 
                        {
                            if (move_uploaded_file($_FILES["cooking_image"]['tmp_name'][$i], $target_path)) 
                            {
                                array_push($arr,$md5_name);
                                if(preg_match('/dashboard/',$_SERVER["REQUEST_URI"]))
                                {
                                    $target_path = "assets/img/cookingsteps/";
                                }else
                                {
                                    $target_path = "../dashboard/assets/img/cookingsteps/";
                                }
                            }else { return false; } // unable to move file 
                        }else { return false; } //invalid type and size
                    }else { return false; }
                }else if( (isset($_POST["cooking_image_old"][$i])) && (strlen($_POST["cooking_image_old"][$i]) > 0) )
                {
                    array_push($arr , $_POST["cooking_image_old"][$i]);
                }
                else { 
                    $flag = true;
                    continue; 
                }
            }
            if( (count($arr) > 0) || ($flag == true) )
            {
                return $arr;
            }
        }else if( (!isset($_FILES["cooking_image"])) && (isset($_POST["cooking_image_old"])) )
        {
            return $_POST["cooking_image_old"];
        }
        else { return false;}
    }
    
    public function saveCookingSteps($val,$valueToCheck,$table_name,$values,$images,$status) 
    {
        $recipe_id = 0;
        $flag = false;
        if($val == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `recipe_id` = :em AND `status`=:st LIMIT 1 ");
        }else if($val == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `chef_email` = :em AND `status`=:st LIMIT 1 ");
        }
        $query->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $recipe_id = $row["recipe_id"];
                $query1 = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id`=:id ");
                $query1->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                $query1->execute();
                if($query1->rowCount() > 0)
                {
                    $query2 = $this->conn->prepare("DELETE FROM `$table_name` WHERE `recipe_id`=:id ");
                    $query2->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                    $query2->execute();
                    if($query2->rowCount() > 0)
                    {
                        for($i = 0; $i < count($values["cooking_step_id"]); $i++)
                        {
                            $step = $i+1;
                            $title = isset($values["cooking_title"][$i]) ? $values["cooking_title"][$i] : NULL ;
                            $desc =  isset($values["cooking_description"][1]) ? $values["cooking_description"][$i] : NULL ;
                            $image = isset($images[$i]) ? $images[$i] : NULL ;
                            $query2 = $this->conn->prepare("INSERT INTO `$table_name`(`recipe_id`,`step_no`,`title`,`description`,`image`) VALUES(:ri,:step,:ti,:desc,:im); ");
                            $query2->bindParam(":ri",$recipe_id,PDO::PARAM_INT);
                            $query2->bindParam(":step",$step,PDO::PARAM_INT);
                            $query2->bindParam(":ti",$title,PDO::PARAM_STR);
                            $query2->bindParam(":desc",$desc,PDO::PARAM_STR);
                            $query2->bindParam(":im",$image,PDO::PARAM_STR);
                            $query2->execute();
                            if($query2->rowCount() > 0)
                            {
                                $flag = true;
                            }else{ return false;}
                        }
                    }
                    
                }else if($query1->rowCount() == 0)
                {   
                    for($i = 0; $i < count($values); $i++)
                    {
                        $step = $i+1;
                        $title = isset($values[$i][0]) ? $values[$i][0] : NULL ;
                        $desc =  isset($values[$i][1]) ? $values[$i][1] : NULL ;
                        $image = isset($images[$i]) ? $images[$i] : NULL ;
                        $query2 = $this->conn->prepare("INSERT INTO `$table_name`(`recipe_id`,`step_no`,`title`,`description`,`image`) VALUES(:ri,:step,:ti,:desc,:im); ");
                        $query2->bindParam(":ri",$recipe_id,PDO::PARAM_INT);
                        $query2->bindParam(":step",$step,PDO::PARAM_INT);
                        $query2->bindParam(":ti",$title,PDO::PARAM_STR);
                        $query2->bindParam(":desc",$desc,PDO::PARAM_STR);
                        $query2->bindParam(":im",$image,PDO::PARAM_STR);
                        $query2->execute();
                        if($query2->rowCount() > 0)
                        {
                            $flag = true;
                        }else{ return false;}
                    }
                }
                return true;
            } 
        }
    }
    public function saveFormDataInitial($value,$valueToCheck,$table_name,$values,$status)
    {
        $title = isset($values[0]) ? $values[0] :  "";
        $desc = isset($values[1]) ? $values[1] :  "";
        if($value == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id` = :em AND `status`=:st LIMIT 1 ");
        }else if($value == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `chef_email` = :em AND `status`=:st LIMIT 1 ");
        }
        $query->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() == 0)
        {
            $query1 = $this->conn->prepare("INSERT INTO `$table_name`(`chef_email`,`title`,`description`) VALUES(:em , :val1, :val2);");
            $query1->bindParam(":em",$valueToCheck,PDO::PARAM_STR);
            $query1->bindParam(":val1",$title,PDO::PARAM_STR);
            $query1->bindParam(":val2",$desc,PDO::PARAM_STR);
            $query1->execute();
            if($query1->rowCount() == 0)
            {
                return true;
            }
        }else if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $recipe_id = 0;
            foreach($result as $row)
            {
                $recipe_id = $row["recipe_id"];
                $query2 = $this->conn->prepare("UPDATE `$table_name` SET `title` = :val1 , `description` = :val2 WHERE `recipe_id` =:id ");
                $query2->bindParam(":val1",$title,PDO::PARAM_STR);
                $query2->bindParam(":val2",$desc,PDO::PARAM_STR);
                $query2->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                if($query2->execute())
                {
                    return true;
                }
            }
        }
    }
   
    public function checkFormSubmission($chef_email)
    {
        $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `chef_email`=:em AND `status`='complete' AND DATE_ADD(`created_at`, INTERVAL 1 MINUTE) >= NOW() ");
        $query->bindParam(":em",$chef_email,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            return "true";
        }else
        {
            return "false";
        }
    }
    public function deleteRecipe($recipe_id,$status)
    {
        $cnt = 0;
        $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `recipe_id`=:id AND `status` =:st");
        $query->bindParam(":id",$recipe_id,PDO::PARAM_INT);
        $query->bindParam(":st",$status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $query00 = $this->conn->prepare("SELECT * FROM `cooking_steps` WHERE `recipe_id`=:id");
            $query00->bindParam(":id",$recipe_id,PDO::PARAM_INT);
            $query00->execute();
            if($query00->rowCount() > 0)
            {
                $query01 = $this->conn->prepare("DELETE FROM `cooking_steps` WHERE `recipe_id`=:id");
                $query01->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                $query01->execute();
                if($query01->rowCount() > 0)
                {
                    $cnt++;
                }
            }else
            {
                $cnt++;
            }

            $query10 = $this->conn->prepare("SELECT * FROM `recipe_supermarket` WHERE `recipe_id`=:id  LIMIT 1");
            $query10->bindParam(":id",$recipe_id,PDO::PARAM_INT);
            $query10->execute();
            if($query10->rowCount() > 0)
            {
                $query11 = $this->conn->prepare("DELETE FROM `recipe_supermarket` WHERE `recipe_id`=:id ");
                $query11->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                $query11->execute();
                if($query11->rowCount() > 0)
                {
                    $cnt++;
                }
            }else
            {
                $cnt++;
            }

            $query20 = $this->conn->prepare("SELECT * FROM `recipe_fancies` WHERE `recipe_id`=:id LIMIT 1 ");
            $query20->bindParam(":id",$recipe_id,PDO::PARAM_INT);
            $query20->execute();
            if($query20->rowCount() > 0)
            {
                $query21 = $this->conn->prepare("DELETE FROM `recipe_fancies` WHERE `recipe_id`=:id ");
                $query21->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                $query21->execute();
                if($query21->rowCount() > 0)
                {
                    $cnt++;
                }
            }
            else
            {
                $cnt++;
            }

            $query30 = $this->conn->prepare("SELECT * FROM `nutritional_info` WHERE `recipe_id`=:id LIMIT 1 ");
            $query30->bindParam(":id",$recipe_id,PDO::PARAM_INT);
            $query30->execute();
            if($query30->rowCount() > 0)
            {
                $query31 = $this->conn->prepare("DELETE FROM `nutritional_info` WHERE `recipe_id`=:id ");
                $query31->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                $query31->execute();
                if($query31->rowCount() > 0)
                {
                    $cnt++;
                }
            }
            else
            {
                $cnt++;
            }

            if($cnt == 4)
            {
                $query40 = $this->conn->prepare("DELETE FROM `main_recipe` WHERE `recipe_id`=:id ");
                $query40->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                $query40->execute();
                if($query40->rowCount() > 0)
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
        }
    }

    // FORM functions -- end

    //Overview Page Functions -- start
    public function userInsertedDataCheckbox($check,$ValueToCheck,$table_name,$column,$recipe_status)
    {   
        $arr = "";
        if($check == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id`=:em AND `status`=:st LIMIT 1 ");
        }else if($check == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `chef_email`=:em AND `status`=:st LIMIT 1 "); 
        }
        $query->bindParam(":em",$ValueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$recipe_status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                if(strlen($row[$column]) > 0)
                {
                    $arr = explode(',',$row[$column]);
                }else{ return false; }
            }
            return $arr;
        }else { return false; }
    }

    public function userInsertedDataTechnical($check,$ValueToCheck,$table_name,$column,$recipe_status)
    {
        $val = "";
        if($check == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id`=:em AND `status`=:st LIMIT 1 ");
        }else if($check == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `chef_email`=:em AND `status`=:st LIMIT 1 "); 
        }
        $query->bindParam(":em",$ValueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$recipe_status,PDO::PARAM_STR);
        
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
               $val = $row[$column];
            }
            return htmlspecialchars_decode($val,ENT_COMPAT);
        }else { return false; }
    }
    public function userInsertedDataNutritional($check,$ValueToCheck,$table_name,$column,$recipe_status)
    {
        $val = "";
        $recipe_id = 0;
        if($check == "id")
        {
            $query1 = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id`=:id LIMIT 1 ");
            $query1->bindParam(":id",$ValueToCheck,PDO::PARAM_INT);
            $query1->execute();
            if($query1->rowCount() > 0)
            {
                $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);
                foreach($result1 as $row1)
                {
                    if(strlen($row1[$column]) > 0)
                    {
                        $val = $row1[$column];    
                    }else{ return false;}
                }
                return htmlspecialchars_decode($val,ENT_COMPAT);
            }else { return false; }
        }else if($check == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `chef_email`=:em AND `status`=:st LIMIT 1 "); 
            $query->bindParam(":em",$ValueToCheck,PDO::PARAM_STR);
            $query->bindParam(":st",$recipe_status,PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0)
            {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {
                $recipe_id = $row["recipe_id"];
                } 
                $query1 = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id`=:id LIMIT 1 ");
                $query1->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                $query1->execute();
                if($query1->rowCount() > 0)
                {
                    $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result1 as $row1)
                    {
                        if(strlen($row1[$column]) > 0)
                        {
                            $val = $row1[$column];    
                        }else{ return false;}
                    }
                    return htmlspecialchars_decode($val,ENT_COMPAT);
                }else { return false; }
            }else { return false; }
        }
    }

    public function userInsertedDataUtils($check,$ValueToCheck,$table_name,$column,$recipe_status)
    {
        $val = "";
        $recipe_id = 0;
        $arr = array();
        if($check == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `recipe_id`=:em AND `status`=:st LIMIT 1 ");
        }else if($check == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `chef_email`=:em AND `status`=:st LIMIT 1 "); 
        }
        $query->bindParam(":em",$ValueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$recipe_status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
              $utils_array = explode(',',$row["utils"]);
            } 
            for($i = 0; $i < count($utils_array); $i++)
            {
                $val = $utils_array[$i];
                $val   = trim($val,')');
                $val   = trim($val,'(');
                $val = intval($val);
                $query1 = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `id`=:id LIMIT 1 ");
                $query1->bindParam(":id",$val,PDO::PARAM_INT);
                $query1->execute();
                if($query1->rowCount() > 0)
                {
                    $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result1 as $row1)
                    {
                        array_push($arr, array(
                        0 => $val,
                        1 => htmlspecialchars_decode($row1[$column],ENT_COMPAT))
                        );
                            
                    }
                   
                }
            }
            return $arr;
        }else { return false; }
    }

    public function userInsertedDataIngredients($check,$ValueToCheck,$section,$recipe_status)
    {
        if($section == "supermarket")
        {
            $col_values = array("meat","animal_products","dairy_products","legumes","vegetables","starch","fruits","herbs","juices");
        }else if($section == "fancies")
        {
            $col_values = array("spices","breadcrumbs","nuts","oils","spice_paste","driedfruits");
        }
        $arr = array();
        $recipe_id = 0;
        $insert_table = "recipe_".$section;
        if($check == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `recipe_id`=:em AND `status`=:st LIMIT 1 ");
        }else if($check == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `chef_email`=:em AND `status`=:st LIMIT 1 "); 
        }
        $query->bindParam(":em",$ValueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$recipe_status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $recipe_id = $row["recipe_id"];
                $query1 = $this->conn->prepare("SELECT * FROM `$insert_table` WHERE `recipe_id`=:id LIMIT 1 ");
                $query1->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                $query1->execute();
                if($query1->rowCount() > 0)
                {
                    $result_by_index = $query1->fetch(PDO::FETCH_NUM);
                    for($i = 2; $i < count($result_by_index);$i++)
                    {
                        if(isset($result_by_index[$i]) && (strlen($result_by_index[$i]) > 0))
                        {
                            $break_into_sets_index = explode(',',$result_by_index[$i]);
                            for($j = 0; $j < count($break_into_sets_index);$j++)
                            {
                                $break_into_subset_index = explode('/',trim($break_into_sets_index[$j],'()'));
                                if(($break_into_sets_index[0] != NULL) || ($break_into_sets_index[1] != NULL ) || ($break_into_sets_index[2] != NULL))
                                {
                                    $search_in_table = $section.'_'.$col_values[$i-2];
                                    $id = intval($break_into_subset_index[0]);
                                    $query2 = $this->conn->prepare("SELECT * FROM `$search_in_table` WHERE `id`=:id LIMIT 1 ");
                                    $query2->bindParam(":id",$id,PDO::PARAM_INT);
                                    $query2->execute();
                                    if($query2->rowCount() > 0)
                                    {
                                        $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($result2 as $row2){ 
                                            $ingre_name = htmlspecialchars_decode($row2["description"],ENT_COMPAT);
                                        }
                                        $string = ucfirst($ingre_name).' ('.$break_into_subset_index[1].' '.$break_into_subset_index[2].')';
                                        array_push($arr , $string);
                                    }
                                }
                            }
                        }else{ continue; }
                    }
                    if(count($arr) > 0)
                    {
                        return $arr;
                    }
                }else{ echo false; }
            } 
        }else { echo false; }
    }

    public function userInsertedDataIngredientsSpecific($check,$ValueToCheck,$section,$column,$recipe_status) 
    {
        $arr = array();
        $recipe_id = 0;
        $insert_table = "recipe_".$section;
        if($check == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `recipe_id`=:em AND `status`=:st LIMIT 1 ");
        }else if($check == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `chef_email`=:em AND `status`=:st LIMIT 1 "); 
        }
        $query->bindParam(":em",$ValueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$recipe_status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $recipe_id = intval($row["recipe_id"]);
                $query1 = $this->conn->prepare("SELECT `$column` FROM `$insert_table` WHERE `recipe_id`=:id LIMIT 1 ");
                $query1->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                $query1->execute();
                if($query1->rowCount() > 0)
                {
                    $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result1 as $row1)
                    {
                        if(isset($row1[$column]) && (strlen($row1[$column]) > 0))
                        {
                            $break_values_sets = explode(',',$row1[$column]);
                            for($j = 0; $j < count($break_values_sets); $j++)
                            {
                                $break_into_subset = explode('/',trim($break_values_sets[$j],'()'));
                                if(($break_into_subset[0] != NULL) || ($break_into_subset[1] != NULL ) || ($break_into_subset[2] != NULL))
                                {
                                    $search_in_table = $section.'_'.$column;
                                    $id = intval($break_into_subset[0]);
                                    $query2 = $this->conn->prepare("SELECT * FROM `$search_in_table` WHERE `id`=:id LIMIT 1 ");
                                    $query2->bindParam(":id",$id,PDO::PARAM_INT);
                                    $query2->execute();
                                    if($query2->rowCount() > 0)
                                    {
                                        $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($result2 as $row2){ 
                                            $ingre_name = htmlspecialchars_decode($row2["description"],ENT_COMPAT);
                                        }
                                        array_push($arr , array(
                                            0 => $id,
                                            1 => $ingre_name,
                                            2 => htmlspecialchars_decode($break_into_subset[1],ENT_COMPAT),
                                            3 => htmlspecialchars_decode($break_into_subset[2],ENT_COMPAT),
                                        ));
                                    }
                                }
                            }
                            unset($break_values_sets);
                            unset($break_into_subset_index);
                        }else{ return ""; }
                    }
                    
                    if(count($arr) > 0)
                    {
                        return $arr;
                    }
                }else{ return false; }
            } 
        }else { return false; }
    }
   
    public function userInsertedDataCookingSteps($check,$ValueToCheck,$table_name,$recipe_status)
    {
        $main_arr = array();
        if($check == "id")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `recipe_id`=:em AND `status`=:st LIMIT 1 ");
        }else if($check == "email")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `chef_email`=:em AND `status`=:st LIMIT 1 "); 
        }
        $query->bindParam(":em",$ValueToCheck,PDO::PARAM_STR);
        $query->bindParam(":st",$recipe_status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $recipe_id = $row["recipe_id"];
                $query1 = $this->conn->prepare("SELECT * FROM `$table_name` WHERE `recipe_id`=:id  ORDER BY `step_no` asc");
                $query1->bindParam(":id",$recipe_id,PDO::PARAM_INT);
                $query1->execute();
                if($query1->rowCount() > 0)
                {
                    $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result1 as $row1)
                    {  
                        array_push($main_arr,array(
                            0 =>  ucfirst(htmlspecialchars_decode($row1["title"],ENT_COMPAT)),
                            1 =>  ucfirst(htmlspecialchars_decode($row1["description"],ENT_COMPAT)),
                            2 =>  htmlentities($row1["image"]),
                            3 => $row1["id"]
                        )); 
                    }
                    return $main_arr;
                }
            }
            
        }
    }

    // OVerview Page functions -- end


    // Chef Dashboard Index Page -- start
    public function fetchRecipesForChef($dashboard,$chef_email)
    {
        $arr = array();
        if($dashboard == "user")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `chef_email`=:em AND `status`='complete' ");
            $query->bindParam(":em",$chef_email,PDO::PARAM_STR);
        }else if($dashboard == "admin")
        {
            $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `status`='complete' ");
        }
        $query->execute();
        if($query->rowCount() > 0)
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row)
            {
                $imgArray = array();
                if( (strlen($row["title"]) > 0) )
                {
                    $title = ucfirst(htmlspecialchars_decode($row["title"],ENT_COMPAT));
                }else { $title = "N/A" ; } 
                if( (strlen($row["description"]) > 0) )
                {
                    $desc = ucfirst(htmlspecialchars_decode($row["description"],ENT_COMPAT));
                }else { $desc = "N/A" ; }

                $query1 = $this->conn->prepare("SELECT * FROM `cooking_steps` WHERE `recipe_id`=:id ORDER BY `step_no` asc ");
                $query1->bindParam(":id",$row["recipe_id"],PDO::PARAM_INT);
                $query1->execute();
                if($query1->rowCount() > 0)
                {
                    $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result1 as $row1)
                    {
                        if(strlen($row1["image"]) > 0)
                        {
                            array_push($imgArray, htmlentities($row1["image"]));
                        }
                    }
                }
                if(isset($row["calorie"]) && (strlen($row["calorie"]) > 0))
                {
                    $calorie = $row["calorie"];
                }else
                {
                    $calorie = 0;
                }
                array_push($arr, array(
                    0 => $row["recipe_id"],
                    1 => $title,
                    2 => $desc,
                    3 => $row["cooking_time"],
                    4 => $calorie,
                    5 => $imgArray,
                    6 => htmlspecialchars_decode($row["chef_email"],ENT_COMPAT)
                ));
                unset($imgArray);
            }
            return json_encode($arr);
        }else
        {
            return false;
        }
    }

    // Chef Dashboard Index Page -- end
    


    // View Page Delete Function -- start
    public function deleteCompleteRecipe($recipe_id,$status)
    {
        $query = $this->conn->prepare("SELECT * FROM `main_recipe` WHERE `recipe_id`=:id AND `status`=:st ");
        $query->bindParam(":id",$recipe_id,PDO::PARAM_INT);
        $query->bindParam(":st",$status,PDO::PARAM_STR);
        $query->execute();
        if($query->rowCount() > 0)
        {
            $query1 = $this->conn->prepare("DELETE main_recipe, cooking_steps, recipe_supermarket,recipe_fancies,nutritional_info FROM main_recipe INNER JOIN cooking_steps ON main_recipe.recipe_id = cooking_steps.recipe_id INNER JOIN recipe_supermarket ON main_recipe.recipe_id = recipe_supermarket.recipe_id INNER JOIN recipe_fancies ON main_recipe.recipe_id = recipe_fancies.recipe_id INNER JOIN nutritional_info ON main_recipe.recipe_id = nutritional_info.recipe_id WHERE main_recipe.recipe_id = :id AND main_recipe.status = 'complete'");
            $query1->bindParam(":id",$recipe_id,PDO::PARAM_INT);
            $query1->execute();
            if($query1->rowCount() > 0)
            {
                return true;
            }
        }

    }

    // View Page Delete Function -- end



}