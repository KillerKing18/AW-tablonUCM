<?php
require_once __DIR__ . '/Aplicacion.php';

class Archivo
{
	private static function devuelveArchivos($facultad, $grado, $curso, $asignatura){
		
		
	}
	
    private static function borra($archivo)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("DELETE FROM archivos A WHERE A.id = '%s'",$conn->real_escape_string($archivo->id));
        if ( !$conn->query($query) ) {
            echo "Error al borrar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }
	
	private static function cambiarNombre($archivo)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE archivos A SET nombreArchivo='%s' WHERE A.id=%i"
            , $conn->real_escape_string($archivo->nombreArchivo)
            , $archivo->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el nombre: " . $archivo->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $evento;
    }
    
    public static function crea($nombreArchivo, $categoria, $asignatura, $curso, $grado, $facultad, $autor, $observaciones, $tamaño, $fecha, $formato)
    {
        $archivo = new Archivo($nombreArchivo, $categoria, $asignatura, $curso, $grado, $facultad, $autor, $observaciones, $tamaño, $fecha, $formato);
		
        return self::inserta($archivo);
    }
    
    private static function inserta($archivo)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO archivos(nombreArchivo, categoria, asignatura, curso, grado, facultad, autor, observaciones, tamaño, fecha, formato) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%i', '%s', '%s')"
             , $conn->real_escape_string($archivo->nombreArchivo)
            , $conn->real_escape_string($archivo->categoria)
            , $conn->real_escape_string($archivo->asignatura)
			, $conn->real_escape_string($archivo->curso)
            , $conn->real_escape_string($archivo->grado)
			, $conn->real_escape_string($archivo->facultad)
			, $conn->real_escape_string($archivo->autor)
			, $conn->real_escape_string($archivo->observaciones)
			, $conn->real_escape_string($archivo->tamaño)
			, $conn->real_escape_string($archivo->fecha)
			, $conn->real_escape_string($archivo->formato));
        if ( $conn->query($query) ) {
            $archivo->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $archivo;
    }
    
    private $id;

    private $nombreArchivo;

    private $categoria;

    private $asignatura;
	
	private $curso;

    private $grado;
	
	private $facultad;
	
	private $autor;
	
	private $observaciones;
	
	private $tamaño;
	
	private $fecha;
	
	private $formato;

    private function __construct($nombreArchivo, $categoria, $asignatura, $curso, $grado, $facultad, $autor, $observaciones, $tamaño, $fecha, $formato)
    {
        $this->nombreArchivo= $nombreArchivo;
        $this->categoria = $categoria;
        $this->asignatura = $asignatura;
		$this->curso = $curso;
        $this->grado = $grado;
		$this->facultad= $facultad;
        $this->autor = $autor;
        $this->observaciones = $observaciones;
		$this->tamaño = $tamaño;
		$this->fecha = $fecha;
		$this->formato = $formato;
    }

    public function id()
    {
        return $this->id;
    }
}
