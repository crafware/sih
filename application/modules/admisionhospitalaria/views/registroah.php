<?= modules::run('Sections/Menu/Header_modal'); ?>   
<link href="<?= base_url()?>assets/libs/css/daterangepicker.css" rel="stylesheet">
<!-- <link href="<?= base_url()?>assets/libs/datatables/DataTables-1.10.22/css/dataTables.min.css" rel="stylesheet"> -->
<link href="<?= base_url()?>assets/libs/datatables/datatables.css" rel="stylesheet">

<style type="text/css">
    div.daterangepicker.ltr.show-ranges.opensright {
    top: 128px !important;
}
</style>
    <div class="panel panel-default ">
        
        <div class="panel-body b-b b-light">
            <div class="row">
                <div class="col-md-3">
                    <label for=""><b>Buscar foli</b></label>
                    <div class="input-group m-b">
                        <input type="text" name="buscarPaciente" class="form-control" placeholder="Ingresar N° de Folio">
                        <span class="input-group-addon back-imss border-back-imss pointer">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group m-b">
                        <label for=""><b>Filtrar datos</b></label>
                            <div id="fecharange" style="background: #fff; cursor: pointer; padding: 6px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="hidden" name='fechaInicial' id="fechaInicial">
                    <input type="hidden" name='fechaFinal' id="fechaFinal">
                    <input type="hidden" name="tipoconsulta" id="tipoconsulta" value="preregistro">
                </div>
                <div class="col-md-2">
                    <div class="input-group m-b">
                        <button class="btn btn-info" style="margin-top: 24px" onclick="window.location.href='RegistrarPaciente'">Agregar Paciente</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">    
                    <!-- <table id="tableRegistros" class="table table-bordered footable"  data-filter="#search" data-page-size="20" data-limit-navigation="8"> -->
                        <table class="table" id="tableRegistros">
                        <thead>
                            <tr>
                                <th>Fecha Registro</th>
                                <th>Folio</th>
                                <th style="width: 25%">Paciente</th>
                                <th>Ingreso</th>
                                <!-- <th>Médico</th>
                                <th>Servicio</th>  -->                      
                                <th>Cama</th>
                                <!-- <th>Acciones</th> -->
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?= modules::run('Sections/Menu/Footer_modal'); ?>
<script src="<?= base_url('assets/libs/js/moment-with-locales.min.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/libs/js/daterangepicker.min.js')?>" type="text/javascript"></script>
<!-- <script src="<?= base_url('assets/js/Mensajes.js')?>" type="text/javascript"></script> -->
<script src="<?= base_url('assets/libs/datatables/datatables.js')?>" type="text/javascript"></script>



<script>
$(document).ready(function($) {
    $(function() {
        //var start = moment().subtract(29, 'days');
        var start = moment();
        var end = moment();

        function cb(start, end) {
            //$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#fecharange span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
            $('#fechaInicial').val(start.format('YYYY-MM-DD'));
            $('#fechaFinal').val(end.format('YYYY-MM-DD'));             
        }
        moment.locale('es');
        $('#fecharange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                    'Mes actual': [moment().startOf('month'), moment().endOf('month')],
                    'Mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]                       
                },
                locale: {
                    'customRangeLabel': 'Rango de Fechas',
                    'applyLabel': 'Aplicar',
                    'cancelLabel': 'Cancelar',
                    'firstDay': 0
                }

            }, cb);

        $('#fecharange').on('apply.daterangepicker', (e, picker) => {
            var fechaInicial = $('#fechaInicial').val();
            var fechaFinal = $('#fechaFinal').val();
            // var startDate = start.format('YYYY-MM-DD'); var endDate = end.format('YYYY-MM-DD');
            
            passDate(fechaInicial, fechaFinal);
                        
        });
        cb(start, end);
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
    
    

    // $('#tableRegistros').DataTable({
    //     'processing': true,
    //     'serverSide':true,
    //     'paging':true,
    //     'info' : true,
    //     //dom: 'Bfrtip',
    //     buttons: ['copy', 'csv', 'excel', 'pdf'],
    //     'ajax': {
    //                 "url":base_url+"AdmisionHospitalaria/AjaxPacientes",
    //                 "type":'POST',
    //                 "dataType": 'json',
    //                 data: {
    //                         fechaInicial:fechaInicial,
    //                         fechaFinal:fechaFinal,
    //                         tipoconsulta:tipoconsulta,
    //                         csrf_token:csrf_token             
    //                       }
    //             }
    //     'columns': [
    //         {data: 'fecha_registro'},
    //         {data: 'triage_id'},
    //         {data: 'triage_nombre_ap'},
    //         {data: 'tipo_ingreso'},
    //         {data: 'medico'},
    //         {data: 'servicio'},
    //         {data: 'cama'}

    //     ],
    // })                  

function passDate(fechaInicial,fechaFinal) {
    const tipoconsulta = $('#tipoconsulta').val();
    $('#tableRegistros').DataTable({
        ajax:{
                url:base_url+"AdmisionHospitalaria/AjaxPacientes",
                type:"POST",
                data: { fechaInicial:fechaInicial,
                        fechaFinal:fechaFinal,
                        tipoconsulta:tipoconsulta,
                        csrf_token:csrf_token},
                dataSrc: 'data'
                },
        columns: [
                    {"data": "fecha_registro"},
                    {"data": "triage_id"},
                    {"data": "nombre"},
                    {"data": "tipo_ingreso"},
                    {"data": "cama"},

                ],
        // columnDefs: [{
        //               }]
            
        });
}  

    /*function passDate(fechaInicial,fechaFinal) {
          const tipoconsulta = $('#tipoconsulta').val();
          $.ajax({                  
                    url: base_url+"AdmisionHospitalaria/AjaxPacientes", // the url where we want to POST
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    dataType: 'json',
                    data: {
                            fechaInicial:fechaInicial,
                            fechaFinal:fechaFinal,
                            tipoconsulta:tipoconsulta,
                            csrf_token:csrf_token             
                    },
                    beforeSend: function(xhr) {
                       // $('.loader').show();
                        msj_loading();
                    },
                  
                    success: function(data, textStatus, jqXHR) {
                        //$('.loader').hide();
                        bootbox.hideAll();
                        $('#tableRegistros tbody').html(data.tr)
                        
                        InicializeFootable('#tableRegistros');
                $('body .tip').tooltip();
                    },
                    error: function(e){
                        bootbox.hideAll()
                        MsjError();
                    }
              });              
      }   */
}); 

</script>

    
    



