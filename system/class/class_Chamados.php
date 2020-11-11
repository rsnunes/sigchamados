<?php

class Chamados extends Principal {
    function __construct(){
        parent::__construct();
        $this->area = 'chamados';
        $this->status = array('0'=>'Não solucionado','1'=>'Solucionado','2'=>'Em análise');
    }
    
    public function formulario(){
        
        $_SESSION['atualizar']['chamado_id'] = 0;
       
        if(Usuarios::getTipo() == '0'){
           $this->acessoNegado();
        }
        elseif(Usuarios::getTipo() == 1){
            $where = " and usuarios_id = :usuarios_id";
            $params[':usuarios_id'] = getUserId();
        }
        $obj = array();
        $id = $this->urlGetVal('id');
        if((int)$id > 0){
            $params[':id'] = $id;
            $sql = "SELECT * FROM {$this->t_chamados} WHERE id = :id {$where} limit 1";
            $o = $this->listar($sql, $params); 
            $obj = $o[0];
        }
        
        $bts = $this->bt_acao().$this->bt_acao('Novo', 1);
        echo "<div class='form_title'><div class='box_acao dib'>{$bts}</div><h2 class=' dib'>Cadastro de Chamados</h2></div>";
    
        $form = "<form id='f_chamados' name='f_chamados' action='{$this->url_system}{$this->area}_xp.php' method='post'>";
        $form .= "<input type='hidden' id='acao' name='acao' value='salvar' />";    
        if(empty($obj['id'])){
            $form .= "<p class='form_row'><label for='descricao'><span>Descrição: </span><textarea id='descricao' name='descricao' class='input_text' >{$obj['descricao']}</textarea></label></p>";
        }
        else{
            $usuario = $this->getRegistro($obj['usuarios_id'], $this->t_usuarios, 'nome, tipo');  
            $form .= "<p class='form_row'><span>Cadastrado por: </span>{$usuario['nome']}</p>";
            $form .= "<p class='form_row'><span>Descrição: </span>{$obj['descricao']}</p>";
            
        }
        
        if(Usuarios::getTipo() == 2 && $obj['id'] && $obj['status'] != 1){  
            $_SESSION['atualizar']['chamado_id'] = $obj['id'];
            $form .= "<p class='form_row'><label for='solucao'><span>Solução: </span><textarea id='solucao' name='solucao' class='input_text' >{$obj['solucao']}</textarea></label></p>";
            $form .= "<p class='form_row'><label for='tipo'><span>Status: </span><select name='status' id='status' class='input_text'>";
                foreach($this->status as $key => $status){
                    $s = ($obj['status'] == $key) ? 'selected' : '';
                    $form .= "<option value='{$key}' {$s} >{$status}</option>";
                }
            $form .= "</select></label></p>";
        }
        elseif($obj['id']){
            $solucao = empty($obj['solucao']) ? '--' : $obj['solucao'];
            $form .= "<p class='form_row'><span>Solução: </span>{$solucao}</p>";
            $form .= "<p class='form_row'><span>Status: </span>{$this->status[$obj['status']]}</p>";
        }
        $form .= (!$obj['id'] || ($obj['id'] && $obj['status'] != 1 && Usuarios::getTipo() ==2)) ? "<input type='submit' value='Salvar' class='input_button' />" : '';
        $form .= "</form>";
        
        echo $form;
        
        if($obj['id']){
            echo "<div id='lista_comentarios' class='lista_ajax'></div>";
            $co = new Comentarios();
            $co->formularioAjax($obj['id']);
        }
    }
    
    public function lista($inicial=0){
        if(Usuarios::getTipo() == '0'){
           $this->acessoNegado();
        }
        
        $title = $link = '';
        if(Usuarios::getTipo() != 2){
            $where = ' a.usuarios_id = :usuarios_id';
            $params[':usuarios_id'] = $_SESSION['usuario']['id'];
        }
        elseif($inicial == 1){
            $where = " a.status = :status ";
            $params[':status'] = 0;
            $title = 'não solucionados';
            $link = "<p><a href='{$this->url}?area=chamados' title='Ver lista completa' >Ver lista completa</a></p>";
        }
        else{
            $where = " 1=1 ";
            $params = array();
        }
        $bts = ($inicial == 1) ? '' : $this->bt_acao();
        $bts .= $this->bt_acao('Novo', 1);
        $html = "<div class='form_title'><div class='box_acao dib'>{$bts}</div><h2 class=' dib'>Lista de Chamados {$title}</h2></div>";
    
        $sql = "SELECT a.id, a.descricao, a.status, a.dtains, a.dtaalt, b.nome FROM {$this->t_chamados} a, {$this->t_usuarios} b WHERE {$where} and a.usuarios_id = b.id ORDER BY a.id DESC";
        
        $obj = $this->listar($sql, $params);
        
        if(count($obj) > 0){          
            
            $html .= "<table name='lista_regs' border='0' cellpadding='2' cellspacing='2' class='table_regs'>";
            $html .= "<tr><th class='ver'>Ver</th><th>Status</th><th>Descrição</th><th class='dta'>Criado em</th><th class='dta'>Modificado em</th><th>Criado por</th></tr>";
            foreach($obj as $row){
                $html .= "<tr><td class='c'>{$this->bt_alt($this->area,$row['id'],'Ver')}</td>";
                $html .= "<td class='status_{$row['status']}'>{$this->status[$row['status']]}</td>";
                $html .= "<td>".substr($row['descricao'],0,150)."</td>";
                $html .= "<td>".fDataHora($row['dtains'])."</td>";
                $html .= "<td>".fDataHora($row['dtaalt'])."</td>";
                $html .= "<td>{$row['nome']}</td>";
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