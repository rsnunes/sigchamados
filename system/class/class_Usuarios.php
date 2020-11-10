<?php

class Usuarios extends Principal {
    function __construct(){
        parent::__construct();
        $this->area = 'usuarios';
    }
    
    public function formulario(){
        echo "<h2 class='form_title'>Cadastro de Usuários</h2>";
        $form = "<form id='f_usuarios' name='f_usuarios' action='{$this->url_system}{$this->area}_xp.php' method='post'>";
        $form .= "<input type='hidden' id='acao' name='acao' value='salvar' />";
        $_SESSION['usuario']['id'] = '';
        $form .= "<p class='form_raw'><label for='nome'><span>Nome: </span><input type='text' id='nome' name='nome' /></label></p>";
        $form .= "<p class='form_raw'><label for='email'><span>Email: </span><input type='text' id='email' name='email' /></label></p>";
        $form .= "<p class='form_raw'><label for='senha'><span>Senha: </span><input type='password' id='senha' name='senha' /></label></p>";
        //tipo funcionario
        $form .= "<input type='submit' value='Salvar' />";
        $form .= "</form>";
        
        echo $form;
    }
    
    public function lista(){
        echo "<h2 class='list_title'>Lista de Usuários</h2>";
        $sql = "SELECT id, nome, email, admin FROM {$this->t_usuarios} WHERE 1=1 ORDER BY id DESC";
        
        $obj = $this->listar($sql);
        if(count($obj) > 0){
            $html = "<table name='lista_regs' border='0' cellpadding='2' cellspacing='2'>";
            $html .= "<tr><th>Alt</th><th>Del</th><th>Nome</th><th>Email</th><th>Admin</th></tr>";
            foreach($obj as $row){
                $html .= "<tr><td>{$this->bt_alt($this->area,$row['id'])}</td>";
                $html .= "<td>{$this->bt_del($row['id'], $this->t_usuarios)}</td>";
                $html .= "<td>{$row['nome']}</td>";
                $html .= "<td>{$row['email']}</td>";
                $html .= "<td>{$row['admin']}</td>";
                $html .= "</tr>";
            }
            $html .= "</table>";
        }
        else{
            $html = "Nenhum registro encontrado!";
        }
        echo $html;
    }
}
