<?php
    $obj = new Usuarios();
    
    $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
    if($acao == 'formulario'){
        $obj->formulario();
    }
    else{
        $obj->lista();
    }
?>

