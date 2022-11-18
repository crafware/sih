$(document).ready(function (){

    $('select[name=inputSelect]').change(function () {
        if($(this).val()=='POR_NUMERO'){
            $('input[name=inputSearch]').attr('placeholder','INGRESAR N° DE PACIENTE');
        }if($(this).val()=='POR_NOMBRE'){
            $('input[name=inputSearch]').attr('placeholder','Ejemplo: Nombre Apellidos');
        }if($(this).val()=='POR_NSS'){
            $('input[name=inputSearch]').attr('placeholder','INGRESAR N.S.S (SIN AGREGADO)');
        }
    });

    $('input[name=inputSearch]').keyup(function (e) {
        if($('select[name=inputSelect]').val()=='POR_NUMERO' && $(this).val().length==11){
            AjaxPaciente();
            $(this).val('');
        }
    })
    
    $('.formSearch').submit(function (e) {
        e.preventDefault();
        if($('input[name=inputSearch]').val()!=''){
            AjaxPaciente();
        }else{
            msj_error_noti('ESPECIFICAR UN VALOR')
        }
    });
});
function AjaxPaciente() {
        $.ajax({
            url: base_url+"Sections/Pacientes/AjaxPaciente",
            type: 'POST',
            dataType: 'json',
            data:$('.formSearch').serialize(),
            beforeSend: function (xhr) {
                msj_loading('Espere por favor esto puede tardar un momento');
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if($('select[name=inputSelect]').val()=='POR_NOMBRE'){
                    $('.inputSelectNombre').removeClass('hide');
                }else{
                    $('.inputSelectNombre').addClass('hide');
                }
                $('#tableResultSearch tbody').html(data.tr)
                InicializeFootable('#tableResultSearch');
                $('body .tip').tooltip();

            },error: function (e) {
                bootbox.hideAll()
                MsjError();
            }
        })
}