<?php

function v($s){
    var_dump($s);//debug
}

function getNome(){
    return $_SESSION['usuario']['nome']; //retorna nome do usuario
}
function getUserId(){
    return $_SESSION['usuario']['id']; //retorna id do usuario
}

function usuarioLogado(){
    return $_SESSION['usuario']['logado'] == 1; //verifica se usuario esta logado
}

?>