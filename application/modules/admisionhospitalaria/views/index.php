<?= modules::run('Sections/Menu/index'); ?> 
<link href="<?= base_url()?>assets/libs/css/daterangepicker.css" rel="stylesheet" type="text/css" />
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12 col-centered" style="margin-top: 10px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase;"><b>Registro de Pacientes de Ingreso Hospitalario</b></span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-4">
                            <label for=""><b>Buscar foliooooo</b></label>
                            <div class="input-group m-b">
                                <span class="input-group-addon back-imss border-back-imss">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" name="buscarPaciente" class="form-control" placeholder="Ingresar N° de Folio">
                            </div>
                        </div>
                        <div class="col-md-5">
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
                        </div>
                        <div class="col-md-12">    
                            <table id="tableRegistros" class="footable table table-bordered"  data-filter="#search" data-page-size="20" data-limit-navigation="7">
                                <thead>
                                    <tr>
                                        <th>N° DE FOLIO</th>
                                        <th style="width: 25%">PACIENTE</th>
                                        <th>TIPO INGRESO</th>
                                        <th>MEDICO</th>
                                        <th>SERVICIO</th>                       
                                        <th>CAMA</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7">
                                            <!-- <div class="loader text-center" style="display:none"><img src="<?=base_url()?>assets/img/loading.gif"></div> -->
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="hide-if-no-paging">
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <ul class="pagination"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" value="Asistente Médica" name="AsistenteMedicaTipo">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/libs/js/moment-with-locales.min.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/libs/js/daterangepicker.min.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/Asistentemedica_hosp.js?'). md5(microtime())?>" type="text/javascript"></script> 
<script>
    
$(document).ready(function() {
        
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
    
    function passDate(fechaInicial,fechaFinal) {
          
          $.ajax({                  
                    url: base_url+"AdmisionHospitalaria/AjaxPacientes", // the url where we want to POST
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    dataType: 'json',
                    data: {
                            fechaInicial:fechaInicial,
                            fechaFinal:fechaFinal,
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
      }   
});   
    </script>