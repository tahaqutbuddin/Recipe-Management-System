<?php
require '../Model/class.recipe.php';
function fetchCompleteOverviewPageForDesktop($chef_email)
{
    $obj = new recipe;
    $diet_arr = $obj->userInsertedDataCheckbox("email",$chef_email,"main_recipe","diet","incomplete");
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
        for($i = 0; $i < count($diet_arr);$i++)
        {
            $diet_values .= '
            <h6 class="bullet">
                <i class="fas fa-circle"></i>&nbsp;
                &nbsp;'.ucfirst(htmlspecialchars_decode($diet_arr[$i],ENT_COMPAT)).'
            </h6>';
        } 
    }
    
    $animal_arr = $obj->userInsertedDataCheckbox("email",$chef_email,"main_recipe","animal_products","incomplete");
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
        for($i = 0; $i < count($animal_arr);$i++)
        {
            $animal_values .= '
            <h6 class="bullet">
                <i class="fas fa-circle"></i>&nbsp;
                &nbsp;'.ucfirst(htmlspecialchars_decode($animal_arr[$i],ENT_COMPAT)).'
            </h6>
            ';
        } 
    }
    $allergen_arr = $obj->userInsertedDataCheckbox("email",$chef_email,"main_recipe","allergen","incomplete");
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
        for($i = 0; $i < count($allergen_arr);$i++)
        {
            $allergen_values .= '
            <h6 class="bullet">
                <i class="fas fa-circle"></i>&nbsp;
                &nbsp;'.ucfirst(htmlspecialchars_decode($allergen_arr[$i],ENT_COMPAT)).'
            </h6>';
        } 
    }
    $home_arr = $obj->userInsertedDataCheckbox("email",$chef_email,"main_recipe","home_equipment","incomplete");
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
        for($i = 0; $i < count($home_arr);$i++)
        {
            $home_values .= '
            <h6 class="bullet">
                <i class="fas fa-circle"></i>&nbsp;
                &nbsp;'.ucfirst(htmlspecialchars_decode($home_arr[$i],ENT_COMPAT)).'
            </h6>';
        }
    } 
    
    $utils_arr = $obj->userInsertedDataUtils("email",$chef_email,"utils","description","incomplete");
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
        for($i = 0; $i < count($utils_arr);$i++)
        {
            $utils_values .= '
            <h6 class="bullet">
                <i class="fas fa-circle"></i>&nbsp;
                &nbsp;'.ucfirst(htmlspecialchars_decode($utils_arr[$i][1],ENT_COMPAT)).'
            </h6>';
        } 
    }
    $supermarket_arr = $obj->userInsertedDataIngredients("email",$chef_email,"supermarket","incomplete");
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
        for($i = 0; $i < count($supermarket_arr);$i++)
        {
            $supermarket_values .= '
            <h6 class="bullet">
                <i class="fas fa-circle"></i>&nbsp;
                &nbsp;'.ucfirst(htmlspecialchars_decode($supermarket_arr[$i],ENT_COMPAT)).'
            </h6>';
        } 
    }

    $fancies_arr = $obj->userInsertedDataIngredients("email",$chef_email,"fancies","incomplete");
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
        for($i = 0; $i < count($fancies_arr);$i++)
        {
            $fancies_values .= '
            <h6 class="bullet">
                <i class="fas fa-circle"></i>&nbsp;
                &nbsp;'.ucfirst(htmlspecialchars_decode($fancies_arr[$i],ENT_COMPAT)).'
            </h6>';
        } 
    }

    $cooking_steps_arr = $obj->userInsertedDataCookingSteps("email",$chef_email,"cooking_steps","incomplete");
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
            <div class="row d-flex flex-row flex-shrink-1 flex-nowrap col-md-12" id="card-last-one">
                <div class="col-md-6 col-xl-8">
                    <div class="row">
                        <div class="col" id="end-heading-col">
                            <h5 id="end-heading" class="main-heading">
                                <span class="main-h-overview">Schritt '.($i + 1).'</span></h5>
                        </div>
                    </div>
                    <div class="row d-flex">
                        <div class="col col-a" id="end-title">
                            <h6 class="heading-title" id="last-id-heading">Titel: '.$title.' 
                            </h6>
                            <p id="paragraph-end">'.$desc.'</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4"><img class="image-title"
                        src="assets/img/cookingsteps/'.$img.'">
                </div>
            </div>
            ';
        } 
    }

    $difficulty = $obj->userInsertedDataTechnical("email",$chef_email,"main_recipe","difficulty","incomplete");
    $sharpness = $obj->userInsertedDataTechnical("email",$chef_email,"main_recipe","sharpness","incomplete");
    $calorie = $obj->userInsertedDataNutritional("email",$chef_email,"nutritional_info","calorie","incomplete");
    $fat = $obj->userInsertedDataNutritional("email",$chef_email,"nutritional_info","fat","incomplete","incomplete");
    $carbo = $obj->userInsertedDataNutritional("email",$chef_email,"nutritional_info","carbohydrates","incomplete");
    $protein = $obj->userInsertedDataNutritional("email",$chef_email,"nutritional_info","protein","incomplete");
    
    if( (is_bool($calorie) &&  ($calorie == false)) && (is_bool($fat) &&  ($fat == false)) && (is_bool($carbo) &&  ($carbo == false)) && (is_bool($protein) &&  ($protein == false)) )
    {
        $nutritional_info = '
        <h6 class="italicred" id="same-text-alig">
            <em>keine Angabe</em>
        </h6>
        ';
    }else
    {
        $nutritional_info = '
        <i class="fas fa-circle"></i>&nbsp;&nbsp;'.$calorie.' Kalorien<br/>
        <i class="fas fa-circle"></i>&nbsp;&nbsp;'.$fat.'g Fett<br/>
        <i class="fas fa-circle"></i>&nbsp;&nbsp;'.$carbo.'g Kohlenhydrate<br/>
        <i class="fas fa-circle"></i>&nbsp;&nbsp;'.$protein.'g Eiweiß<br/>
        ';
    }
    return '
    <div id="r1c3" class="r1 same-r1">
        <div class="container col-md-12 row-a-hide-card-a">
            <div class="row same-row"  overflow="scroll">
                <div class="col-md-4 d-flex flex-column div-white">
                    <h6 class="heading1">
                        <span class="main-h-overview">Diät</span>:
                    </h6>
                    '.$diet_values.'
                    <h6 class="heading-last" id="same-text-alig">
                        <i class="fa fa-play"></i>
                        <a class="goto_button" href="#diat">Etwas vergessen?</a>
                    </h6>
                </div>
                <div class="col-md-4 div-white" id="a">
                    <h6 class="heading1" id="same-text-alig">
                        <span class="main-h-overview">Nährwertangaben:</span><br>
                    </h6>
                    <h6 class="bullet">
                        '.$nutritional_info.'
                    </h6>
                    <h6 class="heading-last" id="same-text-alig">
                        <i class="fa fa-play"></i>&nbsp;
                        <a class="goto_button gray-goto" href="#Nährwertangaben">Etwas vergessen?</a>
                    </h6>
                </div>
                <div class="col-md-4 div-white">
                    <h6 class=" heading1" id="same-text-alig">
                        <span class="main-h-overview">Tierische Produkte:</span>
                    </h6>
                    '.$animal_values.'
                    <h6 class="heading-last" id="same-text-alig">
                        <i class="fa fa-play"></i>&nbsp;
                        <a class="goto_button" href="#Tierische">Etwas vergessen?</a>
                    </h6>
                </div>
            </div>
        </div>
    </div><!-- End: 1 Row 3 Columns -->
    <!-- Start: 1 Row 3 Columns -->
    <div class="r2 same-r1">
        <div class="container col-md-12 row-a-hide-card-a">
            <div class="row same-row">
                <div class="col-md-4 div-white" id="a">
                    <h6 class="heading1"><span class="main-h-overview">
                        Technische Daten:</span>
                    </h6>
                    <h6 class="bullet" >
                        <i class="fas fa-circle"></i>&nbsp;&nbsp;Schwierigkeitsgrad: '.$difficulty.'<br/><br/>
                        <i class="fas fa-circle"></i>&nbsp;&nbsp;Schärfegrad: '.$sharpness.'<br>
                    </h6>
                    <h6 class="heading-last" id="same-text-alig">
                        <i class="fa fa-play"></i>&nbsp;
                        <a class="goto_button gray-goto" href="#Technisched">Etwas vergessen?</a>
                    </h6>
                </div>
                <div class="col-md-4 div-white">
                    <h6 class="heading1" id="same-text-alig">
                        <span class="main-h-overview">Utensilien:</span>
                    </h6>
                    '.$utils_values.'
                    <h6 class="heading-last" id="same-text-alig">
                        <i class="fa fa-play"></i>&nbsp;
                        <a class="goto_button" href="#Utensilien">Etwas vergessen?</a>
                    </h6>
                </div>
                <div class="col-md-4 div-white" id="a">
                    <h6 class=" heading1"><span class="main-h-overview">
                        Allergene:
                    </span>
                    </h6>
                    '.$allergen_values.'
                    <h6 class="heading-last" id="same-text-alig">
                        <i class="fa fa-play"></i>&nbsp;
                        <a class="goto_button gray-goto" href="#Allergene">Etwas vergessen?</a>
                    </h6>
                </div>
            </div>
        </div>
    </div><!-- End: 1 Row 3 Columns -->
    <!-- Start: 1 Row 3 Columns -->
    <div id="r3c3" class="r3">
        <div class="container col-md-12 row-a-hide-card-a">
            <div class="row same-row">
                <div class="col-md-4 div-white">
                    <h6 class="heading1">
                        <span class="main-h-overview">Supermarkt-Zutaten</span>
                    </h6>
                    '.$supermarket_values.'
                    <h6 class="heading-last">
                        <i class="fa fa-play"></i>&nbsp; &nbsp;
                        <a class="goto_button" href="#ingredients">Etwas vergessen?</a>
                    </h6>
                </div>
                <div class="col-md-4 div-white" id="a">
                    <h6 class="heading1">
                        <span class="main-h-overview">Fancies</span>
                    </h6>
                    '.$fancies_values.'
                    <h6 class="heading-last">
                        <i class="fa fa-play"></i>&nbsp; &nbsp;
                        <a class="goto_button gray-goto" href="#gewurze-div">Etwas vergessen?</a>
                    </h6>
                </div>
                <div class="col-md-4 div-white">
                    <h6 class="heading1">
                        <span class="main-h-overview">Heimaustattung</span>
                    </h6>
                    '.$home_values.'
                    <h6 class="heading-last">
                        <i class="fa fa-play"></i>&nbsp; &nbsp;
                        <a class="goto_button" href="#Heimaustattung">Etwas vergessen?</a>
                    </h6>
                </div>
            </div>
        </div>
    </div><!-- End: 1 Row 3 Columns -->
    <div class="container card-1 col-md-12">
        '.$cooking_steps_values.'
    </div>
    <div class="row hr">
        <div class="col">
            <hr class="hr-main">
        </div>
    </div>
    <div class="row d-flex flex-row flex-grow-1 flex-shrink-1 row-button">
        <div class="col" id="previousButton">
            <button class="btn btn-primary d-flex d-lg-flex d-xl-flex justify-content-center align-items-center justify-content-lg-center align-items-lg-center justify-content-xl-center align-items-xl-center Rezept-übermitteln" id="last-button" type="button">Bisherige</button>
        </div>
    </div>
    <div class="row hr">
        <div class="col">
            <hr class="hr-main">
        </div>
    </div>
    <div class="row d-flex flex-row flex-grow-1 flex-shrink-1 row-button">
        <div class="col" id="last-button-column">
        <form method="POST">
            <button class="btn btn-primary d-flex d-lg-flex d-xl-flex justify-content-center align-items-center justify-content-lg-center align-items-lg-center justify-content-xl-center align-items-xl-center Rezept-übermitteln"
                id="last-button" type="submit" name="submitRecipe">Rezept übermitteln</button>
        </form>
        </div>
    </div>';
}

function fetchCompleteOverviewPageForMobile()
{
    return '
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
    ';
}
?>
