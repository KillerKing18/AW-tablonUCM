<?php
require_once __DIR__ . '/Aplicacion.php';

class Evento
{
    private static function borra($evento)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("DELETE FROM eventos E WHERE E.id = '%s'",$conn->real_escape_string($evento->id));
        if ( !$conn->query($query) ) {
            echo "Error al borrar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function buscaEvento($lugar, $fecha, $hora)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM eventos E WHERE E.fecha = '%s' AND E.hora = '%s' AND E.lugar = '%s'", $conn->real_escape_string($fecha), $conn->real_escape_string($hora), $conn->real_escape_string($lugar));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $evento = new Evento($nombreEvento, $categoria, $lugar, $fecha, $hora, $creador, $descripcion);
                $evento->id = $fila['id'];
                $result = $evento;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }
    
    public static function crea($nombreEvento, $categoria, $lugar, $fecha, $hora, $creador, $descripcion)
    {
        $evento = self::buscaEvento($nombreEvento);
        if ($evento) {
            return false;
        }
        $evento = new Evento($nombreEvento, $categoria, $lugar, $fecha, $hora, $creador, $descripcion);
		
        return self::inserta($evento);
    }
    
    private static function inserta($evento)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO eventos(nombreEvento, categoria, lugar, fecha, hora, creador, descripcion) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')"
             , $conn->real_escape_string($evento->nombreEvento)
            , $conn->real_escape_string($evento->categoria)
            , $conn->real_escape_string($evento->lugar)
            , $conn->real_escape_string($evento->fecha)
			, $conn->real_escape_string($evento->hora)
			, $conn->real_escape_string($evento->creador)
			, $conn->real_escape_string($evento->descripcion));
        if ( $conn->query($query) ) {
            $evento->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $usuario;
    }
	
	private static function cambiarLugar($evento)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE eventos E SET lugar='%s' WHERE E.id=%i"
            , $conn->real_escape_string($evento->lugar)
            , $evento->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el lugar: " . $evento->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $evento;
    }
	
	private static function cambiarFecha($evento)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE eventos E SET fecha='%s' WHERE E.id=%i"
            , $conn->real_escape_string($evento->fecha)
            , $evento->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la fecha: " . $evento->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $evento;
    }
	
	private static function cambiarhora($evento)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE eventos E SET hora='%s' WHERE E.id=%i"
            , $conn->real_escape_string($evento->hora)
            , $evento->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la hora: " . $evento->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $evento;
    }
    
    private $id;

    private $nombreEvento;

    private $categoria;

    private $lugar;

    private $fecha;
	
	private $hora;
	
	private $creador;
	
	private $descripcion;

    private function __construct($nombreEvento, $categoria, $lugar, $fecha, $hora, $creador, $descripcion)
    {
        $this->nombreEvento= $nombreEvento;
        $this->categoria = $categoria;
        $this->lugar = $lugar;
        $this->fecha = $fecha;
		$this->hora= $hora;
        $this->creador = $creador;
        $this->descripcion = $descripcion;
    }

    public function id()
    {
        return $this->id;
    }
}
