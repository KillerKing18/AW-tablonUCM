<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Universidad.php';
require_once __DIR__.'/Archivo.php';

class FormularioUpload extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
		$options = Universidad::creaOpcionesFacultades();

        return  '<label>Facultad</label>
                <select name="facultad" class="selector" id="facultad" required>'
                . $options .
                '</select>
                <label>Grado</label>
                <select name="grado" class="selector" id="grado" disabled required>
                    <option value="" disabled selected>Elija un grado</option>
                </select>
                <label>Curso</label>
                <select name="curso" class="selector" id="curso" disabled required>
                    <option value="" disabled selected>Elija un curso</option>
                </select>
                <label>Asignatura</label>
                <select name="asignatura" class="selector" id="asignatura" disabled required>
                    <option value="" disabled selected>Elija una asignatura</option>
                </select>
                <label>Categoría</label>
                <select name="categoria" class="selector" id="categoria" disabled required>
                    <option value="" disabled selected>Elija una categoría</option>
                </select>
                <label>Observaciones</label>
                <textarea rows="4" cols="50" name = "observaciones"></textarea>
                <input type="file" id="archivo" name="archivo" required>
                <button type="submit" id="subir">Subir</button>';
    }

    public function procesaFormulario($datos)
    { 
        $erroresFormulario = array();

        $file_name = $_FILES['archivo']['name'];
        $file_size = $_FILES['archivo']['size'];
        $file_tmp = $_FILES['archivo']['tmp_name'];
        $tmp_file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($tmp_file_ext));
        $facultad = $_REQUEST['facultad'];
        $grado = $_REQUEST['grado'];
        $curso = $_REQUEST['curso'];
        $asignatura = $_REQUEST['asignatura'];
        $categoria = $_REQUEST['categoria'];
        $observaciones = $_REQUEST['observaciones'];
        $carpeta = 'upload/files';

        $archivo = Archivo::crea($file_name, $categoria, $asignatura, $curso, $grado, $facultad, $_SESSION['nombre'], $observaciones, $file_size, date("H:i:s j/n/Y"), $file_ext);
        
        if(!move_uploaded_file($file_tmp, $carpeta . '/' . $archivo ->id() . '.' . $file_ext))
            $erroresFormulario[] = "Se ha producido un error al subir el archivo";
        return $erroresFormulario;
    }

}