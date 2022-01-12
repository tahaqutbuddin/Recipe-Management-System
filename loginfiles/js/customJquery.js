$(document).ready(function(){
    $(".text-validate").keyup(function(){
        var test = /^[a-zA-ZäöüßÄÖÜ]+$/;
        var string = $(this).val();
        
        if(string.length > 0)
        {
            if(string.match(test))
            {
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
                $(this).siblings("small").html("");
            }else
            {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
                $(this).siblings("small").html("Sollte nur Zeichen enthalten");
            }
        }else
        {
            $(this).removeClass("is-valid");
            $(this).removeClass("is-invalid");
            $(this).siblings("small").html("");
        }
    });
    $(".email-validate").keyup(function(){
        var test = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var string = $(this).val();
        if(string.length > 0)
        {
            if(string.match(test))
            {
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
                $(this).siblings("small").html("");
            }else
            {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
                $(this).siblings("small").html("Es werden nur Google Mail-Konten akzeptiert");
            }
        }else
        {
            $(this).removeClass("is-valid");
            $(this).removeClass("is-invalid");
            $(this).siblings("small").html("");
        }
    });
    $(".password-validate").keyup(function(){
        var test = /^(?=.*[A-Za-zäöüßÄÖÜ])(?=.*\d)[A-Za-zäöüßÄÖÜ\d]{10,}$/;
        var string = $(this).val();
        
        if(string.length > 0)
        {
            if(string.match(test))
            {
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
                $(this).siblings("small").html("");
            }else
            {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
                $(this).siblings("small").html("Mindestens 10 Zeichen, mindestens ein Buchstabe und eine Zahl");
            }
        }else
        {
            $(this).removeClass("is-valid");
            $(this).removeClass("is-invalid");
            $(this).siblings("small").html("");
        }
    });
    $(".cnfmpass").keyup(function(){
        var test = /^(?=.*[A-Za-zäöüßÄÖÜ])(?=.*\d)[A-Za-zäöüßÄÖÜ\d]{10,}$/;
        var string = $(this).val();
        if(string.length > 0)
        {
            if(string.match(test))
            {
                var opass = $(".password-validate").val();
                if(opass.length > 0)
                {
                    if(string == opass)
                    {
                        $(this).removeClass("is-invalid");
                        $(this).addClass("is-valid");
                        $(this).siblings("small").html("");
                    }else
                    {
                        $(this).removeClass("is-valid");
                        $(this).addClass("is-invalid");
                        $(this).siblings("small").html("Beide Passwörter stimmen nicht überein");
                    }
                }else
                {
                    $(this).removeClass("is-valid");
                    $(this).removeClass("is-invalid");
                    $(this).siblings("small").html("");
                }
            }else
            {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
                $(this).siblings("small").html("Mindestens 10 Zeichen, mindestens ein Buchstabe und eine Zahl");
            }
        }else
        {
            $(this).removeClass("is-valid");
            $(this).removeClass("is-invalid");
            $(this).siblings("small").html("");
        }
    });
});