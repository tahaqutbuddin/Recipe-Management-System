<?php
session_start();
require 'overview.php';
$req = $_POST["req"] ;
if(isset($_SESSION["user_email"]))
{
    $chef_email = $_SESSION["user_email"];
}

// $chef_email = "taha1709d@aptechgdn.net";
if($req  == "fetchIngredients")
{
    $obj = new recipe;
    echo $obj->fetchDataForIngredients(htmlentities($_POST["section"]),htmlentities($_POST["type"]));
    unset($obj);
}else if($req == "fetchUtils")
{
    $obj = new recipe;
    echo $obj->fetchDataForUtils();
    unset($obj);
}else if($req == "overviewPage")
{
    echo fetchCompleteOverviewPageForDesktop($chef_email);
}
else if($req == "overviewPageMobile")
{
    echo fetchCompleteOverviewPageForMobile($chef_email);
}
else if($req == "updateDandSandU")
{
    $_SESSION["difficulty"] = htmlentities($_POST["difficulty"]);
    $_SESSION["sharpness"] = htmlentities($_POST["sharpness"]);
    $_SESSION["utils"] = json_decode($_POST['util']);
}
else if($req == "SaveFormDataInitial")
{
    if(isset($_POST["values"]))
    {
        $obj = new recipe;
        $obj->saveFormDataInitial("email",$chef_email,"main_recipe",$_POST["values"],"incomplete");
        unset($obj);
    }
}
else if($req == "SaveFormDataCheckbox")
{
    if(($_POST["type"] == "diet") || ($_POST["type"] == "animal_products") || ($_POST["type"] == "allergen") || ($_POST["type"] == "home_equipment"))
    {
        $obj = new recipe;
        $obj->saveFormDataCheckbox("email",$chef_email,"main_recipe",strtolower($_POST["type"]),$_POST["values"],"incomplete");
        unset($obj);
    }
}else if($req == "SaveNutritional")
{
    $obj = new recipe;
    $obj->saveNutritionalInfo("email",$chef_email,"nutritional_info",$_POST["values"],"incomplete");
    unset($obj); 
}else if($req == "SaveTechnical")
{
    $obj = new recipe;
    $obj->saveTechnicalDetails("email",$chef_email,"main_recipe",$_POST["values"],"incomplete");
    unset($obj); 
}else if($req == "SaveDAndS")
{
    $obj = new recipe;
    $obj->saveDiffAndSharp("email",$chef_email,"main_recipe",$_POST["values"],"incomplete");
    unset($obj); 
}
else if($req == "SaveSupermarketIngredients")
{
    $obj = new recipe;
    $obj->saveSupermarketIngredients("email",$chef_email,"recipe_supermarket",$_POST["values"],"incomplete");
    unset($obj); 
}
else if($req == "SaveFanciesIngredients")
{
    $obj = new recipe;
    $obj->saveFanciesIngredients("email",$chef_email,"recipe_fancies",$_POST["values"],"incomplete");
    unset($obj); 
}
else if($req == "SaveUtils")
{
    $obj = new recipe;
    $obj->saveUtils("email",$chef_email,"main_recipe",$_POST["values"],"incomplete");
    unset($obj);
}
else if($req == "SaveCookingSteps")
{
    $obj = new recipe;
    $obj->saveCookingSteps("email",$chef_email,"cooking_steps",$_POST["values"],$_POST["images"],"incomplete");
    unset($obj); 
}
else if($req == "checkFormSubmission")
{
    $obj = new recipe;
    echo $obj->checkFormSubmission($chef_email);
    unset($obj); 
}
else if($req == "SaveTechnicalForEdit")
{
    $obj = new recipe;
    echo $obj->saveTechnicalDetails("id",$_POST["recipe_id"],"main_recipe",$_POST["values"],"complete");
    unset($obj); 
}else if($req == "SaveDAndSForEdit")
{
    $obj = new recipe;
    echo $obj->saveDiffAndSharp("id",$_POST["recipe_id"],"main_recipe",$_POST["values"],"complete");
    unset($obj); 
}
?>