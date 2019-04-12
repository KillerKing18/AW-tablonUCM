<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';

class FormularioImagen extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return  '<input type="file" id="imagen" name="imagen" accept="image/*">';
    }

    public function procesaFormulario($datos)
    {
        $erroresFormulario = array();

        $image_name = $_FILES['imagen']['name'];
        $image_size = $_FILES['imagen']['size'];
        $image_tmp = $_FILES['imagen']['tmp_name'];
        $tmp_image_ext = explode('.', $image_name);
        $image_ext = strtolower(end($tmp_image_ext));

        $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
        $extensionAntigua = $usuario->extensionImagen();
        if($usuario->imagenCargada() && $extensionAntigua !== $image_ext) // Si ha cambiado la extension del archivo, borramos el anterior
            unlink('upload/img/' . $usuario->nombreUsuario() . '.' . $extensionAntigua);

        $usuario->cambiaImagen($image_ext);

        $carpeta = 'upload/img';

        if(!move_uploaded_file($image_tmp, $carpeta . '/' . $usuario->nombreUsuario() . '.' . $image_ext))
            $erroresFormulario[] = "Se ha producido un error al subir la imagen";
        return $erroresFormulario;
    }
}