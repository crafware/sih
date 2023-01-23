var cont = 0;
$(document).ready(function () {
  $('input[name=motivo_egreso][value="' + $('input[name=motivo_egreso]').data('value') + '"]').prop("checked", true);
  $('input[name=req_oxigeno][value="' + $('input[name=req_oxigeno]').data('value') + '"]').prop("checked", true);
  $('input[name=informeMedico][value="' + $('input[name=informeMedico]').data('value') + '"]').prop("checked", true);
  $('input[name=proceso][value="' + $('input[name=proceso]').data('value') + '"]').prop("checked", true);

  // Checkbox de ambulancia 
  $('input[name=check_ambulancia]').click(function () {
    if ($(this).val() == 0) {
      $(this).val('1');
      $('.div_ambulancia').removeClass('hidden');
    } else if ($(this).val() == 1) {
      $(this).val('0');
      $('.div_ambulancia').addClass('hidden');
      //$('input:radio[name="req_ambulancia"]').attr('checked', false);
    }
  });

  if ($('input[name=check_ambulancia]').prop('checked')) {
    $('input[name=req_ambulancia][value="' + $('input[name=req_ambulancia]').data('value') + '"]').prop("checked", true)
    $('.div_ambulancia').removeClass('hidden');
  }
  // Informe Médico
  $('input[name=informeMedico]').click(function () {
    if ($(this).val() == 1) {
      $('#informeFamiliar').removeClass('hidden');
      $('input[name=familiar_informe]').attr('required', true);
    } else {
      $('#informeFamiliar').addClass('hidden');
      $('input[name=familiar_informe]').val('');
      $('input[name=familiar_informe]').attr('required', false);

    }
  });

  // if($('input[name=informeMedico]').attr('data-value')!='0'){
  //     $('#informeFamiliar').removeClass('hidden');
  //     $('input[name=informeMedico][value="1"]').prop("checked",true);

  // }

  $('#medicosBase').typeahead({
    displayText: function (item) {
      return (item.empleado_apellidos + ' ' + item.empleado_nombre)
    },

    afterSelect: function (item) {
      this.$element[0].value = item.empleado_apellidos + ' ' + item.empleado_nombre;
      $("input#empleado_id").val(item.empleado_id);
      $("input#medicoMatricula").val(item.empleado_matricula);
    },
    source: function (query, result) {
      $.ajax({
        url: base_url + "Sections/Documentos/BuscarMedicoBase",
        method: "GET",
        data: { query: query },
        dataType: "json",
        success: function (data) {
          console.log(data);
          result($.map(data, function (item) {
            return item;
          }));
        }
      })
    }
  });

  $("#add_otro_residente").click (function(e) {
        
    /*la varivable cont incrementa cada ves que se genera un nuevo médico residente
    la variable se concatena al identificador del campo con el proposito de tener distinguir cada uno
    en el momento de ser eliminados*/

    if(cont >= 4){
      alert('La nota medica solo acepta maximo 5 medicos residentes');
    }
    else{
      cont += 1;
      $("#medicoResidente").append(
      '<div id=areaResidentes'+ cont +' class="col-sm-12 form-group">'+
      '<div class=col-sm-3 >'+
      '<input id="medico'+ cont +'" class="form-control"  type="text" required name="nombre_residente[]" placeholder="Nombre(s)">'+
      '</div>'+
      '<div class=col-sm-3 >'+
      '<input id="medico'+ cont +'" class=form-control type="text" required name="apellido_residente[]" placeholder="Apellidos">'+
      '</div>'+
      '<div class=col-sm-3 >'+
      '<input id="medico'+ cont +'" class=form-control type="text" required name="cedula_residente[]" placeholder="Cédula Profesional">'+
      '</div>'+
      '<div class=col-sm-2 >'+
      '<input id="grado'+ cont +'" class="form-control"  type="text" required name="grado[]" placeholder="Grado (ej. R3MI)">'+
      '</div>'+
      '<div class=col-sm-1 >'+
      '<a href="#" onclick=quitarResidenteFormulario('+cont+') class="btn btn-danger delete btn-xs" style="width:100%;height:100%;padding:7px;" id="quitar_residente"><span class="glyphicon glyphicon-remove"></span></a>'+
      '</div>'+
      '</div>');
      console.log(cont);
    }    
  });

  $('.Form-Nota-Egreso').submit(function (e){ 
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        url: base_url+'Sections/Documentos/AjaxNotaEgreso',
        type: 'POST',
        dataType: 'json',
        data:data,
        beforeSend: function (xhr) {
            //msj_loading();
        },success: function (data, textStatus, jqXHR) {
        console.log(data);
        if (data.accion == '1') {
          window.opener.location.reload();
          window.top.close();
          AbrirDocumentoMultiple(base_url+'Inicio/Documentos/GenerarNotaEgreso/'+data.notas_id+'?via='+$('input[name=via]').val()+'?inputVia='+$('input[name=inputVia]').val()+'?TipoNota='+$('input[name=tipo_nota]').val(),'NOTAS');
        }
      },error: function (e) {
        bootbox.hideAll();
        MsjError();
        console.log(e);
      }
}); // fin ajax
});// fin 

});



                  