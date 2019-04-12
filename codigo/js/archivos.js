$(()=>{
    $(".borrarArchivo").on('click', function(e){
        let idArchivo = $(this).attr("id");
        const caso = 'borrarArchivo';
        $.post("includes/procesaEdicionBBDD.php",
                { caso : caso, id : idArchivo},
                function(data) {
                    document.location.href = 'perfil.php';
        }); 
    });

});