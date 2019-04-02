<?php
if(isset($_POST['selector'][0]) && !empty($_POST['selector'][0])) {
    $selector = $_POST['selector'][0];
    switch($selector) {
        case 'grado':
            $options = Usuario::creaOpcionesGrados($_POST['selector'][1]);
            
            break;
        case 'curso':
            test();
            break;
        case 'asignatura':
            test();
            break;
    }
    
}
?>