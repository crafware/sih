<?php echo modules::run('Sections/Menu/index'); ?>
<link  href="<?= base_url()?>assets/libs/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding">
            <div class="col-md-12">
                <ol class="breadcrumb" style="margin-top: -30px;color:#2196F3">
                    <li><a href="#">Inicio</a></li>
                    <li><a href="<?= base_url()?>Hospitalizacion/Indicadores">Indicadores</a></li>
                    <li><a href="#">Interconsultas</a></li>
                </ol>  
                <div class="card" style="margin-top: -20px;">
                    <div class="lt p text-center">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h5 class="text-uppercase">
                                    <strong>INDICADORES | SERVICIO DE <?=Modules::run('Config/ObtenerEspecialidad',array('Usuario'=>$this->UMAE_USER)) ?></strong>
                                </h5>
                                <hr>
                            </div>
                            
                            <div class="col-md-4">
                                <input type="hidden" name="indicador_tipo" value="<?=$this->uri->segment(4)?>">
                                <!-- <input type="" name="idServicio" value="<?=Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)) ?>"> -->
                                <div id="fecharange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                                <input type="hidden" name="fechaInicial" id="fechaInicial">
                                <input type="hidden" name="fechaFinal" id="fechaFinal">

                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-block btn-buscarIndicador">BUSCAR</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <a href="#" class="interconsultas-solicitadas">
                    <div class="card">
                        <div class="lt p text-center">
                            <h4>0 Interconsultas</h4>
                            <hr style="margin-top: -6px;margin-bottom: -6px">
                            <h3 style="font-size: 17px">SOLICITADAS</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="#" class="interconsultas-atendidas">
                    <div class="card">
                        <div class="lt p text-center">
                            <h4>0 Interconsultas</h4>
                            <hr style="margin-top: -6px;margin-bottom: -6px">
                            <h3 style="font-size: 17px">ATENDIDAS</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-12 col-ChartInterconsultas hide">
                <div class="lt p text-center">
                    <div class="card">
                        <canvas id="ChartInterconsultas" style="width: 100%"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?=modules::run('Sections/Menu/footer'); ?>
<script src="<?=  base_url()?>assets/js/Chart.js" type="text/javascript"></script>

<script src="<?= base_url()?>assets/libs/daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?= base_url()?>assets/libs/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?=  base_url()?>assets/js/Indicadores.js?<?= md5(microtime())?>"></script>
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
                
                //passDate(fechaInicial, fechaFinal);
                            
            });
        cb(start, end);
    });
    
   /* function passDate(fechaInicial,fechaFinal) {
          
          $.ajax({                  
                    url: base_url+"Hospitalizacion/Indicadores", // the url where we want to POST
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
      }   */
});  
</script>
