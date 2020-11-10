<?php
    include('./config.php');
    
    if($_POST['f'] == 'adicionarComentario'){
        $co = new Comentarios();
        $co->adicionarComentario($_POST['comentario'], $_POST['chamados_id']);
    }