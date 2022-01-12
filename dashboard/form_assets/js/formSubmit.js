 // Fetch Overview Page Along With Saving Form Data
 $(document).on('click',"#nextButton",function(e){
    e.preventDefault();
    if(SaveInitialDetails())
    {
        SaveCheckBox("diet");
        SaveCheckBox("animal_products");
        SaveCheckBox("allergen");
        SaveCheckBox("home_equipment");
        SaveNutritionalInfo();
        SaveTechnicalDetails();
        SaveDiffAndSharp();
        SaveSupermarketIngredients();
        SaveFanciesIngredients();
        SaveUtils();
        SaveCookingSteps();
    }
    return false;
});

function SaveInitialDetails()
{
    var arr = [];
    var flag = false;
    if($("#recipe_title").val().length > 0)
    {
        if($("#recipe_description").val().length > 0)
        {
            arr.push($("#recipe_title").val());
            arr.push($("#recipe_description").val());
        }else
        {
            arr.push($("#recipe_title").val());
        } 
        if(arr.length > 0)
        {
            $.ajax({
                url:"recipeAjax.php",
                type:"POST",
                data:{req:"SaveFormDataInitial",values:arr},
                success:function()
                {
                    flag = true;
                }
            });
            return true;
        }
    }else
    {
        $("#recipe_title").siblings("small").text("Der Rezepttitel ist obligatorisch");
        document.getElementById("recipe_title").scrollIntoView();
    }
    
}

function SaveCheckBox(type)
{
    var arr = [];
    $("#"+type).children("div.row").children("div.col-md-12").children('button.checkbox-diff').each(function(){
        if($(this).children('div').children('input[type=checkbox]').is(":checked") == true)
        {
            var val = $(this).children('div').children('input[type=checkbox]').val();
            arr.push(val.toLowerCase());
        }
    });
    if(arr.length > 0)
    {
        $.ajax({
            url:"recipeAjax.php",
            type:"POST",
            data:{req:"SaveFormDataCheckbox",type:type,values:arr},
        });
    }
}

function SaveNutritionalInfo()
{
    var arr = [];
    $("#nutritional").children("div").each(function(){
        if( $(this).children('input').val() )
        {
            var val = $(this).children('input').val();
            arr.push( parseInt(val) );
        }
    });
    if(arr.length > 0)
    {
        $.ajax({
            url:"recipeAjax.php",
            type:"POST",
            data:{req:"SaveNutritional",values:arr},
        });
    }
}

function SaveTechnicalDetails()
{
    var arr = [];
    $("#technical").siblings('div').children("div").each(function(){
        if( $(this).children('input').val() )
        {
            var val = $(this).children('input').val();
            arr.push( parseInt(val) );
        }
    });
    if(arr.length > 0)
    {
        $.ajax({
            url:"recipeAjax.php",
            type:"POST",
            data:{req:"SaveTechnical",values:arr},
        });
    }
}

function SaveDiffAndSharp()
{
    var arr = [];
    var diff_val = $("#difficulty").children(".active").val();
    var sharp_val = $("#sharpness").children(".active").val();
    arr.push(diff_val);
    arr.push(sharp_val);
    if(arr.length > 0)
    {
        $.ajax({
            url:"recipeAjax.php",
            type:"POST",
            data:{req:"SaveDAndS",values:arr},
        });
    }
}

function SaveSupermarketIngredients()
{
    var main_arr = [];
    var all_ingre_types = ["meat-div","tierische-div","milchprodukte-div","hulsenfruchte-div","gemuse-div","starkebeilagen-div","obst-div","krauter-div","weine_und_safte-div"];
    for(let i = 0; i < all_ingre_types.length; i++)
    {
        var arr = [];
        $output = "";
        ingredient_div = all_ingre_types[i];
        $("#"+ingredient_div).children('div').each(function()
        {
            if( $(this).children('div.usl-fish').children('div').children('div').children('input[type=hidden]').val() )
            {
                if( $(this).children('div.usl-menge').children('div').children('div').children('input').val() )
                {
                    if( $(this).children('div').children('div.dropdown').children('select').children("option:selected").val() )
                    {
                        var ingre_id = $(this).children('div.usl-fish').children('div').children('div').children('input[type=hidden]').val();
                        var quantity = $(this).children('div.usl-menge').children('div').children('div').children('input').val();
                        var unit = $(this).children('div').children('div.dropdown').children('select').children("option:selected").val();
                        var output = '('+ingre_id+'/'+quantity+'/'+unit+')';
                        arr.push(output);
                    }
                }
            }
        });
        main_arr.push(arr.join(','));
    }
    $.ajax({
        url:"recipeAjax.php",
        type:"POST",
        data:{req:"SaveSupermarketIngredients",values:main_arr},
    });
}

function SaveFanciesIngredients()
{
    var main_arr = [];
    var all_ingre_types = ["gewurze-div","panaden-div","nusse-div","ole-div","gewurzpasten-div","trockenfruchte-div"];
    for(let i = 0; i < all_ingre_types.length; i++)
    {
        var arr = [];
        $output = "";
        ingredient_div = all_ingre_types[i];
        $("#"+ingredient_div).children('div').each(function()
        {
            if( $(this).children('div.usl-fish').children('div').children('div').children('input[type=hidden]').val() )
            {
                if( $(this).children('div.usl-menge').children('div').children('div').children('input').val() )
                {
                    if( $(this).children('div').children('div.dropdown').children('select').children("option:selected").val() )
                    {
                        var ingre_id = $(this).children('div.usl-fish').children('div').children('div').children('input[type=hidden]').val();
                        var quantity = $(this).children('div.usl-menge').children('div').children('div').children('input').val();
                        var unit = $(this).children('div').children('div.dropdown').children('select').children("option:selected").val();
                        var output = '('+ingre_id+'/'+quantity+'/'+unit+')';
                        arr.push(output);
                    }
                }
            }
        });
        main_arr.push(arr.join(','));
    }
    $.ajax({
        url:"recipeAjax.php",
        type:"POST",
        data:{req:"SaveFanciesIngredients",values:main_arr},
    });
}

function SaveUtils()
{
    var arr = [];
    $("#save-tag").children("div.chip").each(function()
    {
        var tag_id = $(this).children("input[type=hidden]").val();
        var output = '('+tag_id+')';
        arr.push(output);
    });

    $.ajax({
        url:"recipeAjax.php",
        type:"POST",
        data:{req:"SaveUtils",values:arr},
    });
}

function SaveCookingSteps()
{
    var cnt = 1;
    var arr = [];
    var values_arr = [];
    var flag = false;
    var fd = new FormData();
    $("#cookingStepList").children("div").each(function(){
        var title = $(this).children("div.row-border").children("div").children("section.section-1").children("input[type=text]").val() ;
        var desc = $(this).children("div.row-border").children("div").children("section.section-with-upload-button").children("textarea").val();
        if(title.length > 0)
        {
            if(desc.length > 0)
            {
                var files = $(this).children("div.row-border").children("div.pic").children("div.row-hidden-bild").children("div.button-bild").children(".upload-image-jquery")[0].files;
                if(files.length > 0)
                {
                    var image_name = files[0]["name"];  
                    if(image_name)
                    {
                        arr = [];
                        fd.append('file[]',files[0]);
                        console.log(files[0]["name"]);
                        arr.push(title);
                        arr.push(desc);
                        flag = true;
                        cnt++;
                    } 
                }else
                {
                    alert("Bitte Bild für Schritt einfügen "+cnt);
                    flag = false;
                }
            }else
            {
                $(this).children("div.row-border").children("div").children("section.section-with-upload-button").children("textarea").siblings("small").text("Bitte geben Sie auch die Beschreibung ein");
                flag = false;
            }
        }
        if(arr.length > 0)
        {
            values_arr.push(arr);
        }
    });
      
    if(flag)
    {
        var image_arr = [];
        $("#main-form").fadeOut();
        $('#form_loader').show();
        $.ajax({
            url:"upload.php",
            type:"POST",
            data:fd,
            contentType: false,
            processData: false,
            success:function(response)
            {
                image_arr = JSON.parse(response);
                console.log(response);
                if((values_arr.length > 0 ) && (image_arr.length > 0) && (values_arr.length == image_arr.length) ){
                    $.ajax({
                        url: 'recipeAjax.php',
                        type: 'POST',
                        data: {req:"SaveCookingSteps",values:values_arr,images:image_arr},
                        success:function()
                        {
                            $('#form_loader').hide();
                            $("#main-form").fadeIn();
                            loadOverviewPage();
                        }
                    });
                }else
                {
                    $('#form_loader').hide();
                    $("#main-form").fadeIn();
                    console.log(image_arr);
                    console.log(image_arr.length);
                    console.log(values_arr.length);
                    alert("Internal Error in Cooking Steps");  
                }
            }
        });
    }
}

function loadOverviewPage()
{
    if(window.matchMedia("(max-width: 576px)").matches){
        $.ajax({
            url:"recipeAjax.php",
            type:"POST",
            data:{req:"overviewPageMobile"},
            success:function(response)
            {
                $("#main-form").hide();
                $("#overview").html(response);
                $("#overview").show();
            }
        })
    }
    $.ajax({
        url:"recipeAjax.php",
        type:"POST",
        data:{req:"overviewPage"},
        success:function(response)
        {
            $("#main-form").hide();
            $("#overview").html(response);
            $("#overview").show();
        }
    })
}
