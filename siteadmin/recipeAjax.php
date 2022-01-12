<?php
session_start();
require "../Model/class.recipe.php";
$req = $_POST["req"] ;

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