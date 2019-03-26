<?php
require_once __DIR__ . '/Aplicacion.php';

class Universidad
{
    public static function devuelveFacultades()
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT DISTINCT facultad FROM Universidad");
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    public static function devuelveGrados($facultad)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT DISTINCT grado FROM Universidad U WHERE U.facultad = '%s'", $conn->real_escape_string($facultad));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    public static function devuelveCursos($facultad, $grado)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT DISTINCT curso FROM Universidad U WHERE U.facultad = '%s' AND U.grado = '%s'"
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
        $query = sprintf("SELECT DISTINCT asignatura FROM Universidad U WHERE U.facultad = '%s' AND U.grado = '%s' AND U.curso = '%s'"
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