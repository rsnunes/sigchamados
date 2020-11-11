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

function fData($data){
    $data = explode('-', $data);
    return $data[2].'/'.$data[1].'/'.$data[0];
}
function fDataHora($data){
    if(!empty($data)){
        $data = explode(' ',$data);
        return fData($data[0]).' &agrave;s '.$data[1];
    }
    else
        return '';
}

?>