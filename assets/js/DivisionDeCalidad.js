$(document).ready(function () {
    AjaxCamas();
    let area = $('input[name=area]').val();
    function AjaxCamas() {
        $.ajax({
            url: base_url + "AdmisionHospitalaria/AjaxvisorCamasDivisionDeCalidad",
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading();
            }, success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.visor-camas').html(data.Col);
            }, error: function (e) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    }
    
});
