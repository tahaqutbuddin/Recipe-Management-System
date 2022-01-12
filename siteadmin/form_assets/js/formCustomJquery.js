var meat_id = 1;
var tierische_div = 1;
var milchprodukte_div = 1;
var hulsenfruchte_div = 1;
var gemuse_div = 1;
var starkebeilagen_div = 1;
var obst_div = 1;
var krauter_div = 1;
var gewurze_und_pasten_div = 1;
var weine_und_safte_div = 1;
var gemuse2_div = 1;
var panaden_div = 1;
var nusse_div = 1;
var ole_div = 1;
var gewurzpasten_div = 1;
var trockenfruchte_div = 1
var cooking_step_counter = 1;

    $(document).ready(function () 
    {
        
        DisableAllAddButton(); // Disable all Add New Records Button

        // remove title error
        $(document).on('keyup',"#recipe_title",function(){
            if($(this).length > 0)
            {
                $(this).siblings("small").text("");
            }
        });

        $(".style-dropdown").click(function() {
        var str = $( this ).text();
        var a=$($(this).parent()).siblings();
        a.html(str);
        });
        
        // JS for scrollToTop button
        $("#scrollTop").on('click', function (event) 
        {
            if (this.hash !== "") 
            {
                event.preventDefault();
                var hash = this.hash;
                $('html, body').animate(
                    {
                        scrollTop: $(hash).offset().top
                    }, 0, function () {
                    window.location.hash = hash;
                });
            }    // End if
        });

        // Difficulty button change, change bg-color
        $("#difficulty input").click(function(){
            $("#difficulty input").removeClass("active");
            $("#difficulty input").removeAttr("checked");
            $(this).addClass('active'); 
            $(this).attr("checked","checked");
        });

        // Sharpness button change, change bg-color
        $("#sharpness input").click(function(){
            $("#sharpness input").removeClass("active");
            $("#sharpness input").removeAttr("checked");
            $(this).addClass('active'); 
            $(this).attr("checked","checked");
        });

        $(document).on('keydown',".text-input-2",function(){
            var val = $(this).val();
            if(val.length > 0)
            {
                $(this).siblings("small").text("");
            }
        });
        // Add 1 more cooking Step
        $(document).on('click','#addCookingStep',function(){
            
            var iter = $(this).parent().parent().parent().attr("id");
            $(this).parent().parent().remove();
            cooking_step_counter = parseInt(iter.substring(4));
            cooking_step_counter++;
            $("#cookingStepList").append('  <div class="container d-flex flex-column col-md-12 card form" id="step'+cooking_step_counter+'"><div class="row"> <div class="col schrit"> <h1 class="heading-main heading-c">Schritt: '+cooking_step_counter+'</h1> </div> </div> <div class="row d-flex flex-column row-border"> <div class="col-md-6 col-sm-12"> <section class="section-1"> <h5>Wie heißt der Arbeitsschritt?</h5>  <input type="hidden" name="cooking_step_id[]" value="0" /> <input type="text" class="text-input-1 form-control" name="cooking_title[]" autocomplete="off"/> </section> <section class="section-1 section-with-upload-button"> <h5>Beschreibung:</h5> <textarea class="text-input-2 form-control" name="cooking_description[]" autocomplete="off"></textarea> <small style="color:red"></small> </section> <div class="row upload-button justify-content-center"><div class="col-xs-6 col-sm-10 col-md-8 d-flex flex-row"><input class="btn btn-primary d-flex flex-row uploadbutton-input" type="button" value="Upload Bild" ><img src="form_assets/img/cute-boy-chef-look-smart_38747-11.jpg" style="width: 81px;padding-left: 0px;margin-top: 10px;margin-left: -100px;height: 71px;"></div></div></div> <div class="col-md-6 d-flex flex-column flex-shrink-1 justify-content-center flex-wrap align-items-xl-center col-hidden pic -arb"> <div class="row row-hidden"> <div class="col"> <img class="pic-arbeeaa" src="form_assets/img/cute-boy-chef-look-smart_38747-11.jpg" id="image-display'+cooking_step_counter+'"> </div> </div> <div class="row row-hidden-bild"> <div class="col button-bild"> <input class="btn btn-primary uploadbutton-hidden every-button upload-image-jquery" id="uploadImage'+cooking_step_counter+'" type="file" name="cooking_image[]" hidden> <label for="uploadImage'+cooking_step_counter+'" class="btn btn-primary uploadbutton-hidden every-button"> Upload Bild </label> </div> </div> </div> </div> <div class="row d-flex flex-row flex-grow-1 flex-shrink-1 row-button-1"> <div class="col button-after-form"> <button class="btn btn-primary btn-hide every-button" type="button" id="addCookingStep"> <strong>Weiteren Arbeitsschritt hinzufügen</strong> </button> </div> </div> </div>');
        });

        $(document).on('click',"#removeCookingStep",function(){
            $(this).parent().parent().parent().remove();
        });

        //Upload Image Button in Form
        $(document).on("change",".upload-image-jquery",function(){
            var image_input_id = $(this).attr('id');
            var formData = new FormData();
            var file = document.getElementById(image_input_id).files[0];
            formData.append("Filedata", file);
            var t = file.type.split('/').pop().toLowerCase();
            if (t != "jpeg" && t != "jpg" && t != "png" && t != "svg" && t != "webp") 
            {
                    alert('Please select a valid image file');
                    document.getElementById(image_input_id).value = '';
            }
            if (file.size > 5000000) 
            {
                alert('Max Upload size is 5MB only');
                document.getElementById(image_input_id).value = '';
            }
            var input = document.getElementById(image_input_id);
            var fReader = new FileReader();
            fReader.readAsDataURL(input.files[0]);
            fReader.onloadend = function(event)
            {   
                var img = $("#"+image_input_id).parent().parent().siblings("div").children("div.col").children('img')[0];
                img.src = event.target.result;
            }
            
        });

        var suggestions = [];
        var suggestions_id = [];
        var already_marked = [];
        // fetch suggestion for utils on input click
        $(document).on('click','#myInput',function() {
            suggestions = [];
            suggestions_id = [];
            already_marked = [];
            $(".autocomplete-items").hide();
            var ingre_type = $(this).attr('data-id');
            $.ajax({
                url:"recipeAjax.php",
                type:"POST",
                data:{req:"fetchUtils"},
                success:function(response)
                {
                    var obj = JSON.parse(response);
                    for(var i = 0; i < obj.length; i++)
                    {
                        suggestions.push(obj[i]["title"].toLowerCase());
                        suggestions_id.push(obj[i]["id"]);
                    }
                }
            })
        });
        //show suggestions of Utils
        $(document).on('keyup','#myInput',function() {
            var cur_val = $(this).val().toLowerCase();
            $(this).parent().siblings("button").attr("disabled","true");
            $(".autocomplete-items").hide();  
            $(this).siblings(".autocomplete-items").attr('id',"temp_id");
            if(cur_val.length > 0)
            {
                var result = "";
                for(var i = 0; i < suggestions.length; i++)
                {
                    if(suggestions[i].startsWith(cur_val))
                    {
                        var remaining  = suggestions[i].slice(cur_val.length,suggestions[i].length);
                        result +=  '<div><strong>'+cur_val+'</strong>'+remaining+'<img class="closebtn list-auto-b" src="form_assets/img/add.png"><input type="hidden" value="'+suggestions_id[i]+'" /></div>';
                        continue;
                    }
                }
                if(result.length > 1)
                {
                    $("#temp_id").html(result);
                    $("#temp_id").show();
                    $("#temp_id").attr("id"," ");
                }else
                {
                    $result = "<div>No Records Found</label>";
                    $("#temp_id").html(result);
                    $("#temp_id").show();
                    $("#temp_id").attr("id"," ");
                }
            }
        });

        // fetch ingredients of relevant category on input click
        $(document).on('click','.ingredients-input-supermarket',function() {
            suggestions = [];
            suggestions_id = [];
            $(".autocomplete-items").hide();
            var ingre_type = $(this).attr('data-id');
            var checkDivNo = ($(this).parent().parent().parent().parent().attr("id")).slice(-1);
            if(parseInt(checkDivNo) == 1)
            {
                already_marked = [];
            }
            $.ajax({
                url:"recipeAjax.php",
                type:"POST",
                data:{req:"fetchIngredients",section:"supermarket",type:ingre_type},
                success:function(response)
                {
                    var obj = JSON.parse(response);
                    for(var i = 0; i < obj.length; i++)
                    {
                        suggestions.push(obj[i]["title"].toLowerCase());
                        suggestions_id.push(obj[i]["id"]);
                    }
                }
            })
        });
        //show suggestions of Supermarket-ingredients
        $(document).on('keyup','.ingredients-input-supermarket',function() {
            var cur_val = $(this).val().toLowerCase();
            $(".autocomplete-items").hide();  
            $(this).siblings(".autocomplete-items").attr('id',"temp_id");
            if(cur_val.length > 0)
            {
                var result = "";
                for(var i = 0; i < suggestions.length; i++)
                {
                    if(suggestions[i].startsWith(cur_val))
                    {
                        var remaining  = suggestions[i].slice(cur_val.length,suggestions[i].length);
                        result +=  '<div><strong>'+cur_val+'</strong>'+remaining+'<img class="closebtn list-auto-b" src="form_assets/img/add.png"><input type="hidden" value="'+suggestions_id[i]+'" /></div>';
                        continue;
                    }
                }
                if(result.length > 1)
                {
                    $("#temp_id").html(unescape(result));
                    $("#temp_id").show();
                    $("#temp_id").attr("id"," ");
                }else
                {
                    $result = "<div>No Records Found</label>";
                    $("#temp_id").html(result);
                    $("#temp_id").show();
                    $("#temp_id").attr("id"," ");
                }
            }
        });

        // fetch ingredients of relevant category on input click
        $(document).on('click','.ingredients-input-fancies',function() {
            suggestions = [];
            suggestions_id = [];
            var checkDivNo = ($(this).parent().parent().parent().parent().attr("id")).slice(-1);
            if(parseInt(checkDivNo) == 1)
            {
                already_marked = [];
            }
            $(".autocomplete-items").hide();
            var ingre_type = $(this).attr('data-id');
            $.ajax({
                url:"recipeAjax.php",
                type:"POST",
                data:{req:"fetchIngredients",section:"fancies",type:ingre_type},
                success:function(response)
                {
                    var obj = JSON.parse(response);
                    for(var i = 0; i < obj.length; i++)
                    {
                        suggestions.push(obj[i]["title"].toLowerCase());
                        suggestions_id.push(obj[i]["id"]);
                    }
                }
            })
        });
        //show suggestions of fancies-ingredients
        $(document).on('keyup','.ingredients-input-fancies',function() {
            var cur_val = $(this).val().toLowerCase();
            $(".autocomplete-items").hide();  
            $(this).siblings(".autocomplete-items").attr('id',"temp_id");
            if(cur_val.length > 0)
            {
                var result = "";
                for(var i = 0; i < suggestions.length; i++)
                {
                    if(suggestions[i].startsWith(cur_val))
                    {
                        var remaining  = suggestions[i].slice(cur_val.length,suggestions[i].length);
                        result +=  '<div><strong>'+cur_val+'</strong>'+remaining+'<img class="closebtn list-auto-b" src="form_assets/img/add.png"><input type="hidden" value="'+suggestions_id[i]+'" /></div>';
                        continue;
                    }
                }
                if(result.length > 1)
                {
                    $("#temp_id").html(result);
                    $("#temp_id").show();
                    $("#temp_id").attr("id"," ");
                }else
                {
                    $result = "<div>No Records Found</label>";
                    $("#temp_id").html(result);
                    $("#temp_id").show();
                    $("#temp_id").attr("id"," ");
                }
            }
        });
        
        // hide suggestions div 
        $(document).on("click","body",function(){
            $(".autocomplete-items").hide();  
        });

        // Push Suggestion value in Input field
        $(document).on('click',".autocomplete-items div",function(){
            
            var ingre_id = $(this).children('input').val();
            var text = $(this).text();
            if(!already_marked.includes(ingre_id))
            {
                $(this).parent().siblings("input[type=text]").val(text);
                $(this).parent().siblings("input[type=hidden]").val(ingre_id);
                $(this).parent().hide();
                if($(this).parent().siblings("input[type=text]").hasClass("utils-input-css"))
                {
                    $(this).parent().parent().siblings("button").removeAttr("disabled");
                }
                already_marked.push(ingre_id);
            }
            
        });

        $(document).on('keyup',".only-numeric",function(){
            var value = $(this).val();
            if(value.length > 0)
            {
                var format = /^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)$/;
                if(format.test(value))
                {
                    $(this).removeClass("is-invalid");
                    $(this).addClass("is-valid");
                    $(this).siblings("small").text("");
                    if($(this).hasClass("menge-input"))
                    {
                        var ingre_val = $(this).parent().parent().parent().siblings(".usl-fish").children("div").children("div").children(".Fisch-input").val();
                        if(ingre_val.length > 0)
                        {
                            $(this).parent().parent().parent().siblings(".col-sm-12").children("button").removeAttr("disabled");
                        }
                    }
                }else
                {
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");
                    $(this).siblings("small").text("Nur Zahlen erlaubt");
                }
            }else
            {
                $(this).removeClass("is-invalid");
                $(this).removeClass("is-valid");
                $(this).siblings("small").text("");
                $(this).parent().parent().parent().siblings(".col-sm-12").children("button").attr("disabled","true");
            }
        });
        

        // Fetch Overview Page Along With Saving Form Data
        // $(document).on('click',"#nextButton",function(e){
        //     e.preventDefault();
        //     var utils = [];
        //     var diff_val = $("#difficulty").children(".active").val();
        //     var sharp_val = $("#sharpness").children(".active").val();
        //     $(".chip").each(function(){
        //         var val = $(this).children('.tag-text').html() ;
        //         val = $.trim(val);
        //         if(val.length > 0)
        //         {
        //             utils.push(val.toLowerCase());
        //         }
        //     });
        //     var utilsString = JSON.stringify(utils);
        //     document.getElementById("recipe").submit();
        //     $.ajax({
        //         url:"recipeAjax.php",
        //         type:"POST",
        //         data:{req:"updateDandSandU",difficulty:diff_val,sharpness:sharp_val,util:utilsString},
        //     })
        //     return false;
        // });
        
        // go back from Overview Page
        $(document).on('click',"#previousButton",function(){
            $("#main-form").show();
            $("#overview").html('');
        });

        //Link back to previous section
        $(document).on("click",".goto_button",function(){
            var link = $(this).attr("href");
            var id_from_link = link.slice(1,link.length);
            $("#main-form").show();
            $("#overview").html('');
            document.getElementById(id_from_link).scrollIntoView({behavior: 'smooth'});
        });

        //On checkbox click select that value
        $(document).on("click",".checkbox-diff",function(){
            var attr = $(this).children("div").children("input").attr("checked");
            if (typeof attr === 'undefined' || attr === false ) {
                $(this).children("div").children("input").attr("checked","checked");
            }else
            {
                $(this).children("div").children("input").removeAttr("checked");
            }
        });



        //Meat Add and Remove Records
        $(document).on('click','#meat-div div div #addMoreRecords',function (){
            meat_id++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#meat-div").append(' <div class="row nth-fish-add" id="meat-div'+meat_id+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12">  <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-supermarket form-control" name="meat[]" data-id="meat" type="text" autocomplete="off" /> <input type="hidden" name="meat_id[]"  /><div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div>  </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="meat_quantity[]" /> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge" aria-expanded="true" data-toggle="dropdown" name="meat_unit[]">  <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#meat-div div div #deleteRecords',function (){
            meat_id--;
            var id = $(this).parent().parent().attr('id');
            var abc = $(this).parent().parent().parent();
            $('#'+id).remove();
            if(meat_id == 1)
            {
                $("#meat-div").html('');
                $("#meat-div").append('<div class="row nth-fish" id="meat-div'+meat_id+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Fisch/Fleisch</h1> <input class="Fisch-input ingredients-input-supermarket form-control" name="meat[]" data-id="meat"" type="text" autocomplete="off" /><input type="hidden" name="meat_id[]"  /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="meat_quantity[]"/ > <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown  mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="meat_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select></div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            }
        });


         //Tierische Add and Remove Records
        $(document).on('click','#tierische-div div div #addMoreRecords',function (){
            tierische_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#tierische-div").append(' <div class="row nth-fish-add" id="tierische-div'+tierische_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12">  <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="animal_products[]" data-id="animal_products" autocomplete="off" /><input type="hidden" name="animal_products_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div>  </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="animal_products_quantity[]" /><small style="color:red"></small> </div> </div> </div> <div class="col-md-2 col-sm-3"><div class="dropdown dd-gramm-mo">  <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="animal_products_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div></div>  <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#tierische-div div div #deleteRecords',function (){
            tierische_div--;
            var id = $(this).parent().parent().attr('id');
            var abc = $(this).parent().parent().parent();
            $('#'+id).remove();
            if(tierische_div == 1)
            {
                $("#tierische-div").html('');
                $("#tierische-div").append('<div class="row nth-fish" id="tierische-div'+tierische_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Tierische Erzeugnisse</h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="animal_products[]" data-id="animal_products" autocomplete="off" /> <input type="hidden" name="animal_products_id[]" /><div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="animal_products_quantity[]" /> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="animal_products_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select></div> </div><div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            }
        });


        //MilchProdukte Add and Remove Records
        $(document).on('click','#milchprodukte-div div div #addMoreRecords',function (){
            milchprodukte_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#milchprodukte-div").append(' <div class="row nth-fish-add" id="milchprodukte-div'+milchprodukte_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12">  <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="dairy_products[]" data-id="dairy_products" autocomplete="off" /> <input type="hidden" name="dairy_products_id[]" /><div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div>  </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" autocomplete="off" name="dairy_products_quantity[]" /><small style="color:red"></small> </div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="dairy_products_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#milchprodukte-div div div #deleteRecords',function (){
            milchprodukte_div--;
            var id = $(this).parent().parent().attr('id');
            var abc = $(this).parent().parent().parent();
            $('#'+id).remove();
            if(milchprodukte_div == 1)
            {
                $("#milchprodukte-div").html('');
                $("#milchprodukte-div").append('<div class="row nth-fish" id="milchprodukte-div'+milchprodukte_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Milchprodukte</h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="dairy_products[]" data-id="dairy_products" autocomplete="off" /> <input type="hidden" name="dairy_products_id[]" />  <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" autocomplete="off" name="dairy_products_quantity[]" /> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="dairy_products_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select></div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            }
        });

        //Hülsenfrüchte Add and Remove Records
        $(document).on('click','#hulsenfruchte-div div div #addMoreRecords',function (){
            hulsenfruchte_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#hulsenfruchte-div").append(' <div class="row nth-fish-add" id="hulsenfruchte-div'+hulsenfruchte_div+'" > <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="legumes[]" data-id="legumes" autocomplete="off"> <input type="hidden" name="legumes_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="legumes_quantity[]" autocomplete="off"/><small style="color:red"></small> </div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="legumes_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#hulsenfruchte-div div div #deleteRecords',function (){
            hulsenfruchte_div--;
            var id = $(this).parent().parent().attr('id');
            var abc = $(this).parent().parent().parent();
            $('#'+id).remove();
            if(hulsenfruchte_div == 1)
            {
                $("#hulsenfruchte-div").html('');
                $("#hulsenfruchte-div").append('<div class="row nth-fish" id="hulsenfruchte-div'+hulsenfruchte_div+'" > <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Hülsenfrüchte</h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="legumes[]" data-id="legumes" autocomplete="off"> <input type="hidden" name="legumes_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="legumes_quantity[]" autocomplete="off"/><small style="color:red"></small> </div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="legumes_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            }
        });


         //Gemuse Add and Remove Records
         $(document).on('click','#gemuse-div div div #addMoreRecords',function (){
            gemuse_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#gemuse-div").append(' <div class="row nth-fish-add" id="gemuse-div'+gemuse_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="vegetables[]" data-id="vegetables" autocomplete="off"> <input type="hidden" name="vegetables_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="vegetables_quantity[]" autocomplete="off"/> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="vegetables_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#gemuse-div div div #deleteRecords',function (){
            gemuse_div--;
            var id = $(this).parent().parent().attr('id');
            var abc = $(this).parent().parent().parent();
            $('#'+id).remove();
            if(gemuse_div == 1)
            {
                $("#gemuse-div").html('');
                $("#gemuse-div").append('<div class="row nth-fish" id="gemuse-div'+gemuse_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Gemüse</h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="vegetables[]" data-id="vegetables" autocomplete="off"> <input type="hidden" name="vegetables_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="vegetables_quantity[]" autocomplete="off"/> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="vegetables_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            }
        });

        
         //Stärkebeilagen Add and Remove Records
         $(document).on('click','#starkebeilagen-div div div #addMoreRecords',function (){
            starkebeilagen_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#starkebeilagen-div").append(' <div class="row nth-fish-add" id="starkebeilagen-div'+starkebeilagen_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="starch[]" data-id="starch" autocomplete="off" /> <input type="hidden" name="starch_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="starch_quantity[]" autocomplete="off"/> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="starch_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>')
            DisableAllAddButton();
        });
        $(document).on('click','#starkebeilagen-div div div #deleteRecords',function (){
            starkebeilagen_div--;
            var id = $(this).parent().parent().attr('id');
            var abc = $(this).parent().parent().parent();
            $('#'+id).remove();
            if(starkebeilagen_div == 1)
            {
                $("#starkebeilagen-div").html('');
                $("#starkebeilagen-div").append('<div class="row nth-fish" id="starkebeilagen-div'+starkebeilagen_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Stärkebeilagen</h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="starch[]" data-id="starch" autocomplete="off" /> <input type="hidden" name="starch_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="starch_quantity[]" autocomplete="off" /> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="starch_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>')
            }
        });

          //Obst Add and Remove Records
        $(document).on('click','#obst-div div div #addMoreRecords',function (){
            obst_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#obst-div").append(' <div class="row nth-fish-add" id="obst-div'+obst_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="fruits[]" data-id="fruits" autocomplete="off"/> <input type="hidden" name="fruits_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="fruits_quantity[]" autocomplete="off"/><small style="color:red"></small> </div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="fruits_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#obst-div div div #deleteRecords',function (){
            obst_div--;
            var id = $(this).parent().parent().attr('id');
            var abc = $(this).parent().parent().parent();
            $('#'+id).remove();
            if(obst_div == 1)
            {
                $("#obst-div").html('');
                $("#obst-div").append(' <div class="row nth-fish" id="obst-div'+obst_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Obst</h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="fruits[]" data-id="fruits" autocomplete="off"/> <input type="hidden" name="fruits_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="fruits_quantity[]" autocomplete="off"/><small style="color:red"></small> </div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="fruits_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            }
        });
        
         //Kräuter Add and Remove Records
         $(document).on('click','#krauter-div div div #addMoreRecords',function (){
            krauter_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#krauter-div").append(' <div class="row nth-fish-add" id="krauter-div'+krauter_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="herbs[]" data-id="herbs" autocomplete="off" /> <input type="hidden" name="herbs_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="herbs_quantity[]" autocomplete="off"/> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="herbs_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#krauter-div div div #deleteRecords',function (){
            krauter_div--;
            var id = $(this).parent().parent().attr('id');
            var abc = $(this).parent().parent().parent();
            $('#'+id).remove();
            if(krauter_div == 1)
            {
                $("#krauter-div").html('');
                $("#krauter-div").append(' <div class="row nth-fish" id="krauter-div'+krauter_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Kräuter</h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="herbs[]" data-id="herbs" autocomplete="off"/> <input type="hidden" name="herbs_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="herbs_quantity[]" autocomplete="off"/><small style="color:red"></small> </div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="herbs_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            }
        });


        //Weine und Säfte, Add and Remove Records
        $(document).on('click','#weine_und_safte-div div div #addMoreRecords',function (){
            weine_und_safte_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#weine_und_safte-div").append(' <div class="row nth-fish-add" id="weine_und_safte-div'+weine_und_safte_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="juices[]" data-id="juices" autocomplete="off"/> <input type="hidden" name="juices_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="juices_quantity[]" autocomplete="off"/> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="juices_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#weine_und_safte-div div div #deleteRecords',function (){
            weine_und_safte_div--;
            var id = $(this).parent().parent().attr('id');
            var abc = $(this).parent().parent().parent();
            $('#'+id).remove();
            if(weine_und_safte_div == 1)
            {
                $("#weine_und_safte-div").html('');
                $("#weine_und_safte-div").append('<div class="row nth-fish" id="weine_und_safte-div'+weine_und_safte_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Weine und Säfte</h1> <input class="Fisch-input ingredients-input-supermarket form-control" type="text" name="juices[]" data-id="juices" autocomplete="off"/> <input type="hidden" name="juices_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="juices_quantity[]" autocomplete="off"/> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="juices_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            }
        });
        


         //Gewürze Add and Remove Records
         $(document).on('click','#gewurze-div div div #addMoreRecords',function (){
            gemuse2_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#gewurze-div").append(' <div class="row nth-fish-add" id="gewurze-div'+gemuse2_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="spices[]" data-id="spices" autocomplete="off"/> <input type="hidden" name="spices_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> <!-- Data will be loaded using AJAX --> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="spices_quantity[]" autocomplete="off" /> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="spices_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#gewurze-div div div #deleteRecords',function (){
            gemuse2_div--;
            var id = $(this).parent().parent().attr('id');
            var abc = $(this).parent().parent().parent();
            $('#'+id).remove();
            if(gemuse2_div == 1)
            {
                $("#gewurze-div").html('');
                $("#gewurze-div").append(' <div class="row nth-fish" id="gewurze-div'+gemuse2_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Gewürze</h1> <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="spices[]" data-id="spices" autocomplete="off" /> <input type="hidden" name="spices_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> <!-- Data will be loaded using AJAX --> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="spices_quantity[]" autocomplete="off"/><small style="color:red"></small> </div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="spices_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            }
        });


        //Panaden / Brösel, Add and Remove Records
        $(document).on('click','#panaden-div div div #addMoreRecords',function (){
            panaden_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#panaden-div").append(' <div class="row nth-fish-add" id="panaden-div'+panaden_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="breadcrumbs[]" data-id="breadcrumbs" autocomplete="off"/> <input type="hidden" name="breadcrumbs_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> <!-- Data will be loaded using AJAX --> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="breadcrumbs_quantity[]" autocomplete="off"/><small style="color:red"></small> </div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="breadcrumbs_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#panaden-div div div #deleteRecords',function (){
            panaden_div--;
            var id = $(this).parent().parent().attr('id');
            var abc = $(this).parent().parent().parent();
            $('#'+id).remove();
            if(panaden_div == 1)
            {
                $("#panaden-div").html('');
                $("#panaden-div").append('<div class="row nth-fish" id="panaden-div'+panaden_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Panaden / Brösel</h1> <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="breadcrumbs[]" data-id="breadcrumbs" autocomplete="off"/> <input type="hidden" name="breadcrumbs_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> <!-- Data will be loaded using AJAX --> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="breadcrumbs_quantity[]" autocomplete="off" /> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="breadcrumbs_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            }
        });


        //Nüsse und Kerne, Add and Remove Records
        $(document).on('click','#nusse-div div div #addMoreRecords',function (){
            nusse_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#nusse-div").append(' <div class="row nth-fish-add" id="nusse-div'+nusse_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="nuts[]" data-id="nuts" autocomplete="off"/> <input type="hidden" name="nuts_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> <!-- Data will be loaded using AJAX --> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="nuts_quantity[]" autocomplete="off" /><small style="color:red"></small> </div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="nuts_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#nusse-div div div #deleteRecords',function (){
            nusse_div--;
            var id = $(this).parent().parent().attr('id');
            var abc = $(this).parent().parent().parent();
            $('#'+id).remove();
            if(nusse_div == 1)
            {
                $("#nusse-div").html('');
                $("#nusse-div").append('<div class="row nth-fish" id="nusse-div'+nusse_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Nüsse und Kerne</h1> <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="nuts[]" data-id="nuts" autocomplete="off"/> <input type="hidden" name="nuts_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> <!-- Data will be loaded using AJAX --> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="nuts_quantity[]" autocomplete="off" /> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="nuts_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" type="button" id="addMoreRecords">Hinzufügen</button> </div> </div>');
            }
        });

        //Öle, Soßen, Essig, Add and Remove Records
        $(document).on('click','#ole-div div div #addMoreRecords',function (){
            ole_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#ole-div").append(' <div class="row nth-fish-add" id="ole-div'+ole_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="oils[]" data-id="oils" autocomplete="off"/> <input type="hidden" name="oils_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> <!-- Data will be loaded using AJAX --> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="oils_quantity[]" autocomplete="off"/> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="oils_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" id="addMoreRecords" type="button">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#ole-div div div #deleteRecords',function (){
            ole_div--;
            var id = $(this).parent().parent().attr('id');
            $('#'+id).remove();
            if(ole_div == 1)
            {
                $("#ole-div").html('');
                $("#ole-div").append(' <div class="row nth-fish" id="ole-div'+ole_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Öle, Soßen, Essig</h1> <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="oils[]" data-id="oils" autocomplete="off"/> <input type="hidden" name="oils_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> <!-- Data will be loaded using AJAX --> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="oils_quantity[]" autocomplete="off"/> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="oils_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" id="addMoreRecords" type="button">Hinzufügen</button> </div> </div>');
            }
        });

         //Gewürzpasten, Add and Remove Records
         $(document).on('click','#gewurzpasten-div div div #addMoreRecords',function (){
            gewurzpasten_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#gewurzpasten-div").append(' <div class="row nth-fish-add" id="gewurzpasten-div'+gewurzpasten_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="spice_paste[]" data-id="spice_paste" autocomplete="off"/> <input type="hidden" name="spice_paste_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> <!-- Data will be loaded using AJAX --> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="spice_paste_quantity[]" autocomplete="off"/> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="spice_paste_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" id="addMoreRecords" type="button">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#gewurzpasten-div div div #deleteRecords',function (){
            gewurzpasten_div--;
            var id = $(this).parent().parent().attr('id');
            $('#'+id).remove();
            if(gewurzpasten_div == 1)
            {
                $("#gewurzpasten-div").html('');
                $("#gewurzpasten-div").append(' <div class="row nth-fish" id="gewurzpasten-div'+gewurzpasten_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Gewürzpasten</h1> <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="spice_paste[]" data-id="spice_paste" autocomplete="off"/> <input type="hidden" name="spice_paste_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> <!-- Data will be loaded using AJAX --> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="spice_paste_quantity[]" autocomplete="off"/> <small style="color:red"></small> </div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="spice_paste_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" id="addMoreRecords" type="button">Hinzufügen</button> </div> </div>');
            }
        });

         //Trockenfrüchte, Add and Remove Records
         $(document).on('click','#trockenfruchte-div div div #addMoreRecords',function (){
            trockenfruchte_div++;
            $(this).attr('id','deleteRecords');
            $(this).html('Entfernen');
            $("#trockenfruchte-div").append(' <div class="row nth-fish-add" id="trockenfruchte-div'+trockenfruchte_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title"></h1> <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="driedfruits[]" data-id="driedfruits" autocomplete="off"/> <input type="hidden" name="driedfruits_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> <!-- Data will be loaded using AJAX --> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm"></h1> <input type="text" class="form-control menge-input only-numeric" name="driedfruits_quantity[]" autocomplete="off"/> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="driedfruits_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary button-hera" id="addMoreRecords" type="button">Hinzufügen</button> </div> </div>');
            DisableAllAddButton();
        });
        $(document).on('click','#trockenfruchte-div div div #deleteRecords',function (){
            trockenfruchte_div--;
            var id = $(this).parent().parent().attr('id');
            $('#'+id).remove();
            if(trockenfruchte_div == 1)
            {
                $("#trockenfruchte-div").html('');
                $("#trockenfruchte-div").append(' <div class="row nth-fish" id="trockenfruchte-div'+trockenfruchte_div+'"> <div class="col-md-5 col-sm-5 usl-fish"> <div class="row fisch"> <div class="col-md-12"> <h1 class="heading-sm-title">Trockenfrüchte</h1> <input class="Fisch-input ingredients-input-fancies form-control" type="text" name="driedfruits[]" data-id="driedfruits" autocomplete="off"/> <input type="hidden" name="driedfruits_id[]" /> <div id="" class="autocomplete-items list-auto-a list-a-a-a"> <!-- Data will be loaded using AJAX --> </div> </div> </div> </div> <div class="col-md-2 col-sm-3 usl-menge"> <div class="row"> <div class="col-md-12"> <h1 class="heading-sm">Menge</h1> <input type="text" class="form-control menge-input only-numeric" name="driedfruits_quantity[]" autocomplete="off"/> <small style="color:red"></small></div> </div> </div> <div class="col-md-2 col-sm-3"> <div class="dropdown mt-4 dd-gramm-mo"> <select class="btn btn-primary dropdown-toggle dd-after-menge button-gramm" aria-expanded="true" data-toggle="dropdown" name="driedfruits_unit[]"> <div class="dropdown-menu"> <option class="dropdown-item style-dropdown" value="gramm">Gramm</option> <option class="dropdown-item style-dropdown" value="milliliter">Milliliter</option> <option class="dropdown-item style-dropdown" value="stück">Stück</option> <option class="dropdown-item style-dropdown" value="dose">Dose</option> </div> </select> </div> </div> <div class="col-md-2 col-sm-12" > <button class="btn btn-primary mt-4 button-hera" id="addMoreRecords" type="button">Hinzufügen</button> </div> </div>');
            }
        });

        

      
        
    });

    function DisableAllAddButton()
    {
        //By Default Disbale Add New Records Button
        $("button.button-hera").each(function(){
            var id = $(this).attr("id");
            if($(this).hasClass("not-disabled"))
            {
                $(this).removeAttr("disabled");
            }else
            {
                if(id == "addMoreRecords")
                {
                    $(this).attr("disabled","true");
                }else if(id="deleteRecords")
                {
                    $(this).removeAttr("disabled");
                }
            }  
        })
    }
