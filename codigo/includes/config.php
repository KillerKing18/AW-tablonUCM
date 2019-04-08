<?php

require_once __DIR__.'/Aplicacion.php';

/**
 * Parámetros de conexión a la BD
 */
define('BD_HOST', 'localhost');
define('BD_NAME', 'tablonucm');
define('BD_USER', 'tablonucm');
define('BD_PASS', 'tablonucm');

/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

// Inicializa la aplicación
$app = Aplicacion::getSingleton();
$app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS));

/**
 * @see http://php.net/manual/en/function.register-shutdown-function.php
 * @see http://php.net/manual/en/language.types.callable.php
 */
register_shutdown_function(array($app, 'shutdown'));


function borrarArchivos($folder){
    //Get a list of all of the file names in the folder.
    $files = glob($folder . '/*');
    
    //Loop through the file list.
    foreach($files as $file){
        //Make sure that this is a file and not a directory.
        if(is_file($file))
            //Use the unlink function to delete the file.
            unlink($file);
        else
            borrarArchivos($file);
    }
    if($folder !== 'zip')
        rmdir($folder);
}

borrarArchivos('zip');