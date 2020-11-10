/* confirma exclusao do registro */
function conf_del(form_id){
    var form_id = form_id;
    if(confirm('Excluir este registro?'))
        document.forms[form_id].submit();                   
}
