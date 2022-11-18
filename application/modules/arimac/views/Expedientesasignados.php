<link href="<?= base_url()?>assets/libs/datatables/datatables.css" rel="stylesheet">
<div class="panel panel-default ">       
  <div class="panel-body b-b b-light">
    <div class="row">
      <div class="col-md-3">
          <label for=""><b>Ingrese Folio de Expediente</b></label>
          <div class="input-group m-b">
              <input name="id_paciente" class="form-control" placeholder="Ingresar/Escanear codigo" data-inputmask="'mask': '99999999999'">
              <span class="input-group-addon back-imss border-back-imss pointer">
                  <i class="fa fa-search"></i>
              </span>
          </div>
      </div>
      <div class="col-md-3">
          <label for=""><b>Fecha de asignación o prestamo</b></label>
          <div class="input-group m-b">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input type="text" name="fecha" class="form-control" id="fecha" value="<?php echo date("d-m-Y");?>" placeholder="Seleccionar fecha">
          </div>
      </div>
      
    </div>
    <div class="row">
      <div class="col-md-12">    
          <!-- <table id="tableRegistros" class="table table-bordered footable"  data-filter="#search" data-page-size="20" data-limit-navigation="8"> -->
              <table class="table table-striped table-bordered" id="tableRegistros">
              <thead>
                  <tr>
                      <th width="30%">Datos de expediente</th>
                      <th width="30%">Servicio / Persona que solicita</th>                    
                      <th >Estado</th>
                      <th width="10%">Acciones</th>
                  </tr>
              </thead>
              <tbody></tbody>
          </table>
      </div>
    </div>
  </div>
</div>
<?= modules::run('Sections/Menu/Footer'); ?>
<!-- <script src="<?= base_url('assets/js/Mensajes.js')?>" type="text/javascript"></script> -->
<script src="<?= base_url('assets/libs/datatables/datatables.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/Arimac.js?'). md5(microtime())?>" type="text/javascript"></script> 


<script>
$(document).ready(function($) {
    
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
        
    function passDate(fecha) {
        $('#tableRegistros').DataTable({
            
            
            ajax:{
                    url:base_url+"Arimac/ListaControlExpedientes",
                    type:"POST",
                    data: { fecha:fecha,
                            csrf_token:csrf_token
                          },
                    dataSrc: 'data'
                    },
            columns: [
                      
                        {"data": "folio", "className": "text-left"},
                        {"data": "servicio","className": "text-left"},
                        {"data": "estado","className": "text-left"},
                        {"data": "accion","className": "text-center"}
                    ],
             columnDefs: [

                            {
                            "targets": [0], 
                            "data": "folio",
                            "render": function(data, type, row) {
                                return "<span style='color:#006699;'><b><i class='fa fa-file-text'></i>  &nbsp;"+data+"</b></span><br>"+
                                       "<span style='color:#006699;'><i class='fa fa-address-card-o'></i> &nbsp;"+row.afiliacion+"</span><br>"+
                                       "<span style='color:#006699;'><b><i class='fa fa-user'></i>  &nbsp;"+row.nombre_paciente+"</b></span><br>";
                                }
                            },
                            
                            {
                            "targets": [1], 
                            "data": "servicio", 
                            "render": function(data, type, row) {
                                return "<span style='color:#006699;text-transform: uppercase'><i class='fa fa-medkit'></i> &nbsp;"+data+"</span><br>"+
                                "<span style='color:#008F39;'><i class='fa fa-user-md'></i> &nbsp;"+row.usuario+"</span>";
                                }
                            },

                            {
                            "targets": [2], 
                            "data": "estado", 
                            "render": function(data, type, row) {
                                return ""+data+"";
                                /*"<span style='color:#E60026;text-transform: uppercase'><b><i class='fa fa-hourglass-1'></i> &nbsp;"+data+"</b></span><br>"+
                                       "<span style='color:#006699;'><i class='fa fa-calendar'></i> &nbsp;"+row.fecha_salida+"</span>";*/
                                }
                            },
                            {
                            "target": [3],
                            "data"  : "accion",
                            "render": function (data,type,row) {
                                return ""+data+"";
                                }
                            }

                        ],
            dom: 'flBrtip',
                buttons: [
                    {
                        'extend': 'excel',
                                                 'text': 'Exportar', // Definir el texto del botón de exportación de Excel

                    }
                ]
                
        });
    }

}); 

</script>

    
    



