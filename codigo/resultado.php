<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Archivo.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="estilo.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Resultado</title>
</head>

<body>

    <div id="contenedor">

        <?php
	        require("includes/comun/cabecera.php");
        ?>

        <div id="contenido">
            <div class="archivo">
                <?php
                    if(!isset($_REQUEST['id'])){
                        $facultad = $_REQUEST['facultad'];
                        $grado = $_REQUEST['grado'];
                        $curso = $_REQUEST['curso'];
                        $asignatura = $_REQUEST['asignatura'];
                        $html = isset($_REQUEST['categoria']) ? Archivo::generaBusquedaEspecifica($facultad, $grado, $curso, $asignatura, $_REQUEST['categoria']) : Archivo::generaBusquedaGeneral($facultad, $grado, $curso, $asignatura);
                        crearArchivosZIP($facultad, $grado, $curso, $asignatura);
                        echo $html;
                    }
                    else{
                        $id = $_REQUEST["id"];
                        $archivo = Archivo::devuelveObjetoArchivo($id);
                        echo $archivo->creaTablaArchivo();
                        echo '<embed src="' . $archivo->facultad() . '/' . $archivo->grado() . '/' . $archivo->curso() . '/' . $archivo->asignatura() . '/' . $archivo->categoria() . '/' . $archivo->nombre() . '" width="800px" height="700px" />';
                        echo '<a href="' . $archivo->facultad() . '/' . $archivo->grado() . '/' . $archivo->curso() . '/' . $archivo->asignatura() . '/' . $archivo->categoria() . '/' . $archivo->nombre() . '" download="'. $archivo->nombre() . '">Descargar archivo</a>';
                    }

                    function crearArchivosZIP($facultad, $grado, $curso, $asignatura){
                        $zipAsignatura = new ZipArchive;
                        if ($zipAsignatura->open('zip/' . $asignatura . '.zip', ZipArchive::CREATE) === TRUE)
                        {
                            $categorias = ['Teoría', 'Prácticas', 'Exámenes', 'Ejercicios'];
                            foreach($categorias as $categoria){
                                $path = $facultad . '/' . $grado . '/' . $curso . '/' . $asignatura . '/' . $categoria;
                                $zipCategoria = new ZipArchive;
                                if ($zipCategoria->open('zip/' . $asignatura . ' - ' . $categoria . '.zip', ZipArchive::CREATE) === TRUE)
                                {
                                    if ($dir = opendir($path))
                                        while (false !== ($entrada = readdir($dir)))
                                            if ($entrada != "." && $entrada != ".." && !is_dir($categoria . '/' . $entrada))
                                            {
                                                $zipAsignatura->addFile($path . '/' . $entrada, $asignatura . '/' . $categoria . '/' . $entrada);
                                                $zipCategoria->addFile($path . '/' . $entrada, $asignatura . ' - ' . $categoria . '/' . $entrada);
                                            }
                                        closedir($dir);
                                    $zipCategoria->close();
                                }
                            }
                            $zipAsignatura->close();
                        }
                    }
                ?>
            </div>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>


    </div>
</body>

</html>