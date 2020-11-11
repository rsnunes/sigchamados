<?php
    $obj = new Chamados();
    
    $acao = $obj->urlGetVal('acao');
    if($acao == 'formulario'){
        $obj->formulario();
    }
    else{
        $obj->lista();
    }
?>