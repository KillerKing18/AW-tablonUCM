<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Universidad.php';
class FormularioUpload extends Form{
//jQuery attr
    public function atributoCabeceraFormulario()
    {
        return 'enctype="multipart/form-data"';
    }

    public function generaCamposFormulario($datosIniciales)
    {
		$options = Universidad::creaOpcionesFacultades();

        return  '<label>Facultad</label>
                <select name="facultad" id="facultad">'
                . $options .
                '</select>
                <label>Grado</label>
                <select name="grado" id="grado" disabled>
                    <option value="0" disabled selected>Elija un grado</option>
                </select>
                <label>Curso</label>
                <select name="curso" id="curso" disabled>
                    <option value="0" disabled selected>Elija un curso</option>
                </select>
                <label>Asignatura</label>
                <select name="asignatura" id="asignatura" disabled>
                    <option value="0" disabled selected>Elija una asignatura</option>
                </select>
                <label>Categoría</label>
                <select name="categoria" id="categoria" disabled>
                    <option value="0" disabled selected>Elija una categoría</option>
                </select>
                <label>Observaciones</label>
                <textarea rows="4" cols="50"></textarea>
                <input type="file" name="archivo">
                <button type="submit" name="subir">Subir</button>';
    }

    public function procesaFormulario($datos)
    { 
        $erroresFormulario = array();
        
        $error = $_FILES['archivo']['error']; 
        switch ($error){
        case 0:
            $sizeError= '';
            $file_name = $_FILES['archivo']['name'];
            $file_size = $_FILES['archivo']['size'];
            $file_tmp = $_FILES['archivo']['tmp_name'];
            $tmp_file_ext = explode('.',$file_name);
            $file_ext = strtolower(end($tmp_file_ext));
    
            if(!file_exists('archivos')){
                if(mkdir('archivos', 0777, true))
                    echo "<script type='text/javascript'>alert('Se ha creado una carpeta nueva');</script>";
                else {
                    $erroresFormulario[] = "El usuario o el password no coinciden";
                    echo "<script type='text/javascript'>alert('No se ha podido crear la carpeta');</script>";
                }
            }
            if(move_uploaded_file($file_tmp, "archivos/" . $file_name))
                echo "<script type='text/javascript'>alert('Archivo subido correctamente');</script>";
            else
                echo "<script type='text/javascript'>alert('Se ha producido un error al subir el archivo');</script>";
            break;
        case 4:
            echo "<script type='text/javascript'>alert('No se subió ningún fichero.');</script>";
            break;
        }
        
        return $erroresFormulario;
    }

}