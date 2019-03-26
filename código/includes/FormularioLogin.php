<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';
class FormularioLogin extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return '<div class="grupo-control">
                <label>Nombre de usuario o e-mail:</label> <input type="text" name="usuario" required=""/>
            </div>
            <div class="grupo-control">
                <label>Contraseña:</label> <input type="password" name="password" required=""/>
            </div>
            <div class="grupo-control"><button type="submit" name="login">Entrar</button></div>';
    }

    public function procesaFormulario($datos)
    {        
        $erroresFormulario = array();
        
        $nombreUsuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
		$password = isset($_POST['password']) ? $_POST['password'] : null;
		
		$usuario = Usuario::buscaUsuario($nombreUsuario);
	
		if (!$usuario) {
			$erroresFormulario[] = "El usuario no existe";
		} else {
			if ( $usuario->compruebaPassword($password) ) {
				$_SESSION['login'] = true;
				$_SESSION['nombre'] = $nombreUsuario;
				$_SESSION['esAdmin'] = strcmp($fila['rol'], 'admin') == 0 ? true : false;
				header('Location: inicio.php');
				exit();
			} else {
				$erroresFormulario[] = "El usuario o el password no coinciden";
			}
		}
        
        return $erroresFormulario;
    }

}