$(document).ready(function (e){
    setInterval(function (e){
        AjaxListaCe();
    },30000);
    AjaxListaCe();
    function AjaxListaCe() {
        $.ajax({
            url: base_url+"Sections/Listas/AjaxListaCe",
            dataType: 'json',
            type: 'POST',
            data:{
                csrf_token:csrf_token
            },success: function (data, textStatus, jqXHR) {
                if(data.ListaPacientesLast==''){
                    $('.last_lista_no').addClass('hide')
                }else{
                    $('.last_lista_no').removeClass('hide')
                }
                if(data.TOTAL_LISTA==0){
                    $('.consultoriosespecialidad_last_lista tbody tr').html('<td colspan="4" style="border: none!important"><h2 style="font-size: 41px;text-align: center;font-weight: bold;margin-top: 40px;">UMAE Hospital de especilidades del CMN Siglo XXI<br></h2></td>');
                }else{
                    $('.consultoriosespecialidad_last_lista tbody tr').html(data.ListaPacientesLast);
                }
                if(data.ListaPacientesAll==null){
                    $('.table-pacientes-especialidad-no').removeClass('hide')
                    $('.table-pacientes-especialidad').addClass('hide');
                }else{
                    $('.table-pacientes-especialidad-no').addClass('hide')
                    $('.table-pacientes-especialidad').removeClass('hide');
                    $('.table-pacientes-especialidad').html(data.ListaPacientesAll);
                }
                if(data.ListaAccion=='1'){
                    location.reload();
                }
            },error: function (e) {
                
            }
        });  
    }

});