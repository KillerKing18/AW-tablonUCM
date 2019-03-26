<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';
class FormularioRegistro extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return '<div class="grupo-control">
                <label>Nombre de usuario:</label> <input type="text" name="nombreUsuario" required=""/>
            </div>
			<div class="grupo-control">
                <label>E-mail:</label> <input type="email" name="email" required=""/>
            </div>
            <div class="grupo-control">
                <label>Contraseña:</label> <input type="password" name="password" required=""/>
            </div>
			<div class="grupo-control">
                <label>Repetir contraseña:</label> <input type="password" name="password2" required=""/>
            </div>
            <div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>';
    }

    public function procesaFormulario($datos)
    {        
        $erroresFormulario = array();
        
        $nombreUsuario = isset($_POST['nombreUsuario']) ? $_POST['nombreUsuario'] : null;
        
        $email = isset($_POST['email']) ? $_POST['email'] : null;

        $password = isset($_POST['password']) ? $_POST['password'] : null;

        $password2 = isset($_POST['password2']) ? $_POST['password2'] : null;
        
		$usuario = Usuario::crea($nombreUsuario, $email, $password, 'user');
		
		if (! $usuario ) {
			$erroresFormulario[] = "El usuario ya existe";
		} else {
			$_SESSION['login'] = true;
			$_SESSION['nombre'] = $nombreUsuario;
			header('Location: inicio.php');
			exit();
	
		}
        
        return $erroresFormulario;
    }

}