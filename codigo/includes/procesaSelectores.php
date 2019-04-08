<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/Universidad.php';

$caso = $_POST['caso'];
$facultad = isset($_POST['facultad']) ? $_POST['facultad'] : null;
$grado = isset($_POST['grado']) ? $_POST['grado'] : null;
$curso = isset($_POST['curso']) ? $_POST['curso'] : null;
$result = '';
switch($caso){
    case 'facultad':
        $result = Universidad::creaOpcionesGrados($facultad);
    break;
    case 'grado':
        $result = Universidad::creaOpcionesCursos($facultad, $grado);
    break;
    case 'curso':
        $result = Universidad::creaOpcionesAsignaturas($facultad, $grado, $curso);
    break;
    case 'asignatura':
        $result = Universidad::creaOpcionesCategorias();
    break;
}
echo $result;

?>