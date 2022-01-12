<?php
    session_start();
    require "../Model/class.recipe.php";
    require "../Model/class.chef.php";
    
    if((!isset($_SESSION["user_email"])) && (!isset($_SESSION["facebook_access_token"])) && (!isset($_SESSION["google_access_token"])))
    {
        header("Location: ../login.php");
    }
    $username = $_SESSION["username"];
    $chef_email = $_SESSION["user_email"];

    // $username = "Dummy User";
    // $chef_email = "taha1709d@aptechgdn.net";    
    $chef = new chef;
    $recipe = new recipe;                 
    
   

    $user_avatar = $chef->fetchChefProperties($chef_email,"avatar");
 

    if(isset($_POST["submitRecipe"]))
    {
        $obj = new recipe;
        $obj->updateRecipeStatus($chef_email,"complete");
        unset($obj);
    }
    if(isset($_POST["allRecipes"]))
    {
        header("Location: index.php");
    }

    $recipe_id = $chef->checkRecipeForCurrentChef($chef_email);
    if( intval($recipe_id) > 0)
    {
        if($recipe->deleteRecipe($recipe_id,"incomplete") == true)
        {
            header("Location:".$_SERVER["REQUEST_URI"]);
        }
    }
    

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Neues Rezept hinzufügen</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
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
                        <img src="assets/img/logo.svg" alt="Site Logo" width="150" height="50" />
                    </div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item">
                        <a class="nav-link text-center" href="index.php">
                            <i class="fa fa-th-list icon-nav-link"></i>
                            <span class="text-center text-side-nav-link">Alle Rezepte anzeigen</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center active" href="form.php"><i class="fa fa-plus-circle icon-nav-link"></i>
                            <span class="text-side-nav-link">Neues Rezept erstellen</span>
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
                            <img src="assets/img/form_loader.gif"/>
                        </div>
                <div id="main-form">
                    <form method="POST" role="form" id="recipe" enctype="multipart/form-data" action="form.php" onsubmit="return false;">
                        <div id="form-body">
                            <nav class="navbar navbar-light navbar-expand-md heading-nav">
                                <div class="container-fluid">
                                    <a class="navbar-brand d-flex flex-wrap" id="main_heading-top" href="#">
                                        <strong>FLAVOUR FLIP</strong>
                                    </a>
                                </div>
                            </nav>
                            <div class="container col-md-12" id="textarea-1">
                                
                                <div class="row" style="margin-left:13px" >
                                    <div class="col-sm-12 col-md-6">
                                            <h1 class="diat-heading-main">
                                                &nbsp;Titel
                                                <img data-toggle="tooltip" data-bss-tooltip="" class="tooltip-paragragh" src="form_assets/img/Vector-1.svg"  title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen">
                                            </h1>
                                        <input class="form-control input-text " id="recipe_title" maxlength="200" type="text">
                                        <small style="color:red"></small>
                                    </div>
                                </div>
                                <div class="row" style="margin-left:13px" >
                                    <div class="col-sm-12 col-md-6">
                                        <h1 class="diat-heading-main">
                                            &nbsp;Rezeptbeschreibung
                                            <img data-toggle="tooltip" data-bss-tooltip="" class="tooltip-paragragh" src="form_assets/img/Vector-1.svg"  title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen">
                                        </h1>
                                        <textarea class="form-control input-text  desc-input" id="recipe_description" maxlength="1000" type="text" rows=3></textarea>
                                    </div>
                                </div>
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
                                        <div class="col-md-12 d-flex flex-row flex-shrink-1 flex-wrap order-3 checbox-col mob-margin">
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
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End: 1 Row 1 Column -->
                            <div class="container col-md-12" id="textarea-1">
                                <div class="row">
                                    <div class="col d-flex heading-b">
                                        <h1 id="heading-a" class="heading-a diat-heading-main">Nährwertangaben </h1>
                                    </div>
                                </div>
                                <div class="row" style="margin-left:20px" id="nutritional">
                                    <div class="col-md-3 col-sm-6 ">
                                        <label class="heading-input">Kalorien</label>
                                        <input class="form-control input-text only-numeric" name="calorie" type="text">
                                        <small style="color:red"></small>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                            <label class="heading-input">Fett(g)</label>
                                            <input class="form-control input-text only-numeric" name="fat" type="text">
                                            <small style="color:red"></small>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                            <label class="heading-input">Kohlenhydrate(g)</label>
                                            <input class="form-control input-text only-numeric" name="carbohydrates" type="text">
                                            <small style="color:red"></small>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                            <label class="heading-input">Eiweiß(g)</label>
                                            <input class="form-control input-text only-numeric" name="protein" type="text">
                                            <small style="color:red"></small>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="container Diat" id="animal_products">
                                <div class="row">
                                    <div class="col">
                                        <h1 class="diat-heading-main">
                                            &nbsp;Tierische Produkte<img data-toggle="tooltip" data-bss-tooltip="" src="form_assets/img/Vector-1.svg" class="tooltip-z" title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen">
                                        </h1>
                                    </div>
                                    <div class="col-md-12 d-flex flex-row flex-shrink-1 flex-wrap order-3 checbox-col">
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
                                    </div>
                                </div>
                            </div>
                            <br/>
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
                                            <input class="form-control input-text input-text-a only-numeric" name="prep_time" type="text" >
                                             <small style="color:red"></small>
                                    </div>
                                    <div class="col-md-4 mob-margin-zeit">
                                            <label  class="heading-input">Zeit-Zubereitung (Minuten)</label>
                                            <input class="form-control input-text input-text-a only-numeric" name="cooking_time" type="text">
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
                                                    <input class="btn btn-primary button-option active" name="difficulty" type="button" value="0" checked />
                                                    <input class="btn btn-primary button-option" name="difficulty" type="button" value="1" />
                                                    <input class="btn btn-primary button-option" name="difficulty" type="button" value="2" />
                                                    <input class="btn btn-primary button-option" name="difficulty" type="button" value="3" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column justify-content-start slider col-md-12">
                                    <div class="row text-secondary">
                                        <div class="col-md-4">
                                            <label class="col-form-label" id="field-label-1"><br>Schärfegrad (0 = kein bis 3<br><br></label>
                                        </div>
                                    </div>
                                    <div class="row button-group">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="btn-toolbar">
                                                <div class="btn-group" role="group" id="sharpness">
                                                <input class="btn btn-primary button-option active" name="sharpness" type="button" value="0" checked/>
                                                    <input class="btn btn-primary button-option" name="sharpness" type="button" value="1" />
                                                    <input class="btn btn-primary button-option" name="sharpness" type="button" value="2" />
                                                    <input class="btn btn-primary button-option" name="sharpness" type="button" value="3" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                <div class="row">
                                    <div id="save-tag">
                                        <div id="Bereits">Bereits hinzuegfügte Utensilien:</div>
                                    </div>
                                </div>
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
                                    <div class="col-md-12 d-flex flex-row flex-shrink-1 flex-wrap order-3 checbox-col">
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

                                    </div>
                                </div>
                            </div>
                            <div class="container d-inline-flex flex-column flex-wrap multiple-data-entry" id="ingredients">
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
                                    <div class="row nth-fish" id="meat-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Fisch/Fleisch</h1>
                                                    <input type="text" class="Fisch-input ingredients-input-supermarket form-control" name="meat[]" data-id="meat" autocomplete="off" /> 
                                                    <input type="hidden" name="meat_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a" >
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="meat_quantity[]" autocomplete="off">
                                                    <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- change -->
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="meat_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="tierische-div">
                                    <div class="row nth-fish" id="tierische-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Tierische Erzeugnisse</h1>
                                                    <input type="text" class="Fisch-input ingredients-input-supermarket form-control" name="animal_products[]" data-id="animal_products" autocomplete="off" />
                                                    <input type="hidden" name="animal_products_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="animal_products_quantity[]" autocomplete="off"/>
                                                    <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="animal_products_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="milchprodukte-div">
                                    <div class="row nth-fish" id="milchprodukte-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Milchprodukte</h1>
                                                    <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="dairy_products[]" data-id="dairy_products" autocomplete="off" />
                                                    <input type="hidden" name="dairy_products_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a">
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="dairy_products_quantity[]" autocomplete="off"/>
                                                    <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="dairy_products_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="hulsenfruchte-div" >
                                    <div class="row nth-fish" id="hulsenfruchte-div1" >
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Hülsenfrüchte</h1>
                                                    <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="legumes[]" data-id="legumes" autocomplete="off">
                                                    <input type="hidden" name="legumes_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="legumes_quantity[]" autocomplete="off"/>
                                                     <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="legumes_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="gemuse-div">
                                    <div class="row nth-fish" id="gemuse-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Gemüse</h1>
                                                    <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="vegetables[]" data-id="vegetables" autocomplete="off" />
                                                    <input type="hidden" name="vegetables_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="vegetables_quantity[]" autocomplete="off"/>
                                                    <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="vegetables_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="starkebeilagen-div">
                                    <div class="row nth-fish" id="starkebeilagen-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Stärkebeilagen</h1>
                                                    <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="starch[]" data-id="starch" autocomplete="off" />
                                                    <input type="hidden" name="starch_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="starch_quantity[]" autocomplete="off"/>
                                                    <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="starch_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="obst-div">
                                    <div class="row nth-fish" id="obst-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Obst</h1>
                                                    <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="fruits[]" data-id="fruits" autocomplete="off" />
                                                    <input type="hidden" name="fruits_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a">
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="fruits_quantity[]" autocomplete="off"/>
                                                    <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="fruits_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="krauter-div">
                                    <div class="row nth-fish" id="krauter-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Kräuter</h1>
                                                    <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="herbs[]" data-id="herbs" autocomplete="off" />
                                                    <input type="hidden" name="herbs_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="herbs_quantity[]" autocomplete="off"/>
                                                    <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="herbs_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>


                                <div id="weine_und_safte-div">
                                    <div class="row nth-fish" id="weine_und_safte-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Weine und Säfte</h1>
                                                    <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="juices[]" data-id="juices" autocomplete="off" />
                                                    <input type="hidden" name="juices_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a">
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="juices_quantity[]" autocomplete="off">
                                                    <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="juices_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="container d-inline-flex flex-column flex-wrap multiple-data-entry-1">

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
                                    <div class="row nth-fish" id="gewurze-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Gewürze</h1>
                                                    <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="spices[]" data-id="spices" autocomplete="off" />
                                                    <input type="hidden" name="spices_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a">
                                                        <!-- Data will be loaded using AJAX -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="spices_quantity[]" autocomplete="off">
                                                    <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="spices_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="panaden-div">
                                    <div class="row nth-fish" id="panaden-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Panaden / Brösel</h1>
                                                    <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="breadcrumbs[]" data-id="breadcrumbs" autocomplete="off" />
                                                    <input type="hidden" name="breadcrumbs_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a ">
                                                        <!-- Data will be loaded using AJAX -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="breadcrumbs_quantity[]" autocomplete="off"/>
                                                    <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="breadcrumbs_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="nusse-div">
                                    <div class="row nth-fish" id="nusse-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Nüsse und Kerne</h1>
                                                    <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="nuts[]" data-id="nuts" autocomplete="off" />
                                                    <input type="hidden" name="nuts_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a">
                                                        <!-- Data will be loaded using AJAX -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="nuts_quantity[]" autocomplete="off" />
                                                    <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="nuts_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="ole-div" >
                                    <div class="row nth-fish" id="ole-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Öle, Soßen, Essig</h1>
                                                    <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="oils[]" data-id="oils" autocomplete="off" />
                                                    <input type="hidden" name="oils_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a">
                                                        <!-- Data will be loaded using AJAX -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="oils_quantity[]" autocomplete="off" />
                                                    <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="oils_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" id="addMoreRecords" type="button">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="gewurzpasten-div">
                                    <div class="row nth-fish" id="gewurzpasten-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Gewürzpasten</h1>
                                                    <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="spice_paste[]" data-id="spice_paste" autocomplete="off" />
                                                    <input type="hidden" name="spice_paste_id[]" />
                                                    
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a">
                                                        <!-- Data will be loaded using AJAX -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="spice_paste_quantity[]" autocomplete="off" />
                                                     <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="spice_paste_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" id="addMoreRecords" type="button">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="trockenfruchte-div">
                                    <div class="row nth-fish" id="trockenfruchte-div1">
                                        <div class="col-md-5 col-sm-5 usl-fish">
                                            <div class="row fisch">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm-title">Trockenfrüchte</h1>
                                                    <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="driedfruits[]" data-id="driedfruits" autocomplete="off" />
                                                    <input type="hidden" name="driedfruits_id[]" />
                                                    <div id="" class="autocomplete-items list-auto-a list-a-a-a">
                                                        <!-- Data will be loaded using AJAX -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 usl-menge">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="heading-sm">Menge</h1>
                                                    <input type="text" class="form-control menge-input only-numeric" name="driedfruits_quantity[]" autocomplete="off" />
                                                    <small style="color:red"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="dropdown mt-4 dd-gramm-mo">
                                                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="driedfruits_unit[]">
                                                    <div class="dropdown-menu">
                                                    <option class="dropdown-item style-dropdown" value="gramm" selected>Gramm</option>
                                                    <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option>
                                                    <option class="dropdown-item style-dropdown" value="stück">Stück</option>
                                                    <option class="dropdown-item style-dropdown" value="dose">Dose</option>
                                                    </div>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12" >
                                            <button class="btn btn-primary mt-4 button-hera" id="addMoreRecords" type="button">Hinzufügen</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="container Diat diat-1" id="home_equipment">
                                <div class="row">
                                    <div class="col">
                                        <h1 class="diat-heading-main">
                                            &nbsp;Heimaustattung <img data-toggle="tooltip" data-bss-tooltip="" src="form_assets/img/Vector-1.svg" class="tooltip-z"  title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen">
                                        </h1>
                                    </div>
                                    <div class="col-md-12 d-flex flex-row flex-shrink-1 flex-wrap order-3 checbox-col">
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
                                    </div>
                                </div>
                            </div>

                        <!-- <div class="container d-flex flex-column col-md-12 card form">
                            <div class="row row-hide">
                                <div class="col dis-drop">
                                    <h1 class="heading-main"><em>Schritt: 1</em></h1>
                                    <div class="dropdown show">
                                        <button class="btn btn-primary active dropdown-toggle pic-dropdown" aria-expanded="true" data-toggle="dropdown" type="button">
                                            <img src="form_assets/img/cute-boy-chef-look-smart_38747-11.jpg" class="hid-pic-dropd">ASDASDASDASDA
                                        </button>
                                        <div class="dropdown-menu hid-dd-m">
                                            <a class="dropdown-item text-break text-left d-flex flex-grow-1 flex-shrink-1 flex-wrap desciption-option col-md-12">Firaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        
                        <div id="cookingStepList">
                            <div class="container d-flex flex-column col-md-12 card form" id="step1">
                                <div class="row d-flex flex-shrink-1 flex-wrap">
                                    <div class="col d-flex flex-row flex-shrink-1 flex-wrap">
                                        <h1 class="Arbeitsschritte diat-heading-main">Koch Anleitung
                                            <img data-toggle="tooltip" class="tooltip-paragragh" data-bss-tooltip="" src="form_assets/img/Vector-1.svg" title="Trage hier bitte ein, zu welcher Ernährungsart dein Gericht passen könnte. Du kannst mehrere Ernährungsformen auswählen">
                                        </h1>
                                        <p><b>WICHTIG:</b> Der <i>1 Schritt</i> bildet das <i>Präsentationsbild / Coverbild</i> des Gerichts. Trage in den Titel und Beschreibung jeweils das Wort <i>Cover</i> ein!</p>
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
                                                <div class="col-xs-6 col-sm-10 col-md-8 d-flex flex-row">
                                                    <!-- <input class="btn btn-primary d-flex flex-row uploadbutton-input" type="file" value="Upload Bild" >
                                                    <img src="form_assets/img/cute-boy-chef-look-smart_38747-11.jpg" style="width: 81px;padding-left: 0px;margin-top: 10px;margin-left: -100px;height: 71px;"> -->
                                                    <label for="files1" class="btn btn-primary d-flex flex-row uploadbutton-input" >Upload Bild</label>
                                                    <input  id="files1" type="file" hidden>    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex flex-column flex-shrink-1 justify-content-center flex-wrap align-items-xl-center col-hidden pic -arb">
                                            <div class="row row-hidden">
                                                <div class="col">
                                                    <img class="pic-arbeeaa" src="form_assets/img/cute-boy-chef-look-smart_38747-11.jpg" id="image-display1">
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
                        </div>
                        <div class="row hr">
                            <div class="col">
                                <hr class="hr-main">
                            </div>
                        </div>
                        <div class="row d-flex flex-row flex-grow-1 flex-shrink-1 row-button">
                            <div class="col" id="nextButton">
                                <button class="btn btn-primary d-flex d-lg-flex d-xl-flex justify-content-center align-items-center justify-content-lg-center align-items-lg-center justify-content-xl-center align-items-xl-center Rezept-übermitteln" id="last-button" type="button">Nächster</button>
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

    <script src="assets/js/jquery.min.js"></script>
    <script src="form_assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="form_assets/js/script.min.js"></script>
    <script src="assets/js/script.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="form_assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="form_assets/js/formCustomJquery.js" ></script>
    <script src="form_assets/js/formSubmit.js" ></script>
    <script>
    $(document).ready(function(){
        
        checkIfFormSubmitted();
        
    });

    function checkIfFormSubmitted()
    {
        $.ajax({
            url:"recipeAjax.php",
            type:"POST",
            data:{req:"checkFormSubmission"},
            success:function(response)
            {
                if((response.toString().length > 0) && (response == "true"))
                {
                    $("#RecipesFormSubmit").modal('show');
                }
            }
        })
    }
    function loadOverViewPage()
    {
        $.ajax({
            url:"recipeAjax.php",
            type:"POST",
            data:{req:"overviewPage"},
            success:function(response)
            {
                $("#main-form").hide();
                $("#overview").html(response);
            }
        })
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

    
<!-- Modal -->
<div class="modal fade" id="RecipesFormSubmit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#ffa3a4" >
                    <h5 class="modal-title" id="exampleModalLongTitle">Recipe Submitted Successfully</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="form_assets/img/success.png" style="max-width:100%;max-height:40px" />
                    Thank you for Your submission
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="allRecipes" class="btn btn-primary" style="background-color:#ffa3a4;color:black;">Show All Recipes</button>
                </div>
            </div>
        </form>
    </div>
</div>


</body>

</html>
    