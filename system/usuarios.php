<?php
    $obj = new Usuarios();
        
    $acao = $obj->urlGetVal('acao');
    if($acao == 'formulario'){
        $obj->formulario();
    }
    else{
        $obj->lista();
    }
?>

