<?= modules::run('Sections/Menu/index'); ?>  
<link href="<?= base_url()?>assets/libs/datatables/datatables.css" rel="stylesheet">
<div class="panel panel-default ">       
  <div class="panel-body b-b b-light">
    <div class="row">
      <div class="col-md-3">
          <label for=""><b>Buscar folio para orden de internamiento</b></label>
          <div class="input-group m-b">
              <input type="text" name="triage_id" class="form-control" placeholder="Ingresar N° de Folio">
              <span class="input-group-addon back-imss border-back-imss pointer">
                  <i class="fa fa-search"></i>
              </span>
          </div>
      </div>
      <div class="col-md-3">
          <label for=""><b>Fecha de ingreso</b></label>
          <div class="input-group m-b">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input type="text" name="fecha" class="form-control" id="fecha" value="<?php echo date("d-m-Y");?>" placeholder="Seleccionar fecha">
          </div>
      </div>
      <div class="col-md-3">
          <input type="hidden" name="tipoconsulta" id="tipoconsulta" value="preregistro">
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">    
          <!-- <table id="tableRegistros" class="table table-bordered footable"  data-filter="#search" data-page-size="20" data-limit-navigation="8"> -->
              <table class="table table-striped table-bordered" id="tableRegistros">
              <thead>
                  <tr>
                      <th>Paciente</th>
                      <th>Servicio / Médico</th>                    
                      <th>Cama</th>
                      <th>Acciones</th>
                  </tr>
              </thead>
              <tbody></tbody>
          </table>
      </div>
    </div>
  </div>
</div>
<?= modules::run('Sections/Menu/Footer'); ?>
<script src="<?= base_url('assets/libs/datatables/datatables.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/AsistentemedicaOrden.js?'). md5(microtime())?>" type="text/javascript"></script> 


<script>
$(document).ready(function($) {
    const tipoconsulta = $('#tipoconsulta').val();
    let fecha = $('#fecha').val();    
    passDate(fecha);
    $('#fecha').datepicker({
        startDate: 0,
        language: 'es',
        format: "dd-mm-yyyy",
        autoclose: true,
        setDate: new Date(),
        todayBtn: 'linked'
    }).on('changeDate', function(e){
        let fecha=$('#fecha').val();
        passDate(fecha);
    });

    
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

    $('#asignarCama button').click(function (e) {
        $('#iframe-modal').modal('hide');
        $('.fade').remove();

        $('body').removeClass('modal-open');
    })
        
    function passDate(fecha) {
        $('#tableRegistros').DataTable({
            ajax:{
                    url:base_url+"AdmisionHospitalaria/AjaxPacientes",
                    type:"POST",
                    data: { fecha:fecha,
                            tipoconsulta:tipoconsulta,
                            csrf_token:csrf_token
                          },
                    dataSrc: 'data'
                    },
            columns: [
                      
                        {"data": "nombre", "className": "text-left"},
                        {"data": "servicio","className": "text-left"},
                        {"data": "cama","className": "text-center"},
                        {"data": "accion","className": "text-center"}
                    ],
            columnDefs: [

                            {
                            "targets": [0], 
                            "data": "nombre",
                            "render": function(data, type, row) {
                                return "<span style='color:#006699;'><b><i class='fa fa-user'></i>  &nbsp;"+data+"</b></span><br>"+
                                "<span style='color:#006699;'><i class='fa fa-address-card-o'></i> &nbsp;"+row.afiliacion+"</span><br>"+
                                "<span style='color:#555;'><i class='fa fa-file-text'></i>  &nbsp;"+row.triage_id+"</span><br>";
                                           
                                }
                            },
                            
                            {
                            "targets": [1], 
                            "data": "servicio", 
                            "render": function(data, type, row) {
                                return "<span style='color:#006699;text-transform: uppercase'><i class='fa fa-h-square'></i> &nbsp;"+data+"</span><br>"+
                                "<span style='color:#008F39;'><i class='fa fa-user-md'></i> &nbsp;"+row.medico+"</span><br>"+
                                "<span style='color:#FF8000;'><i class='fa fa-clock-o'></i> &nbsp;Ingreso "+row.tipo_ingreso+" el "+row.fecha_ingreso+" "+row.hora_ingreso+" hrs.</span>";
                                             
                                }
                            },

                            {
                            "targets": [2], 
                            "data": "cama", 
                            "render": function(data, type, row) {
                                return "<span style='color:#006699;text-transform: uppercase'><i class='fa fa-bed'></i> &nbsp;"+data+"</span><br>";
                                
                                }
                            }

                        ],
            dom: 'Bfrtip',
            buttons: [
                        {
                            extend: 'pdfHtml5',
                            title: 'Prealtas'
                        }
            ]
                
        });
    }

}); 

</script>

    
    



