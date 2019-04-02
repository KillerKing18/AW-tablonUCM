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
		$options = '<option value="0" disabled selected>Elija una facultad</option>';
		while ($fila = $resultado->fetch_assoc()) {
			$options .= '<option value="' . $fila["facultad"] . '">' . $fila["facultad"] . '</option>';
		}
        $resultado->free();
        return $options;
    }

    public static function devuelveGrados($facultad)
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
        $resultado = Universidad::devuelveGrados();
		$options = '<option value="0" disabled selected>Elija un grado</option>';
		while ($fila = $resultado->fetch_assoc()) {
			$options .= '<option value="' . $fila["grado"] . '">' . $fila["grado"] . '</option>';
		}
        $resultado->free();
        return $options;
    }

    public static function devuelveCursos($facultad, $grado)
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

    public static function devuelveAsignaturas($facultad, $grado, $curso)
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

}