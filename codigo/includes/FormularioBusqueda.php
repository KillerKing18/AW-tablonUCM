<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Universidad.php';
require_once __DIR__.'/Archivo.php';

class FormularioBusqueda extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
		$options = Universidad::creaOpcionesFacultades();

        return  '<label>Facultad</label>
                <select name="facultad" class="selector" id="facultad">'
                . $options .
                '</select>
                <label>Grado</label>
                <select name="grado" class="selector" id="grado" disabled>
                    <option value="0" disabled selected>Elija un grado</option>
                </select>
                <label>Curso</label>
                <select name="curso" class="selector" id="curso" disabled>
                    <option value="0" disabled selected>Elija un curso</option>
                </select>
                <label>Asignatura</label>
                <select name="asignatura" class="selector" id="asignatura" disabled>
                    <option value="0" disabled selected>Elija una asignatura</option>
                </select>
                <button type="submit" id="buscar">Buscar</button>';
    }

    public function procesaFormulario($datos)
    {
        $erroresFormulario = array();
        $facultad = $_REQUEST['facultad'];
        $grado = $_REQUEST['grado'];
        $curso = $_REQUEST['curso'];
        $asignatura = $_REQUEST['asignatura'];
        echo '<script>document.location.href = "resultado.php?facultad=' . $facultad . '&grado=' . $grado . '&curso=' . $curso . '&asignatura=' . $asignatura . '";</script>';
        return $erroresFormulario;
    }
}