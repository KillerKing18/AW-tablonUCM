$(()=>{
    $("#password1").on("invalid", function(e) {
        $(this)[0].setCustomValidity("La contraseña debe tener una longitud mínima de 7 caracteres y contener al menos un dígito, una letra minúscula y una letra mayúscula");
    });
    
    $(".validacion").on("input", function(e) {
        let text = $(this).val();
        let id = $(this).attr("id");
        let caso = "";
        let ajax = false;
        
        switch(id){
            case "usuarioCambio":
                caso = "usuario";
                ajax = true;
                break;
            case "usuarioRegistro":
                caso = "usuario";
                ajax = true;
                break;
            case "password1":
                otherPasswordID = $("#password2").attr("id");
                break;
            case "password2":
                otherPasswordID = $("#password1").attr("id");
                break;
                case "usuarioLogin":
                caso = "usuario";
                ajax = true;
                break;
            case "email":
                caso = "email";
                ajax = true;
                break;
        }
        if(ajax){
            $.post("includes/procesaValidacion.php",
                    { caso : caso, text : text},
                    function(data) {
                        if (id === "usuarioRegistro")
                            $("#" + id)[0].setCustomValidity(data == 1 ? "Ya existe un usuario con ese nombre" : "");
                        else if (id === "usuarioLogin")
                            $("#" + id)[0].setCustomValidity(data == 1 ? "" : "No existe ningún usuario con ese nombre");
                        else if (id === "usuarioCambio") {
                            if (data == -1)
                                $("#" + id)[0].setCustomValidity("Tu nuevo nombre de usuario no puede ser el mismo que el antiguo");
                            if (data == 0)
                                $("#" + id)[0].setCustomValidity("");
                            if (data == 1)
                                $("#" + id)[0].setCustomValidity("Ya existe un usuario con ese nombre");
                        }
                        else if (id === "email")
                            $("#" + id)[0].setCustomValidity(data == 1 ? "Tu nuevo email no puede ser el mismo que el antiguo" : "");
            });
        }
        else{
            let textOtherPassword = $("#" + otherPasswordID).val();
            $("#" + otherPasswordID)[0].setCustomValidity("");
            if(textOtherPassword !== "")
                $("#" + id)[0].setCustomValidity(text === textOtherPassword ? "" : "Las contraseñas no coinciden");
        }
    });
});