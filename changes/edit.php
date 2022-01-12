<?php
    include "editPageCode.php";
    if(isset($_POST["saveFormDataInitial"]))
    {
        $arr = array(htmlspecialchars($_POST["recipe_title"]), htmlspecialchars($_POST["recipe_description"]));
        $obj = new recipe;
        if($obj->saveFormDataInitial("id",$recipe_id,"main_recipe",$arr,"complete") == true)
        {
            unset($obj);
            header("Location:".$_SERVER["REQUEST_URI"]);
        }
    }

    if(isset($_POST["saveFormDataDietCheckbox"]))
    {
        $obj = new recipe;
        if($obj->saveFormDataCheckbox("id",$recipe_id,"main_recipe","diet",$_POST["diet"],"complete") == true)
        {
            unset($obj);
            header("Location:".$_SERVER["REQUEST_URI"]);
        }
    }

    if(isset($_POST["saveFormDataAnimalCheckbox"]))
    {
        $obj = new recipe;
        if($obj->saveFormDataCheckbox("id",$recipe_id,"main_recipe","animal_products",$_POST["animal_products"],"complete") == true)
        {
            unset($obj);
            header("Location:".$_SERVER["REQUEST_URI"]);
        }
    }

    if(isset($_POST["saveFormDataAllergenCheckbox"]))
    {
        $obj = new recipe;
        if($obj->saveFormDataCheckbox("id",$recipe_id,"main_recipe","allergen",$_POST["allergens"],"complete") == true)
        {
            unset($obj);
            header("Location:".$_SERVER["REQUEST_URI"]);
        }
    }

    if(isset($_POST["saveFormDataHomeCheckbox"]))
    {
        $obj = new recipe;
        if($obj->saveFormDataCheckbox("id",$recipe_id,"main_recipe","home_equipment",$_POST["home_equipment"],"complete") == true)
        {
            unset($obj);
            header("Location:".$_SERVER["REQUEST_URI"]);
        }
    }
    
    if(isset($_POST["saveFormDataNutritional"]))
    {
        $arr = array( htmlspecialchars($_POST["calorie"]) , htmlspecialchars($_POST["fat"]) , htmlspecialchars($_POST["carbohydrates"]) , htmlspecialchars($_POST["protein"]) );
        $obj = new recipe;
        if($obj->saveNutritionalInfo("id",$recipe_id,"nutritional_info",$arr,"complete") == true)
        {
            unset($obj);
            header("Location:".$_SERVER["REQUEST_URI"]);
        }
    }

    if(isset($_POST["saveFormDataUtils"]))
    {
        $obj = new recipe;
        $arr = array();
        var_dump($_POST["tag_id"]);
        foreach($_POST["tag_id"] as $tag)
        {
            $string = '('.$tag.')';
            array_push($arr , $string);
        }
        if( $obj->saveUtils("id",$recipe_id,"main_recipe",$arr,"complete")  == true)
        {
            unset($obj);
            header("Location:".$_SERVER["REQUEST_URI"]);
        }
    }

    if(isset($_POST["saveFormDataSupermarket"]))
    {
        $supermarket_ingredients = array("meat","animal_products","dairy_products","legumes","vegetables","starch","fruit","herbs","juices"); 
        $arr = array();
        $obj = new recipe;
        for($i = 0;$i < count($supermarket_ingredients); $i++)
        {
            $innerArr = array();
            for($j = 0;$j < count($_POST[$supermarket_ingredients[$i]."_id"]); $j++ )
            {
                $ingre_id = isset($_POST[$supermarket_ingredients[$i]."_id"][$j]) ? $_POST[$supermarket_ingredients[$i]."_id"][$j]  : NULL; 
                $qty = isset($_POST[$supermarket_ingredients[$i]."_quantity"][$j]) ? $_POST[$supermarket_ingredients[$i]."_quantity"][$j]  : NULL;
                $unit = isset($_POST[$supermarket_ingredients[$i]."_unit"][$j]) ? $_POST[$supermarket_ingredients[$i]."_unit"][$j]  : NULL;
                if( ($ingre_id != NULL) && ($qty != NULL ) && ($unit != NULL) )
                {
                    $string = '('.$ingre_id.'/'.$qty.'/'.$unit.')';
                    array_push($innerArr, $string);
                }else { continue; }
            }
            array_push($arr , implode(',',$innerArr) );
            unset($innerArr);
        }
        if( $obj->saveSupermarketIngredients("id",$recipe_id,"recipe_supermarket",$arr,"complete")  == true)
        {
            unset($obj);
            header("Location:".$_SERVER["REQUEST_URI"]);
        }
    }

    if(isset($_POST["saveFormDataFancies"]))
    {
        $fancies_ingredients = array("spices","breadcrumbs","nuts","oils","spice_paste","driedfruits"); 
        $arr = array();
        $obj = new recipe;
        var_dump($_POST);
        for($i = 0;$i < count($fancies_ingredients); $i++)
        {
            $innerArr = array();
            for($j = 0;$j < count($_POST[$fancies_ingredients[$i]."_id"]); $j++ )
            {
                $ingre_id = isset($_POST[$fancies_ingredients[$i]."_id"][$j]) ? $_POST[$fancies_ingredients[$i]."_id"][$j]  : NULL; 
                $qty = isset($_POST[$fancies_ingredients[$i]."_quantity"][$j]) ? $_POST[$fancies_ingredients[$i]."_quantity"][$j]  : NULL;
                $unit = isset($_POST[$fancies_ingredients[$i]."_unit"][$j]) ? $_POST[$fancies_ingredients[$i]."_unit"][$j]  : NULL;
                if( ($ingre_id != NULL) && ($qty != NULL ) && ($unit != NULL) )
                {
                    $string = '('.$ingre_id.'/'.$qty.'/'.$unit.')';
                    array_push($innerArr, $string);
                }else { continue; }
            }
            array_push($arr , implode(',',$innerArr) );
            unset($innerArr);
        }
        if( $obj->saveFanciesIngredients("id",$recipe_id,"recipe_fancies",$arr,"complete")  == true)
        {
            unset($obj);
            header("Location:".$_SERVER["REQUEST_URI"]);
        }
    }

    
    if(isset($_POST["saveFormDataCookingSteps"]))
    {
        $obj = new recipe;
        $img_arr = $obj->saveCookingImagesInFolder();
        if( (is_array($img_arr)))
        {
            if( $obj->saveCookingSteps("id",$recipe_id,"cooking_steps",$_POST,$img_arr,"complete")  == true)
            {
                unset($obj);
                header("Location:".$_SERVER["REQUEST_URI"]);
            }
        }
    }


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Rezept bearbeiten</title>
    <link rel="stylesheet" href="../dashboard/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../dashboard/assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../dashboard/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../dashboard/assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="../dashboard/assets/css/styles.min.css">
    <link rel="stylesheet" href="form_assets/css/styles.min.css">
    <link rel="stylesheet" href="form_assets/pretty-checkbox/dist/pretty-checkbox.css">
    <link rel="stylesheet" href="form_assets/pretty-checkbox/dist/pretty-checkbox.min.css">
    <link rel="stylesheet" href="form_assets/@mdi/font/css/materialdesignicons.css">
    <link rel="stylesheet" href="form_assets/@mdi/font/css/materialdesignicons.css.map">
    <link rel="stylesheet" href="form_assets/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="form_assets/@mdi/font/css/materialdesignicons.min.css.map">
        <!-- JavaScript -->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <!-- Default theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
        <!-- Semantic UI theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
        <!-- Bootstrap theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

        <!-- 
            RTL version
        -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
        <!-- Default theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
        <!-- Semantic UI theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>
        <!-- Bootstrap theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" id="sidebar">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="index.php">
                    <div class="sidebar-brand-text mx-3">
                        <img src="../dashboard/assets/img/logo.svg" alt="Site Logo" width="150" height="50" />
                    </div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item">
                        <a class="nav-link text-center" href="index.php">
                            <i class="fa fa-plus-circle icon-nav-link"></i>
                            <span class="text-side-nav-link">View All Recipes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center active" href="chefs.php">
                            <i class="fas fa-user icon-nav-link"></i>
                            <span class="text-side-nav-link">View all Chefs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center" href="admins.php">
                            <i class="fas fa-user icon-nav-link"></i>
                            <span class="text-side-nav-link">All Admins</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center" href="supermarket.php">
                            <i  class="fas fa-clipboard icon-nav-link"></i>
                            <span class="text-side-nav-link">Supermarket</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center " href="fancies.php">
                            <i class="fas fa-clipboard icon-nav-link"></i>
                            <span class="text-side-nav-link">Fancies</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center" href="utils.php">
                            <i class="fas fa-clipboard icon-nav-link"></i>
                            <span class="text-side-nav-link">Utils</span>
                        </a>
                    </li>
                </ul>
                <div class="text-center d-none d-md-inline">
                    <button class="btn rounded-circle border-0" id="sidebarToggle" type="button">
                        <i class="fas fa-angle-left"></i>
                    </button>
                </div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid">
                        <ul class="navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item d-flex justify-content-center align-items-center align-self-center order-2 dropdown no-arrow mx-1"
                                id="menu-bar-a"><button class="btn btn-link rounded-circle mr-3" id="menu-bar"
                                    type="button" onclick="openNav()"><i class="fas fa-bars"></i></button></li>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow">
                                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-toggle="dropdown" href="#">
                                        <span class="d-none d-lg-inline mr-2 text-gray-600 small">
                                            <?= $username; ?>
                                        </span>
                                        <img class="border rounded-circle img-profile" src="<?= $user_avatar; ?>">
                                    </a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in">
                                        <a class="dropdown-item" href="profile.php">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="logout.php">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        
                    </div>
                </nav>
                <div id="form_loader">
                            <img src="../dashboard/assets/img/form_loader.gif"/>
                        </div>
                <div id="main-form">
                        <div id="form-body">
                            <nav class="navbar navbar-light navbar-expand-md heading-nav">
                                <div class="container-fluid">
                                    <a class="navbar-brand d-flex flex-wrap" id="main_heading-top" href="#">
                                        <strong>FLAVOUR FLIP</strong>
                                    </a>
                                </div>
                            </nav>
                            <div class="container col-md-12" id="textarea-1">
                                <form method="post" style="margin-left:3.5%">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                                <h1 class="diat-heading-main">
                                                    &nbsp;Titel
                                                    <img data-toggle="tooltip" data-bss-tooltip="" class="tooltip-paragragh" src="form_assets/img/Vector-1.svg"  title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen">
                                                </h1>
                                            <input class="form-control input-text " id="recipe_title" name="recipe_title" maxlength="200" type="text" value="<?= $title; ?>">
                                            <small style="color:red"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                                <h1 class="diat-heading-main">
                                                    &nbsp;Rezeptbeschreibung
                                                    <img data-toggle="tooltip" data-bss-tooltip="" class="tooltip-paragragh" src="form_assets/img/Vector-1.svg"  title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen">
                                                </h1>
                                                <textarea class="form-control input-text  desc-input" id="recipe_description" name="recipe_description" maxlength="1000" type="text" rows=3><?= $desc; ?></textarea>
                                            </div>
                                            <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                                                <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataInitial" >Änderungen speichern</button>
                                            </div>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Start: 1 Row 1 Column -->
                            <div>
                                <div id="diet" class="container Diat">
                                    <div class="row">
                                        <div class="col">
                                            <h1 class="diat-heading-main">
                                                &nbsp;Diät
                                                <img data-toggle="tooltip" data-bss-tooltip="" class="tooltip-paragragh" src="form_assets/img/Vector-1.svg"  title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen">
                                            </h1>
                                        </div>
                                            <?= $diet_values; ?>
                                            
                                    </div>
                                </div>
                            </div><!-- End: 1 Row 1 Column -->
                            <div class="container col-md-12" id="textarea-1">
                                <div class="row">
                                    <div class="col d-flex heading-b">
                                        <h1 id="heading-a" class="heading-a diat-heading-main">Nährwertangaben </h1>
                                    </div>
                                </div>
                                <form method="POST">
                                    <div class="row" style="margin-left:20px" id="nutritional">
                                        <div class="col-md-3 col-sm-6 ">
                                            <label class="heading-input">Kalorien</label>
                                            <input class="form-control input-text only-numeric" name="calorie" type="text" value="<?= $calorie; ?>" />
                                            <small style="color:red"></small>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                                <label class="heading-input">Fett(g)</label>
                                                <input class="form-control input-text only-numeric" name="fat" type="text" value="<?= $fat; ?>" />
                                                <small style="color:red"></small>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                                <label class="heading-input">Kohlenhydrate(g)</label>
                                                <input class="form-control input-text only-numeric" name="carbohydrates" type="text" value="<?= $carbo; ?>" />
                                                <small style="color:red"></small>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                                <label class="heading-input">Eiweiß(g)</label>
                                                <input class="form-control input-text only-numeric" name="protein" type="text" value="<?= $protein; ?>" />
                                                <small style="color:red"></small>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                                                <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataNutritional" >Änderungen speichern</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br/>
                            <div class="container Diat" id="animal_products">
                                <div class="row">
                                    <div class="col">
                                        <h1 class="diat-heading-main">
                                            &nbsp;Tierische Produkte<img data-toggle="tooltip" data-bss-tooltip="" src="form_assets/img/Vector-1.svg" class="tooltip-z" title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen">
                                        </h1>
                                    </div>
                                    <?= $animal_values; ?>
                                </div>
                            </div>
                            <br/>
                            <form method="POST">
                                <div class="container section-2 col-md-12" id="textarea-2">
                                    <div class="row" id="technical">
                                        <div class="col heading-1">
                                            <h1 id="heading-a-1" class="diat-heading-main">
                                                Technische Daten
                                                <img data-toggle="tooltip" data-bss-tooltip="" src="form_assets/img/Vector-1.svg" class="tooltip-z" title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen">
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mob-margin-zeit">
                                                <label class="heading-input">Zeit-Vorbereitung (Minuten)</label>
                                                <input class="form-control input-text input-text-a only-numeric" name="prep_time" type="text" value="<?= $prep; ?>" />
                                                <small style="color:red"></small>
                                        </div>
                                        <div class="col-md-4 mob-margin-zeit">
                                                <label  class="heading-input">Zeit-Zubereitung (Minuten)</label>
                                                <input class="form-control input-text input-text-a only-numeric" name="cooking_time" type="text" value="<?= $cook; ?>" />
                                                <small style="color:red"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="container" id="slider-custom">
                                    <div class="d-flex flex-column justify-content-start slider col-md-12">
                                        <div class="row text-secondary">
                                            <div class="col-md-4">
                                                <label class="col-form-label" id="field-label-1"><br>Schwierigkeitsgrad (0 = leicht bis 3) <br><br></label>
                                            </div>
                                        </div>
                                        <div class="row button-group">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="btn-toolbar">
                                                    <div class="btn-group" role="group" id="difficulty">
                                                        <?= $difficulty_values; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column justify-content-start slider col-md-12">
                                        <div class="row text-secondary">
                                            <div class="col-md-4">
                                                <label class="col-form-label" id="field-label-1"><br>Schärfegrad (0 = kein bis 3)<br><br></label>
                                            </div>
                                        </div>
                                        <div class="row button-group">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="btn-toolbar">
                                                    <div class="btn-group" role="group" id="sharpness">
                                                       <?= $sharpness_values; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                    <div class="row">
                                            <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                                                <button class="btn btn-primary order-2 save-changes-btn" type="button" name="saveFormDataTechnicalDetails" id="saveFormDataTechnicalDetails"  >Änderungen speichern</button>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                            </form>

                            <div class="container" id="Utensilien">
                                <div class="row">
                                    <div class="utensilien-a">
                                        <section class="utensilien-aa">
                                            <h2 class="diat-heading-main">Utensilien 
                                            <img data-toggle="tooltip" src="form_assets/img/Vector-1.svg" class="uten-img"  title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen" />
                                            </h2>

                                            <p id="Fuge">Füge Utensilien hinzu:</p>

                                            <div class="autocomplete uten-auto">
                                                <input id="myInput" type="text" class="utils-input-css form-control" name="utensilien" placeholder="Geben Sie hier die Utensilien ein" autocomplete="off">
                                                <input type="hidden" id="utils_id" />
                                                <div id="" class="autocomplete-items list-auto-a" ></div>
                                            </div>
                                            <button class="every-button" id="button-add-tag" type="button" onclick="addtag(this)" disabled>Hinzufügen</button>

                                        </section>
                                    </div>
                                </div>
                                <form method="POST">
                                    <div class="row">
                                        <div id="save-tag">
                                            <div id="Bereits">Bereits hinzuegfügte Utensilien:</div>
                                            <?= $utils_values; ?>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                                            <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataUtils" >Änderungen speichern</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br/>
                            <div class="container Diat diat-1" id="allergen">
                                <div class="row">
                                    <div class="col">
                                        <h1 class="diat-heading-main">
                                            &nbsp;Allergene<img data-toggle="tooltip" data-bss-tooltip=""
                                                src="form_assets/img/Vector-1.svg" class="tooltip-z"
                                                title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen">
                                        </h1>
                                    </div>
                                    <?= $allergen_values; ?>
                                </div>
                            </div>
                            <form class="container d-inline-flex flex-column flex-wrap multiple-data-entry" id="ingredients" method="POST">
                                <div class="row Zutaten-row">
                                    <div class="col col-sm1">
                                        <h1 class="Zutaten-heading zh">Zutaten für zwei Personen</h1>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-sm">
                                        <h1 class="Zutaten-subheading zh">Supermarkt-Zutaten:<img data-toggle="tooltip"
                                                data-bss-tooltip="" src="form_assets/img/Vector-1.svg"
                                                title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen"
                                                class="tooltip-z">
                                        </h1>
                                    </div>
                                </div>
                                    <div id="meat-div">
                                        <?= $meat_values; ?>
                                    </div>

                                    <div id="tierische-div">
                                        <?= $animal_ingre_values; ?>
                                    </div>

                                    <div id="milchprodukte-div">
                                    <?= $dairy_ingre_values; ?>
                                    </div>

                                    <div id="hulsenfruchte-div" >
                                        <?= $legumes_ingre_values; ?>
                                    </div>

                                    <div id="gemuse-div">
                                        <?= $vegetables_ingre_values; ?>
                                    </div>

                                    <div id="starkebeilagen-div">
                                        <?= $starch_ingre_values; ?>
                                    </div>

                                    <div id="obst-div">
                                        <?= $fruit_ingre_values; ?>
                                    </div>

                                    <div id="krauter-div">
                                        <?= $herbs_ingre_values; ?>
                                    </div>

                                    <div id="weine_und_safte-div">
                                        <?= $juices_ingre_values; ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                                            <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataSupermarket" >Änderungen speichern</button>
                                        </div>
                                    </div>
                            </form>
                            <form class="container d-inline-flex flex-column flex-wrap multiple-data-entry-1" method="POST">
                                <div class="row Zutaten-row">
                                    <div class="col col-sm">
                                        <h1 class="Zutaten-subheading zh">Fancies<img data-toggle="tooltip"
                                                data-bss-tooltip="" src="form_assets/img/Vector-1.svg"
                                                title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen"
                                                class="tooltip-z">
                                        </h1>
                                    </div>
                                </div>

                                <div id="gewurze-div">
                                    <?= $spices_ingre_values; ?>
                                </div>

                                <div id="panaden-div">
                                    <?= $breadcrumbs_ingre_values; ?>
                                </div>

                                <div id="nusse-div">
                                    <?= $nuts_ingre_values; ?>
                                </div>
                                
                                <div id="ole-div" >
                                    <?= $oils_ingre_values; ?>
                                </div>

                                <div id="gewurzpasten-div">
                                    <?= $spice_paste_ingre_values; ?>
                                </div>
                                
                                <div id="trockenfruchte-div">
                                    <?= $driedfruits_ingre_values; ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                                        <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataFancies" >Änderungen speichern</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                            <div class="container Diat diat-1" id="home_equipment">
                                <div class="row">
                                    <div class="col">
                                        <h1 class="diat-heading-main">
                                            &nbsp;Heimaustattung <img data-toggle="tooltip" data-bss-tooltip="" src="form_assets/img/Vector-1.svg" class="tooltip-z"  title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen">
                                        </h1>
                                    </div>
                                    <?= $home_values; ?>
                                </div>
                            </div>

                        <form method="POST" enctype="multipart/form-data">
                            <div id="cookingStepList">
                                <?= $cooking_steps_values; ?>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 d-flex flex-column align-items-start col-save-changes" >
                                        <button class="btn btn-primary order-2 save-changes-btn" type="submit" name="saveFormDataCookingSteps" >Änderungen speichern</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>

                <!-- Overview Page using Ajax -->
                <div id="overview">
                </div>
                    
                    <!-- Overview Page using Ajax -- end -->

                    <div class="row last-line">
                        <div class="col text-center d-flex justify-content-center">
                            <h5 class="text-center" id="last-light-text">
                                Du kannst das Rezept in deinem Profil jederzeit bearbeiten!</h5>
                        </div>
                    </div>
                    <section class="footer-end">
                        <div class="container coon-row-button-end">
                            <div class="row row-button-end">
                                <div class="col-12 offset-0"><button class="btn btn-primary last-b-d"
                                        type="button">About</button>
                                </div>
                            </div>
                            <div class="row row-button-end">
                                <div class="col-12"><button class="btn btn-primary last-b-d"
                                        type="button">Impressum</button>
                                </div>
                            </div>
                            <div class="row row-button-end">
                                <div class="col-12"><button class="btn btn-primary last-b-d"
                                        type="button">Datenschutz</button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
         
        </div><a class="border rounded d-inline scroll-to-top " id="scrollTop" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <?php
        include_once("../userIncludes/footer.php");
    ?>

    <script src="../dashboard/assets/js/jquery.min.js"></script>
    <script src="form_assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="form_assets/js/script.min.js"></script>
    <script src="../dashboard/assets/js/script.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="form_assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="form_assets/js/formCustomJquery.js" ></script>
    <script>
    var repid = <?= $recipe_id; ?>;
    $(document).ready(function(){
        $("#saveFormDataTechnicalDetails").click(function(){
            SaveTechnicalDetails();
            SaveDiffAndSharp();
        })
    });

function SaveTechnicalDetails()
{
    var arr = [];
    $("#technical").siblings('div').children("div").each(function(){
        if( $(this).children('input').val() )
        {
            var val = $(this).children('input').val();
            arr.push( parseInt(val) );
        }
    });
    if(arr.length > 0)
    {
        $.ajax({
            url:"recipeAjax.php",
            type:"POST",
            data:{req:"SaveTechnicalForEdit",recipe_id:repid,values:arr}, 
            success:function(response)
            {
                location.reload(true);
            }
        });
    }
}

function SaveDiffAndSharp()
{
    var arr = [];
    var diff_val = $("#difficulty").children(".active").val();
    var sharp_val = $("#sharpness").children(".active").val();
    arr.push(diff_val);
    arr.push(sharp_val);
    if(arr.length > 0)
    {
        $.ajax({
            url:"recipeAjax.php",
            type:"POST",
            data:{req:"SaveDAndSForEdit",recipe_id:repid,values:arr},
            success:function(response)
            {
                location.reload(true);
            }
        });
    }
}

     function validateImage() 
        {
            var formData = new FormData();
            var file = document.getElementById("change_photo").files[0];
            formData.append("Filedata", file);
            var t = file.type.split('/').pop().toLowerCase();
            if (t != "jpeg" && t != "jpg" && t != "png" && t != "svg" && t != "webp") 
            {
                    alert('Please select a valid image file');
                    document.getElementById("change_photo").value = '';
                    return false;
            }
            if (file.size > 5000000) 
            {
                alert('Max Upload size is 5MB only');
                document.getElementById("change_photo").value = '';
                return false;
            }
                var input = document.getElementById("change_photo");
                var fReader = new FileReader();
                fReader.readAsDataURL(input.files[0]);
                fReader.onloadend = function(event)
                {
                    var img = document.getElementById("profileImage");
                    img.src = event.target.result;
                    return true;
                }
        }
    </script>

</body>

</html>
    