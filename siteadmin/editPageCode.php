<?php
    session_start();
    include "extraFuncs.php";
    require "../Model/class.recipe.php";
    require "../Model/class.chef.php";
    
    if(!isset($_GET["protected"],$_GET["hash"],$_GET["mode"]))
    {
        header("Location: denied.php");
    }
    if($_GET["mode"] != "edit")
    {
        header("Location: index.php");
    }

    $recipe_id = base64_decode($_GET["protected"]);

    if((!isset($_SESSION["admin_email"])) && (!isset($_SESSION["adminname"])) )
    {
        header("Location: ../login.php");
    }
    $username = $_SESSION["adminname"];
    $chef_email = $_SESSION["admin_email"];

    
    $chef = new chef;                    
    $user_avatar = $chef->fetchChefProperties($chef_email,"avatar");

    $obj = new recipe;
    $diet_arr = $obj->userInsertedDataCheckbox("id",$recipe_id,"main_recipe","diet","complete");
    $diet_values = "";
    if((is_bool($diet_arr) && ($diet_arr == false)) || ($diet_arr == NULL)) // Incase of error atleast display empty checkboxes
    {
        $diet_values = '
        <form class="col-md-12 d-flex flex-row flex-shrink-1 flex-wrap order-3 checbox-col mob-margin" method="POST">
            <button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill ">
                    <input type="checkbox" name="diet[]" value="low-carb">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>Low-Carb</label>
                    </div>
                </div>
            </button>

            <button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input name="diet[]" value="trennkost" type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>TrennKost</label>
                    </div>
                </div>
            </button>
            <button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input name="diet[]" value="laktosefrei"  type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>Laktosefrei</label>
                    </div>
                </div>
            </button><button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input  name="diet[]" value="low-fat" type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>Low-Fat</label>
                    </div>
                </div>
            </button>
            <button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input name="diet[]" value="glutenarm" type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>Glutenarm</label>
                    </div>
                </div>
            </button>
            <button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input name="diet[]" value="high protein" type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>High Protein</label>
                    </div>
                </div>
            </button>
            <div class="container">
                <div class="row row-save-changes">
                    <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                        <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataDietCheckbox" >Save changes</button>
                    </div>
                </div>
            </div>
        </form>
        ';
    }else
    {
        $all_diet_values = array("low-carb","trennkost","laktosefrei","low-fat","glutenarm","high protein");
        $diet_values .= '<form class="col-md-12 d-flex flex-row flex-shrink-1 flex-wrap order-3 checbox-col mob-margin" method="POST">';
        for($i = 0; $i < count($all_diet_values);$i++)
        {
            $flag = false;
            for($j = 0; $j < count($diet_arr); $j++)
            {
                if($all_diet_values[$i] == $diet_arr[$j])
                {
                    $flag = true;
                }
            }
            $value = $all_diet_values[$i];
            if($flag)
            {
                $diet_values .= '
                <button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill ">
                        <input type="checkbox" name="diet[]" value="'.strtolower($value).'" checked="checked" />
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>'.ucfirst($value).'</label>
                        </div>
                    </div>
                </button>';
            }else
            {
                $diet_values .= '
                <button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill ">
                        <input type="checkbox" name="diet[]" value="'.strtolower(htmlspecialchars_decode($all_diet_values[$i],ENT_COMPAT)).'">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>'.ucfirst(htmlspecialchars_decode($all_diet_values[$i],ENT_COMPAT)).'</label>
                        </div>
                    </div>
                </button>';
            }
        } 
        $diet_values .= '
                <div class="row">
                    <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                        <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataDietCheckbox" >Änderungen speichern</button>
                    </div>
            </div>
            </form>
        ';
    }
    
    $animal_arr = $obj->userInsertedDataCheckbox("id",$recipe_id,"main_recipe","animal_products","complete");
    $animal_values = "";
    if((is_bool($animal_arr) && ($animal_arr == false)) || ($animal_arr == NULL)) // Incase of error atleast display empty checkboxes
    {
        $animal_values = '
        <form class="col-md-12 d-flex flex-row flex-shrink-1 flex-wrap order-3 checbox-col" method="POST">
            <button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input name="animal_products[]" value="geflügel" type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>Geflügel</label>
                    </div>
                </div>
            </button>

            <button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input name="animal_products[]" value="schwein"  type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>Schwein</label>
                    </div>
                </div>
            </button><button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input name="animal_products[]" value="meeresfrüchte" type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>Meeresfrüchte</label>
                    </div>
                </div>
            </button><button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input name="animal_products[]" value="rind" type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>Rind</label>
                    </div>
                </div>
            </button><button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input name="animal_products[]" value="fisch" type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>Fisch</label>
                    </div>
                </div>
            </button><button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input name="animal_products[]" value="milch" type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>Milch</label>
                    </div>
                </div>
            </button>
            </button><button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input name="animal_products[]" value="eier"  type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>Eier</label>
                    </div>
                </div>
            </button>
            </button><button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input name="animal_products[]" value="vegetarisch" type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>Vegetarisch</label>
                    </div>
                </div>
            </button>
            </button><button class="checkbox-diff" type="button">
                <div class="pretty p-icon p-default p-round p-fill">
                    <input name="animal_products[]" value="vegan"  type="checkbox">
                    <div class="state p-danger ">
                        <i class="icon mdi mdi-check"></i>
                        <label>Vegan</label>
                    </div>
                </div>
            </button>
                <div class="row">
                    <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                        <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataAnimalCheckbox" >Änderungen speichern</button>
                    </div>
                </div>
        </form>
        ';
    }else
    {

        $all_animal_values = array("geflügel","schwein","meeresfrüchte","rind","fisch","milch","eier","vegetarisch","vegan");
        $animal_values .= '<form class="col-md-12 d-flex flex-row flex-shrink-1 flex-wrap order-3 checbox-col" method="POST">';
        for($i = 0; $i < count($all_animal_values); $i++)
        {
            $flag = false;
            for($j = 0; $j < count($animal_arr); $j++)
            {
                if($all_animal_values[$i] == $animal_arr[$j])
                {
                    $flag = true;
                }
            }
            $value = $all_animal_values[$i];
            if($flag)
            {
                $animal_values .= '
                <button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill ">
                        <input type="checkbox" name="animal_products[]" value="'.$value.'" checked="checked" />
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>'.ucfirst($value).'</label>
                        </div>
                    </div>
                </button>';
            }else
            {
                $animal_values .= '
                <button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill ">
                        <input type="checkbox" name="animal_products[]" value="'.$value.'">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>'.ucfirst($value).'</label>
                        </div>
                    </div>
                </button>';
            }
        }
        $animal_values .= '
                <div class="row">
                    <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                        <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataAnimalCheckbox" >Änderungen speichern</button>
                    </div>
                </div>
        </form>';
    }


    $allergen_arr = $obj->userInsertedDataCheckbox("id",$recipe_id,"main_recipe","allergen","complete"); // Incase of error atleast display empty checkboxes
    $allergen_values = "";
    if((is_bool($allergen_arr) && ($allergen_arr == false)) || ($allergen_arr == NULL))
    {
        $allergen_values = '
        <form class="col-md-12 d-flex flex-row flex-shrink-1 flex-wrap order-3 checbox-col" method="POST">
        <button class="checkbox-diff" type="button">
            <div class="pretty p-icon p-default p-round p-fill">
                <input name="allergens[]" value="senf" type="checkbox">
                <div class="state p-danger ">
                    <i class="icon mdi mdi-check"></i>
                    <label>Senf</label>
                </div>
            </div>
        </button>

        <button class="checkbox-diff" type="button">
            <div class="pretty p-icon p-default p-round p-fill">
                <input name="allergens[]" value="schwefeldioxid" type="checkbox">
                <div class="state p-danger ">
                    <i class="icon mdi mdi-check"></i>
                    <label>Schwefeldioxid</label>
                </div>
            </div>
        </button><button class="checkbox-diff" type="button">
            <div class="pretty p-icon p-default p-round p-fill">
                <input name="allergens[]" value="sulphite" type="checkbox">
                <div class="state p-danger ">
                    <i class="icon mdi mdi-check"></i>
                    <label>Sulphite</label>
                </div>
            </div>
        </button>
        <button class="checkbox-diff" type="button">
            <div class="pretty p-icon p-default p-round p-fill">
                <input name="allergens[]" value="nüsse" type="checkbox">
                <div class="state p-danger ">
                    <i class="icon mdi mdi-check"></i>
                    <label>Nüsse</label>
                </div>
            </div>
        </button>
    
        <button class="checkbox-diff" type="button">
            <div class="pretty p-icon p-default p-round p-fill">
                <input  name="allergens[]" value="gluten"   type="checkbox">
                <div class="state p-danger ">
                    <i class="icon mdi mdi-check"></i>
                    <label>Gluten</label>
                </div>
            </div>
        </button><button class="checkbox-diff" type="button">
            <div class="pretty p-icon p-default p-round p-fill">
                <input name="allergens[]" value="sellerie"  type="checkbox">
                <div class="state p-danger ">
                    <i class="icon mdi mdi-check"></i>
                    <label>Sellerie</label>
                </div>
            </div>
        </button>
        </button><button class="checkbox-diff" type="button">
            <div class="pretty p-icon p-default p-round p-fill">
                <input  name="allergens[]" value="sesamsamen" type="checkbox">
                <div class="state p-danger ">
                    <i class="icon mdi mdi-check"></i>
                    <label>Sesamsamen</label>
                </div>
            </div>
        </button>
        </button><button class="checkbox-diff" type="button">
            <div class="pretty p-icon p-default p-round p-fill">
                <input  name="allergens[]" value="soja" type="checkbox">
                <div class="state p-danger ">
                    <i class="icon mdi mdi-check"></i>
                    <label>Soja</label>
                </div>
            </div>
        </button>
        </button><button class="checkbox-diff" type="button">
            <div class="pretty p-icon p-default p-round p-fill">
                <input name="allergens[]" value="milch" type="checkbox">
                <div class="state p-danger ">
                    <i class="icon mdi mdi-check"></i>
                    <label>Milch, Laktose</label>
                </div>
            </div>
        </button>
        </button><button class="checkbox-diff" type="button">
            <div class="pretty p-icon p-default p-round p-fill">
                <input name="allergens[]" value="eiererzeugnisse" type="checkbox">
                <div class="state p-danger ">
                    <i class="icon mdi mdi-check"></i>
                    <label>Eiererzeugnisse</label>
                </div>
            </div>
        </button>
        </button><button class="checkbox-diff" type="button">
            <div class="pretty p-icon p-default p-round p-fill">
                <input name="allergens[]" value="hülsenfrüchte" type="checkbox">
                <div class="state p-danger ">
                    <i class="icon mdi mdi-check"></i>
                    <label>Hülsenfrüchte</label>
                </div>
            </div>
        </button>
        </button><button class="checkbox-diff" type="button">
            <div class="pretty p-icon p-default p-round p-fill">
                <input name="allergens[]" value="Andere" type="checkbox">
                <div class="state p-danger ">
                    <i class="icon mdi mdi-check"></i>
                    <label>Andere Allergene</label>
                </div>
            </div>
        </button>
        <div class="row">
            <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataAllergenCheckbox" >Änderungen speichern</button>
            </div>
        </div>
        </form>
        ';
    }else
    {

        $all_allergen_values = array("senf","schwefeldioxid","sulphite","nüsse","gluten","sellerie","sesamsamen","soja","milch","eiererzeugnisse","hülsenfrüchte","Andere");
        $allergen_values .= '<form class="col-md-12 d-flex flex-row flex-shrink-1 flex-wrap order-3 checbox-col" method="POST">';
        for($i = 0; $i < count($all_allergen_values); $i++)
        {
            $flag = false;
            for($j = 0; $j < count($allergen_arr); $j++)
            {
                if($all_allergen_values[$i] == $allergen_arr[$j])
                {
                    $flag = true;
                }
            }
            $value = $all_allergen_values[$i];
            if($flag)
            {
                $allergen_values .= '
                <button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill ">
                        <input type="checkbox" name="allergens[]" value="'.$value.'" checked="checked" />
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>'.ucfirst($value).'</label>
                        </div>
                    </div>
                </button>';
            }else
            {
                $allergen_values .= '
                <button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill ">
                        <input type="checkbox" name="allergens[]" value="'.$value.'">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>'.ucfirst($value).'</label>
                        </div>
                    </div>
                </button>';
            }
        }
        $allergen_values .= '
            <div class="row">
                <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                    <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataAllergenCheckbox" >Änderungen speichern</button>
                </div>
            </div>
        </form>';
    }


    $home_arr = $obj->userInsertedDataCheckbox("id",$recipe_id,"main_recipe","home_equipment","complete");
    $home_values = "";
    if((is_bool($home_arr) && ($home_arr == false)) || ($home_arr == NULL))
    {
        $home_values = '
        <form class="col-md-12 d-flex flex-row flex-shrink-1 flex-wrap order-3 checbox-col" method="POST">
                <button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill">
                        <input name="home_equipment[]" value="salz" type="checkbox">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>Salz</label>
                        </div>
                    </div>
                </button>

                <button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill">
                        <input name="home_equipment[]" value="pfeffer" type="checkbox">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>Pfeffer</label>
                        </div>
                    </div>
                </button><button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill">
                        <input  name="home_equipment[]" value="olivenöl" type="checkbox">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>Olivenöl</label>
                        </div>
                    </div>
                </button><button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill">
                        <input  name="home_equipment[]" value="zucker" type="checkbox">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>Zucker</label>
                        </div>
                    </div>
                </button><button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill">
                        <input  name="home_equipment[]" value="zucker (braun)" type="checkbox">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>Zucker (braun)</label>
                        </div>
                    </div>
                </button><button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill">
                        <input  name="home_equipment[]" value="pflanzenöl" type="checkbox">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>Pflanzenöl </label>
                        </div>
                    </div>
                </button>
                </button><button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill">
                        <input  name="home_equipment[]" value="essig" type="checkbox">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>Essig </label>
                        </div>
                    </div>
                </button>
                </button><button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill">
                        <input  name="home_equipment[]" value="butter"  type="checkbox">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>Butter </label>
                        </div>
                    </div>
                </button>
                </button><button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill">
                        <input name="home_equipment[]" value="mehl"  type="checkbox">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>Mehl</label>
                        </div>
                    </div>
                </button>
                </button><button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill">
                        <input  name="home_equipment[]" value="honig"  type="checkbox">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>Honig</label>
                        </div>
                    </div>
                </button>
                
                <div class="row">
                    <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                        <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataHomeCheckbox" >Änderungen speichern</button>
                    </div>
                </div>
            </form>
        ';
    }else
    {
        $all_home_values = array("salz","pfeffer","olivenöl","zucker","zucker (braun)","pflanzenöl","essig","butter","mehl","honig");
        $home_values .= '<form class="col-md-12 d-flex flex-row flex-shrink-1 flex-wrap order-3 checbox-col" method="POST">';
        for($i = 0; $i < count($all_home_values); $i++)
        {
            $flag = false;
            for($j = 0; $j < count($home_arr); $j++)
            {
                if($all_home_values[$i] == $home_arr[$j])
                {
                    $flag = true;
                }
            }
            $value = $all_home_values[$i];
            if($flag)
            {
                $home_values .= '
                <button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill ">
                        <input type="checkbox" name="home_equipment[]" value="'.$value.'" checked="checked" />
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>'.ucfirst($value).'</label>
                        </div>
                    </div>
                </button>';
            }else
            {
                $home_values .= '
                <button class="checkbox-diff" type="button">
                    <div class="pretty p-icon p-default p-round p-fill ">
                        <input type="checkbox" name="home_equipment[]" value="'.$value.'">
                        <div class="state p-danger ">
                            <i class="icon mdi mdi-check"></i>
                            <label>'.ucfirst($value).'</label>
                        </div>
                    </div>
                </button>';
            }
        }
        $home_values .= '
        <div class="container">
            <div class="row">
                <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                    <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataHomeCheckbox" >Änderungen speichern</button>
                </div>
            </div>
        </div>
        </form>';
    } 
    
    
    $utils_arr = $obj->userInsertedDataUtils("id",$recipe_id,"utils","description","complete");
    $utils_values = "";
    if((is_bool($utils_arr) && ($utils_arr == false)) || ($utils_arr == NULL))
    {
        $utils_values = '';
    }else
    {
        for($i = 0; $i < count($utils_arr);$i++)
        {
            $utils_values .= '
            <div class="chip">
                <div class="tag-text">
                    '.htmlspecialchars_decode($utils_arr[$i][1],ENT_COMPAT).'
                </div>
                <input type="hidden" class="tag-id" name="tag_id[]" value="'.$utils_arr[$i][0].'" />
                <img class="closebtn" onclick="tagCloseFunc(this)" src="../dashboard/form_assets/img/Vector.png" />
            </div>
            ';
        } 
    }


    $meat_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"supermarket","meat","complete"); // incomplete
    $meat_values = "";
    $ingre_name = "meat";
    if( is_string($meat_arr) && ( strlen($meat_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity = "";
        $unit = "gramm";
        $div_id = "meat-div".($i+1);
        $ingre_title = "Fisch/Fleisch";
        $meat_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($meat_arr); $i++)
        {
            $val_id = $meat_arr[$i][0];
            $val = $meat_arr[$i][1];
            $quantity = $meat_arr[$i][2];
            $unit = $meat_arr[$i][3];
            $div_id = "meat-div".($i+1);
            $ingre_title = "Fisch/Fleisch";
            $meat_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }
    

    $animal_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"supermarket","animal_products","complete"); // incomplete
    $animal_ingre_values = "";
    $ingre_name = "animal_products";
    if( is_string($animal_arr) && ( strlen($animal_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "tierische-div".($i+1);
        $ingre_title = "Tierische Produkte";
        $animal_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($animal_arr); $i++)
        {
            $val_id = $animal_arr[$i][0];
            $val = $animal_arr[$i][1];
            $quantity = $animal_arr[$i][2];
            $unit = $animal_arr[$i][3];
            $div_id = "tierische-div".($i+1);
            $ingre_title = "Tierische Produkte";
            $animal_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }

    $dairy_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"supermarket","dairy_products","complete"); // incomplete
    $dairy_ingre_values = "";
    $ingre_name = "dairy_products";
    if( is_string($dairy_arr) && ( strlen($dairy_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "milchprodukte-div".($i+1);
        $ingre_title = "Milchprodukte";
        $dairy_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($dairy_arr); $i++)
        {
            $val_id = $dairy_arr[$i][0];
            $val = $dairy_arr[$i][1];
            $quantity = $dairy_arr[$i][2];
            $unit = $dairy_arr[$i][3];
            $div_id = "milchprodukte-div".($i+1);
            $ingre_title = "Milchprodukte";
            $dairy_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }

    $legumes_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"supermarket","legumes","complete"); // incomplete
    $legumes_ingre_values = "";
    $ingre_name = "legumes";
    if( is_string($legumes_arr) && ( strlen($legumes_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "hulsenfruchte-div".($i+1);
        $ingre_title = "Hülsenfrüchte";
        $legumes_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($legumes_arr); $i++)
        {
            $val_id = $legumes_arr[$i][0];
            $val = $legumes_arr[$i][1];
            $quantity = $legumes_arr[$i][2];
            $unit = $legumes_arr[$i][3];
            $div_id = "hulsenfruchte-div".($i+1);
            $ingre_title = "Hülsenfrüchte";
            $legumes_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }


    $vegetables_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"supermarket","vegetables","complete"); // incomplete
    $vegetables_ingre_values = "";
    $ingre_name = "vegetables";
    if( is_string($vegetables_arr) && ( strlen($vegetables_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "gemuse-div".($i+1);
        $ingre_title = "Gemüse";
        $vegetables_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($vegetables_arr); $i++)
        {
            $val_id = $vegetables_arr[$i][0];
            $val = $vegetables_arr[$i][1];
            $quantity = $vegetables_arr[$i][2];
            $unit = $vegetables_arr[$i][3];
            $div_id = "gemuse-div".($i+1);
            $ingre_title = "Gemüse";
            $vegetables_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }

    $starch_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"supermarket","starch","complete"); // incomplete
    $starch_ingre_values = "";
    $ingre_name = "starch";
    if( is_string($starch_arr) && ( strlen($starch_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "starkebeilagen-div".($i+1);
        $ingre_title = "Stärkebeilagen";
        $starch_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($starch_arr); $i++)
        {
            $val_id = $starch_arr[$i][0];
            $val = $starch_arr[$i][1];
            $quantity = $starch_arr[$i][2];
            $unit = $starch_arr[$i][3];
            $div_id = "starkebeilagen-div".($i+1);
            $ingre_title = "Stärkebeilagen";
            $starch_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }

    $fruit_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"supermarket","fruit","complete"); // incomplete
    $fruit_ingre_values = "";
    $ingre_name = "fruit";
    if( is_string($fruit_arr) && ( strlen($fruit_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "obst-div".($i+1);
        $ingre_title = "Obst";
        $fruit_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($fruit_arr); $i++)
        {
            $val_id = $fruit_arr[$i][0];
            $val = $fruit_arr[$i][1];
            $quantity = $fruit_arr[$i][2];
            $unit = $fruit_arr[$i][3];
            $div_id = "obst-div".($i+1);
            $ingre_title = "Obst";
            $fruit_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }

    $herbs_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"supermarket","herbs","complete"); // incomplete
    $herbs_ingre_values = "";
    $ingre_name = "herbs";
    if( is_string($herbs_arr) && ( strlen($herbs_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "krauter-div".($i+1);
        $ingre_title = "Kräuter";
        $herbs_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($herbs_arr); $i++)
        {
            $val_id = $herbs_arr[$i][0];
            $val = $herbs_arr[$i][1];
            $quantity = $herbs_arr[$i][2];
            $unit = $herbs_arr[$i][3];
            $div_id = "krauter-div".($i+1);
            $ingre_title = "Kräuter";
            $herbs_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }


    $juices_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"supermarket","juices","complete"); // incomplete
    $juices_ingre_values = "";
    $ingre_name = "juices";
    if( is_string($juices_arr) && ( strlen($juices_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "weine_und_safte-div".($i+1);
        $ingre_title = "Weine und Säfte";
        $juices_ingre_values .= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($juices_arr); $i++)
        {
            $val_id = $juices_arr[$i][0];
            $val = $juices_arr[$i][1];
            $quantity = $juices_arr[$i][2];
            $unit = $juices_arr[$i][3];
            $div_id = "weine_und_safte-div".($i+1);
            $ingre_title = "Weine und Säfte";
            $juices_ingre_values.= ingredient_row_edit_page("supermarket",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }

    $spices_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"fancies","spices","complete"); // incomplete
    $spices_ingre_values = "";
    $ingre_name = "spices";
    if( is_string($spices_arr) && ( strlen($spices_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "gewurze-div".($i+1);
        $ingre_title = "Gewürze";
        $spices_ingre_values .= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($spices_arr); $i++)
        {
            $val_id = $spices_arr[$i][0];
            $val = $spices_arr[$i][1];
            $quantity = $spices_arr[$i][2];
            $unit = $spices_arr[$i][3];
            $div_id = "gewurze-div".($i+1);
            $ingre_title = "Gewürze";
            $spices_ingre_values.= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }

    $breadcrumbs_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"fancies","breadcrumbs","complete"); // incomplete
    $breadcrumbs_ingre_values = "";
    $ingre_name = "breadcrumbs";
    if( is_string($breadcrumbs_arr) && ( strlen($breadcrumbs_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "panaden-div".($i+1);
        $ingre_title = "Panaden / Brösel";
        $breadcrumbs_ingre_values .= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($breadcrumbs_arr); $i++)
        {
            $val_id = $breadcrumbs_arr[$i][0];
            $val = $breadcrumbs_arr[$i][1];
            $quantity = $breadcrumbs_arr[$i][2];
            $unit = $breadcrumbs_arr[$i][3];
            $div_id = "panaden-div".($i+1);
            $ingre_title = "Panaden / Brösel";
            $breadcrumbs_ingre_values.= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }


    $nuts_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"fancies","nuts","complete"); // incomplete
    $nuts_ingre_values = "";
    $ingre_name = "nuts";
    if( is_string($nuts_arr) && ( strlen($nuts_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "nusse-div".($i+1);
        $ingre_title = "Nüsse und Kerne";
        $nuts_ingre_values .= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($nuts_arr); $i++)
        {
            $val_id = $nuts_arr[$i][0];
            $val = $nuts_arr[$i][1];
            $quantity = $nuts_arr[$i][2];
            $unit = $nuts_arr[$i][3];
            $div_id = "nusse-div".($i+1);
            $ingre_title = "Nüsse und Kerne";
            $nuts_ingre_values.= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }

    $oils_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"fancies","oils","complete"); // incomplete
    $oils_ingre_values = "";
    $ingre_name = "oils";
    if( is_string($oils_arr) && ( strlen($oils_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "ole-div".($i+1);
        $ingre_title = "Öle, Soßen, Essig";
        $oils_ingre_values .= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($oils_arr); $i++)
        {
            $val_id = $oils_arr[$i][0];
            $val = $oils_arr[$i][1];
            $quantity = $oils_arr[$i][2];
            $unit = $oils_arr[$i][3];
            $div_id = "ole-div".($i+1);
            $ingre_title = "Öle, Soßen, Essig";
            $oils_ingre_values.= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }

    $oils_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"fancies","oils","complete"); // incomplete
    $oils_ingre_values = "";
    $ingre_name = "oils";
    if( is_string($oils_arr) && ( strlen($oils_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "ole-div".($i+1);
        $ingre_title = "Öle, Soßen, Essig";
        $oils_ingre_values .= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($oils_arr); $i++)
        {
            $val_id = $oils_arr[$i][0];
            $val = $oils_arr[$i][1];
            $quantity = $oils_arr[$i][2];
            $unit = $oils_arr[$i][3];
            $div_id = "ole-div".($i+1);
            $ingre_title = "Öle, Soßen, Essig";
            $oils_ingre_values.= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }


    $spice_paste_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"fancies","spice_paste","complete"); // incomplete
    $spice_paste_ingre_values = "";
    $ingre_name = "spice_paste";
    if( is_string($spice_paste_arr) && ( strlen($spice_paste_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "gewurzpasten-div".($i+1);
        $ingre_title = "Gewürzpasten";
        $spice_paste_ingre_values .= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($spice_paste_arr); $i++)
        {
            $val_id = $spice_paste_arr[$i][0];
            $val = $spice_paste_arr[$i][1];
            $quantity = $spice_paste_arr[$i][2];
            $unit = $spice_paste_arr[$i][3];
            $div_id = "gewurzpasten-div".($i+1);
            $ingre_title = "Gewürzpasten";
            $spice_paste_ingre_values.= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }

    
    $driedfruits_arr = $obj->userInsertedDataIngredientsSpecific("id",$recipe_id,"fancies","driedfruits","complete"); // incomplete
    $driedfruits_ingre_values = "";
    $ingre_name = "driedfruits";
    if( is_string($driedfruits_arr) && ( strlen($driedfruits_arr) == 0 ) )
    {
        $val_id = "";
        $val = "";
        $quantity ="";
        $unit = "gramm";
        $div_id = "ole-div".($i+1);
        $ingre_title = "Trockenfrüchte";
        $driedfruits_ingre_values .= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
    }else
    {
        for($i = 0; $i < count($driedfruits_arr); $i++)
        {
            $val_id = $driedfruits_arr[$i][0];
            $val = $driedfruits_arr[$i][1];
            $quantity = $driedfruits_arr[$i][2];
            $unit = $driedfruits_arr[$i][3];
            $div_id = "ole-div".($i+1);
            $ingre_title = "Trockenfrüchte";
            $driedfruits_ingre_values.= ingredient_row_edit_page("fancies",$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit);
        } 
    }

    $cooking_steps_arr = $obj->userInsertedDataCookingSteps("id",$recipe_id,"cooking_steps","complete");
    $cooking_steps_values = "";
    if((is_bool($cooking_steps_arr) && ($cooking_steps_arr == false)) || ($cooking_steps_arr == NULL))
    {
        $cooking_steps_values = '
        <div class="container d-flex flex-column col-md-12 card form" id="step1">
            <div class="row d-flex flex-shrink-1 flex-wrap">
                <div class="col d-flex flex-row flex-shrink-1 flex-wrap">
                    <h1 class="Arbeitsschritte diat-heading-main">Koch Anleitung
                        <img data-toggle="tooltip" class="tooltip-paragragh" data-bss-tooltip="" src="../dashboard/form_assets/img/Vector-1.svg" title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen">
                    </h1>
                </div>
            </div>
            <br/>
                <div class="row">
                    <div class="col schrit">
                        <h1 class="heading-main heading-c">Schritt: 1</h1>
                    </div>
                </div>
                <div class="row d-flex flex-column row-border">
                    <div class="col-md-6 col-sm-12">
                        <section class="section-1">
                            <h5>Wie heißt der Arbeitsschritt?</h5>
                            <input type="text" class="text-input-1 form-control" name="cooking_title[]" autocomplete="off" />
                        </section>
                        <section class="section-1 section-with-upload-button ">
                            <h5>Beschreibung:</h5>
                            <textarea class="text-input-2 form-control" name="cooking_description[]" autocomplete="off"></textarea>
                            <small style="color:red"></small>
                        </section>
                        <div class="row upload-button justify-content-center">
                            <div class="col-xs-6 col-sm-10 col-md-8 d-flex flex-row"><input class="btn btn-primary d-flex flex-row uploadbutton-input" type="button" value="Upload Bild" >
                                <img src="../dashboard/form_assets/img/cute-boy-chef-look-smart_38747-11.jpg" style="width: 81px;padding-left: 0px;margin-top: 10px;margin-left: -100px;height: 71px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex flex-column flex-shrink-1 justify-content-center flex-wrap align-items-xl-center col-hidden pic -arb">
                        <div class="row row-hidden">
                            <div class="col">
                                <img class="pic-arbeeaa" src="../dashboard/form_assets/img/cute-boy-chef-look-smart_38747-11.jpg" id="image-display1">
                            </div>
                        </div>
                        <div class="row row-hidden-bild">
                            <div class="col button-bild">
                                <input class="btn btn-primary uploadbutton-hidden every-button upload-image-jquery" id="uploadImage1" name="cooking_image[]" type="file" hidden>
                                <label for="uploadImage1" class="btn btn-primary uploadbutton-hidden every-button">
                                    Upload Bild
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex flex-row flex-grow-1 flex-shrink-1 row-button-1">
                    <div class="col button-after-form">
                        <button class="btn btn-primary btn-hide every-button" type="button" id="addCookingStep">
                            <strong>Weiteren Arbeitsschritt hinzufügen</strong>
                        </button>
                    </div>
                </div>
        </div>
        ';
    }else
    {
        for($i = 0; $i < count($cooking_steps_arr); $i++)
        {
            $title = isset($cooking_steps_arr[$i][0]) ?  $cooking_steps_arr[$i][0] : NULL;
            $desc  = isset($cooking_steps_arr[$i][1]) ?  $cooking_steps_arr[$i][1] : NULL;
            $img   = isset($cooking_steps_arr[$i][2]) ?  $cooking_steps_arr[$i][2] : NULL;
            $step_id = isset($cooking_steps_arr[$i][3]) ?  $cooking_steps_arr[$i][3] : NULL;
            $cooking_steps_values .= cooking_step($i,count($cooking_steps_arr),$step_id,$title,$desc,$img);
        }
    }

    $difficulty_values = '';
    $sharpness_values = '';     
    $difficulty = $obj->userInsertedDataTechnical("id",$recipe_id,"main_recipe","difficulty","complete");
    $sharpness = $obj->userInsertedDataTechnical("id",$recipe_id,"main_recipe","sharpness","complete");
    for($i = 0; $i  <= 3; $i++)
    {
        if( ($sharpness == $i) )
        {
            $sharpness_values .= '
            <input class="btn btn-primary button-option active" name="sharpness" type="button" value="'.$i.'" checked />
            ';
        }
        else
        {
            $sharpness_values .= '
            <input class="btn btn-primary button-option" name="sharpness" type="button" value="'.$i.'" />
            ';
        }  

        if( ($difficulty == $i) )
        {
            $difficulty_values .= '
            <input class="btn btn-primary button-option active" name="difficulty" type="button" value="'.$i.'" checked />
            ';
        }
        else
        {
            $difficulty_values .= '
            <input class="btn btn-primary button-option" name="difficulty" type="button" value="'.$i.'" />
            ';
        }   
    }


    $calorie = $obj->userInsertedDataNutritional("id",$recipe_id,"nutritional_info","calorie","complete");
    $fat = $obj->userInsertedDataNutritional("id",$recipe_id,"nutritional_info","fat","complete");
    $carbo = $obj->userInsertedDataNutritional("id",$recipe_id,"nutritional_info","carbohydrates","complete");
    $protein = $obj->userInsertedDataNutritional("id",$recipe_id,"nutritional_info","protein","complete");
    $title = $obj->userInsertedDataTechnical("id",$recipe_id,"main_recipe","title","complete");
    $desc = $obj->userInsertedDataTechnical("id",$recipe_id,"main_recipe","description","complete");
    $cook = $obj->userInsertedDataTechnical("id",$recipe_id,"main_recipe","cooking_time","complete");
    $prep = $obj->userInsertedDataTechnical("id",$recipe_id,"main_recipe","prep_time","complete");

 
?>