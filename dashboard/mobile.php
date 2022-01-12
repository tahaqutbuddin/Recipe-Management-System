
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
    <link rel="stylesheet" href="assets/css/over_style.css">
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
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"><i class="fas fa-angle-left"></i></button></div>
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
                                        <span class="d-none d-lg-inline mr-2 text-gray-600 small"><?php if(isset($_SESSION["username"])){echo strtolower(htmlentities($_SESSION["username"])); }else{ echo "Dummy User";} ?></span>
                                        <img class="border rounded-circle img-profile" src="assets/img/avatars/dummy.png">
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
                <div id="main-form">
                    <div id="form-body">
                        
                        <div class="container container-cc">
                            <!-- Start: Carousel_Image_Slider -->
                            <div class="col-sm-4 col-md-4">
                                <!-- Start: best carousel slide -->
                                <section id="carousel " class="overview-slider">
                                    <!-- Start: Carousel Hero -->
                                    <div class="carousel slide" data-ride="carousel" data-interval="false" id="carousel-1">
                                        <div class="carousel-inner">
                    
                                            <div class="carousel-item active">
                                                <div class="overview-inner">
                                                    <h5 class="text-left heading-cc-1">Diat</h5>
                                                    <h5 class="text-left heading-cc-2">kava
                                                        asdasd</h5>
                                                    <h5 class="text-left heading-cc-3 text-break  d-flex flex-grow-1 col-md-12"><i class="fa fa-caret-right"></i>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h5>
                    
                                                </div>
                                            </div>
                                            <div class="carousel-item ">
                                                <div class="overview-inner">
                                                    <h5 class="text-left heading-cc-1">Diat</h5>
                                                    <h5 class="text-left  heading-cc-2">kava
                                                        asdasd</h5>
                                                    <h5 class="text-left heading-cc-3 text-break d-flex flex-grow-1 col-md-12"><i class="fa fa-caret-right"></i>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h5>
                    
                                                </div>
                                            </div>
                                            <div class="carousel-item ">
                                                <div class="overview-inner">
                                                    <h5 class="text-left heading-cc-1">Diat</h5>
                                                    <h5 class="text-left  heading-cc-2">kava
                                                        asdasd</h5>
                                                    <h5 class="text-left heading-cc-3 text-break  d-flex flex-grow-1 col-md-12"><i class="fa fa-caret-right"></i>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h5>
                                                    <h5 class="text-left heading-cc-3 text-break d-flex flex-grow-1 col-md-12"><i class="fa fa-caret-right"></i>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h5>
                    
                                                </div>
                                            </div>
                                        </div>
                                        <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><i
                                                    class="fa fa-chevron-left"></i><span class="sr-only">Previous</span></a><a
                                                class="carousel-control-next" href="#carousel-1" role="button" data-slide="next"><i
                                                    class="fa fa-chevron-right"></i><span class="sr-only">Next</span></a></div>
                                        <ol class="carousel-indicators">
                                            <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
                                            <li data-target="#carousel-1" data-slide-to="1"></li>
                                            <li data-target="#carousel-1" data-slide-to="2"></li>
                                        </ol>
                                    </div><!-- End: Carousel Hero -->
                                </section><!-- End: best carousel slide -->
                            </div><!-- End: Carousel_Image_Slider -->
                        </div><div class="container container-cc">
                            <!-- Start: Carousel_Image_Slider -->
                            <div class="col-sm-4 col-md-4">
                                <!-- Start: best carousel slide -->
                                <section id="carousel " class="overview-slider">
                                    <!-- Start: Carousel Hero -->
                                    <div class="carousel slide" data-ride="carousel" data-interval="false" id="carousel-2">
                                        <div class="carousel-inner">
                    
                                            <div class="carousel-item active">
                                                <div class="overview-inner">
                                                    <h5 class="text-left heading-cc-1">Diat</h5>
                                                    <h5 class="text-left heading-cc-2">kava
                                                        asdasd</h5>
                                                    <h5 class="text-left heading-cc-3 text-break  d-flex flex-grow-1 col-md-12"><i class="fa fa-caret-right"></i>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h5>
                    
                                                </div>
                                            </div>
                                            <div class="carousel-item ">
                                                <div class="overview-inner">
                                                    <h5 class="text-left heading-cc-1">Diat</h5>
                                                    <h5 class="text-left  heading-cc-2">kava
                                                        asdasd</h5>
                                                    <h5 class="text-left heading-cc-3 text-break d-flex flex-grow-1 col-md-12"><i class="fa fa-caret-right"></i>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h5>
                    
                                                </div>
                                            </div>
                                            <div class="carousel-item ">
                                                <div class="overview-inner">
                                                    <h5 class="text-left heading-cc-1">Diat</h5>
                                                    <h5 class="text-left  heading-cc-2">kava
                                                        asdasd</h5>
                                                    <h5 class="text-left heading-cc-3 text-break  d-flex flex-grow-1 col-md-12"><i class="fa fa-caret-right"></i>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h5>
                                                    <h5 class="text-left heading-cc-3 text-break d-flex flex-grow-1 col-md-12"><i class="fa fa-caret-right"></i>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h5>
                    
                                                </div>
                                            </div>
                                        </div>
                                        <div><a class="carousel-control-prev" href="#carousel-2" role="button" data-slide="prev"><i
                                                    class="fa fa-chevron-left"></i><span class="sr-only">Previous</span></a><a
                                                class="carousel-control-next" href="#carousel-2" role="button" data-slide="next"><i
                                                    class="fa fa-chevron-right"></i><span class="sr-only">Next</span></a></div>
                                        <ol class="carousel-indicators">
                                            <li data-target="#carousel-2" data-slide-to="0" class="active"></li>
                                            <li data-target="#carousel-2" data-slide-to="1"></li>
                                            <li data-target="#carousel-2" data-slide-to="2"></li>
                                        </ol>
                                    </div><!-- End: Carousel Hero -->
                                </section><!-- End: best carousel slide -->
                            </div><!-- End: Carousel_Image_Slider -->
                        </div><div class="container container-cc">
                            <!-- Start: Carousel_Image_Slider -->
                            <div class="col-sm-4 col-md-4">
                                <!-- Start: best carousel slide -->
                                <section id="carousel " class="overview-slider">
                                    <!-- Start: Carousel Hero -->
                                    <div class="carousel slide" data-ride="carousel" data-interval="false" id="carousel-3">
                                        <div class="carousel-inner">
                    
                                            <div class="carousel-item active">
                                                <div class="overview-inner">
                                                    <h5 class="text-left heading-cc-1">Diat</h5>
                                                    <h5 class="text-left heading-cc-2">kava
                                                        asdasd</h5>
                                                    <h5 class="text-left heading-cc-3 text-break  d-flex flex-grow-1 col-md-12"><i class="fa fa-caret-right"></i>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h5>
                    
                                                </div>
                                            </div>
                                            <div class="carousel-item ">
                                                <div class="overview-inner">
                                                    <h5 class="text-left heading-cc-1">Diat</h5>
                                                    <h5 class="text-left  heading-cc-2">kava
                                                        asdasd</h5>
                                                    <h5 class="text-left heading-cc-3 text-break d-flex flex-grow-1 col-md-12"><i class="fa fa-caret-right"></i>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h5>
                    
                                                </div>
                                            </div>
                                            <div class="carousel-item ">
                                                <div class="overview-inner">
                                                    <h5 class="text-left heading-cc-1">Diat</h5>
                                                    <h5 class="text-left  heading-cc-2">kava
                                                        asdasd</h5>
                                                    <h5 class="text-left heading-cc-3 text-break  d-flex flex-grow-1 col-md-12"><i class="fa fa-caret-right"></i>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h5>
                                                    <h5 class="text-left heading-cc-3 text-break d-flex flex-grow-1 col-md-12"><i class="fa fa-caret-right"></i>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h5>
                    
                                                </div>
                                            </div>
                                        </div>
                                        <div><a class="carousel-control-prev" href="#carousel-3" role="button" data-slide="prev"><i
                                                    class="fa fa-chevron-left"></i><span class="sr-only">Previous</span></a><a
                                                class="carousel-control-next" href="#carousel-3" role="button" data-slide="next"><i
                                                    class="fa fa-chevron-right"></i><span class="sr-only">Next</span></a></div>
                                        <ol class="carousel-indicators">
                                            <li data-target="#carousel-3" data-slide-to="0" class="active"></li>
                                            <li data-target="#carousel-3" data-slide-to="1"></li>
                                            <li data-target="#carousel-3" data-slide-to="2"></li>
                                        </ol>
                                    </div><!-- End: Carousel Hero -->
                                </section><!-- End: best carousel slide -->
                            </div><!-- End: Carousel_Image_Slider -->
                        </div>
                        
                        
                        <div class="container " >
    
                            <div class="row row-hide">
                                <div class="col-sm-4 col-md-4" >
                                    <h1 class="heading-main" ><em>Schritt: 1</em></h1>
                                    <div class="dropdown">
                                    <div class="dropdown show"><button
                                            class="btn btn-primary active dropdown-toggle pic-dropdown btn-script" aria-expanded="true"
                                            data-toggle="dropdown" type="button"
                                            ><img
                                                src="form_assets/img/cute-boy-chef-look-smart_38747-11.jpg"
                                                class="img-title" >ASDASDASDASDA</button>
                                        <div class="dropdown-menu schrit" ><a
                                                class="dropdown-item text-break text-left d-flex flex-grow-1 flex-shrink-1 flex-wrap desciption-option col-md-12 drop-down-overview-wala">Firaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div><!-- Start: 1 Row 3 Columns -->
                        <div class="container " >
    
                            <div class="row row-hide">
                                <div class="col-sm-4 col-md-4" >
                                    <h1 class="heading-main" ><em>Schritt: 1</em></h1>
                                    <div class="dropdown">
                                    <div class="dropdown show"><button
                                            class="btn btn-primary active dropdown-toggle pic-dropdown btn-script" aria-expanded="true"
                                            data-toggle="dropdown" type="button"
                                            ><img
                                                src="form_assets/img/cute-boy-chef-look-smart_38747-11.jpg"
                                                class="img-title" >ASDASDASDASDA</button>
                                        <div class="dropdown-menu schrit" ><a
                                                class="dropdown-item text-break text-left d-flex flex-grow-1 flex-shrink-1 flex-wrap desciption-option col-md-12 drop-down-overview-wala">Firaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div><!-- Start: 1 Row 3 Columns -->
                        
                    </div>
                </div>
            </div>
        </div>
        </div><a class="border rounded d-inline scroll-to-top" id="scrollTop" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    
    <?php
                include_once("../userIncludes/footer.php");
            ?>

    <script src="form_assets/js/jquery.min.js"></script>
    <script src="form_assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="form_assets/js/script.min.js"></script>
    <script src="assets/js/script.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="form_assets/js/formCustomJquery.js" ></script>
    <script>
    
        jQuery(window).load(function() {
 
        /*
            Stop carousel
        */
        $('.carousel').carousel('pause');
       
       });
       </script>

</body>

</html>