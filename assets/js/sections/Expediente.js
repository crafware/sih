$(document).ready(function($) {
 /*
  $.extend(true, $.fn.dataTable.defaults, {
        info: true,
        paging: true,
        ordering: true,
        searching: true,
        processing: true,
        //retrieve: true,
        destroy: true,
        //serverSide: true,
       
        language: {
            url: base_url+"assets/libs/datatables/Spanish_Mexico.json"
        }
    });
  let paciente = $('.triage_id').val();
  var tablaPrescripciones = $('#tablaPrescripciones').DataTable({
    ajax:{
            url:base_url+"Sections/Medicamentos/Prescripciones/"+paciente,
            type:"POST",
            data: { csrf_token:csrf_token },
            dataSrc: 'data'
          },
    columns: [
                {"data": "folio"},
                {"data": "medicamento_nombre"},
                {"data": "dosis"},
                {"data": "duracion"},
                {"data": "acciones"}
              ],

    columnDefs: [                       
                  {
                   "targets": [0],
                   "data"   : "folio",
                   "render" : function (data,type,row) {
                            return "<span style='color:#006699;'>"+data+"</span><br>"+
                                   "<span style='color:#006699;'>"+row.fecha_prescripcion+"</span>";
                            }
                  },
                     
                  { 
                   "targets": [1],
                   "data": "medicamento_nombre",
                   "render": function(data,type,row){
                          return "<span style='color:#1A2935;'><b>"+data+"</b></span><br>";
                                 
                     
                          }
                  },
                  {
                   "targets": [2], 
                   "data": "dosis", 
                   "render": function(data, type, row) {
                      return "<span>"+row.dosis+" en "+row.frecuencia+" via "+row.via+"</span>"+
                             "<span>&nbsp;"+row.duracion+"</span><br>"+
                             "<span>Horario de aplicación:&nbsp;"+row.aplicacion+"</span>";          
                      }
                  },

                  {
                   "targets": [3], 
                   "data": "duracion", 
                   "render": function(data, type, row) {
                      return "<span style='color:#006699;'><i class='fas fa-syringe' style='font-size:18px'></i> &nbsp;"+data+"</span><br>";          
                      }
                  }

                    ] 

  });  */

  $("#btnAdd").click(function(){
    //let url = base_url+"Sections/Medicamentos/NuevaPrescripcion";
    //$("#formPrescripcion").trigger("reset");
    $(".modal-header").css( "background-color", "#FFFFFF");
    $(".modal-header").css( "color", "black" );
    $(".modal-title").text("Agregar nuevo medicamento");
    //$('#iframe-modal').attr("src",url);
    $('#modalPrescripcion').modal('show');      
  });

  // $('#formPrescripcion').submit(function(e){
  //   e.preventDefault();
  //   SendAjax($(this).serialize(),'Sections/Medicamentos/AjaxGuardarPrescripcion',function (response) {
  //     if(response.accion=='1'){
  //         tablaPrescripciones.ajax.reload(null, false); 
  //     }
  //   });
  //   $('#modalPrescripcion').modal('hide');  
  //   ;
  // }); 
});