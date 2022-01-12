<?php
session_start();
require '../Model/class.admin.php';
if(!isset($_SESSION["admin_email"],$_SESSION["adminname"]))
{
    header("Location:../login.php");
}
$obj = new admin;
$admin_name = $obj->fetchAdminProperties($_SESSION["admin_email"],"first_name");


if(isset($_POST["add_admin"]))
{
    $obj = new admin;
    $result = $obj->validateNewAdmin();
    if(is_bool($result) && $result == true)
    {
        unset($obj);
        $_SESSION["success"] = 1;
    }else if(is_string($result) && (strlen($result) > 0))
    {
        unset($obj);
        $_SESSION["error"] = 1;
        $_SESSION["message"] = $result;
    }else
    {
        unset($obj);
        $_SESSION["error"] = 1;
    }   

}

if(isset($_POST["delete_admin"]))
{
    $obj = new admin;
    if($obj->deleteAdmin() == true)
    {
        unset($obj);
        $_SESSION["success"] = 1;
    }else
    {
        unset($obj);
        $_SESSION["error"] = 1;
    }   
}

if(isset($_POST["save_admin"]))
{
    $obj = new admin;
    if($obj->saveAdmin() == true)
    {
        unset($obj);
        $_SESSION["success"] = 1;
    }else
    {
        unset($obj);
        $_SESSION["error"] = 1;
    }   
}

$obj = new admin;
$all_admin_records = json_decode( $obj->fetchAllAdmins(),true);
unset($obj);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>All Admins</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
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
                        <a class="nav-link text-center active" href="admins.php">
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
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"><i class="fas fa-angle-left"></i></button></div>
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
                            <p class="text-p m-0 font-weight-bold">Admins Info</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 d-lg-flex justify-content-lg-start">
                                    <div class="text-md-right d-flex d-sm-flex d-md-flex justify-content-center justify-content-sm-center justify-content-md-start dataTables_filter"
                                        id="dataTable_filter">
                                        <button class="btn btn-primary button-style-r" type="button" data-toggle="modal" data-target="#add_admin_Modal">
                                            Add new Admin
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-3 col-sm-12 d-flex justify-content-center">
                                    <label class="col-form-label">
                                        <input type="search" class="form-control" aria-controls="dataTable"  placeholder="Search" id="searchAdmin" />
                                    </label>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid"
                                aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="admins-table-body">
                                        <?php
                                            if((is_bool($all_admin_records) && $all_admin_records == false) || $all_admin_records == NULL)
                                            {
                                                echo '<tr><td class="alert alert-danger text-center" colspan=6 >No Records Found</td></tr>';
                                            }else
                                            {
                                                $rows = count($all_admin_records);
                                                for ($row = 0; $row < $rows; $row++) 
                                                {
                                                    $output = '<tr>';
                                                    $data = array();
                                                    $cols = count($all_admin_records[$row]);
                                                    for($col = 0; $col < $cols; $col++ ) 
                                                    {
                                                        if($col == 0)
                                                        { 
                                                            array_push($data,$all_admin_records[$row][$col]);
                                                            $output .= '<td>'.($row+1).'</td>';
                                                            continue;
                                                        }else if($col == 1 || $col == 2 || $col == 3)
                                                        {
                                                            $name = htmlspecialchars_decode($all_admin_records[$row][$col],ENT_COMPAT);
                                                            array_push($data,$name);
                                                            $output .= '<td>'.$name.'</td>';
                                                        }else if($col == 4)
                                                        {
                                                            array_push($data,$all_admin_records[$row][$col]);
                                                            if(intval($all_admin_records[$row][$col]) == 0)
                                                            {
                                                                $output .= '<td class="text-danger">Inactive</td>';
                                                            }else if(intval($all_admin_records[$row][$col]) == 1)
                                                            {
                                                                $output .= '<td class="text-success">Active</td>';
                                                            }
                                                        }
                                                    }
                                                    $output .= '
                                                            <td class="d-flex justify-content-center">  
                                                                <button  class="btn btn-primary button-style-r" type="button" data-id="'.implode(',',$data).'" data-toggle="modal" data-target="#viewModal">
                                                                    View More
                                                                </button>
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
    <script src="../loginfiles/js/customJquery.js"></script> 
    <script>
        var error_flag = <?php if(isset($_SESSION["error"])) { echo $_SESSION["error"]; unset($_SESSION["error"]); }else{ echo 0; } ?>;
        var success_flag = <?php if(isset($_SESSION["success"])) { echo $_SESSION["success"]; unset($_SESSION["success"]); } else { echo 0; } ?>;
        var message = <?php if(isset($_SESSION["message"])) { echo $_SESSION["message"]; unset($_SESSION["message"]); } else { echo ""; } ?>

        $(document).ready(function(){
            if( parseInt(success_flag) == 1)
            {
                success_flag = 0;
                alertify.set('notifier','position', 'bottom-left');
                alertify.notify('<b>Your data has been Updated Successfully!</b>', 'success', 2, function(){ console.log("dismissed"); });
            }
            if( parseInt(error_flag) == 1)
            {
                if(message.length > 0)
                {
                    error_flag = 0;
                    alertify.set('notifier','position', 'bottom-left');
                    alertify.notify('<b>'+message+'</b>', 'error', 2, function(){ console.log("dismissed"); });
                    message = "";
                }else
                {
                    error_flag = 0;
                    alertify.set('notifier','position', 'bottom-left');
                    alertify.notify('<b>Error while Storing data</b>', 'error', 2, function(){ console.log("dismissed"); });
                }
            }
            

            $("#searchAdmin").on("keyup", function()                // Search Bar functionality for admins
            {
                var value = $(this).val().toLowerCase();
                $("#admins-table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            
            $('#viewModal').on('show.bs.modal', function (event) {
                var data = $(event.relatedTarget).data('id').split(',');
                (data[0])!="" ?  $("#admin_id").val(data[0]) : $("#admin_id").val('') ;
                (data[1])!="" ?  $("#first_name").val(data[1]) : $("#first_name").val('') ;
                (data[2])!="" ?  $("#last_name").val(data[2]) : $("#last_name").val('') ;
                (data[3])!="" ?  $("#email").val(data[3]) : $("#email").val('') ;
                (data[4])!="" ?  $("#status").val(data[4]) : $("#status").val('') ; 
            });



        });
    </script>
</body>

</html>

   
<div role="dialog" tabindex="-1" class="modal fade" id="add_admin_Modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" role="form">
                <div class="modal-header" style="background-color:#ffa3a4;">
                    <h4>Add New Admin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column align-items-center align-items-sm-center align-items-md-center">
                        <div class="form-group d-flex d-md-flex flex-row justify-content-md-center col-10">
                            <div class="col-6">
                                <label class="d-md-flex justify-content-md-start">
                                    <strong>First Name:</strong>
                                </label>
                                <input type="text" class="form-control text-validate" name="first_name" />
                                <small style="color:red"></small>
                            </div>
                            <div class="col-6">
                                <label class="d-md-flex justify-content-md-start">
                                    <strong>Last Name:</strong>
                                </label>
                                <input type="text" class="form-control text-validate" name="last_name" />
                                <small style="color:red"></small>
                            </div>
                        </div>
                        <div class="form-group d-flex d-md-flex flex-column justify-content-md-center col-10">
                            <label class="d-md-flex justify-content-md-start">
                                <strong>Email:</strong>
                            </label>
                            <input type="email" class="form-control email-validate" name="email" />
                            <small style="color:red"></small>
                        </div>
                        <div class="form-group d-flex d-md-flex flex-column justify-content-md-center col-10">
                            <label class="d-md-flex justify-content-md-start">
                                <strong>Password:</strong>
                            </label>
                            <input type="text" class="form-control password-validate" name="password" />
                            <small style="color:red"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
                    <button class="btn btn-primary button-style-r" type="submit" name="add_admin">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div role="dialog" tabindex="-1" class="modal fade" id="viewModal">
<div class="modal-dialog" role="document">
    <form method="POST" role="form">
        <input type="hidden"  name="admin_id" id="admin_id"/>
        <div class="modal-content">
            <div class="modal-header" style="background-color:#ffa3a4;">
                <h4>Edit Admin Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column align-items-center align-items-sm-center align-items-md-center">
                    <div class="form-group d-flex d-md-flex flex-row justify-content-md-center col-10">
                        <div class="col-6">
                            <label class="d-md-flex justify-content-md-start">
                                <strong>First Name:</strong>
                            </label>
                            <input type="text" class="form-control text-validate" id="first_name" name="first_name"/>
                            <small style="color:red"></small>
                        </div>
                        <div class="col-6">
                            <label class="d-md-flex justify-content-md-start">
                                <strong>Last Name:</strong>
                            </label>
                            <input type="text" class="form-control text-validate" id="last_name" name="last_name" />
                            <small style="color:red"></small>
                        </div>
                    </div>
                    <div class="form-group d-flex d-md-flex flex-column justify-content-md-center col-10">
                        <label class="d-md-flex justify-content-md-start">
                            <strong>Email:</strong>
                        </label>
                        <input type="email" class="form-control email-validate"  id="email" name="email" readonly />
                        <small style="color:red"></small>
                    </div>
                    <div class="form-group d-flex d-md-flex flex-column justify-content-md-center col-10">
                        <label class="d-md-flex justify-content-md-start">
                            <strong>Status:</strong>
                        </label>
                        <select  class="form-control"  id="status" name="status" >
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger" type="submit" name="delete_admin">Delete Admin</button>
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
                <button class="btn btn-success button-style-r" type="submit" name="save_admin"><strong>Save Data</strong></button>
            </div>
        </div>
    </form>
    </div>

</div>