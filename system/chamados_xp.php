<?php
    include('./config.php');
    $obj = new Chamados();
    
    if($_POST['acao'] == 'salvar'){
        $record['descricao'] = $_POST['descricao'];
        $record['usuarios_id'] = $_SESSION['usuario']['id'];
        if($_SESSION['usuario']['tipo'] == 2){
            $record['solucao'] = isset($_POST['solucao']) ? $_POST['solucao'] : '';
            $record['status'] = isset($_POST['status']) ? $_POST['status'] : 0;
        }
        
        
        if(empty($_SESSION['atualizar']['chamado_id'])){
            $obj->inserir($record, $obj->t_chamados);
            $url = $obj->url . "?area=" . $obj->area . "&acao=formulario&id=" . $obj->getLastId();
        }
        else{
            $obj->atualizar($record, $obj->t_chamados, $_SESSION['atualizar']['chamado_id']);
            $_SESSION['atualizar']['chamado_id'] = 0;
            $url = $_SERVER['HTTP_REFERER'];
        }
        
        header("Location: {$url}");
    }
    
    if($_POST['acao'] == 'deletar'){
        $obj->deletar($_POST['id'], $obj->t_chamados);
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
?>