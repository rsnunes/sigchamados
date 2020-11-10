<?php
    $obj = new Usuarios();
    
    $bts = $obj->bt_acao();
    $bts .= ($_SESSION['usuario']['tipo'] == 2) ? $obj->bt_acao('Novo', 1) : '';
    echo "<div class='box_acao'>{$bts}</div>";
    
    $acao = $obj->urlGetVal('acao');
    if($acao == 'formulario'){
        $obj->formulario();
    }
    else{
        $obj->lista();
    }
?>

