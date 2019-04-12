<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';
class FormularioLogin extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return '<div class="grupo-control">
                <label>Nombre de usuario:</label> <input type="text" class="validacion" id="usuarioLogin" maxlength="15" name="usuario" required=""/>
            </div>
            <div class="grupo-control">
                <label>Contraseña:</label> <input type="password" maxlength="80" name="password" required=""/>
            </div>
            <div class="grupo-control"><button type="submit">Entrar</button></div>';
    }

    public function procesaFormulario($datos)
    {        
        $erroresFormulario = array();
        
        $nombreUsuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
		$password = isset($_POST['password']) ? $_POST['password'] : null;
		
		$usuario = Usuario::buscaUsuario($nombreUsuario);
    
        if($usuario){
            if ($usuario->compruebaPassword($password)) {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $nombreUsuario;
                $_SESSION['esAdmin'] = strcmp($usuario->rol(), 'admin') == 0 ? true : false;
                $_SESSION['seccion'] = 'inicio';
                echo "<script>document.location.href = 'inicio.php';</script>";
                exit();
            }
            else
                $erroresFormulario[] = "El usuario y el password no coinciden";
        }
        else
            $erroresFormulario[] = "No existe ningún usuario con ese nombre";
        
        return $erroresFormulario;
    }

}