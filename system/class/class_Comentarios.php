<?php

class Comentarios extends Principal {
    function __construct(){
        parent::__construct();
        $this->area = 'comentarios';
    }
    
    public function formularioAjax($chamados_id){
        $js = "<script type='text/javascript'>
            $(document).ready(function(){
                $('#adicionarComentario').click(function(){adicionarComentario();});              
            });
            function adicionarComentario(){
                var comentario = $('#comentario').val();
                var chamados_id = $('#chamados_id').val();
                if(comentario == ''){
                    alert('Preencha o campo!');
                    $('#comentario').focus();
                    return false;
                }
                
                $.post('{$this->url_system}ajax.php',{'f':'adicionarComentario','comentario':comentario,'chamados_id':chamados_id},function(returned_data){
                    if(returned_data == 1)
                        window.location.href = window.location.href;
                    else
                        alert('Falha ao salvar comentário!');
                });
            }
            </script>";
        $form = "<h2 class='form_subtitle'>Adicionar comentário</h2>";
        $form .= "<form id='f_comentarios' name='f_comentarios' action='{$this->url_system}ajax.php' method='post'>";
        $form .= "<input type='hidden' id='acao' name='acao' value='salvar' />";
        $form .= "<input type='hidden' id='chamados_id' name='chamados_id' value='{$chamados_id}' />";
        $form .= "<p class='form_raw_ajax'><label for='comentario'><span>Comentário: </span><textarea id='comentario' name='comentario' ></textarea></label></p>";
        $form .= "<input type='button' id='adicionarComentario' value='Adicionar' />";
        $form .= "</form>";
        
        echo $form;
        echo $js;
    }
    
    function adicionarComentario($comentario, $chamados_id){
        $record['comentario'] = $comentario;
        $record['chamados_id'] = $chamados_id;
        $record['usuarios_id'] = $_SESSION['usuario']['id'];
        if($this->inserir($record, $this->t_comentarios)){
            echo 1;
        }
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
