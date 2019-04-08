$(document).ready(function(){
//TODO setCustomValidity
    $("#form-upload").attr("enctype", "multipart/form-data");

    $("#form-upload").submit(function(){
        for(var i = 0; i < $(".selector").length; i++){
            if ($(".selector")[i].selectedIndex == 0) {
                return false;
            }
        }
        
        if (!$("#archivo").val()) {
            return false;
        }
    });

    $(".selector").change(function(){
        const caso = this.id;
        const id = '#' + this.id;
        let facultad = '';
        let grado = '';
        let curso = '';
        
        switch(caso){
            case 'facultad':
                facultad = this.value;
                break;
            case 'grado':
                facultad = $(this).prevAll("#facultad").val();
                grado = this.value;
                break;
            case 'curso':
                facultad = $(this).prevAll("#facultad").val();
                grado = $(this).prevAll("#grado").val();
                curso = this.value;
                break;
            case 'asignatura':
                facultad = $(this).prevAll("#facultad").val();
                grado = $(this).prevAll("#grado").val();
                curso = $(this).prevAll("#curso").val();
                break;
        }
        $(this).nextAll(".selector").prop("disabled", false);
        if(caso !== 'asignatura'){
            $(this).nextAll(".selector").nextAll(".selector").prop("disabled", true);
            $(this).nextAll(".selector").nextAll(".selector").prop("value", 0);
        }
        $.post("includes/procesaSelectores.php",
            { caso : caso, facultad : facultad, grado : grado, curso : curso},
            function(data) {
                $(id).nextAll(".selector:first").html(data);
        });

    });
});