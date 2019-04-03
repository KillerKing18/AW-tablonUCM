<?php
require_once __DIR__.'/includes/Universidad.php';

$caso = isset($_POST['caso']) ? $_POST['caso'] : null;
$facultad = isset($_POST['facultad']) ? $_POST['facultad'] : null;
$grado = isset($_POST['grado']) ? $_POST['grado'] : null;
$curso = isset($_POST['curso']) ? $_POST['curso'] : null;
$result = '';
switch($caso){
    case 'grado':
        $result = Universidad::creaOpcionesGrados($facultad);
    break;
    case 'curso':
        $result = Universidad::creaOpcionesCursos($facultad, $grado);
    break;
    case 'asignatura':
        $result = Universidad::creaOpcionesAsignaturas($facultad, $grado, $curso);
    break;
}
echo $result;

?>