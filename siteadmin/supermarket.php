<?php
session_start();
require '../Model/class.recipe.php';
require '../Model/class.admin.php';
// if(!isset($_SESSION["admin_email"],$_SESSION["adminname"]))
// {
    
//     header("Location:../login.php");
// }
$admin = new admin;
if(isset($_SESSION["admin_email"]))
{
    $admin_name = $admin->fetchAdminProperties($_SESSION["admin_email"],"first_name");
}else { $admin_name =  "Dummy User"; }


if(isset($_POST["addRecord"]))
{
    foreach($_POST as $key=>$value)
    {
        if($key == "addRecord")
        {
            continue;
        }else
        {
            $break_key = explode('_',$key);
            array_pop($break_key);
            $table_name = implode('_',$break_key);
            $val = htmlentities($value);
        }
    }
    $obj = new recipe;
    if($obj->insertIngredients("supermarket",$table_name,$val) == true)
    {
        unset($obj);
        $_SESSION["success"] = 1;
    }else
    {
        unset($obj);
        $_SESSION["error"] = 1;
    }   
}

if(isset($_POST["deleteRecord"]))
{
    $obj = new recipe;
    if($obj->deleteIngredients("supermarket",$_POST["table_name"],$_POST["ingre_id"]) == true)
    {
        unset($obj);
        $_SESSION["success"] = 1;
    }else
    {
        unset($obj);
        $_SESSION["error"] = 1;
    }   
}

$obj = new recipe;
$all_meat_records = json_decode( $obj->fetchAllIngredients("supermarket","meat"),true);
$all_animal_records = json_decode( $obj->fetchAllIngredients("supermarket","animal_products"),true);
$all_dairy_records = json_decode( $obj->fetchAllIngredients("supermarket","dairy_products"),true);
$all_legumes_records = json_decode( $obj->fetchAllIngredients("supermarket","legumes"),true);
$all_vegetables_records = json_decode( $obj->fetchAllIngredients("supermarket","vegetables"),true);
$all_starch_records = json_decode( $obj->fetchAllIngredients("supermarket","starch"),true);
$all_fruits_records = json_decode( $obj->fetchAllIngredients("supermarket","fruits"),true);
$all_herbs_records = json_decode( $obj->fetchAllIngredients("supermarket","herbs"),true);
$all_juices_records = json_decode( $obj->fetchAllIngredients("supermarket","juices"),true);
unset($obj);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Supermarket Ingredients</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" />
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css" />
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
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
                        <a class="nav-link text-center" href="index.php">
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
                        <a class="nav-link text-center active" href="supermarket.php">
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
                        <a class="nav-link text-center " href="utils.php">
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
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Supermarket Ingredients:</h3>
                    <div class="row">
                        <!-- here -->
                        <div id="col-1" class="col col-md-6 col-lg-6" >
                            <div class="card shadow col0-6">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 font-weight-bold"><strong>Fisch/Fleisch</strong></p>
                                </div>
                                <div class="card-body">
                                    <div class="row text-sm-center text-md-left text-lg-left text-xl-left d-flex d-sm-flex align-items-center flex-sm-row justify-content-sm-center align-items-sm-center flex-md-row flex-lg-row flex-xl-row">
                                        <div class="col">
                                            <form method="POST" role="form">
                                                <div class="input-group">
                                                    <input class="form-control" name="meat_input" type="text" placeholder="Ingredient Name" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary button-style-r" type="submit" name="addRecord">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <input class="form-control" id="searchMeat" type="text" placeholder="Search">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table mt-2 tableFixHead" id="dataTable" role="grid" aria-describedby="dataTable_info" >
                                        <table class="table my-0" id="dataTable">
                                            <thead id="thead-1" >
                                                <tr>
                                                    <th class="text-center">S.No</th>
                                                    <th class="text-center">Ingredients</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="meat-table-body">
                                                <?php
                                                    if((is_bool($all_meat_records) && $all_meat_records == false) || $all_meat_records == NULL)
                                                    {
                                                        echo '<tr><td class="alert alert-danger text-center" colspan=3 >No Records Found</td></tr>';
                                                    }else
                                                    {
                                                       
                                                        $rows = count($all_meat_records);
                                                        for ($row = 0; $row < $rows; $row++) 
                                                        {
                                                            $data = array();
                                                            $output = '';
                                                            $cols = count($all_meat_records[$row]);
                                                            for($col = 0; $col < $cols; $col++ ) 
                                                            {
                                                                array_push($data, $all_meat_records[$row][$col]);
                                                                if($col == 0)
                                                                {
                                                                   continue;
                                                                }else
                                                                {
                                                                    array_push($data, "meat");
                                                                    $name = htmlspecialchars_decode($all_meat_records[$row][$col],ENT_COMPAT);
                                                                    $output .= ' <tr>
                                                                        <td class="text-center">'.($row+1).'.</td>
                                                                        <td class="text-center">'.$name.'</td>
                                                                        <td>
                                                                                <button class="btn btn-danger" type="button" data-id="'.implode(',',$data).'" data-toggle="modal" data-target="#deleteModal">Remove</button>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                                echo $output;
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- here -->
                        <div id="col-1" class="col col-md-6 col-lg-6" >
                            <div class="card shadow col0-6">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 font-weight-bold"><strong>Tierische Erzeugnisse</strong></p>
                                </div>
                                <div class="card-body">
                                    <div class="row text-sm-center text-md-left text-lg-left text-xl-left d-flex d-sm-flex align-items-center flex-sm-row justify-content-sm-center align-items-sm-center flex-md-row flex-lg-row flex-xl-row">
                                        <div class="col">
                                            <form method="POST" role="form">
                                                <div class="input-group">
                                                    <input class="form-control" name="animal_products_input" type="text" placeholder="Ingredient Name" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary button-style-r" type="submit" name="addRecord">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <div class="col">
                                            <div class="input-group">
                                                <input class="form-control" type="text" placeholder="Search" id="searchAnimalProducts" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table mt-2 tableFixHead" id="dataTable" role="grid" aria-describedby="dataTable_info" >
                                        <table class="table my-0" id="dataTable">
                                            <thead id="thead-1" >
                                                <tr>
                                                    <th class="text-center">S.No</th>
                                                    <th class="text-center">Ingredients</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="animal-table-body" >
                                                <?php
                                                if((is_bool($all_animal_records) && $all_animal_records == false) || $all_animal_records == NULL)
                                                    {
                                                        echo '<tr><td class="alert alert-danger text-center" colspan=3 >No Records Found</td></tr>';
                                                    }else
                                                    {
                                                       
                                                        $rows = count($all_animal_records);
                                                        for ($row = 0; $row < $rows; $row++) 
                                                        {
                                                            $data = array();
                                                            $output = '';
                                                            $cols = count($all_animal_records[$row]);
                                                            for($col = 0; $col < $cols; $col++ ) 
                                                            {
                                                                array_push($data, $all_animal_records[$row][$col]);
                                                                if($col == 0)
                                                                {
                                                                   continue;
                                                                }else
                                                                {
                                                                    array_push($data, "animal_products");
                                                                    $name = htmlspecialchars_decode($all_animal_records[$row][$col],ENT_COMPAT);
                                                                    $output .= ' <tr>
                                                                        <td class="text-center">'.($row+1).'.</td>
                                                                        <td class="text-center">'.$name.'</td>
                                                                        <td>
                                                                                <button class="btn btn-danger" type="button" data-id="'.implode(',',$data).'" data-toggle="modal" data-target="#deleteModal">Remove</button>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                                echo $output;
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="col-1" class="col col-md-6 col-lg-6" >
                            <div class="card shadow col0-6">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 font-weight-bold"><strong>Milchprodukte</strong></p>
                                </div>
                                <div class="card-body">
                                    <div class="row text-sm-center text-md-left text-lg-left text-xl-left d-flex d-sm-flex align-items-center flex-sm-row justify-content-sm-center align-items-sm-center flex-md-row flex-lg-row flex-xl-row">
                                        <div class="col">
                                            <form method="POST" role="form">
                                                <div class="input-group">
                                                    <input class="form-control" name="dairy_products_input" type="text" placeholder="Ingredient Name" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary button-style-r" type="submit" name="addRecord">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <input class="form-control" type="text" placeholder="Search" id="searchDairyProducts">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table mt-2 tableFixHead" id="dataTable" role="grid" aria-describedby="dataTable_info" >
                                        <table class="table my-0" id="dataTable">
                                            <thead id="thead-1" >
                                                <tr>
                                                    <th class="text-center">S.No</th>
                                                    <th class="text-center">Ingredients</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="dairy-table-body" >
                                                <?php
                                                if((is_bool($all_dairy_records) && $all_dairy_records == false) || $all_dairy_records == NULL)
                                                    {
                                                        echo '<tr><td class="alert alert-danger text-center" colspan=3 >No Records Found</td></tr>';
                                                    }else
                                                    {
                                                       
                                                        $rows = count($all_dairy_records);
                                                        for ($row = 0; $row < $rows; $row++) 
                                                        {
                                                            $data = array();
                                                            $output = '';
                                                            $cols = count($all_dairy_records[$row]);
                                                            for($col = 0; $col < $cols; $col++ ) 
                                                            {
                                                                array_push($data, $all_dairy_records[$row][$col]);
                                                                if($col == 0)
                                                                {
                                                                   continue;
                                                                }else
                                                                {
                                                                    array_push($data, "dairy_products");
                                                                    $name = htmlspecialchars_decode($all_dairy_records[$row][$col],ENT_COMPAT);
                                                                    $output .= ' <tr>
                                                                        <td class="text-center">'.($row+1).'.</td>
                                                                        <td class="text-center">'.$name.'</td>
                                                                        <td>
                                                                                <button class="btn btn-danger" type="button" data-id="'.implode(',',$data).'" data-toggle="modal" data-target="#deleteModal">Remove</button>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                                echo $output;
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="col-1" class="col col-md-6 col-lg-6" >
                            <div class="card shadow col0-6">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 font-weight-bold"><strong>Hülsenfrüchte</strong></p>
                                </div>
                                <div class="card-body">
                                    <div class="row text-sm-center text-md-left text-lg-left text-xl-left d-flex d-sm-flex align-items-center flex-sm-row justify-content-sm-center align-items-sm-center flex-md-row flex-lg-row flex-xl-row">
                                        <div class="col">
                                            <form method="POST" role="form">
                                                <div class="input-group">
                                                    <input class="form-control" name="legumes_input" type="text" placeholder="Ingredient Name" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary button-style-r" type="submit" name="addRecord">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <input class="form-control" type="text" placeholder="Search" id="searchLegumes">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table mt-2 tableFixHead" id="dataTable" role="grid" aria-describedby="dataTable_info" >
                                        <table class="table my-0" id="dataTable">
                                            <thead id="thead-1" >
                                                <tr>
                                                    <th class="text-center">S.No</th>
                                                    <th class="text-center">Ingredients</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="legumes-table-body" >
                                                <?php
                                                    if((is_bool($all_legumes_records) && $all_legumes_records == false) || $all_legumes_records == NULL)
                                                    {
                                                        echo '<tr><td class="alert alert-danger text-center" colspan=3 >No Records Found</td></tr>';
                                                    }else
                                                    {
                                                       
                                                        $rows = count($all_legumes_records);
                                                        for ($row = 0; $row < $rows; $row++) 
                                                        {
                                                            $data = array();
                                                            $output = '';
                                                            $cols = count($all_legumes_records[$row]);
                                                            for($col = 0; $col < $cols; $col++ ) 
                                                            {
                                                                array_push($data, $all_legumes_records[$row][$col]);
                                                                if($col == 0)
                                                                {
                                                                   continue;
                                                                }else
                                                                {
                                                                    array_push($data, "legumes");
                                                                    $name = htmlspecialchars_decode($all_legumes_records[$row][$col],ENT_COMPAT);
                                                                    $output .= ' <tr>
                                                                        <td class="text-center">'.($row+1).'.</td>
                                                                        <td class="text-center">'.$name.'</td>
                                                                        <td>
                                                                                <button class="btn btn-danger" type="button" data-id="'.implode(',',$data).'" data-toggle="modal" data-target="#deleteModal">Remove</button>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                                echo $output;
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="col-1" class="col col-md-6 col-lg-6" >
                            <div class="card shadow col0-6">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 font-weight-bold"><strong>Gemüse</strong></p>
                                </div>
                                <div class="card-body">
                                    <div class="row text-sm-center text-md-left text-lg-left text-xl-left d-flex d-sm-flex align-items-center flex-sm-row justify-content-sm-center align-items-sm-center flex-md-row flex-lg-row flex-xl-row">
                                        <div class="col">
                                            <form method="POST" role="form">
                                                <div class="input-group">
                                                    <input class="form-control" name="vegetables_input" type="text" placeholder="Ingredient Name" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary button-style-r" type="submit" name="addRecord">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <input class="form-control" type="text" placeholder="Search" id="searchVegetables">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table mt-2 tableFixHead" id="dataTable" role="grid" aria-describedby="dataTable_info" >
                                        <table class="table my-0" id="dataTable">
                                            <thead id="thead-1" >
                                                <tr>
                                                    <th class="text-center">S.No</th>
                                                    <th class="text-center">Ingredients</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="vegetables-table-body" >
                                                <?php
                                                        if((is_bool($all_vegetables_records) && $all_vegetables_records == false) || $all_vegetables_records == NULL)
                                                        {
                                                        echo '<tr><td class="alert alert-danger text-center" colspan=3 >No Records Found</td></tr>';
                                                    }else
                                                    {
                                                       
                                                        $rows = count($all_vegetables_records);
                                                        for ($row = 0; $row < $rows; $row++) 
                                                        {
                                                            $data = array();
                                                            $output = '';
                                                            $cols = count($all_vegetables_records[$row]);
                                                            for($col = 0; $col < $cols; $col++ ) 
                                                            {
                                                                array_push($data, $all_vegetables_records[$row][$col]);
                                                                if($col == 0)
                                                                {
                                                                   continue;
                                                                }else
                                                                {
                                                                    array_push($data, "vegetables");
                                                                    $name = htmlspecialchars_decode($all_vegetables_records[$row][$col],ENT_COMPAT);
                                                                    
                                                                    $output .= ' <tr>
                                                                        <td class="text-center">'.($row+1).'.</td>
                                                                        <td class="text-center">'.$name.'</td>
                                                                        <td>
                                                                                <button class="btn btn-danger" type="button" data-id="'.implode(',',$data).'" data-toggle="modal" data-target="#deleteModal">Remove</button>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                                echo $output;
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="col-1" class="col col-md-6 col-lg-6" >
                            <div class="card shadow col0-6">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 font-weight-bold"><strong>Stärkebeilagen</strong></p>
                                </div>
                                <div class="card-body">
                                    <div class="row text-sm-center text-md-left text-lg-left text-xl-left d-flex d-sm-flex align-items-center flex-sm-row justify-content-sm-center align-items-sm-center flex-md-row flex-lg-row flex-xl-row">
                                        <div class="col">
                                            <form method="POST" role="form">
                                                <div class="input-group">
                                                    <input class="form-control" name="starch_input" type="text" placeholder="Ingredient Name" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary button-style-r" type="submit" name="addRecord">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <input class="form-control" type="text" placeholder="Search" id="searchStarch">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table mt-2 tableFixHead" id="dataTable" role="grid" aria-describedby="dataTable_info" >
                                        <table class="table my-0" id="dataTable">
                                            <thead id="thead-1" >
                                                <tr>
                                                    <th class="text-center">S.No</th>
                                                    <th class="text-center">Ingredients</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="starch-table-body" >
                                                <?php
                                                  if((is_bool($all_starch_records) && $all_starch_records == false) || $all_starch_records == NULL)
                                                  {
                                                  echo '<tr><td class="alert alert-danger text-center" colspan=3 >No Records Found</td></tr>';
                                                    }else
                                                    {
                                                        
                                                        $rows = count($all_starch_records);
                                                        for ($row = 0; $row < $rows; $row++) 
                                                        {
                                                            $data = array();
                                                            $output = '';
                                                            $cols = count($all_starch_records[$row]);
                                                            for($col = 0; $col < $cols; $col++ ) 
                                                            {
                                                                array_push($data, $all_starch_records[$row][$col]);
                                                                if($col == 0)
                                                                {
                                                                    continue;
                                                                }else
                                                                {
                                                                    array_push($data, "starch");
                                                                    $name = htmlspecialchars_decode($all_starch_records[$row][$col],ENT_COMPAT);
                                                                    $output .= ' <tr>
                                                                        <td class="text-center">'.($row+1).'.</td>
                                                                        <td class="text-center">'.$name.'</td>
                                                                        <td>
                                                                                <button class="btn btn-danger" type="button" data-id="'.implode(',',$data).'" data-toggle="modal" data-target="#deleteModal">Remove</button>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                                echo $output;
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="col-1" class="col col-md-6 col-lg-6" >
                            <div class="card shadow col0-6">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 font-weight-bold"><strong>Obst</strong></p>
                                </div>
                                <div class="card-body">
                                    <div class="row text-sm-center text-md-left text-lg-left text-xl-left d-flex d-sm-flex align-items-center flex-sm-row justify-content-sm-center align-items-sm-center flex-md-row flex-lg-row flex-xl-row">
                                        <div class="col">
                                            <form method="POST" role="form">
                                                <div class="input-group">
                                                    <input class="form-control" name="fruits_input" type="text" placeholder="Ingredient Name" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary button-style-r" type="submit" name="addRecord">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <input class="form-control" type="text" placeholder="Search" id="searchFruits">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table mt-2 tableFixHead" id="dataTable" role="grid" aria-describedby="dataTable_info" >
                                        <table class="table my-0" id="dataTable">
                                            <thead id="thead-1" >
                                                <tr>
                                                    <th class="text-center">S.No</th>
                                                    <th class="text-center">Ingredients</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="fruits-table-body" >
                                                <?php
                                                  if((is_bool($all_fruits_records) && $all_fruits_records == false) || $all_fruits_records == NULL )
                                                  {
                                                  echo '<tr><td class="alert alert-danger text-center" colspan=3 >No Records Found</td></tr>';
                                                    }else
                                                    {
                                                        
                                                        $rows = count($all_fruits_records);
                                                        for ($row = 0; $row < $rows; $row++) 
                                                        {
                                                            $data = array();
                                                            $output = '';
                                                            $cols = count($all_fruits_records[$row]);
                                                            for($col = 0; $col < $cols; $col++ ) 
                                                            {
                                                                array_push($data, $all_fruits_records[$row][$col]);
                                                                if($col == 0)
                                                                {
                                                                    continue;
                                                                }else
                                                                {
                                                                    array_push($data, "fruits");
                                                                    
                                                                    $name = htmlspecialchars_decode($all_fruits_records[$row][$col],ENT_COMPAT);
                                                                    $output .= ' <tr>
                                                                        <td class="text-center">'.($row+1).'.</td>
                                                                        <td class="text-center">'.$name.'</td>
                                                                        <td>
                                                                                <button class="btn btn-danger" type="button" data-id="'.implode(',',$data).'" data-toggle="modal" data-target="#deleteModal">Remove</button>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                                echo $output;
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="col-1" class="col col-md-6 col-lg-6" >
                            <div class="card shadow col0-6">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 font-weight-bold"><strong>Kräuter</strong></p>
                                </div>
                                <div class="card-body">
                                    <div class="row text-sm-center text-md-left text-lg-left text-xl-left d-flex d-sm-flex align-items-center flex-sm-row justify-content-sm-center align-items-sm-center flex-md-row flex-lg-row flex-xl-row">
                                        <div class="col">
                                            <form method="POST" role="form">
                                                <div class="input-group">
                                                    <input class="form-control" name="herbs_input" type="text" placeholder="Ingredient Name" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary button-style-r" type="submit" name="addRecord">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <input class="form-control" type="text" placeholder="Search" id="searchHerbs">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table mt-2 tableFixHead" id="dataTable" role="grid" aria-describedby="dataTable_info" >
                                        <table class="table my-0" id="dataTable">
                                            <thead id="thead-1" >
                                                <tr>
                                                    <th class="text-center">S.No</th>
                                                    <th class="text-center">Ingredients</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="herbs-table-body" >
                                                <?php
                                                  if((is_bool($all_herbs_records) && $all_herbs_records == false) || $all_herbs_records == NULL)
                                                  {
                                                  echo '<tr><td class="alert alert-danger text-center" colspan=3 >No Records Found</td></tr>';
                                                    }else
                                                    {
                                                        
                                                        $rows = count($all_herbs_records);
                                                        for ($row = 0; $row < $rows; $row++) 
                                                        {
                                                            $data = array();
                                                            $output = '';
                                                            $cols = count($all_herbs_records[$row]);
                                                            for($col = 0; $col < $cols; $col++ ) 
                                                            {
                                                                array_push($data, $all_herbs_records[$row][$col]);
                                                                if($col == 0)
                                                                {
                                                                    continue;
                                                                }else
                                                                {
                                                                    array_push($data, "herbs");
                                                                    
                                                                    $name = htmlspecialchars_decode($all_herbs_records[$row][$col],ENT_COMPAT);
                                                                    $output .= ' <tr>
                                                                        <td class="text-center">'.($row+1).'.</td>
                                                                        <td class="text-center">'.$name.'</td>
                                                                        <td>
                                                                                <button class="btn btn-danger" type="button" data-id="'.implode(',',$data).'" data-toggle="modal" data-target="#deleteModal">Remove</button>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                                echo $output;
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="col-1" class="col col-md-6 col-lg-6" >
                            <div class="card shadow col0-6">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 font-weight-bold"><strong>Weine und Säfte</strong></p>
                                </div>
                                <div class="card-body">
                                    <div class="row text-sm-center text-md-left text-lg-left text-xl-left d-flex d-sm-flex align-items-center flex-sm-row justify-content-sm-center align-items-sm-center flex-md-row flex-lg-row flex-xl-row">
                                        <div class="col">
                                            <form method="POST" role="form">
                                                <div class="input-group">
                                                    <input class="form-control" name="juices_input" type="text" placeholder="Ingredient Name" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary button-style-r" type="submit" name="addRecord">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <input class="form-control" type="text" placeholder="Search" id="searchJuices">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table mt-2 tableFixHead" id="dataTable" role="grid" aria-describedby="dataTable_info" >
                                        <table class="table my-0" id="dataTable">
                                            <thead id="thead-1" >
                                                <tr>
                                                    <th class="text-center">S.No</th>
                                                    <th class="text-center">Ingredients</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="juices-table-body" >
                                                <?php
                                                  if((is_bool($all_juices_records) && $all_juices_records == false) || $all_juices_records == NULL)
                                                  {
                                                    echo '<tr><td class="alert alert-danger text-center" colspan=3 >No Records Found</td></tr>';
                                                    }else
                                                    {
                                                        
                                                        $rows = count($all_juices_records);
                                                        for ($row = 0; $row < $rows; $row++) 
                                                        {
                                                            $data = array();
                                                            $output = '';
                                                            $cols = count($all_juices_records[$row]);
                                                            for($col = 0; $col < $cols; $col++ ) 
                                                            {
                                                                array_push($data, $all_juices_records[$row][$col]);
                                                                if($col == 0)
                                                                {
                                                                    continue;
                                                                }else
                                                                {
                                                                    array_push($data, "juices");
                                                                    
                                                                    $name = htmlspecialchars_decode($all_juices_records[$row][$col],ENT_COMPAT);
                                                                    $output .= ' <tr>
                                                                        <td class="text-center">'.($row+1).'.</td>
                                                                        <td class="text-center">'.$name.'</td>
                                                                        <td>
                                                                                <button class="btn btn-danger" type="button" data-id="'.implode(',',$data).'" data-toggle="modal" data-target="#deleteModal">Remove</button>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                                echo $output;
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
           
        </div>
        <?php
                include_once("../userIncludes/footer.php");
            ?>
        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/script.min.js"></script>
    <script>

        var error_flag = <?php if(isset($_SESSION["error"])) { echo $_SESSION["error"]; unset($_SESSION["error"]); }else{ echo 0; } ?>;
        var success_flag = <?php if(isset($_SESSION["success"])) { echo $_SESSION["success"]; unset($_SESSION["success"]); } else { echo 0; } ?>;
        $(document).ready(function()
        {
            if( parseInt(success_flag) == 1)
            {
                success_flag = 0;
                alertify.set('notifier','position', 'bottom-left');
                alertify.notify('<b>Your data has been Updated Successfully!</b>', 'success', 2, function(){ console.log("dismissed"); });
            }
            if( parseInt(error_flag) == 1)
            {
                error_flag = 0;
                alertify.set('notifier','position', 'bottom-left');
                alertify.notify('<b>Error while storing data</b>', 'error', 2, function(){ console.log("dismissed"); });
            }
            

            $("#searchMeat").on("keyup", function()                 // Search Bar functionality for Fisch
            {
                var value = $(this).val().toLowerCase();
                $("#meat-table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $("#searchAnimalProducts").on("keyup", function()             // Search Bar functionality for Tierische 
            {
                var value = $(this).val().toLowerCase();
                $("#animal-table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $("#searchDairyProducts").on("keyup", function()                // Search Bar functionality for Milchprodukte 
            {
                var value = $(this).val().toLowerCase();
                $("#dairy-table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $("#searchLegumes").on("keyup", function()                // Search Bar functionality for Hülsenfrüchte 
            {
                var value = $(this).val().toLowerCase();
                $("#legumes-table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $("#searchVegetables").on("keyup", function()                // Search Bar functionality for Gemüse 
            {
                var value = $(this).val().toLowerCase();
                $("#vegetables-table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $("#searchStarch").on("keyup", function()                // Search Bar functionality for Stärkebeilagen 
            {
                var value = $(this).val().toLowerCase();
                $("#starch-table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $("#searchFruits").on("keyup", function()                // Search Bar functionality for Obst 
            {
                var value = $(this).val().toLowerCase();
                $("#fruits-table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $("#searchHerbs").on("keyup", function()                // Search Bar functionality for Kräuter 
            {
                var value = $(this).val().toLowerCase();
                $("#herbs-table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $("#searchJuices").on("keyup", function()                // Search Bar functionality for Weine und Säfte 
            {
                var value = $(this).val().toLowerCase();
                $("#juices-table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('#deleteModal').on('show.bs.modal', function (event) {
                var data = $(event.relatedTarget).data('id').split(',');
                (data[0])!="" ?  $("#ingre_id").val(data[0]) : $("#ingre_id").val('') ;
                (data[1])!="" ?  $("#ingredientValue").html(data[1]) : $("#ingredientValue").html('') ;
                (data[2])!="" ?  $("#table_name").val(data[2]) : $("#table_name").val('') ;
            });

        });
    
       
    </script>
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
                <h5 class="modal-title" id="exampleModalLabel">Delete this Record?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <label style="font-style:italic;">Ingredient Value</label><br/>
                    <span id="ingredientValue" style="font-weight:bold"></span>
                </p>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" name="deleteRecord">Delete</button>
            </div>
        </form>
    </div>
  </div>
</div>