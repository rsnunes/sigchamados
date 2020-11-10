<?php

class Principal {
    function __construct(){
        $this->url = "http://127.0.0.1/sigchamados/";
        $this->url_system = $this->url . "system/";
        $this->url_class = $this->url_system . "class/";
        $this->url_img = $this->url . "media/img/";
        $this->url_css = $this->url . "media/css/";
        $this->url_js = $this->url . "media/js/";
        
        $this->t_usuarios = 'usuarios';
    }
    
    public function getLastId(){
        return $_SESSION['last_id'];
    }
    
    public function query($query, $params = array()){
        $conn = new Sql();
        return $conn->query($query, $params);
    }
    
    public function listar($query, $params = array()){
        $conn = new Sql();
        return $conn->select($query, $params);
    }
    
    public function inserir($record, $table){
        $campos = '';
        $values = '';
        foreach($record as $key => $val){
            $campos .= ",".$key;
            $values .= ",:".$key;
            $valores[":".$key] = $val;
        }
        
        $sql = "INSERT INTO {$table} (" . substr($campos, 1) . ") values (" . substr($values,1) . ")";
        $conn = new Sql();
        
        return $conn->inserir($sql, $valores);         
    }
    
    public function atualizar($record, $table, $id){
        $campos = '';
        $values = '';
        
        $sql = "UPDATE {$table} SET ";
        
        foreach($record as $key => $val){
            $campos .= ",". $key . " = :" . $key;
            $valores[":".$key] = $val;
        }
        
        $sql .= substr($campos, 1) . " WHERE id = :id";
        $valores[":id"] = $id;
        
        return $this->query($sql, $valores);
        
    }
    
    public function deletar($id, $table){
        $sql = "DELETE FROM {$table} WHERE id = :id";
        $valores[":id"] = $id;
        return $this->query($sql, $valores);
    }
    
    function bt_alt($area, $id, $titulo = 'Alterar'){
        $html = "<a href='{$this->url}?area={$area}&acao=formulario&id={$id}' title='{$titulo}' class='a_bt_alt'><input type='button' value='&nbsp;' /></a>";
        return $html;
    }
    
    function bt_del($id,$table){
        $f = "f_del_{$id}";
        $html = "<form id='{$f}' action='{$this->url_system}{$this->area}_xp.php method='post' >";
        $html .= "<input type='hidden' id='acao' value='deletar' />";
        $html .= "<input type='hidden' id='id' value='{$id}' />";
        $html .= "<input type='hidden' id='table' value='{$table}' />";
        $html .= "<input type='button' id='excluir{$id}' name='excluir{$id}' title='Deletar' value='&nbsp;' onclick=\"conf_del('{$f}')\" class='bt_del'>";
        $html .= "</form>";
        return $html;
    }
}

?>
