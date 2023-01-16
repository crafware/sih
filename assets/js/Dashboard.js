/*$(document).ready(function (e){
       setInterval(function (e){
        AjaxDashboard_ac();
    },60000);

    function AjaxDashboard_ac() {

        $.ajax({
            url: base_url+"Dashboard/AjaxDashboard_ac",
            dataType: 'json',
            type: 'POST',
            data:{
              
                csrf_token:csrf_token
            },success: function (data, textStatus, jqXHR) {
                AjaxDashboard_ac()
                $('.result_camas').html(data.listaPacientes);
                $('.listaPacientesCortaEstancia').html(data.listaPacientesCortaEstancia);
                $('.listaPacientesAsignados').html(data.listaPacientesAsignados);
            },error: function (e) {
                
            }
        });  
    }

});*/