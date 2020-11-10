<?php include('./system/config.php');

    Usuarios::logout();
    
    header("Location: {$url}");

?>
