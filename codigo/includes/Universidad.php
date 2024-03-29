<?php
require_once __DIR__ . '/Aplicacion.php';

class Universidad
{
    private static function devuelveFacultades()
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT DISTINCT facultad FROM universidad");
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    public static function creaOpcionesFacultades(){
        $resultado = Universidad::devuelveFacultades();
		$options = '<option value="" disabled selected>Elija una facultad</option>';
		while ($fila = $resultado->fetch_assoc()) {
			$options .= '<option value="' . $fila["facultad"] . '">' . $fila["facultad"] . '</option>';
		}
        $resultado->free();
        return $options;
    }

    private static function devuelveGrados($facultad)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT DISTINCT grado FROM universidad U WHERE U.facultad = '%s'", $conn->real_escape_string($facultad));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    public static function creaOpcionesGrados($facultad){
        $resultado = Universidad::devuelveGrados($facultad);
		$options = '<option value="" disabled selected>Elija un grado</option>';
		while ($fila = $resultado->fetch_assoc()) {
			$options .= '<option value="' . $fila["grado"] . '">' . $fila["grado"] . '</option>';
		}
        $resultado->free();
        return $options;
    }

    private static function devuelveCursos($facultad, $grado)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT DISTINCT curso FROM universidad U WHERE U.facultad = '%s' AND U.grado = '%s'"
            , $conn->real_escape_string($facultad)
            , $conn->real_escape_string($grado));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    public static function creaOpcionesCursos($facultad, $grado){
        $resultado = Universidad::devuelveCursos($facultad, $grado);
		$options = '<option value="" disabled selected>Elija un curso</option>';
		while ($fila = $resultado->fetch_assoc()) {
			$options .= '<option value="' . $fila["curso"] . '">' . $fila["curso"] . '</option>';
		}
        $resultado->free();
        return $options;
    }

    private static function devuelveAsignaturas($facultad, $grado, $curso)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT DISTINCT asignatura FROM universidad U WHERE U.facultad = '%s' AND U.grado = '%s' AND U.curso = '%s'"
            , $conn->real_escape_string($facultad)
            , $conn->real_escape_string($grado)
            , $conn->real_escape_string($curso));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    public static function creaOpcionesAsignaturas($facultad, $grado, $curso){
        $resultado = Universidad::devuelveAsignaturas($facultad, $grado, $curso);
		$options = '<option value="" disabled selected>Elija una asignatura</option>';
		while ($fila = $resultado->fetch_assoc()) {
			$options .= '<option value="' . $fila["asignatura"] . '">' . $fila["asignatura"] . '</option>';
		}
        $resultado->free();
        return $options;
    }

    public static function creaOpcionesCategorias(){
		$options = '<option value="" disabled selected>Elija una categoría</option>';
        $options .= '<option value="Teoría">Teoría</option>';
        $options .= '<option value="Ejercicios">Ejercicios</option>';
        $options .= '<option value="Exámenes">Exámenes</option>';
        $options .= '<option value="Prácticas">Prácticas</option>';
        return $options;
    }

    public static function devuelveIDAsignatura($facultad, $grado, $curso, $asignatura){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT id FROM universidad U WHERE U.facultad = '%s' AND U.grado = '%s' AND U.curso = '%s' AND U.asignatura = '%s'"
            , $conn->real_escape_string($facultad)
            , $conn->real_escape_string($grado)
            , $conn->real_escape_string($curso)
            , $conn->real_escape_string($asignatura));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        $subject = $rs->fetch_assoc();
		return $subject['id'];
    }

    public static function zipAsignaturaActualizado($facultad, $grado, $curso, $asignatura){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT zip FROM universidad U WHERE U.facultad = '%s' AND U.grado = '%s' AND U.curso = '%s' AND U.asignatura = '%s'"
            , $conn->real_escape_string($facultad)
            , $conn->real_escape_string($grado)
            , $conn->real_escape_string($curso)
            , $conn->real_escape_string($asignatura));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        $subject = $rs->fetch_assoc();
		return $subject['zip'];
    }

    public static function cambiarZIPAsignatura($facultad, $grado, $curso, $asignatura, $zip){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE universidad U SET zip = '%d' WHERE U.facultad = '%s' AND U.grado = '%s' AND U.curso = '%s' AND U.asignatura = '%s'"
            , $zip
            , $conn->real_escape_string($facultad)
            , $conn->real_escape_string($grado)
            , $conn->real_escape_string($curso)
            , $conn->real_escape_string($asignatura));
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la asignatura";
                exit();
            }
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }
}