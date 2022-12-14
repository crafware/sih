$(document).ready(function () {
    AjaxCamas();
    let area = $('input[name=area]').val();
    console.log(area)
    function AjaxCamas() {
        $.ajax({
            url: base_url + "AdmisionHospitalaria/AjaxvisorCamasDivisionDeCalidad",
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading();
            }, success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                console.log(data)
                $('.visor-camas').html(data.Col);
            }, error: function (e) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    }
});

$('body').on('click', '.buscarPacienteDDC', function (e) {
    var inputSelect = $('#inputSelect').val();
    var inputSearch = $('#inputSearch').val();
    var IngresosEgr = $('#inputSelectIngresosEgresosGet').val();
    var selectFecha = $('#selectFechaGet').val();
    var data = {
        "inputSelect": inputSelect,
        "inputSearch": inputSearch,
        "IngresosEgr": IngresosEgr,
        "selectFecha": selectFecha,
        csrf_token: csrf_token
    };
    e.preventDefault();
    if ($('input[name=inputSearch]').val() != '' || selectFecha != "") {
        $.ajax({
            url: base_url + "Hospitalizacion/BuscarPacienteDDC",
            type: 'POST',
            dataType: 'json',
            data: data
            , beforeSend: function (xhr) {
                msj_loading('Espere por favor esto puede tardar un momento');
            }, success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                console.log(data)
                if ($('select[name=inputSelect]').val() == 'POR_NOMBRE') {
                    $('.inputSelectNombre').removeClass('hide');
                } else {
                    $('.inputSelectNombre').addClass('hide');
                }
                $('#tableResultSearch').css("display", "");
                $('#tableResultSearch tbody').html(data.tr)
                InicializeFootable('#tableResultSearch');
                $('body .tip').tooltip();
            }, error: function (e) {
                bootbox.hideAll()
                MsjError();
            }
        })
    } else {
        msj_error_noti('ESPECIFICAR UN VALOR')
    }
});