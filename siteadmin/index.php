<?php
session_start();
require "../Model/class.admin.php";
require "../Model/class.recipe.php";
require "../Model/class.chef.php";

if(!isset($_SESSION["admin_email"],$_SESSION["adminname"]))
{
    header("Location:../login.php");
}
$admin = new admin;
$recipe = new recipe;
$chef = new chef;
if(isset($_SESSION["admin_email"]))
{
    $admin_name = ucfirst($admin->fetchAdminProperties($_SESSION["admin_email"],"first_name"));
}else { $admin_name = "dummy"; }


$totalChefs = $admin->totalChefs();
$totalRecipes = $admin->totalRecipes();
$totalAdmins = $admin->totalAdmins();
$totalIngredients = $admin->totalIngredients();

$result = json_decode($recipe->fetchRecipesForChef("admin","") , true);
unset($recipe);
$displayRecipe = ''; 
if((is_bool($result) && ($result == false)) || ($result == NULL))
{
    $displayRecipe .= '
    <div class="alert alert-danger col-md-12 text-center">Sie haben noch kein Rezept hinzugefügt
    </div>
    ';
}else
{
    for($i = 0; $i < count($result); $i++)
    {
        $recipe_id = $result[$i][0];
        $title = $result[$i][1];
        $desc = $result[$i][2];
        $cook = $result[$i][3];
        $cal = $result[$i][4];
        $images = $result[$i][5];
        $chef_email = $result[$i][6];
        $images_carousal = '';
        $protected = base64_encode($recipe_id);
        $hash = hash('sha512',$protected);
        $chef_avatar = $chef->fetchChefProperties($chef_email,"avatar");
        $chef_name = ucfirst($chef->fetchChefProperties($chef_email,"first_name")).' '.ucfirst($chef->fetchChefProperties($chef_email,"last_name"));
        if(strlen($desc) > 150)
        {
            $desc = substr($desc,0,150);
            $desc .= "..."; 
        }
        if(count($images) > 0)
        {
            $image_display = $caraousal = '';
            for($j = 0; $j < count($images);$j++)
            {
                if($j == (count($images) -1 ))
                {
                    $image_display .= '
                    <div class="carousel-item active">
                        <img  id="car-image" class="pulse animated hero-technology carousel-hero" src="../dashboard/assets/img/cookingsteps/'.$images[$j].'">
                    </div>';
                    $caraousal .= '
                    <li data-target="#carousel-'.$i.'" data-slide-to="'.$j.'" class="active"></li>
                    ';
                }else
                {
                    $image_display .= '
                    <div class="carousel-item">
                        <img  id="car-image" class="pulse animated hero-technology carousel-hero" src="../dashboard/assets/img/cookingsteps/'.$images[$j].'">
                    </div>';
                    $caraousal .= '
                    <li data-target="#carousel-'.$i.'" data-slide-to="'.$j.'" ></li>
                    ';
                }
            }
            $images_carousal = '
            <section id="carousel">
                <!-- Start: Carousel Hero -->
                <div class="carousel slide" data-ride="carousel" id="carousel-'.$i.'">
                    <div class="carousel-inner">
                    '.$image_display.'
                    </div>
                    <div>
                        <a class="carousel-control-prev" href="#carousel-'.$i.'" role="button" data-slide="prev">
                            <i class="fa fa-chevron-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel-'.$i.'" role="button" data-slide="next">
                            <i class="fa fa-chevron-right"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <ol class="carousel-indicators">
                        '.$caraousal.'
                    </ol>
                </div>
            </section>';
            
        }
        $displayRecipe .= '
        <div class="col-md-6 col-lg-4">
            <div class="d-flex justify-content-start align-items-end">
                <img class="border rounded-circle img-profile-1" src="'.$chef_avatar.'">&nbsp;
                <a href="#">
                    <label class="profile-text">'.$chef_name.'</label>
                </a>
            </div>
            <div class="card">
                <!-- Start: best carousel slide -->
                    '.$images_carousal.'
                <div class="card-body">
                    <h1 class="text-left d-xl-flex justify-content-xl-start card-title">'.$title.'<br></h1>
                    <ul class="list-inline text-left d-flex justify-content-start list-icon">
                        <li class="list-inline-item text-center d-flex">
                            <i class="material-icons">timer</i>
                            <span>'.$cook.'min<br></span>
                        </li>
                        <li class="list-inline-item text-center d-flex">
                            <i class="fas fa-fire-alt"></i>
                            <span>'.$cal.'cal<br></span>
                        </li>
                    </ul>
                    <p class="text-left desciption-card">'.$desc.'<br><br></p>
                </div>
                <div>
                    <a class="btn btn-outline-primary btn-sm see-more" href="edit.php?mode=edit&hash='.$hash.'&protected='.$protected.'">Rezept bearbeiten</a>
                    <a class="btn btn-outline-primary btn-sm see-more" href="view.php?mode=view&hash='.$hash.'&protected='.$protected.'">Mehr sehen</a>
                </div>
            </div>
        </div>
        ';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>View All Recipes</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="card_assets/css/styles.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0"
            id="sidebar">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="index.php">
                    <div class="sidebar-brand-text mx-3">
                        <img src="assets/img/logo.svg" alt="Site Logo" width="150" height="50" />
                    </div>
                </a>
                <hr class="sidebar-divider my-0">
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
                        <a class="nav-link text-center" href="fancies.php">
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
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0"
                        id="sidebarToggle" type="button"><i class="fas fa-angle-left"></i></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid">
                        <ul class="navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item d-flex justify-content-center align-items-center align-self-center order-2 dropdown no-arrow mx-1" id="menu-bar-a"><button class="btn btn-link rounded-circle mr-3" id="menu-bar" type="button" onclick="openNav()"><i class="fas fa-bars"></i></button></li>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow">
                                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-toggle="dropdown" href="#">
                                        <span class="d-none d-lg-inline mr-2 text-gray-600 small"><?= $admin_name ?></span>
                                        <img class="border rounded-circle img-profile" src="../dashboard/assets/img/avatars/dummy.png">
                                    </a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in">
                                        <a class="dropdown-item logout-button" href="logout.php">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- ------------------------------------copy from here -->
                <div class="container-fluid">
                    <div class="d-flex flex-column" id="content-wrapper">
                        <div id="content">
                            <section class="clean-block clean-services dark">
                                <div class="row">
                                    <div class="col-md-6 col-xl-3 mb-4">
                                        <div class="card shadow py-2" style="border-left-width: 8px;border-left-color: #FFA3A4;">
                                            <div class="card-body">
                                                <div class="row align-items-center no-gutters">
                                                    <div class="col mr-2">
                                                        <div class="text-uppercase font-weight-bold text-xs mb-1" style="color: #FFA3A4;font-size: 12.2px;"><span>chefs</span></div>
                                                        <div class="text-dark font-weight-bold h5 mb-0"><span><?= $totalChefs ?></span></div>
                                                    </div>
                                                    <div class="col-auto"><i class="fas fa-user-plus fa-2x text-gray-300"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3 mb-4">
                                        <div class="card shadow py-2" style="border-left-width: 8px;border-left-color: #FFA3A4;">
                                            <div class="card-body">
                                                <div class="row align-items-center no-gutters">
                                                    <div class="col mr-2">
                                                        <div class="text-uppercase font-weight-bold text-xs mb-1" style="color: #FFA3A4;font-size: 12.2px;"><span>recipes</span></div>
                                                        <div class="text-dark font-weight-bold h5 mb-0"><span><?= $totalRecipes; ?></span></div>
                                                    </div>
                                                    <div class="col-auto"><i class="fas fa-utensils fa-2x text-gray-300"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3 mb-4">
                                        <div class="card shadow py-2" style="border-left-width: 8px;border-left-color: #FFA3A4;">
                                            <div class="card-body">
                                                <div class="row align-items-center no-gutters">
                                                    <div class="col mr-2">
                                                        <div class="text-uppercase font-weight-bold text-xs mb-1" style="color: #FFA3A4;font-size: 12.2px;"><span>admins</span></div>
                                                        <div class="text-dark font-weight-bold h5 mb-0"><span><?= $totalAdmins; ?></span></div>
                                                    </div>
                                                    <div class="col-auto"><i class="fas fa-id-badge fa-2x text-gray-300"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3 mb-4">
                                        <div class="card shadow py-2" style="border-left-width: 8px;border-left-color: #FFA3A4;">
                                            <div class="card-body">
                                                <div class="row align-items-center no-gutters">
                                                    <div class="col mr-2">
                                                        <div class="text-uppercase font-weight-bold text-xs mb-1" style="color: #FFA3A4;font-size: 12.2px;">
                                                            <span>Ingredients</span>
                                                        </div>
                                                        <div class="text-dark font-weight-bold h5 mb-0"><span><?= $totalIngredients; ?></span></div>
                                                    </div>
                                                    <div class="col-auto"><i class="fas fa-id-badge fa-2x text-gray-300"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    
                                    <!-- <div class="file-upload  align-items-center">
                                        <div class="file-select">
                                            <div class="file-select-button" id="fileName">Choose File</div>
                                            <div class="file-select-name" id="noFile">No file chosen...</div> 
                                            <input type="file" name="chooseFile" id="chooseFile">
                                        </div>
                                        <div id="upload-btn">
                                            <button class="btn btn-primary search-button-recipes" type="button">Upload</button>
                                        </div>
                                    </div> -->

                                    <div class="block-heading">
                                        <h2 id="search-text">Search Recipes</h2>
                                        <!-- Start: Search Input Responsive with Icon -->
                                        <div class="row">
                                            <div class="col-md-10 offset-md-1">
                                                <div class="card m-auto">
                                                    <div class="card-body">
                                                        <form class="d-flex align-items-center justify-content-md-start">
                                                            <i class="fas fa-search d-none d-sm-block h4 text-body m-0"></i>
                                                                <input class="form-control form-control-lg flex-shrink-1 form-control-borderless"
                                                                type="search" placeholder="Search topics or keywords"
                                                                name="searchbar" id="searchRecipes">
                                                                <button class="btn btn-primary search-button-recipes" type="button">Search</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- End: Search Input Responsive with Icon -->
                                    </div>
                                    <div class="row" id="RecipesList">
                                        <?= $displayRecipe; ?>
                                    </div>
                                    <!-- <nav
                                        class="d-flex d-lg-flex justify-content-center justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                        <ul class="pagination">
                                            <li class="page-item disabled page-arrow"><a class="page-link" href="#"
                                                    aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                            <li class="page-item active number-page"><a class="page-link" href="#">1</a>
                                            </li>
                                            <li class="page-item number-page"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item number-page"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item page-arrow"><a class="page-link" href="#"
                                                    aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                        </ul>
                                    </nav> -->
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <!-- -----------------------to here -->
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
    <script src="card_assets/js/jquery.min.js"></script>
    <script src="card_assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function(){
        $("#searchRecipes").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#RecipesList .col-md-6").filter(function() {
              $(this).toggle($(this).children(".card").children(".card-body").children("h1").text().toLowerCase().indexOf(value) > -1)
            });

          });
    });
    </script>
</body>

</html>