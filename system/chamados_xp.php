<?php
    include('./config.php');
    $obj = new Chamados();
    
    if($_POST['acao'] == 'salvar'){
               
        if(!$_SESSION['atualizar']['chamado_id'] > 0){
            $record['usuarios_id'] = $_SESSION['usuario']['id'];
            $record['descricao'] = $_POST['descricao'];
            $obj->inserir($record, $obj->t_chamados);
            $url = $obj->url . "?area=" . $obj->area . "&acao=formulario&id=" . $obj->getLastId();
        }
        elseif(Usuarios::getTipo()){
            $record['solucao'] = isset($_POST['solucao']) ? $_POST['solucao'] : '';
            $record['status'] = isset($_POST['status']) ? $_POST['status'] : 0;
            
            $obj->atualizar($record, $obj->t_chamados, $_SESSION['atualizar']['chamado_id']);
            $_SESSION['atualizar']['chamado_id'] = 0;
            $url = $_SERVER['HTTP_REFERER'];
        }        
        
        header("Location: {$url}");
    }
    
?>