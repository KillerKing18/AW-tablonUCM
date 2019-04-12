$(()=>{
    $(".icono-cabecera").filter(".active").removeClass("active");
        
    $.post("includes/procesaSeccion.php",
                { },
                function(data) {
                    $("#" + data).addClass("active");
        });
});