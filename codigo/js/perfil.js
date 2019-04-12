// Para mostrar la informacion actualizada en caso de que se haya actualizado
// el nombre de usuario, el email o la imagen, debemos obtener esa informacion
// despues de que se llame a los metodos gestiona de cada uno de estos formularios.
// De lo contrario, estariamos obteniendo la informacion de antes de actualizar.
// Para ello usamos este jquery para coger el html del de info provisional y darselo 
// al div de info final, para que se muestre la informacion antes que los formularios.
$(()=>{
    const info = $(".info").filter("#provisional").html();
    $(".info").filter("#provisional").html('');
    $(".info").filter("#final").html(info);

    $("#imagen").hide();

    $("#subirImagen").on('click', function(e){
        e.preventDefault();
        $("#imagen").trigger('click');
    });

    $("#form-borrarCuenta").on('submit', function(e){
        if(!confirm('¿Estás seguro/a de que quieres borrar tu cuenta?'))
        return false;
    });

    $("#imagen").change(function() {
        $("#form-imagen").submit();
    });

    $("#form-imagen").attr("enctype", "multipart/form-data");
});