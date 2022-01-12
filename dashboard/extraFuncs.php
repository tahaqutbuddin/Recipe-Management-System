<?php

function ingredient_row_edit_page($section,$ingre_title,$ingre_name,$div_id,$val_id,$val,$quantity,$unit)
{
    $option = '';
    $q_arr = array("gramm","milliliter","stück","dose");
    for($j=0; $j  < count($q_arr); $j++)
    {
        $opt  = $q_arr[$j];
        if($opt == $unit)
        {
            $option .= '<option class="dropdown-item style-dropdown" value="'.($opt).'" selected>'.ucfirst($opt).'</option>';
        }else
        {
            $option .= '<option class="dropdown-item style-dropdown" value="'.($opt).'">'.ucfirst($opt).'</option>';
        }
    }
    $explode_id = explode('-',$div_id);
    $no = intval(trim($explode_id[1],"div"));
    if( (strlen($val) > 1) && (intval($quantity) > 0))
    {
        $button1 = '<button class="btn btn-primary button-hera not-disabled" type="button" id="addMoreRecords">Hinzufügen</button> ';
        $button2 = '<button class="btn btn-primary mt-4 button-hera not-disabled" type="button" id="addMoreRecords">Hinzufügen</button>'; 
    }else
    {
        $button1 = '<button class="btn btn-primary button-hera" type="button" id="addMoreRecords">Hinzufügen</button> ';
        $button2 = '<button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button>';
    }
    if(($no > 1) && (strlen($val) > 0))
    {
        return '
        <div class="row nth-fish-add" id="'.$div_id.'"> 
                <div class="col-md-5 col-sm-5 usl-fish"> 
                    <div class="row fisch"> 
                        <div class="col-md-12">  
                            <h1 class="heading-sm-title"></h1>
                            <input class="Fisch-input ingredients-input-'.$section.' form-control" type="text" name="'.$ingre_name.'[]" data-id="animal_products" autocomplete="off" value="'.$val.'" />
                            <input type="hidden" name="'.$ingre_name.'_id[]"  value="'.$val_id.'"> 
                            <div id="" class="autocomplete-items list-auto-a list-a-a-a" style="display: none;"> 
                            
                            </div>  
                        </div> 
                    </div> 
                </div> 
                <div class="col-md-2 col-sm-3 usl-menge"> 
                    <div class="row"> 
                        <div class="col-md-12"> 
                            <h1 class="heading-sm"></h1> 
                            <input type="text" class="form-control menge-input only-numeric" name="'.$ingre_name.'_quantity[]" value="'.$quantity.'">
                            <small style="color:red"></small> 
                        </div> 
                    </div> 
                </div> 
                <div class="col-md-2 col-sm-3">
                    <div class="dropdown dd-gramm-mo">  
                        <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="'.$ingre_name.'_unit[]" />  
                        '.$option.'
                        </select> 
                    </div>
                </div>  
                <div class="col-md-2 col-sm-12"> 
                '.$button1.'
                </div> 
        </div>';
    }else
    {
        return '
        <div class="row nth-fish" id="'.$div_id.'">
        <div class="col-md-5 col-sm-5 usl-fish">
            <div class="row fisch">
                <div class="col-md-12">
                    <h1 class="heading-sm-title">'.$ingre_title.'</h1>
                    <input type="text" class="Fisch-input ingredients-input-'.$section.' form-control" name="'.$ingre_name.'[]" data-id="'.$ingre_name.'" autocomplete="off" value="'.$val.'" /> 
                    <input type="hidden" name="'.$ingre_name.'_id[]" value="'.$val_id.'" />
                    <div id="" class="autocomplete-items list-auto-a list-a-a-a" >
                    
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-3 usl-menge">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="heading-sm">Menge</h1>
                    <input type="text" class="form-control menge-input only-numeric" name="'.$ingre_name.'_quantity[]" autocomplete="off" value="'.$quantity.'">
                    <small style="color:red"></small>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-3">
            <div class="dropdown mt-4 dd-gramm-mo">
                <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="'.$ingre_name.'_unit[]">
                    <div class="dropdown-menu">
                        '.$option.'
                    </div>
                </select>
            </div>
        </div>
        <div class="col-md-2 col-sm-12" >
            '.$button2.'
        </div>
        </div>
        ';
    }
    
}


function cooking_step($i,$total_steps_count,$step_id,$title,$desc,$img)
{
    if($i == ($total_steps_count-1))
    {
        
        return '
        <div class="container d-flex flex-column col-md-12 card form" id="step'.($i+1).'">
            <br/>
                <div class="row">
                    <div class="col schrit">
                        <h1 class="heading-main heading-c">Schritt: '.($i+1).'</h1>
                    </div>
                </div>
                <div class="row d-flex flex-column row-border">
                    <div class="col-md-6 col-sm-12">
                        <section class="section-1">
                            <h5>Wie heißt der Arbeitsschritt?</h5>
                            <input type="hidden" name="cooking_step_id[]" value="'.$step_id.'" />
                            <input type="text" class="text-input-1 form-control" name="cooking_title[]" value="'.$title.'" autocomplete="off" />
                        </section>
                        <section class="section-1 section-with-upload-button ">
                            <h5>Beschreibung:</h5>
                            <textarea class="text-input-2 form-control" name="cooking_description[]" autocomplete="off">'.$desc.'</textarea>
                            <small style="color:red"></small>
                        </section>
                        <div class="row upload-button justify-content-center">
                            <div class="col-xs-6 col-sm-10 col-md-8 d-flex flex-row">
                                <label for="files'.$i.'" class="btn btn-primary d-flex flex-row uploadbutton-input" >Upload Bild</label>
                                <input  id="files'.$i.'" type="file" hidden>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex flex-column flex-shrink-1 justify-content-center flex-wrap align-items-xl-center col-hidden pic -arb">
                        <div class="row row-hidden">
                            <div class="col">
                                <img class="pic-arbeeaa" src="assets/img/cookingsteps/'.$img.'" id="image-display'.($i+1).'">
                            </div>
                        </div>
                        <div class="row row-hidden-bild">
                            <div class="col button-bild">
                                <input class="btn btn-primary uploadbutton-hidden every-button upload-image-jquery" id="uploadImage'.($i+1).'" type="file" name="cooking_image[]" value="'.$img.'"  hidden>
                                <input type="hidden" name="cooking_image_old[]" value="'.$img.'" />
                                <label for="uploadImage'.($i+1).'" class="btn btn-primary uploadbutton-hidden every-button">
                                    Bild ändern
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row d-flex flex-row flex-grow-1 flex-shrink-1 row-button-1">
                    <div class="col button-after-form">
                        <button class="btn btn-primary btn-hide every-button" type="button" id="removeCookingStep">
                            <strong>Schritt entfernen</strong>
                        </button>
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
        ';
    }else
    {
        return '
        <div class="container d-flex flex-column col-md-12 card form" id="step'.($i+1).'">
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
                    <h1 class="heading-main heading-c">Schritt: '.($i+1).'</h1>
                </div>
            </div>
            <div class="row d-flex flex-column row-border">
                <div class="col-md-6 col-sm-12">
                    <section class="section-1">
                        <h5>Wie heißt der Arbeitsschritt?</h5>
                        <input type="hidden" name="cooking_step_id[]" value="'.$step_id.'"  />
                        <input type="text" class="text-input-1 form-control" name="cooking_title[]" value="'.$title.'" autocomplete="off" />
                    </section>
                    <section class="section-1 section-with-upload-button ">
                        <h5>Beschreibung:</h5>
                        <textarea class="text-input-2 form-control" name="cooking_description[]" autocomplete="off">'.$desc.'</textarea>
                        <small style="color:red"></small>
                    </section>
                    <div class="row upload-button justify-content-center">
                        <div class="col-xs-6 col-sm-10 col-md-8 d-flex flex-row">
                            <label for="files'.$i.'" class="btn btn-primary d-flex flex-row uploadbutton-input" >Upload Bild</label>
                            <input  id="files'.$i.'" type="file" hidden>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column flex-shrink-1 justify-content-center flex-wrap align-items-xl-center col-hidden pic -arb">
                    <div class="row row-hidden">
                        <div class="col">
                            <img class="pic-arbeeaa" src="assets/img/cookingsteps/'.$img.'" id="image-display'.($i+1).'">
                        </div>
                    </div>
                    <div class="row row-hidden-bild">
                        <div class="col button-bild">
                            <input class="btn btn-primary uploadbutton-hidden every-button upload-image-jquery" id="uploadImage'.($i+1).'" name="cooking_image[]" value="'.$img.'" type="file" hidden>
                            <input type="hidden" name="cooking_image_old[]" value="'.$img.'" />
                            <label for="uploadImage'.($i+1).'" class="btn btn-primary uploadbutton-hidden every-button">
                                Bild ändern
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex flex-row flex-grow-1 flex-shrink-1 row-button-1">
                <div class="col button-after-form">
                    <button class="btn btn-primary btn-hide every-button" type="button" id="removeCookingStep">
                        <strong>Schritt entfernen</strong>
                    </button>
                </div>
            </div>
        </div>
        ';
        
    }
}



?>