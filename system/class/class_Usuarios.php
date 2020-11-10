<?php

class Usuarios extends Principal {
    function __construct(){
        parent::__construct();
        $this->area = 'usuarios';
        $this->tipo = array('0'=>'Usuário','1'=>'Cliente','2'=>'Funcionário');
    }
    
    public function formulario(){
        $id = $this->urlGetVal('id');
        $obj = array();
        if((int)$id > 0){
            $obj = $this->getRegistro($id,$this->t_usuarios);            
        }
        echo "<h2 class='form_title'>Cadastro de Usuários</h2>";
        $form = "<form id='f_usuarios' name='f_usuarios' action='{$this->url_system}{$this->area}_xp.php' method='post'>";
        $form .= "<input type='hidden' id='acao' name='acao' value='salvar' />";
        $_SESSION['usuario']['id'] = $obj['id'];
        $form .= "<p class='form_raw'><label for='nome'><span>Nome: </span><input type='text' id='nome' name='nome' value='{$obj['nome']}' /></label></p>";
        $form .= "<p class='form_raw'><label for='email'><span>Email: </span><input type='text' id='email' name='email' value='{$obj['email']}' /></label></p>";
        $form .= "<p class='form_raw'><label for='senha'><span>Senha: </span><input type='password' id='senha' name='senha' /></label></p>";
        //tipo usuario
        if($obj['tipo'] == 2){  
            $form .= "<p class='form_raw'><label for='tipo'>Tipo: <select name='tipo' id='tipo'>";
                foreach($this->tipo as $key => $tipo){
                    $s = ($obj['tipo'] == $tipo) ? 'selected' : '';
                    $form .= "<option value='{$key}' {$s} >{$tipo}</option>";
                }
            $form .= "</select></label></p>";
        }
        $form .= "<input type='submit' value='Salvar' />";
        $form .= "</form>";
        
        echo $form;
    }
    
    public function lista(){
        echo "<h2 class='list_title'>Lista de Usuários</h2>";
        $sql = "SELECT id, nome, email, tipo FROM {$this->t_usuarios} WHERE 1=1 ORDER BY id DESC";
        
        $obj = $this->listar($sql);
        
        if(count($obj) > 0){            
            $html = "<table name='lista_regs' border='0' cellpadding='2' cellspacing='2'>";
            $html .= "<tr><th>Alt</th><th>Del</th><th>Nome</th><th>Email</th><th>Tipo</th></tr>";
            foreach($obj as $row){
                $html .= "<tr><td>{$this->bt_alt($this->area,$row['id'])}</td>";
                $html .= "<td>{$this->bt_del($row['id'], $this->t_usuarios)}</td>";
                $html .= "<td>{$row['nome']}</td>";
                $html .= "<td>{$row['email']}</td>";
                $html .= "<td>{$this->tipo[$row['tipo']]}</td>";
                $html .= "</tr>";
            }
            $html .= "</table>";
        }
        else{
            $html = "Nenhum registro encontrado!";
        }
        echo $html;
    }
    
    function logar($email, $senha){
        $sql = "SELECT nome, email, tipo FROM {$this->t_usuarios} WHERE email = :email and senha = :senha limit 1";
        $params = array(':email'=>$email, ':senha'=>md5($senha));
        $usuario = $this->listar($sql, $params);
        
        if(count($usuario) == 1){ 
            $_SESSION['usuario']['logado'] = 1;
            $_SESSION['usuario']['nome'] = $usuario[0]['nome'];
            $_SESSION['usuario']['email'] = $usuario[0]['email'];
            $_SESSION['usuario']['tipo'] = $usuario[0]['tipo'];
            header("Location: {$this->url}");
        }
        else{
            return false;
        }
    }
    
    function usuarioLogado(){
        return $_SESSION['usuario']['logado'] == 1;
    }
}
