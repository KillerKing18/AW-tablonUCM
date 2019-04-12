<?php
require_once __DIR__ . '/Aplicacion.php';
require_once __DIR__ . '/Universidad.php';

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
        $resultado = self::devuelveInfoArchivo($this->id);

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
        $html .= '<td><a id="' . $info["autor"] . '" href="perfilAjeno.php?id=' . $info["autor"] . '" class="autor">' . $info["autor"] . '</a></td>';
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

    private static function devuelveArchivosUsuario($nombreUsuario){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos A WHERE A.autor = '%s'"
            , $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    public static function devuelveArrayArchivosUsuario($nombreUsuario){
        $ids = array();
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos A WHERE A.autor = '%s'"
            , $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        while ($fila = $rs->fetch_assoc())
            $ids[] = $fila['id'] . '.' . $fila['formato'];
        $rs->free();
        return $ids;
    }

    public static function generaBusquedaGeneral($facultad, $grado, $curso, $asignatura){
        $categorias = array("Teoría", "Ejercicios", "Exámenes", "Prácticas");
        $html = '<h1>Búsqueda: ' . $facultad . ' / ' . $grado . ' / ' . $curso . ' / ' . $asignatura .'</h1>';
        foreach($categorias as $categoria){
            $resultado = self::devuelveArchivosCategoria($facultad, $grado, $curso, $asignatura, $categoria);
            $html .= '<h2><a href="resultadoApuntes.php?facultad=' . $facultad . '&grado=' . $grado . '&curso=' . $curso . '&asignatura=' . $asignatura . '&categoria=' . $categoria . '">'.$categoria.'</a></h2>';
            $html .= '<ul>';
            if($resultado->num_rows !== 0)
                while ($fila = $resultado->fetch_assoc())
                    $html .= '<li value="' . $fila["nombreArchivo"] . '"><a id="' . $fila["id"] . '" href="resultadoApuntes.php?id=' . $fila["id"] . '" class="file">' . $fila["nombreArchivo"] . '</a></li>';
            else
                $html .= '<li>No hay archivos todavía para esta categoría</li>';
            $html .= '</ul>';
            $resultado->free();
        }
        return $html;
    }

    public static function generaBusquedaEspecifica($facultad, $grado, $curso, $asignatura, $categoria){
        $html = '<h1>Búsqueda: ' . $facultad . ' / ' . $grado . ' / ' . $curso . ' / ' . $asignatura . ' / ' . $categoria . '</h1>';
        $resultado = self::devuelveArchivosCategoria($facultad, $grado, $curso, $asignatura, $categoria);
        $html .= '<ul>';
        if($resultado->num_rows !== 0)
            while ($fila = $resultado->fetch_assoc()) 
                $html .= '<li value="' . $fila["nombreArchivo"] . '"><a id="' . $fila["id"] . '" href="resultadoApuntes.php?id=' . $fila["id"] . '" class="file">' . $fila["nombreArchivo"] . '</a></li>';
        else
            $html .= '<li>No hay archivos todavía para esta categoría</li>';
        $html .= '</ul>';
        $resultado->free();

        return $html;
    }

    public static function generaArchivosUsuario($nombreUsuario){
        $html = '<h3>Archivos subidos:</h3>';
        $resultado = self::devuelveArchivosUsuario($nombreUsuario);
        $html .= '<ul>';
        if($resultado->num_rows !== 0)
            while ($fila = $resultado->fetch_assoc()) 
                $html .= '<li value="' . $fila['nombreArchivo'] . '"><a id="' . $fila['id'] . '" href="resultadoApuntes.php?id=' . $fila['id'] . '" class="file">' . $fila['nombreArchivo'] . '</a></li>';
        else
            if($self)
                $html .= '<li>Aún no has subido ningún archivo</li>';
            else
                $html .= '<li>El usuario ' . $nombreUsuario . ' aún no ha subido ningún archivo</li>';
        $html .= '</ul>';
        $resultado->free();

        return $html;
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
        if(Universidad::zipAsignaturaActualizado($facultad, $grado, $curso, $asignatura))
            Universidad::cambiarZIPAsignatura($facultad, $grado, $curso, $asignatura, 0);
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

    public static function generarResultado(){
        if(!isset($_REQUEST['id'])){
            self::generarResultadoCarpeta();
        }
        else{
            self::generarResultadoArchivo();
        }
    }

    private static function generarResultadoCarpeta(){
        $facultad = $_REQUEST['facultad'];
        $grado = $_REQUEST['grado'];
        $curso = $_REQUEST['curso'];
        $asignatura = $_REQUEST['asignatura'];
        self::crearArchivosZIP($facultad, $grado, $curso, $asignatura);
        if(isset($_REQUEST['categoria'])){
            echo self::generaBusquedaEspecifica($facultad, $grado, $curso, $asignatura, $_REQUEST['categoria']);
        }
        else{
            echo self::generaBusquedaGeneral($facultad, $grado, $curso, $asignatura);
        }
    }

    private static function generarResultadoArchivo(){
        $id = $_REQUEST['id'];
        $archivo = self::devuelveObjetoArchivo($id);
        echo $archivo->creaTablaArchivo();
        echo '<embed src="upload/files/' . $archivo->id() . '.' . $archivo->formato() . '" width="800px" height="700px" />';
        echo '<a href="upload/files/' . $archivo->id() . '.' . $archivo->formato() . '" download="'. $archivo->nombre() . '">Descargar archivo</a>';
        if ($archivo->autor === $_SESSION['nombre'] || $_SESSION['esAdmin']){
            echo '<button class="borrarArchivo" id="' . $id . '"><i class="fa fa-trash-o"></i></button>';
        }
        echo '<h3>Observaciones del autor:</h3>';
        if($archivo->observaciones() !== '')
            echo '<p>' . $archivo->observaciones() . '</p>';
        else
            echo '<p>El autor no ha añadido observaciones sobre este archivo.</p>';
    }

    public static function borrarArchivo($id){
        $resultado = self::devuelveInfoArchivo($id);
        $info = $resultado->fetch_assoc();
        $nombreArchivo = $id . '.' . $info["formato"];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM archivos WHERE id = '%d'", $id);
        if ( !$conn->query($query) ) {
            echo "Error al borrar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        unlink('../upload/files/' . $nombreArchivo);
    }

    private static function crearArchivosZIP($facultad, $grado, $curso, $asignatura){
        if(!Universidad::zipAsignaturaActualizado($facultad, $grado, $curso, $asignatura)){
            $zipAsignatura = new ZipArchive;
            $id = Universidad::devuelveIDAsignatura($facultad, $grado, $curso, $asignatura);
            if ($zipAsignatura->open('zip/asignaturaID' . $id . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE)
            {
                $path = 'upload/files';
                $dir = opendir($path);
                $categorias = ['Teoría', 'Prácticas', 'Exámenes', 'Ejercicios'];
                foreach($categorias as $categoria){
                    $zipCategoria = new ZipArchive;
                    if ($zipCategoria->open('zip/asignaturaID' . $id . ' - ' . $categoria . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE){
                        $resultado = self::devuelveArchivosCategoria($facultad, $grado, $curso, $asignatura, $categoria);
                        while ($fila = $resultado->fetch_assoc()){
                            $zipAsignatura->addFile($path . '/' . $fila['id'] . '.' . $fila['formato'], $asignatura . '/' . $categoria . '/' . $fila['nombreArchivo']);
                            $zipCategoria->addFile($path . '/' . $fila['id'] . '.' . $fila['formato'], $asignatura . ' - ' . $categoria . '/' . $fila['nombreArchivo']);
                        }
                        $zipCategoria->close();
                    }
                }
                closedir($dir);
                $zipAsignatura->close();
            }
            Universidad::cambiarZIPAsignatura($facultad, $grado, $curso, $asignatura, 1);
        }
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

    public function formato()
    {
        return $this->formato;
    }

    public function observaciones()
    {
        return $this->observaciones;
    }
}
