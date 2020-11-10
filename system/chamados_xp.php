<?php
    include('./config.php');
    $obj = new Chamados();
    
    if($_POST['acao'] == 'salvar'){
               
        if(empty($_SESSION['atualizar']['chamado_id'])){
            $record['usuarios_id'] = $_SESSION['usuario']['id'];
            $record['descricao'] = $_POST['descricao'];
            $obj->inserir($record, $obj->t_chamados);
            $url = $obj->url . "?area=" . $obj->area . "&acao=formulario&id=" . $obj->getLastId();
        }
        elseif($_SESSION['usuario']['tipo'] == 2){
            $record['solucao'] = isset($_POST['solucao']) ? $_POST['solucao'] : '';
            $record['status'] = isset($_POST['status']) ? $_POST['status'] : 0;
            
            $obj->atualizar($record, $obj->t_chamados, $_SESSION['atualizar']['chamado_id']);
            $_SESSION['atualizar']['chamado_id'] = 0;
            $url = $_SERVER['HTTP_REFERER'];
        }
        
        header("Location: {$url}");
    }
    
?>