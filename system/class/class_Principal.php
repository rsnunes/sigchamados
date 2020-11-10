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
        $this->t_chamados = 'chamados';
        $this->t_comentarios = 'comentarios_chamados';
    }
    
    function getArea(){
        return isset($_GET['area']) ? $_GET['area'] : 'home';
    }
    
    function urlGetVal($field){
        return isset($_GET[$field]) ? $_GET[$field] : '';
    }
    
    
    function getLastId(){
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
    
    public function getRegistro($id, $table, $campo='*'){
        $sql = "SELECT {$campo} FROM {$table} WHERE id = :id";
        $obj = $this->listar($sql,array(':id'=>$id));            
        
        return $obj[0];
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
        $html = "<form id='{$f}' action='{$this->url_system}{$this->area}_xp.php' method='post' >";
        $html .= "<input type='hidden' name='acao' value='deletar' />";
        $html .= "<input type='hidden' name='id' value='{$id}' />";
        $html .= "<input type='hidden' name='table' value='{$table}' />";
        $html .= "<input type='button' id='excluir{$id}' name='excluir{$id}' title='Deletar' value='&nbsp;' onclick=\"conf_del('{$f}')\" class='bt_del'>";
        $html .= "</form>";
        return $html;
    }
    
    function bt_acao($titulo = 'Voltar', $novo = 0){
        $area = $this->getArea();
        $acao = $this->urlGetVal('acao');
        $id = $this->urlGetVal('id');
        if($novo == 1){
            $url = "?area={$area}&acao=formulario";
        }
        elseif($id || $acao){
            $url = "?area={$area}";            
        }
        
        $html = "<a href='{$this->url}{$url}' title='{$titulo}' class='bt_acao'>{$titulo}</a>";
        return $html;
    }
    function getTitle(){
        return "<h1>SIG Chamados</h1><h3>Sistema gerenciador de chamados</h3>";        
    }
    function getAbout(){
        $html = "<p>Neste sistema você poderá:";
        $html .= "<ol><li>Inserir novos chamados</li>";
        $html .= "<li>Consultar a situação dos seus chamados</li>";
        $html .= "<li>Verificar a solução encontrada para o seu chamado</li>";
        $html .= "<li>Adicionar comentários aos seus chamados</li>";
        $html .= "<li>Atualizar seu <a href='{$this->url}?area=usuarios&acao=formulario&id={$_SESSION['usuario']['id']}'>perfil</a></li></ol></p>";
        return $html;
    }
    
    function setMsg($msg){
        $_SESSION['msg'] = $msg;
    }
    function getMsg(){
        $msg = $_SESSION['msg'];
        $_SESSION['msg'] = '';
        return "<div class='msg'>{$msg}</div>";
    }
    
    function acessoNegado(){
        $this->setMsg('Acesso negado! Aguarde a liberação de seus acessos por um funcionário.');
        header("Location: {$this->url}");
    }
}

?>
