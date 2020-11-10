<?php

error_reporting(E_ALL || E_ERROR);

define('DS',DIRECTORY_SEPARATOR);

//load class
function loadClass($className) {
    
    $classe = __DIR__ . DS . "class". DS ."class_" . $className . ".php";

    if (file_exists($classe)) {
        include($classe);
    } 
}
spl_autoload_register("loadClass");

session_start();

?>
