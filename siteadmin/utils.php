<?php
    session_start();
    require '../Model/class.recipe.php';
    require "../Model/class.admin.php";
    if(!isset($_SESSION["admin_email"],$_SESSION["adminname"]))
    {
        header("Location:../login.php");
    }
    $admin = new admin;
    $admin_name = $admin->fetchAdminProperties($_SESSION["admin_email"],"first_name");
        
    if(isset($_POST["addRecord"]))
    {
        $obj = new recipe;
        if($obj->insertUtil(htmlentities($_POST["utils_input"])) == true)
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
        if($obj->deleteUtil($_POST["ingre_id"]) == true)
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
    $all_utils_records = json_decode( $obj->fetchDataForUtils(),true);
    unset($obj);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Utils</title>
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
                        <a class="nav-link text-center active" href="utils.php">
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
                            <li class="nav-item d-flex justify-content-center align-items-center align-self-center order-2 dropdown no-arrow mx-1" id="menu-bar-a">
                                <button class="btn btn-link rounded-circle mr-3" id="menu-bar" type="button" onclick="openNav()"><i class="fas fa-bars"></i></button>
                            </li>
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
                    <div class="row">
                        <!-- here -->
                        <div class="col-md-3 col-lg-3 col-sm-12"></div>
                        <div id="col-1" class="col col-md-6 col-lg-6 col-sm-12" >
                            <div class="card shadow col0-6">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 font-weight-bold"><strong>Utensilien</strong></p>
                                </div>
                                <div class="card-body">
                                    <div class="row text-sm-center text-md-left text-lg-left text-xl-left d-flex d-sm-flex align-items-center flex-sm-row justify-content-sm-center align-items-sm-center flex-md-row flex-lg-row flex-xl-row">
                                        <div class="col">
                                            <form method="POST" role="form">
                                                <div class="input-group">
                                                    <input class="form-control" name="utils_input" type="text" placeholder="Ingredient Name" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary button-style-r" type="submit" name="addRecord">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <input class="form-control" type="text" placeholder="Search" id="searchUtils">
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
                                            <tbody id="utils-table-body" >
                                                <?php
                                                    if((is_bool($all_utils_records) && $all_utils_records == false) || $all_utils_records == NULL)
                                                    {
                                                        echo '<tr><td class="alert alert-danger text-center" colspan=3 >No Records Found</td></tr>';
                                                    }else
                                                    {
                                                        $rows = count($all_utils_records);
                                                        for ($row = 0; $row < $rows; $row++) 
                                                        {
                                                            $data = array();
                                                            $output = '';
                                                            $cols = count($all_utils_records[$row]);
                                                            for($col = 0; $col < $cols; $col++ ) 
                                                            {
                                                                
                                                                if($col == "id")
                                                                {   
                                                                    array_push($data, $all_utils_records[$row]["id"]);
                                                                    continue;
                                                                }else
                                                                {
                                                                    array_push($data, $all_utils_records[$row]["title"]);
                                                                    $name = htmlspecialchars_decode($all_utils_records[$row]["title"],ENT_COMPAT);
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
            

            $("#searchUtils").on("keyup", function()                 // Search Bar functionality for Fisch
            {
                var value = $(this).val().toLowerCase();
                $("#utils-table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('#deleteModal').on('show.bs.modal', function (event) {
                var data = $(event.relatedTarget).data('id').split(',');
                (data[0])!="" ?  $("#ingre_id").val(data[0]) : $("#ingre_id").val('') ;
                (data[1])!="" ?  $("#ingredientValue").html(data[1]) : $("#ingredientValue").html('') ;
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