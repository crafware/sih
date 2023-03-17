var cont=0;
$(document).ready(function () {
  $('#add_otro_residente').click (function(e) {
  
      /*la varivable cont incrementa cada ves que se genera un nuevo médico residente
      la variable se concatena al identificador del campo con el proposito de tener distinguir cada uno
      en el momento de ser eliminados*/
      console.log("cont hola mundo");
      if(cont >= 4){
        alert('La nota medica solo acepta maximo 4 medicos residentes');
      }
      else{
        cont += 1;
        $("#medicoResidente").append(
        //'<div id=areaResidentes'+ cont +' style="padding: 10px 0px 30px 0px">'+
        '<div class="col-sm-12 form-group" id=areaResidentes'+ cont +'>'+
        '<div class="col-sm-4 col-md-3">  '+
        '<input id="medico'+ cont +'" class="form-control"  type="text" required name="nombre_residente[]" placeholder="Nombre(s)">'+
        '</div>'+
        '<div class="col-sm-4 col-md-3"> '+
        '<input id="medico'+ cont +'" class=form-control type="text" required name="apellido_residente[]" placeholder="Apellidos">'+
        '</div>'+
        '<div class="col-sm-3 col-md-3">'+
        '<input id="medico'+ cont +'" class=form-control type="text" required name="cedula_residente[]" placeholder="Cédula Profesional">'+
        '</div>'+
        '<div class="col-sm-2 col-md-2">'+
        '<input id="grado'+ cont +'" class="form-control"  type="text" required name="grado[]" placeholder="Grado (ej. R3MI)">'+
        '</div>'+
        '<div class="col-sm-1" >'+
        '<a href="#" onclick=quitarResidenteFormulario('+cont+') class="t btn btn-danger delete btn-xs" style="width:100%;height:100%;padding:7px;" id="quitar_residente'+cont+'"><span class="glyphicon glyphicon-remove"></span></a>'+
        '</div>'+
        '</div>');
        console.log(cont);
      } 
   /* $('body #quitar_residente'+cont).click(function (e) {
                var didConfirm = confirm("Are you sure You want to delete");
                if (didConfirm == true) {
                    $('#areaResidentes'+cont).remove();
                    cont -=1;
                    return true;
                } else {
                    return false;
                }
    });*/
  });

  $('#add_otro_residente2').click (function(e) {
  
    /*la varivable cont incrementa cada ves que se genera un nuevo médico residente
    la variable se concatena al identificador del campo con el proposito de tener distinguir cada uno
    en el momento de ser eliminados*/
    console.log(cont);
    if(cont >= 4){
      alert('La nota medica solo acepta maximo 4 medicos residentes');
    }
    else{
      cont += 1;
      $("#medicoResidente").append(
      '<div class="col-sm-12 form-group" id=areaResidentes'+ cont +'>'+
      '<div class="col-sm-4 col-md-3">  '+
      '<input id="medico'+ cont +'" class="form-control"  type="text" required name="nombre_residente[]" placeholder="Nombre(s)">'+
      '</div>'+
      '<div class="col-sm-4 col-md-3"> '+
      '<input id="medico'+ cont +'" class=form-control type="text" required name="apellido_residente[]" placeholder="Apellidos">'+
      '</div>'+
      '<div class="col-sm-3 col-md-3">'+
      '<input id="medico'+ cont +'" class=form-control type="text" required name="cedula_residente[]" placeholder="Cédula Profesional">'+
      '</div>'+
      '<div class="col-sm-2 col-md-2">'+
      '<input id="grado'+ cont +'" class="form-control"  type="text" required name="grado[]" placeholder="Grado (ej. R3MI)">'+
      '</div>'+
      '<div class=col-sm-1 >'+
      '<a href="#" class="btn btn-danger delete btn-xs" style="width:100%;height:100%;padding:7px;" id="quitar_residente'+cont+'"><span class="glyphicon glyphicon-remove"></span></a>'+
      '</div>'+
      '</div>');
 console.log(cont);
    } 

  $('body #quitar_residente'+cont).click(function (e) {
              var didConfirm = confirm("Are you sure You want to delete");
              if (didConfirm == true) {
                  $('#areaResidentes'+cont).remove();
                  cont -=1;
                  return true;
              } else {
                  return false;
              }
  });

});
  $('#medicosBase').typeahead({
          displayText: function(item) {
                 return (item.empleado_nombre+' '+item.empleado_apellidos)
            },

          afterSelect: function(item) {
                  this.$element[0].value = item.empleado_apellidos+' '+item.empleado_nombre;
                  $("input#empleado_id").val(item.empleado_id);
                  $("input#medicoMatricula").val(item.empleado_matricula);
            },
          source: function(query, result)  {
            $.ajax({
              url: base_url+"Sections/Documentos/BuscarMedicoBase",
              method:"GET",
              data:{query:query},
              dataType:"json",
              success:function(data)  {
                console.log(data);
                result($.map(data, function(item){
                return item;
                })); 
               }
            })
            }
    });

  $('.notaProcedimientos').submit(function (e) {
        e.preventDefault();
        SendAjax(
          $(this).serialize(),
          'Sections/Documentos/AjaxNotaProcedimientos',
          function (response) {
            console.log(response)
          if(response.accion=='1'){
            ActionCloseWindowsReload();
            AbrirDocumentoMultiple(base_url+'Inicio/Documentos/GenerarNotaProcedimientos/'+response.notas_id+'?inputVia='+$('input[name=inputVia]').val(),'NOTAS');
          }
        },'','No');
    });  
  
  console.log("response")

});
function quitarResidenteFormulario(residente){
  $('#areaResidentes'+residente).remove();
  cont -= 1;
  console.log('#areaResidentes'+residente)
  console.log(cont)
}
console.log("response")