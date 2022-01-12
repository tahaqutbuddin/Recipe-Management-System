<?php
    session_start();
    require "../Model/class.recipe.php";
    require "../Model/class.chef.php";
    require "../Model/class.admin.php";
    
    
    if(!isset($_SESSION["admin_email"],$_SESSION["adminname"]))
    {
        header("Location:../login.php");
    }

    if(!isset($_GET["protected"],$_GET["hash"],$_GET["mode"]))
    {
        header("Location: denied.php");
    }

    $recipe_id = base64_decode($_GET["protected"]);    
    $admin = new admin;
    $chef = new chef;
    $obj = new recipe;
    if(isset($_SESSION["admin_email"]))
    {
        $admin_name = ucfirst($admin->fetchAdminProperties($_SESSION["admin_email"],"first_name"));
    }else { $admin_name = "dummy"; }

    $chef_email = $obj->userInsertedDataTechnical("id",$recipe_id,"main_recipe","chef_email","complete");

    $chef_avatar = $chef->fetchChefProperties($chef_email,"avatar");
    $chef_name = ucfirst($chef->fetchChefProperties($chef_email,"first_name")).' '.ucfirst($chef->fetchChefProperties($chef_email,"last_name"));

    $diet_arr = $obj->userInsertedDataCheckbox("id",$recipe_id,"main_recipe","diet","complete");
    $diet_values = "";
    if((is_bool($diet_arr) && ($diet_arr == false)) || ($diet_arr == NULL))
    {
        $diet_values = '
        <h6 class="italicred" id="same-text-alig">
            <em>keine Angabe</em>
        </h6>
        ';
    }else
    {
        $diet_values .= ' <ul>';
        for($i = 0; $i < count($diet_arr);$i++)
        {
            $diet_values .= '<li>'.ucfirst(htmlspecialchars_decode($diet_arr[$i],ENT_COMPAT)).'</li>';
        } 
        $diet_values .= ' </ul>';
    }
    
    $animal_arr = $obj->userInsertedDataCheckbox("id",$recipe_id,"main_recipe","animal_products","complete");
    $animal_values = "";
    if((is_bool($animal_arr) && ($animal_arr == false)) || ($animal_arr == NULL))
    {
        $animal_values = '
        <h6 class="italicred" id="same-text-alig">
            <em>keine Angabe</em>
        </h6>
        ';
    }else
    {
        $animal_values .= ' <ul>';
        for($i = 0; $i < count($animal_arr);$i++)
        {
            $animal_values .= '<li>'.ucfirst(htmlspecialchars_decode($animal_arr[$i],ENT_COMPAT)).'</li>';
        } 
        $animal_values .= ' </ul>';
    }
    $allergen_arr = $obj->userInsertedDataCheckbox("id",$recipe_id,"main_recipe","allergen","complete");
    $allergen_values = "";
    if((is_bool($allergen_arr) && ($allergen_arr == false)) || ($allergen_arr == NULL))
    {
        $allergen_values = '
        <h6 class="italicred" id="same-text-alig">
            <em>keine Angabe</em>
        </h6>
        ';
    }else
    {
        $allergen_values .= ' <ul>';
        for($i = 0; $i < count($allergen_arr);$i++)
        {
            $allergen_values .= '<li>'.ucfirst(htmlspecialchars_decode($allergen_arr[$i],ENT_COMPAT)).'</li>';
        } 
        $allergen_values .= ' </ul>';
    }


    $home_arr = $obj->userInsertedDataCheckbox("id",$recipe_id,"main_recipe","home_equipment","complete");
    $home_values = "";
    if((is_bool($home_arr) && ($home_arr == false)) || ($home_arr == NULL))
    {
        $home_values = '
        <h6 class="italicred" id="same-text-alig">
            <em>keine Angabe</em>
        </h6>
        ';
    }else
    {
        $home_values .= ' <ul>';
        for($i = 0; $i < count($home_arr);$i++)
        {
            $home_values .= '<li>'.ucfirst(htmlspecialchars_decode($home_arr[$i],ENT_COMPAT)).'</li>';
        } 
        $home_values .= ' </ul>';
    } 
    
    $utils_arr = $obj->userInsertedDataUtils("id",$recipe_id,"utils","description","complete");
    $utils_values = "";
    if((is_bool($utils_arr) && ($utils_arr == false)) || ($utils_arr == NULL))
    {
        $utils_values = '
        <h6 class="italicred" id="same-text-alig">
            <em>keine Angabe</em>
        </h6>
        ';
    }else
    {
        $utils_values .= ' <ul>';
        for($i = 0; $i < count($utils_arr);$i++)
        {
            $utils_values .= '<li>'.ucfirst($utils_arr[$i][1]).'</li>';
        } 
        $utils_values .= ' </ul>';
    }
    $supermarket_arr = $obj->userInsertedDataIngredients("id",$recipe_id,"supermarket","complete");
    $supermarket_values = "";
    if((is_bool($supermarket_arr) && ($supermarket_arr == false)) || ($supermarket_arr == NULL))
    {
        $supermarket_values = '
        <h6 class="italicred" id="same-text-alig">
            <em>keine Angabe</em>
        </h6>
        ';
    }else
    {
        $supermarket_values .= ' <ul>';
        for($i = 0; $i < count($supermarket_arr);$i++)
        {
            $supermarket_values .= '<li>'.ucfirst(htmlspecialchars_decode($supermarket_arr[$i],ENT_COMPAT)).'</li>';
        } 
        $supermarket_values .= ' </ul>';
    }

    $fancies_arr = $obj->userInsertedDataIngredients("id",$recipe_id,"fancies","complete");
    $fancies_values = "";
    if((is_bool($fancies_arr) && ($fancies_arr == false)) || ($fancies_arr == NULL))
    {
        $fancies_values = '
        <h6 class="italicred" id="same-text-alig">
            <em>keine Angabe</em>
        </h6>
        ';
    }else
    {
        $fancies_values .= ' <ul>';
        for($i = 0; $i < count($fancies_arr);$i++)
        {
            $fancies_values .= '<li>'.ucfirst(htmlspecialchars_decode($fancies_arr[$i],ENT_COMPAT)).'</li>';
        } 
        $fancies_values .= ' </ul>';
    }

    $cooking_steps_arr = $obj->userInsertedDataCookingSteps("id",$recipe_id,"cooking_steps","complete");
    $cooking_steps_values = "";
    if((is_bool($cooking_steps_arr) && ($cooking_steps_arr == false)) || ($cooking_steps_arr == NULL))
    {
        $cooking_steps_values = '
        <div class="row d-flex flex-row flex-shrink-1 flex-nowrap col-md-12" id="card-last-one">
            <div class="col-md-6 col-xl-8">
                <div class="row">
                    <div class="alert alert-danger"> Keine Kochschritte eingefügt.</div>
                </div>
            </div>
        </div>
        ';
    }else
    {
        for($i = 0; $i < count($cooking_steps_arr);$i++)
        {
            $title = isset($cooking_steps_arr[$i][0]) ?  $cooking_steps_arr[$i][0] : NULL;
            $desc  = isset($cooking_steps_arr[$i][1]) ?  $cooking_steps_arr[$i][1] : NULL;
            $img   = isset($cooking_steps_arr[$i][2]) ?  $cooking_steps_arr[$i][2] : NULL;
            $cooking_steps_values .= '
            <div>
            <h1 class="justify-content edit-title" >Step '.($i+1).'</h1>
            <div id="id-12" class="row" >
            
            <div id="id-13"class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4" >
                <img id="id-14" src="../dashboard/assets/img/cookingsteps/'.$img.'">
            </div>
            
            <div id="id-13" class="col" >
                
                <div id="examplecom" class="card" >
                    <div id="id-15" class="card-body">
                        <h4 class="card-title">Title: '.$title.'</h4>
                        <p id="id-123" >'.$desc.'</p>
                    </div>
                </div>
            </div>
             </div><!-- End: Responsive Left Image Card -->
        </div>
            ';
            
        } 
    }

    $difficulty = $obj->userInsertedDataTechnical("id",$recipe_id,"main_recipe","difficulty","complete");
    $sharpness = $obj->userInsertedDataTechnical("id",$recipe_id,"main_recipe","sharpness","complete");
    $calorie = $obj->userInsertedDataNutritional("id",$recipe_id,"nutritional_info","calorie","complete");
    $fat = $obj->userInsertedDataNutritional("id",$recipe_id,"nutritional_info","fat","complete");
    $carbo = $obj->userInsertedDataNutritional("id",$recipe_id,"nutritional_info","carbohydrates","complete");
    $protein = $obj->userInsertedDataNutritional("id",$recipe_id,"nutritional_info","protein","complete");
    $title = $obj->userInsertedDataTechnical("id",$recipe_id,"main_recipe","title","complete");
    $desc = $obj->userInsertedDataTechnical("id",$recipe_id,"main_recipe","description","complete");
    $cook = $obj->userInsertedDataTechnical("id",$recipe_id,"main_recipe","cooking_time","complete");
    $prep = $obj->userInsertedDataTechnical("id",$recipe_id,"main_recipe","prep_time","complete");
   
    if((strlen($title) == 0) || ($title == NULL))
    {
        $title = "No Title";
    }else if((strlen($desc) == 0)|| ($desc == NULL))
    {
        $desc = "No Description Available";
    }

    if(isset($_POST["deleteRecipe"]))
    {
        $obj = new recipe;
        if( $obj->deleteRecipe($recipe_id,"complete") == true)
        {
            unset($obj);
            header("Location:index.php");
        }
    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Chef Complete Profile</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=ABeeZee">
    <link rel="stylesheet" href="assets/fonts/material-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="assets/css/view.css">
    
    
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0"
            id="sidebar" >
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="index.php">
                    <div class="sidebar-brand-text mx-3">
                        <img src="assets/img/logo.svg" alt="Site Logo" width="150" height="50" />
                    </div>
                </a>
                <hr class="sidebar-divider my-0" />
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item">
                        <a class="nav-link text-center active" href="index.php">
                            <i class="fa fa-plus-circle icon-nav-link"></i>
                            <span class="text-side-nav-link">View All Recipes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center" href="chefs.php">
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
                <nav class="navbar navbar-light navbar-expand bg-white shadow topbar static-top">
                    <div class="container-fluid">
                        <ul class="navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item d-flex justify-content-center align-items-center align-self-center order-2 dropdown no-arrow mx-1" id="menu-bar-a"><button class="btn btn-link rounded-circle mr-3" id="menu-bar" type="button" onclick="openNav()"><i class="fas fa-bars"></i></button></li>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow">
                                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-toggle="dropdown" href="#">
                                        <span class="d-none d-lg-inline mr-2 text-gray-600 small">
                                            <?= $admin_name; ?>
                                        </span>
                                        <img class="border rounded-circle img-profile" src="../dashboard/assets/img/avatars/dummy.png">
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
                <div id="main-color" >
                    <section id="page-cta" class="page-section cta" >
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-10 mx-auto">
                                    <div id="id-1" class="text-center cta-inner rounded" >
                                        <div class="row">
                                            <div class="col-4">
                                                <a href="index.php" class="d-flex align-items-center" style="text-decoration:none">
                                                    <i class="fas fa-arrow-alt-circle-left" style="font-size:30px;"></i>&nbsp;Go Back
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-center">
                                                <h1 id="id-2" class="col-12 col-sm-12" ><strong><?= ucfirst($title); ?></strong></h1>
                                                <h2 id="id-3">Rezeptdetails&nbsp;</h2>
                                                <p id="id-4"><?= ucfirst($desc); ?><br><br></p>
                                            </div>
                                        </div>
                                        <hr id="hr-id" >
                                        <div class="row">
                                            <div id="id-5" class="col d-lg-flex justify-content-center align-items-lg-center" >
                                                <img class="rounded-circle mr-2 image-chef" src="<?= $chef_avatar; ?>">
                                                <h1 id="id-6"class="chefname" ><?= ucfirst($chef_name); ?></h1>
                                            </div>
                                        </div>
                                        
                                         <hr id="hr-id" >
                                        <div class="row d-flex flex-row">
                                            <div class="col d-lg-flex flex-row justify-content-lg-start align-items-lg-center">
                                                <div class="row d-flex flex-row col-12">
                                                    <div id="id-7" class="col flex-row col-xl-3 col-lg-4 col-md-5 col-sm-6 col-xs-6 justify-content-center" >Kalorien:
                                                        <h1 id="id-10" class="text-center" ><?= $calorie; ?> cal</h1>
                                                    </div>
                                                    <div id="id-7" class="col flex-row col-xl-3 col-lg-4 col-md-5 col-sm-6 col-xs-6 justify-content-center" >Fett:
                                                        <h1 id="id-10" class="text-center" ><?= $fat; ?> g</h1>
                                                    </div>
                                                    <div id="id-7" class="col flex-row col-xl-3 col-lg-4 col-md-5 col-sm-6 col-xs-6 justify-content-center" >Kohlenhydrate:
                                                        <h1 id="id-10" class="text-center" ><?= $carbo; ?> g</h1>
                                                    </div>
                                                    <div id="id-7" class="col flex-row col-xl-3 col-lg-4 col-md-5 col-sm-6 col-xs-6 justify-content-center" >Eiweiß:
                                                        <h1 id="id-10" class="text-center" ><?= $protein ?> g</h1>
                                                    </div>
                                                    <div id="id-7" class="col flex-row col-xl-3 col-lg-4 col-md-5 col-sm-6 col-xs-6 justify-content-center" >Zubereitung:
                                                        <h1 id="id-10" class="text-center" ><?= $cook; ?> mins</h1>
                                                    </div>
                                                    <div id="id-7" class="col flex-row col-xl-3 col-lg-4 col-md-5 col-sm-6 col-xs-6 justify-content-center" >Vorbereitung:
                                                        <h1 id="id-10" class="text-center" ><?= $prep; ?> mins</h1>
                                                    </div>
                                                    <div id="id-7" class="col flex-row col-xl-3 col-lg-4 col-md-5 col-sm-6 col-xs-6 justify-content-center" >Schwierigkeitsgrad:
                                                        <h1 id="id-10" class="text-center" > <?= $difficulty; ?></h1>
                                                    </div>
                                                    <div id="id-7" class="col flex-row col-xl-3 col-lg-4 col-md-5 col-sm-6 col-xs-6 justify-content-center" >Schärfegrad:
                                                        <h1 id="id-10" class="text-center" ><?= $sharpness; ?></h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <hr id="hr-id" >
                                        <div class="row">
                                            <div class="col-lg-3 col">
                                                <div>
                                                    <h1 class="d-flex justify-content-start" id="heading-101" >Diät</h1>
                                                </div>
                                                <div class="d-flex d-sm-flex d-md-flex justify-content-start justify-content-sm-start justify-content-md-start" >
                                                    <?= $diet_values; ?>
                                                </div>             
                                            </div> 
                                            <div class="col-lg-3 col">
                                                <div>
                                                    <h1 class="d-flex justify-content-start" id="heading-101" >Tierische Produkte</h1>
                                                </div>
                                                <div class="d-flex d-sm-flex d-md-flex justify-content-start justify-content-sm-start justify-content-md-start" >
                                                    <?= $animal_values; ?>
                                                </div>             
                                            </div>                     
                                             
                                            <div class="col-lg-3 col">
                                                <div>
                                                    <h1 class="d-flex justify-content-start" id="heading-101" >Heimaustattung</h1>
                                                </div>
                                                <div class="d-flex d-sm-flex d-md-flex justify-content-start justify-content-sm-start justify-content-md-start" >
                                                    <?= $home_values; ?>
                                                </div>             
                                            </div>  
                                            <div class="col-lg-3 col">
                                                <div>
                                                    <h1 class="d-flex justify-content-start" id="heading-101" >Allergene</h1>
                                                </div>
                                                <div class="d-flex d-sm-flex d-md-flex justify-content-start justify-content-sm-start justify-content-md-start" >
                                                    <?= $allergen_values; ?>
                                                </div>             
                                            </div>  
                                                              
                                            <div class="col-lg-3 col">
                                                <div>
                                                    <h1 class="d-flex justify-content-start" id="heading-101" >Utensilien</h1>
                                                </div>
                                                <div class="d-flex d-sm-flex d-md-flex justify-content-start justify-content-sm-start justify-content-md-start" >
                                                    <?= $utils_values; ?>
                                                </div>             
                                            </div>  
                                            <div class="col-lg-3 col">
                                                <div>
                                                    <h1 class="d-flex justify-content-start" id="heading-101" >Supermarkt</h1>
                                                </div>
                                                <div class="d-flex d-sm-flex d-md-flex justify-content-start justify-content-sm-start justify-content-md-start" >
                                                    <?= $supermarket_values; ?>
                                                </div>             
                                            </div> 
                                            <div class="col-lg-3 col">
                                                <div>
                                                    <h1 class="d-flex justify-content-start" id="heading-101" >Fancies</h1>
                                                </div>
                                                <div class="d-flex d-sm-flex d-md-flex justify-content-start justify-content-sm-start justify-content-md-start" >
                                                    <?= $fancies_values; ?>
                                                </div>             
                                            </div>  

                                        </div>
                                        
                                        <hr id="hr-id" >
                                        <div class="row">
                                            <div class="col">
                                                <h1>Instructions</h1>
                                            </div>
                                        </div>
                                        
                                        <!-- Start: Responsive Left Image Card -->
                                        <?= $cooking_steps_values; ?>
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="col-md-6">
                                    <button class="btn btn-danger btn-lg btn-block" type="button" data-toggle="modal" data-target="#deleteModal">Dieses Rezept löschen</button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <?php
                include_once("../userIncludes/footer.php");
            ?>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/script.min.js"></script>
    
</body>

</html>


<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST" role="form">
            <input type="hidden" class="form-control" value="" name="ingre_id" id="ingre_id" />
            <input type="hidden" class="form-control" value="" name="table_name" id="table_name" />
            
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="exampleModalLabel">Dieses Rezept löschen?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Möchten Sie dieses Rezept wirklich löschen?</p>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" name="deleteRecipe">Delete</button>
            </div>
        </form>
    </div>
  </div>
</div>