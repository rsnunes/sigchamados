<?php include("./system/config.php");
    $us = new Usuarios();
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <!-- <link rel="stylesheet" type="text/css" href="" /> -->
        <script type="text/javascript" src="<?=$us->url_js?>funcoes.js"></script>
        <title>
            home
        </title>
    </head>
    <body>
        <p>
        <?php
            $get_area = $us->getArea();
            $file_area = __DIR__ . DS . "system" . DS . $get_area . ".php";
            if(file_exists($file_area)){
                include($file_area);
            }
            else{
                echo $us->getAbout();
            }
        ?>            
        </p>
    </body>
</html>

