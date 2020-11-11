<?php

class Comentarios extends Principal {
    function __construct(){
        parent::__construct();
        $this->area = 'comentarios';
    }
    
    public function formularioAjax($chamados_id){
        $js = "<script type='text/javascript'>
            $(document).ready(function(){
                listaComentarios('{$chamados_id}');
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
            function listaComentarios(chamados_id){                
                $.post('{$this->url_system}ajax.php',{'f':'listaComentarios','chamados_id':chamados_id},function(returned_data){
                    $('#lista_comentarios').empty().html(returned_data);                    
                });
            }
            </script>";
        $form = "<h3 class='form_subtitle'>Adicionar comentários</h3>";
        $form .= "<form id='f_comentarios' name='f_comentarios' action='{$this->url_system}ajax.php' method='post'>";
        $form .= "<input type='hidden' id='acao' name='acao' value='salvar' />";
        $form .= "<input type='hidden' id='chamados_id' name='chamados_id' value='{$chamados_id}' />";
        $form .= "<p class='form_row_ajax'><label for='comentario'><span>Comentário: </span><textarea id='comentario' name='comentario' class='input_text' cols='60' rows='3'></textarea></label></p>";
        $form .= "<input type='button' id='adicionarComentario' value='Adicionar' title='Adicionar comentário' class='input_button' />";
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
    
    public function listaAjax($chamados_id){
        echo "<h3 class='form_subtitle'>Comentários deste chamado</h3>";
        $sql = "SELECT a.comentario, a.dtains, b.nome FROM {$this->t_comentarios} a, {$this->t_usuarios} b WHERE a.chamados_id = :chamados_id and a.usuarios_id = b.id ORDER BY a.id DESC";
        $params[':chamados_id'] = $chamados_id;
        $obj = $this->listar($sql, $params);
        
        if(count($obj) > 0){            
            $html = "<table name='lista_ajax' border='0' cellpadding='2' cellspacing='2' class='table_regs'>";
            $html .= "<tr><th>Comentário</th><th>Adicionado por</th><th class='dta'>Data</th></tr>";
            foreach($obj as $row){                
                $html .= "<td>".substr($row['comentario'],0,200)."</td>";
                $html .= "<td>{$row['nome']}</td>";
                $html .= "<td>".fDataHora($row['dtains'])."</td>";
                $html .= "</tr>";
            }
            $html .= "</table>";
        }
        else{
            $html = "<p class='nenhum_reg'>Nenhum registro encontrado!</p>";
        }
        echo $html;
    }
    
}
?>
