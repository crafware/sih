$('document').ready(function() {
	ObtenerUsuario();
	function ObtenerUsuario() {
		$.ajax({
	        url: base_url+"Laboratorio/Obtenerpacientes",
	        type: 'POST',
	        dataType: 'json',
	        data: {
	            area:$('input[name=area]').val(),
	            csrf_token:csrf_token
	        },beforeSend: function (xhr) {
	            msj_loading();
	        },success: function (data, textStatus, jqXHR) {
	            bootbox.hideAll();
	            $('.table-pacientes tbody').html(data.tr);
	            $('.title').html(data.title);
	            InicializeFootable('.table-pacientes');
	        },error: function (e) {
	            bootbox.hideAll();
	            msj_error_serve(e)
	        }

	    })
	}
});	