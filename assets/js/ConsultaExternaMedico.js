$(document).ready(function () {
  init_InputMask();
  $('#btnborrardx').click(function() {
    $('#text_diagnostico_0').val('');
  });
  
  $('.orden-internamiento-medico').submit(function (e){
        e.preventDefault();
        $.ajax({
            url: base_url+'Consultaexterna/Guardarordeninternamiento',
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.accion=='1'){
                    AbrirDocumentoMultiple(base_url+'inicio/documentos/Ordeninternamiento/'+$('input[name=triage_id]').val(),'OI',100);
                    if($('select[name=triage_paciente_accidente_lugar]').val()=='TRABAJO'){
                        AbrirDocumentoMultiple(base_url+'inicio/documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',300);
                    }
                    window.location.href=base_url+'Consultaexterna/';
                }
            },error: function (e) {
                msj_error_serve();
                bootbox.hideAll();
                ReportarError(window.location.pathname,e.responseText)
            }
        })
    });
  /* Agregar eventos para el boton que permite agrgar un complemento para el diagnostico by CRAF*/
  $('#btncomplemento').click(function() {  
        displaying = $('.complemento').hasClass('hidden');
        if(displaying) {
          $('.complemento').removeClass('hidden');
          $('input[name=complemento]').attr('required',true);
        }else {
          $('.complemento').addClass('hidden');
          $('input[name=complemento]').val('');

        } 
      }
    );
});
function init_InputMask() {          
   if( typeof ($.fn.inputmask) === 'undefined'){ return; }
     console.log('init_InputMask');        
    $(":input").inputmask();             
};
function BuscarDiagnostico(indice){

  $('#lista_resultado_diagnosticos_'+indice).empty();
  var diagnostico_solicitado = $('#text_diagnostico_'+indice).val();
  var lista_opciones = "";
 
  //condicion para validar que un input sea seleccionado y filtrar la busqueda
  //if(diagnostico_solicitado.length >= 3 && tipo_diagnostico != null){
  if(diagnostico_solicitado.length >= 3){
    
    $.ajax({
        url:base_url+'Sections/Documentos/AjaxDiagnosticos',
        type: 'get',
        dataType: 'json',
        data:{diagnostico_solicitado:diagnostico_solicitado},
        success: function (data, textStatus, jqXHR) {
            console.log(data);
          $('#lista_resultado_diagnosticos_'+indice).empty();
            for(var x = 0; x < data.length; x++){
              lista_opciones =
              "<li class='lista_diagnosticos' id='lista_diagnosticos_"+indice+"' >"+
                "<a onclick=ConsultarClaveCIE10('"+data[x].cie10_clave+"',"+x+","+indice+","+data[x].cie10_id+") class='btn_diagnostico_cie10_"+x+"' id='btn_diagnostico_cie10'>"+data[x].cie10_nombre+"</a>"+
              "</li>";

              $('#lista_resultado_diagnosticos_'+indice).append(lista_opciones);
            }
        },error: function (jqXHR, textStatus, errorThrown) {
            bootbox.hideAll();
            MsjError();
        }
    });
  }
}

function ConsultarClaveCIE10(valor_clave,lista,indice,id_cie10){
  var diagnostico = $('.btn_diagnostico_cie10_'+lista).text();
  $('#text_diagnostico_'+indice).val(diagnostico);
  $('#text_codigo_diagnostico_'+indice).val(valor_clave);
  $('#text_id_diagnostico_'+indice).val(id_cie10);
  $('#lista_resultado_diagnosticos_'+indice).empty();
}