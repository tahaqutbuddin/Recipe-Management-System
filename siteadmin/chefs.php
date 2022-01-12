<?php
session_start();
require '../Model/class.chef.php';
require '../Model/class.admin.php';
if(!isset($_SESSION["admin_email"],$_SESSION["adminname"]))
{
    header("Location:../login.php");
}
$obj = new admin;
$admin_name = $obj->fetchAdminProperties($_SESSION["admin_email"],"first_name");

$obj = new chef;
$all_users_records = json_decode( $obj->fetchAllChefs(),true);
unset($obj);
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Chef Dashboard</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">

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
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-p m-0 font-weight-bold">Chefs Info</p>
                        </div>
                        <div class="card-body">
                            <div class="row d-md-flex justify-content-md-end">
                                <div class="col-md-6 d-flex justify-content-center">
                                    <label class="col-form-label">
                                        <input type="search" class="form-control" aria-controls="dataTable" placeholder="Search" id="searchUsers" />
                                    </label>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid"
                                aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Age</th>
                                            <th>City</th>
                                            <th>Country</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="users-table-body">

                                        <?php
                                            if((is_bool($all_users_records) && $all_users_records == false) || $all_users_records == NULL)
                                            {
                                                echo '<tr><td class="alert alert-danger text-center" colspan=8 >No Records Found</td></tr>';
                                            }else
                                            {
                                                $rows = count($all_users_records);
                                                for ($row = 0; $row < $rows; $row++) 
                                                {
                                                    $email = "";
                                                    $b_date;
                                                    $output = '';
                                                    $cols = count($all_users_records[$row]);
                                                    for($col = 0; $col < $cols; $col++ ) 
                                                    {
                                                        if($col == 0)
                                                        {
                                                            $output .= '<td>'.($row+1).'</td>';
                                                        }else  if($col == 1 )
                                                        {
                                                            continue;
                                                        }else if($col == 2)
                                                        {
                                                            if((strlen($all_users_records[$row][$col-1]) > 0) && (strlen($all_users_records[$row][$col]) > 0))
                                                            {
                                                                $full_name = htmlspecialchars_decode(ucfirst($all_users_records[$row][$col-1]),ENT_COMPAT).' '.htmlspecialchars_decode($all_users_records[$row][$col],ENT_COMPAT);
                                                                $output .= '<td>'.$full_name.'</td>';
                                                            }else 
                                                            {
                                                                if((strlen($all_users_records[$row][$col-1]) > 0))
                                                                {
                                                                    $f_name =  htmlspecialchars_decode($all_users_records[$row][$col-1],ENT_COMPAT);
                                                                    $output .= '<td>'.$f_name.'</td>';
                                                                }else if(strlen($all_users_records[$row][$col]) > 0)
                                                                {
                                                                    $l_name =  htmlspecialchars_decode($all_users_records[$row][$col],ENT_COMPAT);
                                                                    $output .= '<td>'.$l_name.'</td>';
                                                                }else
                                                                {
                                                                    $output .= '<td>-</td>';
                                                                }

                                                            }

                                                        }else if(($col == 3 || $col == 5 || $col == 6))
                                                        {
                                                                if((strlen($all_users_records[$row][$col]) > 0))
                                                                { 
                                                                    $val =  htmlspecialchars_decode($all_users_records[$row][$col],ENT_COMPAT);
                                                                    if($col == 3)
                                                                    {
                                                                        $email = $val;
                                                                    }
                                                                    $output .= '<td>'.$val.'</td>';
                                                                }else { $output .= '<td>-</td>'; }
                                                        }else if($col == 4)
                                                        {
                                                            if(strlen($all_users_records[$row][$col]) > 0)
                                                            {
                                                                $birthDate = date("d/m/Y",strtotime($all_users_records[$row][$col]));
                                                                $birthDate = explode("/", $birthDate);
                                                                $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2])): (date("Y") - $birthDate[2]));
                                                                $output .= '<td>'.$age.' Years</td>';
                                                                $b_date = $birthDate;
                                                            }else { $output .= '<td>-</td>'; }
                                                        }else if($col == 7)
                                                        {
                                                            if((strlen($all_users_records[$row][$col]) > 0) && $all_users_records[$row][$col] == "block")
                                                            {
                                                                $output .= '<td><button class="btn btn-sm btn-outline-danger" disabled><strong>Blocked</strong></button></td>';
                                                            }
                                                            else if((strlen($all_users_records[$row][$col]) > 0) && $all_users_records[$row][$col] == "inactive")
                                                            {
                                                                $output .= '<td><button class="btn btn-sm btn-outline-primary" disabled><strong>Inactive</strong></button></td>';
                                                            }else if((strlen($all_users_records[$row][$col]) > 0) && $all_users_records[$row][$col] == "active")
                                                            {
                                                                $output .= '<td><button class="btn btn-sm btn-outline-success" disabled><strong>Active</strong></button></td>';
                                                            }
                                                        }
                                                    }
                                                    $protected = base64_encode("email".$email); 
                                                    $hash = hash("sha512",$protected.$full_name);                                              
                                                    $output .= '
                                                        <td class="d-flex justify-content-center">
                                                            <a  href="profile.php?mode=edit&protected='.$protected.'&hash='.$hash.'" class="btn btn-primary d-flex justify-content-center button-style-r">
                                                                View More 
                                                            </a>
                                                        </td>
                                                        </tr>
                                                        ';

                                                        echo $output;
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
            <?php
                include_once("../userIncludes/footer.php");
            ?>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/script.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#searchUsers").on("keyup", function()                // Search Bar functionality for admins
            {
                var value = $(this).val().toLowerCase();
                $("#users-table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>

</html>