<?php
    include('./config.php');
    
    if($_POST['f'] == 'adicionarComentario'){
        $co = new Comentarios();
        $co->adicionarComentario($_POST['comentario'], $_POST['chamados_id']);
    }
    elseif($_POST['f'] == 'listaComentarios'){
        $co = new Comentarios();
        $co->listaAjax($_POST['chamados_id']);
    }