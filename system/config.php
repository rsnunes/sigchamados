<?php

//error_reporting(E_ALL || E_ERROR);

//load class
function loadClass($className) {
    
    $classe = __DIR__ . DIRECTORY_SEPARATOR . "class". DIRECTORY_SEPARATOR ."class_" . $className . ".php";

    if (file_exists($classe)) {
        include($classe);
    } 
}
spl_autoload_register("loadClass");

session_start();

?>
