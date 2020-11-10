<?php

class Chamados extends Principal {
    function __construct(){
        parent::__construct();
        $this->area = 'chamados';
        $this->status = array('0'=>'Não solucionado','1'=>'Solucionado');
    }
    
    public function formulario(){
        $id = $this->urlGetVal('id');
        $obj = array();
        if((int)$id > 0){
            $obj = $this->getRegistro($id,$this->t_chamados);            
        }
        
        echo "<h2 class='form_title'>Cadastro de Chamados</h2>";
        $form = "<form id='f_chamados' name='f_chamados' action='{$this->url_system}{$this->area}_xp.php' method='post'>";
        $form .= "<input type='hidden' id='acao' name='acao' value='salvar' />";    
        $_SESSION['atualizar']['chamado_id'] = $obj['id'];
        $usuario = $this->getRegistro($obj['usuarios_id'], $this->t_usuarios, 'nome, tipo');  
        $form .= "<p class='form_raw'><span>Cadastrado por: </span>{$usuario['nome']}</p>";
        $form .= "<p class='form_raw'><label for='descricao'><span>Descrição: </span><textarea id='descricao' name='descricao' >{$obj['descricao']}</textarea></label></p>";
        //tipo usuario
        
        if($_SESSION['usuario']['tipo'] == 2 && $obj['id']){  
            $form .= "<p class='form_raw'><label for='solucao'><span>Solução: </span><textarea id='solucao' name='solucao' >{$obj['solucao']}</textarea></label></p>";
            $form .= "<p class='form_raw'><label for='tipo'>Status: <select name='status' id='status'>";
                foreach($this->status as $key => $status){
                    $s = ($obj['status'] == $key) ? 'selected' : '';
                    $form .= "<option value='{$key}' {$s} >{$status}</option>";
                }
            $form .= "</select></label></p>";
        }
        elseif($obj['id']){
            $form .= "<p class='form_raw'><span>Status: </span>{$this->status[$obj['status']]}</p>";
        }
        $form .= "<input type='submit' value='Salvar' />";
        $form .= "</form>";
        
        echo $form;
        if($obj['id']){
            echo "<div id='lista_comentarios' class='lista_ajax'></div>";
            $co = new Comentarios();
            $co->formularioAjax($obj['id']);
        }
    }
    
    public function lista($inicial=0){
        $title = $link = '';
        if($_SESSION['usuario']['tipo'] != 2){
            $where = ' usuarios_id = :usuarios_id';
            $params[':usuarios_id'] = $_SESSION['usuario']['id'];
        }
        elseif($inicial == 1){
            $where = " status = :status ";
            $params[':status'] = 0;
            $title = 'não solucionados';
            $link = "<p><a href='{$this->url}?area=chamados' title='Ver lista completa' >Ver lista completa</a></p>";
        }
        else{
            $where = " 1=1 ";
            $params = array();
        }
        $html = "<h2 class='list_title'>Lista de Chamados {$title}</h2>";
        $sql = "SELECT id, descricao, status, dtains, dtaalt FROM {$this->t_chamados} WHERE {$where} ORDER BY id DESC";
        
        $obj = $this->listar($sql, $params);
        
        if(count($obj) > 0){          
            $del = ($_SESSION['usuario']['tipo'] == 2) ? "<th>Del</th>" : '';
            
            $html .= "<table name='lista_regs' border='0' cellpadding='2' cellspacing='2'>";
            $html .= "<tr><th>Alt</th>{$del}<th>Status</th><th>Descrição</th><th>Criado em</th><th>Modificado em</th></tr>";
            foreach($obj as $row){
                $html .= "<tr><td>{$this->bt_alt($this->area,$row['id'])}</td>";
                $html .= ($_SESSION['usuario']['tipo'] == 2) ? "<td>{$this->bt_del($row['id'], $this->t_chamados)}</td>" : '';
                $html .= "<td>{$this->status[$row['status']]}</td>";
                $html .= "<td>".substr($row['descricao'],0,150)."</td>";
                $html .= "<td>{$row['dtains']}</td>";
                $html .= "<td>{$row['dtaalt']}</td>";
                $html .= "</tr>";
            }
            $html .= "</table>";
        }
        else{
            $html .= "<p class='nenhum_reg'>Nenhum registro encontrado!</p>{$link}";
        }
        echo $html;
    }
    
    
    
    
}


?>