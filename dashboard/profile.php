<?php
session_start();
require '../Model/class.chef.php';
if((!isset($_SESSION["user_email"])) && (!isset($_SESSION["facebook_access_token"])) && (!isset($_SESSION["google_access_token"])))
{
    header("Location: ../login.php");
}

$chef_email = $_SESSION["chef_email"];
// $chef_email = "tips@gmail.com";

if(isset($_POST["image"]))
{
    $obj = new chef;
    if($obj->saveProfileData("image",$chef_email) == true)
    {
        unset($obj);
        $_SESSION["success"] = 1;
    }else 
    {
        unset($obj);
        $_SESSION["error"] = 1;
    }
}

if(isset($_POST["about_chef"]))
{
    $obj = new chef;
    if($obj->saveProfileData("about_chef",$chef_email)== true)
    {
        unset($obj);
        $_SESSION["success"] = 1;
    }else
    {
        unset($obj);
        $_SESSION["error"]  = 1;
    }
}


if(isset($_POST["save_settings1"]))
{
    $obj = new chef;
    if($obj->saveProfileData("user_settings",$chef_email)== true)
    {
        unset($obj);
        $_SESSION["success"] = 1;
    }else
    {
        unset($obj);
        $_SESSION["error"]  = 1;
    }
}

if(isset($_POST["save_settings2"]))
{
    $obj = new chef;
    if($obj->saveProfileData("contact_details",$chef_email) == true)
    {
        unset($obj);
        $_SESSION["success"] = 1;
    }else
    {
        unset($obj);
        $_SESSION["error"] = 1;
    }
}

$obj = new chef;
$first_name = htmlspecialchars_decode($obj->fetchChefProperties($chef_email,"first_name"),ENT_COMPAT);
$last_name = htmlspecialchars_decode($obj->fetchChefProperties($chef_email,"last_name"),ENT_COMPAT);
$email = htmlspecialchars_decode($obj->fetchChefProperties($chef_email,"email"),ENT_COMPAT);
$birth_date = htmlspecialchars_decode($obj->fetchChefProperties($chef_email,"birth_date"),ENT_COMPAT);
$city = htmlspecialchars_decode($obj->fetchChefProperties($chef_email,"city"),ENT_COMPAT);
$country = htmlspecialchars_decode($obj->fetchChefProperties($chef_email,"country"),ENT_COMPAT);
$postal_code = htmlspecialchars_decode($obj->fetchChefProperties($chef_email,"postal_code"),ENT_COMPAT);
$address = htmlspecialchars_decode($obj->fetchChefProperties($chef_email,"address"),ENT_COMPAT);
$avatar = htmlspecialchars_decode($obj->fetchChefProperties($chef_email,"avatar"),ENT_COMPAT);
$continent = htmlspecialchars_decode($obj->fetchChefProperties($chef_email,"continent"),ENT_COMPAT);
$about_me = htmlspecialchars_decode($obj->fetchChefProperties($chef_email,"about_me"),ENT_COMPAT);
unset($obj);



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Chef Profil</title>
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
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
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
                        <a class="nav-link text-center" href="form.php">
                            <i class="fa fa-plus-circle icon-nav-link"></i>
                            <span class="text-side-nav-link">Neues Rezept erstellen</span>
                        </a>
                    </li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
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
                                        <span class="d-none d-lg-inline mr-2 text-gray-600 small"><?php if(isset($_SESSION["username"])){echo strtolower(htmlentities($_SESSION["username"])); }else{ echo "Valerie Luna";} ?></span>
                                        <img class="border rounded-circle img-profile" src="assets/img/avatars/dummy.png">
                                    </a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in">
                                        <a class="dropdown-item" href="profile.php">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profil
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="logout.php">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Ausloggen
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Chef Profil</h3>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <form method="POST" role="form" enctype="multipart/form-data">
                                    <div class="card-body text-center shadow">
                                        <img class="rounded-circle mb-3 mt-4" src="<?= "assets/img/avatars/".$avatar ?>" width="160" height="160" id="profileImage">
                                        <div class="mb-3">
                                                <label> Bild ändern</label>
                                                <input type="file" class="btn btn-primary btn-sm profile-button-a" type="button" name="avatar" id="change_photo" onchange="validateImage()"/>
                                                <hr/>
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-sm profile-button-a" type="submit" name="image">Einstellungen speichern</button>
                                                </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                       
                            <div class="card mb-2">
                                <form method="POST" role="form">
                                    <div class="card-body text-center shadow">
                                        <label><strong>Kurzbeschreibung</strong></label>
                                        <div class="mb-3">
                                                <textarea class="form-control" rows=5 maxlength=10000 name="about_me" ><?= $about_me; ?></textarea>
                                                <hr/>
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-sm profile-button-a" type="submit" name="about_chef">Einstellungen speichern</button>
                                                </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 font-weight-bold">Benutzereinstellungen</p>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" role="form">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="first_name"><strong>Vorname</strong></label>
                                                            <input class="form-control" type="text" id="first_name"  name="first_name" value="<?= $first_name; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="last_name"><strong>Nachname</strong></label>
                                                            <input class="form-control" type="text" id="last_name" name="last_name" value="<?= $last_name; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="email"><strong>Email</strong></label>
                                                            <input class="form-control" type="email" id="email" name="email" value="<?= $email; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="dob"><strong>Geburtsdatum</strong></label>
                                                            <input class="form-control" type="date" id="birth_date" name="birth_date" value="<?= $birth_date; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-primary btn-sm profile-button-a" type="submit" name="save_settings1">Einstellungen speichern</button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card shadow">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 font-weight-bold">Kontakteinstellungen</p>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" role="form">
                                                <div class="form-group">
                                                    <label for="address"><strong>Adresse</strong></label>
                                                    <input class="form-control" type="text" id="address" name="address" value="<?= $address; ?>" />
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="city"><strong>Stadt</strong></label>
                                                            <input class="form-control" type="text" id="city" name="city" value="<?= $city; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="country"><strong>Land</strong></label>
                                                            <input class="form-control" type="text" id="country" name="country" value="<?= $country; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="postal"><strong>Postleitzahl</strong></label>
                                                            <input class="form-control" type="text" id="postal" name="postal_code" value="<?= $postal_code; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="continent"><strong>Kontinent</strong></label>
                                                            <input class="form-control" type="text" id="continent" name="continent" value="<?= $continent; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-sm profile-button-a" type="submit" name="save_settings2">Einstellungen speichern</button>
                                                </div>
                                            </form>
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
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
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
        });

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