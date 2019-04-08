<?php
require_once __DIR__ . '/Aplicacion.php';

class Archivo
{
    private static function devuelveInfoArchivo($id){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos A WHERE A.id = '%d'"
            , $id);
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    public function creaTablaArchivo(){
        $html = '';
        $resultado = Archivo::devuelveInfoArchivo($this->id);

        $info = $resultado->fetch_assoc();
        $html .= '<table>';
        $html .= '<tr>';
        $html .= '<th>Nombre</th>';
        $html .= '<th>Facultad</th>';
        $html .= '<th>Grado</th>';
        $html .= '<th>Curso</th>';
        $html .= '<th>Asignatura</th>';
        $html .= '<th>Categoría</th>';
        $html .= '<th>Autor</th>';
        $html .= '<th>Observaciones</th>';
        $html .= '<th>Tamaño</th>';
        $html .= '<th>Fecha</th>';
        $html .= '<th>Formato</th>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>' . $info["nombreArchivo"] . '</td>';
        $html .= '<td>' . $info["facultad"] . '</td>';
        $html .= '<td>' . $info["grado"] . '</td>';
        $html .= '<td>' . $info["curso"] . '</td>';
        $html .= '<td>' . $info["asignatura"] . '</td>';
        $html .= '<td>' . $info["categoria"] . '</td>';
        $html .= '<td>' . $info["autor"] . '</td>';
        $html .= '<td>' . $info["observaciones"] . '</td>';
        $html .= '<td>' . $info["tamano"] . '</td>';
        $html .= '<td>' . $info["fecha"] . '</td>';
        $html .= '<td>' . $info["formato"] . '</td>';
        $html .= '</tr>';
        $html .= '</table>';
        $resultado->free();

        return $html;
    }

	private static function devuelveArchivosCategoria($facultad, $grado, $curso, $asignatura, $categoria){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos A WHERE A.facultad = '%s' AND A.grado = '%s' AND A.curso = '%s' AND A.asignatura = '%s' AND A.categoria= '%s'"
            , $conn->real_escape_string($facultad)
            , $conn->real_escape_string($grado)
            , $conn->real_escape_string($curso)
            , $conn->real_escape_string($asignatura)
            , $conn->real_escape_string($categoria));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    public static function generaBusquedaGeneral($facultad, $grado, $curso, $asignatura){
        $categorias = array("Teoría", "Ejercicios", "Exámenes", "Prácticas");
        $html = '';
        foreach($categorias as $categoria){
            $resultado = Archivo::devuelveArchivosCategoria($facultad, $grado, $curso, $asignatura, $categoria);
            $html .= '<h1><a href="resultado.php?facultad=' . $facultad . '&grado=' . $grado . '&curso=' . $curso . '&asignatura=' . $asignatura . '&categoria=' . $categoria . '">'.$categoria.'</a></h1>';
            $html .= '<ul>';
            while ($fila = $resultado->fetch_assoc()) {
                $html .= '<li value="' . $fila["nombreArchivo"] . '"><a id="' . $fila["id"] . '" href="resultado.php?id=' . $fila["id"] . '" class="file">' . $fila["nombreArchivo"] . '</a></li>';
            }
            $html .= '</ul>';
            $resultado->free();
        }
        return $html;
    }

    public static function generaBusquedaEspecifica($facultad, $grado, $curso, $asignatura, $categoria){
        $html = '';
        $resultado = Archivo::devuelveArchivosCategoria($facultad, $grado, $curso, $asignatura, $categoria);
        $html .= '<h1>' . $categoria . '</h1>';
        $html .= '<ul>';
        while ($fila = $resultado->fetch_assoc()) {
            $html .= '<li value="' . $fila["nombreArchivo"] . '"><a id="' . $fila["id"] . '" href="resultado.php?id=' . $fila["id"] . '" class="file">' . $fila["nombreArchivo"] . '</a></li>';
        }
        $html .= '</ul>';
        $resultado->free();
        return $html;
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
    
    public static function crea($nombreArchivo, $categoria, $asignatura, $curso, $grado, $facultad, $autor, $observaciones, $tamano, $fecha, $formato)
    {
        $archivo = new Archivo($nombreArchivo, $categoria, $asignatura, $curso, $grado, $facultad, $autor, $observaciones, $tamano, $fecha, $formato);
        return self::inserta($archivo);
    }
    
    private static function inserta($archivo)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO archivos(nombreArchivo, categoria, asignatura, curso, grado, facultad, autor, observaciones, tamano, fecha, formato) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s')"
             , $conn->real_escape_string($archivo->nombreArchivo)
            , $conn->real_escape_string($archivo->categoria)
            , $conn->real_escape_string($archivo->asignatura)
			, $conn->real_escape_string($archivo->curso)
            , $conn->real_escape_string($archivo->grado)
			, $conn->real_escape_string($archivo->facultad)
			, $conn->real_escape_string($archivo->autor)
			, $conn->real_escape_string($archivo->observaciones)
			, $archivo->tamano
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
	
	private $tamano;
	
	private $fecha;
	
	private $formato;

    private function __construct($nombreArchivo, $categoria, $asignatura, $curso, $grado, $facultad, $autor, $observaciones, $tamano, $fecha, $formato)
    {
        $this->nombreArchivo= $nombreArchivo;
        $this->categoria = $categoria;
        $this->asignatura = $asignatura;
		$this->curso = $curso;
        $this->grado = $grado;
		$this->facultad= $facultad;
        $this->autor = $autor;
        $this->observaciones = $observaciones;
		$this->tamano = $tamano;
		$this->fecha = $fecha;
		$this->formato = $formato;
    }

    public static function devuelveObjetoArchivo($id)
    {
        $resultado = Archivo::devuelveInfoArchivo($id);

        $info = $resultado->fetch_assoc();

        $archivo = new Archivo($info["nombreArchivo"], $info["categoria"], $info["asignatura"], $info["curso"], $info["grado"], $info["facultad"], $info["autor"], $info["observaciones"], $info["tamano"], $info["fecha"], $info["formato"]);
        $archivo->id = $id;
        return $archivo;
    }

    public function id()
    {
        return $this->id;
    }

    public function nombre()
    {
        return $this->nombreArchivo;
    }

    public function facultad()
    {
        return $this->facultad;
    }

    public function grado()
    {
        return $this->grado;
    }

    public function curso()
    {
        return $this->curso;
    }

    public function asignatura()
    {
        return $this->asignatura;
    }
    
    public function categoria()
    {
        return $this->categoria;
    }
}
