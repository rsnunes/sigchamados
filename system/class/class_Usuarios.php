<?php

class Usuarios extends Principal {
    function __construct(){
        parent::__construct();
        $this->area = 'usuarios';
        $this->tipo = array('0'=>'Usuário','1'=>'Cliente','2'=>'Funcionário');
    }
    
    public function formulario(){        
        $id = ($_SESSION['usuario']['tipo'] != '2') ? $_SESSION['usuario']['id'] : $this->urlGetVal('id');
        $obj = array();
        if((int)$id > 0){
            $obj = $this->getRegistro($id,$this->t_usuarios);            
        }
        echo "<h2 class='form_title'>Cadastro de Usuários</h2>";
        $form = "<form id='f_usuarios' name='f_usuarios' action='{$this->url_system}{$this->area}_xp.php' method='post'>";
        $form .= "<input type='hidden' id='acao' name='acao' value='salvar' />";
        $_SESSION['atualizar']['usuario_id'] = $obj['id'];
        $form .= "<p class='form_raw'><label for='nome'><span>Nome: </span><input type='text' id='nome' name='nome' value='{$obj['nome']}' /></label></p>";
        $form .= "<p class='form_raw'><label for='email'><span>Email: </span><input type='text' id='email' name='email' value='{$obj['email']}' /></label></p>";
        $form .= "<p class='form_raw'><label for='senha'><span>Senha: </span><input type='password' id='senha' name='senha' /></label></p>";
        
        if($_SESSION['usuario']['tipo'] == 2){  
            $form .= "<p class='form_raw'><label for='tipo'>Tipo: <select name='tipo' id='tipo'>";
                foreach($this->tipo as $key => $tipo){
                    $s = ($obj['tipo'] == $key) ? 'selected' : '';
                    $form .= "<option value='{$key}' {$s} >{$tipo}</option>";
                }
            $form .= "</select></label></p>";
        }
        $form .= "<input type='submit' value='Salvar' />";
        $form .= "</form>";
        
        echo $form;
    }
    
    public function lista(){
        if($_SESSION['usuario']['tipo'] != '2'){
           $where = " id = :id";
           $params[':id'] = $_SESSION['usuario']['id'];
           $title = "Meu cadastro";
        }else{
            $bt_del = "<th>Del</th>";
            $where = ' 1=1 ';
            $params = array();
            $title = "Lista de Usuários";
        }
        echo "<h2 class='list_title'>{$title}</h2>";
        $sql = "SELECT id, nome, email, tipo FROM {$this->t_usuarios} WHERE {$where} ORDER BY id DESC";
        
        $obj = $this->listar($sql,$params);
        
        if(count($obj) > 0){            
            $html = "<table name='lista_regs' border='0' cellpadding='2' cellspacing='2'>";
            $html .= "<tr><th>Alt</th>{$bt_del}<th>Nome</th><th>Email</th><th>Tipo</th></tr>";
            foreach($obj as $row){
                $html .= "<tr><td>{$this->bt_alt($this->area,$row['id'])}</td>";
                $html .= ($_SESSION['usuario']['tipo'] == 2) ? "<td>{$this->bt_del($row['id'], $this->t_usuarios)}</td>" : '';
                $html .= "<td>{$row['nome']}</td>";
                $html .= "<td>{$row['email']}</td>";
                $html .= "<td>{$this->tipo[$row['tipo']]}</td>";
                $html .= "</tr>";
            }
            $html .= "</table>";
        }
        else{
            $html = "<p class='nenhum_reg'>Nenhum registro encontrado!</p>";
        }
        echo $html;
    }
    
    function logar($email, $senha){
        $sql = "SELECT id, nome, email, tipo FROM {$this->t_usuarios} WHERE email = :email and senha = :senha limit 1";
        $params = array(':email'=>$email, ':senha'=>md5($senha));
        $usuario = $this->listar($sql, $params);
        
        if(count($usuario) == 1){ 
            $_SESSION['usuario']['logado'] = 1;
            $_SESSION['usuario']['id'] = $usuario[0]['id'];
            $_SESSION['usuario']['nome'] = $usuario[0]['nome'];
            $_SESSION['usuario']['email'] = $usuario[0]['email'];
            $_SESSION['usuario']['tipo'] = $usuario[0]['tipo'];
            header("Location: {$this->url}");
        }
        else{
            return false;
        }
    }
    
    function cadastrarUsuario($nome, $email, $senha){
        $record['nome'] = $nome;
        $record['email'] = $email;
        $record['senha'] = md5($senha);
        $record['tipo'] = 0;
        $this->inserir($record, $this->t_usuarios);
        $_SESSION['usuario']['logado'] = 1;
        $_SESSION['usuario']['id'] = $_SESSION['last_id'];
        $_SESSION['usuario']['nome'] = $record['nome'];
        $_SESSION['usuario']['email'] = $record['email'];
        $_SESSION['usuario']['tipo'] = 0;
    }
            
    function usuarioLogado(){
        return $_SESSION['usuario']['logado'] == 1;
    }
    
    static function logout(){
        session_destroy();
    }
    
  
}
?>