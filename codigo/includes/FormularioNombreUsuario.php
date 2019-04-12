<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';

class FormularioNombreUsuario extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return  '<label>Nuevo nombre de usuario:</label>
                <input name="nombreUsuario" id="usuarioCambio" maxlength="15" class="validacion" required=""></input>
                <button type="submit" id="cambiar">Actualizar</button>';
    }

    public function procesaFormulario($datos)
    {
        $erroresFormulario = array();

        $nombreUsuario = $_REQUEST['nombreUsuario'];
        $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
        $nombreUsuarioAntiguo = $usuario->nombreUsuario();
        if($usuario->nombreUsuario() !== $nombreUsuario){
            if($usuario->cambiaNombreUsuario($nombreUsuario)){
                $_SESSION['nombre'] = $nombreUsuario;
                if($usuario->imagenCargada())
                    rename('upload/img/'. $nombreUsuarioAntiguo . '.' . $usuario->extensionImagen(), 'upload/img/'. $nombreUsuario . '.' . $usuario->extensionImagen());  
            }
            else
                $erroresFormulario[] = "Error. Ya existe otro usuario con el mismo nombre";
        }
        else
            $erroresFormulario[] = "Error. Tu nuevo nombre de usuario no puede ser el mismo que el antiguo";

        return $erroresFormulario;
    }
}