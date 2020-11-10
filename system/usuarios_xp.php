<?php
    include('./config.php');
    $obj = new Usuarios();
    
    if($_POST['acao'] == 'salvar'){
        $record['nome'] = $_POST['nome'];
        $record['email'] = $_POST['email'];
        if(isset($_POST['senha'])){
            $record['senha'] = md5($_POST['senha']);
        }
        if(isset($_POST['tipo']) && $obj->getTipo() == 2){
            $record['tipo'] = $_POST['tipo'];
        }
        
        if(empty($_SESSION['atualizar']['usuario_id'])){
            $obj->inserir($record, $obj->t_usuarios);
            $url = $obj->url . "?area=" . $obj->area . "&acao=formulario&id=" . $obj->getLastId();
        }
        elseif($obj->getTipo() == 2 || $_SESSION['usuario']['id'] == $_SESSION['atualizar']['usuario_id']){
            $obj->atualizar($record, $obj->t_usuarios, $_SESSION['atualizar']['usuario_id']);
            $_SESSION['atualizar']['usuario_id'] = 0;
            $url = $_SERVER['HTTP_REFERER'];
        }
        
        header("Location: {$url}");
    }
    
    if($_POST['acao'] == 'deletar' && $obj->getTipo() == 2){
        $obj->deletar($_POST['id'], $obj->t_usuarios);
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
?>