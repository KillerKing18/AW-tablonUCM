<?php
require_once __DIR__ . '/Aplicacion.php';
require_once __DIR__ . '/Archivo.php';

class Usuario
{

    public static function login($nombreUsuario, $password)
    {
        $user = self::buscaUsuario($nombreUsuario);
        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }

    public static function buscaUsuario($nombreUsuario)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.nombreUsuario = '%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['nombreUsuario'], $fila['email'], $fila['password'], $fila['rol'], $fila['imagen'], $fila['extensionImagen']);
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }
    
    public static function crea($nombreUsuario, $email, $password, $rol)
    {
        $user = self::buscaUsuario($nombreUsuario);
        if ($user) {
            return false;
        }
        $user = new Usuario($nombreUsuario, $email, self::hashPassword($password), $rol, 0, 'png');
        return self::inserta($user);
    }
    
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    private static function inserta($usuario)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO usuarios(nombreUsuario, email, password, rol, imagen, extensionImagen) VALUES('%s', '%s', '%s', '%s', '%d', '%s')"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol)
            , $usuario->imagen
            , $conn->real_escape_string($usuario->extensionImagen));
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $usuario;
    }
    
    private static function actualiza($usuario)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE usuarios U SET nombreUsuario = '%s', email ='%s', password ='%s', rol='%s', imagen='%d', extensionImagen='%s' WHERE U.nombreUsuario='%s'"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol)
            , $usuario->imagen
            , $conn->real_escape_string($usuario->extensionImagen)
            , $conn->real_escape_string($usuario->id));
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el usuario: " . $usuario->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        $usuario->id = $usuario->nombreUsuario;
        
        return $usuario;
    }
    
    private $id;

    private $nombreUsuario;

    private $email;

    private $password;

    private $rol;

    private $imagen;

    private function __construct($nombreUsuario, $email, $password, $rol, $imagen, $extensionImagen)
    {
        $this->id = $nombreUsuario;
        $this->nombreUsuario = $nombreUsuario;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
        $this->imagen = $imagen;
        $this->extensionImagen = $extensionImagen;
    }

    public function id()
    {
        return $this->id;
    }

    public function rol()
    {
        return $this->rol;
    }

    public function email()
    {
        return $this->email;
    }

    public function nombreUsuario()
    {
        return $this->nombreUsuario;
    }

    public function extensionImagen()
    {
        return $this->extensionImagen;
    }

    public function imagenCargada()
    {
        return $this->imagen;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevaPassword)
    {
        $this->password = self::hashPassword($nuevaPassword);
        self::actualiza($this);
    }

    public function cambiaEmail($nuevoEmail)
    {
        $this->email = $nuevoEmail;
        self::actualiza($this);
    }

    public function cambiaNombreUsuario($nuevoNombreUsuario)
    {
        $this->nombreUsuario = $nuevoNombreUsuario;
        if(self::buscaUsuario($nuevoNombreUsuario))
            return false;
        self::actualiza($this);
        return true;
    }

    public function cambiaImagen($extensionImagen)
    {
        $cambio = false;
        if(!$this->imagen){
            $this->imagen = 1;
            $cambio = true;
        }
        if($this->extensionImagen !== $extensionImagen){
            $this->extensionImagen = $extensionImagen;
            $cambio = true;
        }
        if ($cambio)
            self::actualiza($this);
    }

    public function mostrarPerfil(){
        $html = '';
        $path = $this->imagen ? 'upload/img/' . $this->nombreUsuario . '.' . $this->extensionImagen : 'img/default.png';
        $html .= '<img src="' . $path . '"></img>';
        $html .= '<a href="" id="subirImagen">Cambiar imagen</a>';
        $html .='<br>';
        $html .= 'Nombre de usuario: ' . $this->nombreUsuario;
        $html .= '<br>';
        //$html .= 'Valoracion: ' . $this->valoracion;
        $html .= 'E-mail: ' . $this->email;

        return $html;
    }

    public static function mostrarPerfilAjeno($id){
        $html = '';
        $usuario = self::buscaUsuario($id);
        if($usuario){
            $html .= '<h1>Perfil de ' . $id . '</h1>';
            $path = $usuario->imagen ? 'upload/img/' . $usuario->nombreUsuario . '.' . $usuario->extensionImagen : 'img/default.png';
            $html .= '<img src="' . $path . '"></img>';
            $html .='<br>';
            $html .= 'Nombre de usuario: ' . $usuario->nombreUsuario;
            $html .= '<br>';
            //$html .= 'Valoracion: ' . $usuario->valoracion();
            $html .= Archivo::generaArchivosUsuario($id);
            //$html .= Evento::generaEventosUsuario($id);
        }
        else{
            $html .= '<h1>Perfil ajeno</h1>';
            $html .= '<p>Oops! Parece que salió algo mal...</p>';
        }
        return $html;
    }

    public function borrarUsuario(){
        $archivosUsuario = Archivo::devuelveArrayArchivosUsuario($this->nombreUsuario);
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM usuarios WHERE nombreUsuario = '%s'", $conn->real_escape_string($this->nombreUsuario));
        if ( !$conn->query($query) ) {
            echo "Error al borrar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        foreach ($archivosUsuario as $archivo)
            unlink('upload/files/' . $archivo);
    }
}
