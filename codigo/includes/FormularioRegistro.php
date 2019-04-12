<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';
class FormularioRegistro extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return '<div class="grupo-control">
                <label>Nombre de usuario:</label> <input type="text" class="validacion" id="usuarioRegistro" maxlength="15" name="usuario" required=""/>
            </div>
			<div class="grupo-control">
                <label>E-mail:</label> <input type="email" name="email" maxlength="40" required=""/>
            </div>
            <div class="grupo-control">
                <label>Contraseña:</label> <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*.{7}" maxlength="80" class="validacion" id="password1" name="password" required=""/>
            </div>
			<div class="grupo-control">
                <label>Repetir contraseña:</label> <input type="password" class="validacion" id="password2" name="password2" required=""/>
            </div>
            <div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>';
    }

    public function procesaFormulario($datos)
    {        
        $erroresFormulario = array();

        $nombreUsuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;      
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $password2 = isset($_POST['password2']) ? $_POST['password2'] : null;
        
        if($password === $password2){
            $usuario = Usuario::crea($nombreUsuario, $email, $password, 'user');
            
            if (!$usuario) {
                $erroresFormulario[] = "El usuario ya existe";
            } else {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $nombreUsuario;
                $_SESSION['esAdmin'] = false;
                $_SESSION['seccion'] = 'inicio';
                echo "<script>document.location.href = 'inicio.php';</script>";
                exit();
            }
        }
        else
            $erroresFormulario[] = "Las contraseñas no coinciden";

        return $erroresFormulario;
    }

}