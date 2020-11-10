<?php
    include('./config.php');
    $obj = new Usuarios();
    
    if($_POST['acao'] == 'salvar'){
        $record['nome'] = $_POST['nome'];
        $record['email'] = $_POST['email'];
        if(isset($_POST['senha'])){
            $record['senha'] = md5($_POST['senha']);
        }
        if(empty($_SESSION['usuario']['id'])){
            $obj->inserir($record, $obj->t_usuarios);
            $url = $obj->url . "?area=" . $obj->area . "&acao=formulario&id=" . $obj->getLastId();
        }
        else{
            $obj->atualizar($record, $obj->t_usuarios, $_SESSION['usuario']['id']);
            $url = $_SERVER['HTTP_REFERER'];
        }
        
        header("Location: {$url}");
    }
    
    if($_POST['acao'] == 'deletar'){
        $obj->deletar($_POST['id'], $obj->t_usuarios);
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
?>