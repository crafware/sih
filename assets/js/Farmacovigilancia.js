$(document).ready(function () {

  $('.btn_estado_prescripcion').click(function(){
    var estado = $(this).attr('data-value');
    ConsultarEstadoPrescripcionesPaciente('estado',estado);
  });

  $('#select_filtro').change(function(){

    if($('#select_filtro option:selected').val() != 'Todos'){

      $('#input_busqueda').removeAttr('disabled');

    }else{
      $('#input_busqueda').attr('disabled',true);
    }
  });

  $('#input_busqueda').keyup(function(){

      var consulta = $(this).val(),
          filtro = $('#select_filtro option:selected').val();


          $.ajax({
              url: base_url+"Farmacovigilancia/AjaxBusqueda",
              type: 'GET',
              dataType: 'json',
              data:{
                  filtro:filtro,
                  consulta: consulta
              },success: function (data, textStatus, jqXHR) {
                $('#tbl_paciente_prescripcion').empty(fila);
                var fila = '',
                    color_estado;
                for(var x = 0; x < data.length; x++){
                  color_estado = AsignarColorEstadoPrescripcion(data[x].estado);
                  fila = "" +
                  "<tr class='fila_paciente' style='cursor: pointer;' onClick=TomarDatosTabla("+x+"); data-value="+x+" >"+
                    "<td id='id_"+x+"'  style='background-color: "+color_estado+";' >"+data[x].triage_id+"</td>"+
                    "<td id='paciente_"+x+"' >"+data[x].triage_nombre+" "+data[x].triage_nombre_ap+"</td>"+
                    "<td id='cama_"+x+"' >"+data[x].cama_nombre+"</td>"+
                    "<td id='area_"+x+"' >"+data[x].area_nombre+"</td>"+
                    "<td id='medico_"+x+"' >"+data[x].empleado_nombre+" "+data[x].empleado_apellidos+"</td>"+
                    "<td id='medicamento_"+x+"' >"+data[x].medicamento+"</td>"+
                  "</tr>"+
                  "";
                  $('#tbl_paciente_prescripcion').append(fila);
                }

              },error: function (jqXHR, textStatus, errorThrown) {
                  bootbox.hideAll();
                  MsjError();
              }
          });



  });

  $('.form_conciliacion_prescripciones').submit(function(){
    alert("hola");
  });

  $('.fila_paciente').click(function(){
    var fila = $(this).attr('data-value'),
        folio = $('#id_'+fila).text(),
        paciente = $('#paciente_'+fila).text(),
        cama = $('#cama_'+fila).text(),
        area = $('#area_'+fila).text(),
        medico = $('#medico_'+fila).text()
        dataArray = [fila,folio,paciente,cama,area,medico];

    ModalPacientePrescripciones(dataArray);

  });

  $('.op_filtro').click(function(){
    var op_filtro = $(this).text();
    $('#filtro_busqueda').text(op_filtro);
  });

});

function ModalPacientePrescripciones(dataArray){
  var paciente = dataArray[2],
      cama = dataArray[3],
      area = dataArray[4],
      medico = dataArray[5];
  $.ajax({
      url: base_url+"Farmacovigilancia/AjaxPrescripcionesPaciente",
      type: 'GET',
      dataType: 'json',
      data:{
          folio:dataArray[1]
      },success: function (data, textStatus, jqXHR) {
        var filaDatos = "";
        var nueva_fila = "";
        var estado = 0;
        var color_estado = "";
        var check = "";
        var acciones = "";
        var interaccion_roja = "";
        var interaccion_amarilla = "";
        var array_interaccion_roja = [];
        var array_interaccion_amarilla = [];
        var id_medicamento = '';
        var color_interaccion = "";
        var color_letra = "";
        var prescripcion_id = 0;
        var medicamento = "";
        var dosis = "";
        var pr_via= "";
        var frecuencia = "";

        for(var x = 0; x < data.length; x++){
          console.log('Inicio vuelta:'+(x+1)+'/'+data.length);
          prescripcion_id = data[x].prescripcion_id;
          medicamento = data[x].medicamento;
          dosis = data[x].dosis;
          pr_via = data[x].pr_via;
          frecuencia = data[x].frecuencia;

          estado = data[x].estado;
          check = (estado == 2)? 'checked':'';
          color_estado = AsignarColorEstadoPrescripcion(estado);
          id_medicamento = data[x].id_medicamento;
          interaccion_roja = data[x].interaccion_roja; //Texto sin desglosar
          interaccion_amarilla = data[x].interaccion_amarilla;

          //primera vuelta, los arreglos no tienen datos
          if(array_interaccion_roja.length == 0 &&
             array_interaccion_amarilla.length == 0){

               array_interaccion_roja = interaccion_roja.split(',');
               array_interaccion_amarilla = interaccion_amarilla.split(',');
               console.log('Primera vuelta se declaran arreglos: '+array_interaccion_roja+' / '+array_interaccion_amarilla);

          }else{ //segunda vuelta

              console.log('Segunda y posteriores vueltas, comparacion de medicamentos');
              for(var y = 0; y < array_interaccion_amarilla.length; y++){
                console.log('Comparacion amarilla: '+id_medicamento+' - '+array_interaccion_amarilla[y]);
                if(id_medicamento === array_interaccion_amarilla[y]){
                  color_interaccion = "rgb(255, 245, 0)";

                }
              }
              for(var z = 0; z < array_interaccion_roja.length; z++){
                console.log('Comparacion roja: '+id_medicamento+' - '+array_interaccion_roja[z]);
                if(id_medicamento === array_interaccion_roja[z]){
                  color_interaccion = "rgb(255, 1, 1)";
                  color_letra = "rgb(255, 255, 255)";

                }
              }

              if(interaccion_roja != "0"){

                array_interaccion_roja = array_interaccion_roja.concat(interaccion_roja.split(','));

              }
              if(interaccion_amarilla != "0"){
                array_interaccion_amarilla = array_interaccion_amarilla.concat(interaccion_amarilla.split(','));
              }



          }


          if(estado != 0){
            acciones = ""+
            "<label class='md-check'>"+
              "<input type='checkbox' data-value='"+estado+"' "+check+" onClick=ActualizarEstadoPrescripcion("+prescripcion_id+"); /><i class='blue'></i>"+
            "</label>"+
            "<button class='btn btn-xs back-imss btn_msj_prescripcion' onClick=FormMensajePrescripcion("+prescripcion_id+"); >Mensaje</button>"+
            "";
          }



          nueva_fila = ""+
          "<tr>"+
            "<td style='background-color:"+color_estado+"'>"+prescripcion_id+"</td>"+
            "<td style='background-color:"+color_interaccion+"; color:"+color_letra+"'>"+medicamento+"</td>"+
            "<td>"+dosis+"</td>"+
            "<td>"+pr_via+"</td>"+
            "<td>"+frecuencia+"</td>"+
            "<td>"+
              acciones+
            "</td>"+
          "</tr>"+
          "";
          filaDatos = filaDatos + nueva_fila;
          acciones = "";
          console.log('Fin vuelta:'+(x+1)+'/'+data.length);
          color_interaccion = "";
          color_letra = "";
        }
        console.log('ultima array: '+array_interaccion_roja+'/ tot: '+array_interaccion_roja.length);

        bootbox.confirm({
          size: 'large',
          title:'Paciente '+paciente+' Cama: '+cama+' Area: '+area+' Médico: '+medico,
          message: ''+
          '<div class="table-responsive">'+
              '<table class="table table-hover table-responsive center">'+
                '<thead>'+
                  '<tr>'+
                    '<th>Folio</th>'+
                    '<th>Prescripción</th>'+
                    '<th>Dosis</th>'+
                    '<th>Via</th>'+
                    '<th>Frecuencia</th>'+
                    '<th>Acciones</th>'+
                  '</tr>'+
                '</thead>'+
                '<tbody>'+
                  filaDatos+
                '</tbody>'+
              '</table>'+

          '</div>'+
          '',
          buttons: {
            confirm: {
                label: 'Aceptar',
                className: 'back-imss'
            },
            cancel: {
                label: 'Cancelar',
                className: 'btn-basic'
            }
          },
          callback: function(result){
            window.location.reload(true);
          }
        });


      },error: function (jqXHR, textStatus, errorThrown) {
          bootbox.hideAll();
          MsjError();
      }
  });


}


function TomarDatosTabla(fila){

  var folio = $('#id_'+fila).text(),
      paciente = $('#paciente_'+fila).text(),
      cama = $('#cama_'+fila).text(),
      area = $('#area_'+fila).text(),
      medico = $('#medico_'+fila).text()
      dataArray = [fila,folio,paciente,cama,area,medico];

  ModalPacientePrescripciones(dataArray);

}


function BusquedaPorFiltroPacientePrescripcion(filtro, consulta){
  $.ajax({
      url: base_url+"Farmacovigilancia/AjaxBusquedaPorFiltroPacientePrescripcion",
      type: 'GET',
      dataType: 'json',
      data:{
          filtro:filtro,
          consulta: consulta
      },success: function (data, textStatus, jqXHR) {
        $('#tbl_paciente_prescripcion').empty(fila);
        var fila = '',
            color_estado;
        for(var x = 0; x < data.length; x++){
          color_estado = AsignarColorEstadoPrescripcion(data[x].estado);
          fila = "" +
          "<tr class='fila_paciente' style='cursor: pointer;' onClick=TomarDatosTabla("+x+"); data-value="+x+" >"+
            "<td id='id_"+x+"'  style='background-color: "+color_estado+";' >"+data[x].triage_id+"</td>"+
            "<td id='paciente_"+x+"' >"+data[x].triage_nombre+" "+data[x].triage_nombre_ap+"</td>"+
            "<td id='cama_"+x+"' >"+data[x].cama_nombre+"</td>"+
            "<td id='area_"+x+"' >"+data[x].area_nombre+"</td>"+
            "<td id='medico_"+x+"' >"+data[x].empleado_nombre+" "+data[x].empleado_apellidos+"</td>"+
            "<td id='medicamento_"+x+"' >"+data[x].medicamento+"</td>"+
          "</tr>"+
          "";
          $('#tbl_paciente_prescripcion').append(fila);
        }

      },error: function (jqXHR, textStatus, errorThrown) {
          bootbox.hideAll();
          MsjError();
      }
  });
}

function ConsultarEstadoPrescripcionesPaciente(filtro,estado){

  $.ajax({
      url: base_url+"Farmacovigilancia/AjaxPacientePrescripcion",
      type: 'GET',
      dataType: 'json',
      data:{
          estado:estado,
          filtro:filtro
      },success: function (data, textStatus, jqXHR) {
        $('#tbl_paciente_prescripcion').empty(fila);
        var fila = '',
            color_estado;
        for(var x = 0; x < data.length; x++){
          color_estado = AsignarColorEstadoPrescripcion(data[x].estado);
          fila = "" +
          "<tr class='fila_paciente' style='cursor: pointer;' onClick=TomarDatosTabla("+x+"); data-value="+x+" >"+
            "<td id='id_"+x+"'  style='background-color: "+color_estado+";' >"+data[x].triage_id+"</td>"+
            "<td id='paciente_"+x+"' >"+data[x].triage_nombre+" "+data[x].triage_nombre_ap+"</td>"+
            "<td id='cama_"+x+"' >"+data[x].cama_nombre+"</td>"+
            "<td id='area_"+x+"' >"+data[x].area_nombre+"</td>"+
            "<td id='medico_"+x+"' >"+data[x].empleado_nombre+" "+data[x].empleado_apellidos+"</td>"+
            "<td id='medicamento_"+x+"' >"+data[x].medicamento+"</td>"+
          "</tr>"+
          "";
          $('#tbl_paciente_prescripcion').append(fila);
        }

      },error: function (jqXHR, textStatus, errorThrown) {
          bootbox.hideAll();
          MsjError();
      }
  });
}

function AsignarColorEstadoPrescripcion(estado){

  switch (estado) {
    case '0':
      return 'rgb(242, 222, 222)';
    case '1':
      return 'rgb(252, 248, 227)';
    case '2':
      return 'rgb(223, 240, 216)';
  }

}

function FormMensajePrescripcion(prescripcion_id){
  $.ajax({
    url: base_url+"Farmacovigilancia/AjaxConsultarMensajePrescripcion",
    type: 'GET',
    dataType: 'JSON',
    data: {
      'prescripcion_id' : prescripcion_id
    },success: function(data){

      var mensaje =(data.num_resultados > 0)?data.consulta[0].notificacion : '';
      bootbox.confirm({
        size: 'large',
        title:'Notificación',
        message: ''+
        '<div class="form-group">'+
        '<label>Mensaje</label>'+
        '<input type="text" id="prescripcion_id" value="'+prescripcion_id+'" hidden />'+
        '<textarea class="form-control" id="mensaje_prescripcion" >'+mensaje+'</textarea>'+
        '</div>'+
        '',
        buttons: {
          confirm: {
              label: 'Aceptar',
              className: 'back-imss'
          },
          cancel: {
              label: 'Cancelar',
              className: 'btn-basic'
          }
        },
        callback: function(result){
          var prescripcion_id = $('#prescripcion_id').val(),
              mensaje_prescripcion = $('#mensaje_prescripcion').val();

          $.ajax({
              url: base_url+"Farmacovigilancia/AjaxGestionMensajePrescripcion",
              type: 'GET',
              dataType: 'JSON',
              data: {
                'prescripcion_id' : prescripcion_id,
                'mensaje_prescripcion' : mensaje_prescripcion
              },success: function(data){
                console.log(data.mensaje);
              }
          });

        }
      });


    }
  });



}

function ActualizarEstadoPrescripcion(prescripcion_id){

  $.ajax({
      url: base_url+"Farmacovigilancia/AjaxActivarPrescrpciones",
      type: 'GET',
      data: {'prescripcion_id':prescripcion_id},
      dataType: 'json',
      success: function (data, textStatus, jqXHR) {
      }
  });

}
