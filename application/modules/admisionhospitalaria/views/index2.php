<?= modules::run('Sections/Menu/index'); ?> 
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet"/>

<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12 col-centered" style="margin-top: 10px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase;"><b>Registro de Pacientes de Ingreso Hospitalario</b></span>
                    <a href="<?=  base_url()?>Asistentesmedicas/Indicadores" md-ink-ripple="" target="_blank" class="md-btn md-fab m-b red pull-right tip " data-original-title="Indicadores">
                        <i class="fa fa-bar-chart i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group m-b">
                                <span class="input-group-addon back-imss border-back-imss">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" name="triage_id" class="form-control" placeholder="Ingresar N° de Folio">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group m-b">
                                <div id="fecharange" style="background: #fff; cursor: pointer; padding: 6px 10px; border: 1px solid #ccc; width: 100%">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                                <input type="hidden" name="fechas" id="fechas" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="hidden" name='fechaInicial' id="fechaInicial">
                            <input type="hidden" name='fechaFinal' id="fechaFinal">
                        </div>
                        <div class="col-md-12">
                            <table class="table footable table-bordered" data-filter="#filter">
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
                                    <?php $cont=0; foreach ($dataPaciente as $value) {
                                        ++$cont;
                                    ?>
                                    <tr>
                                        
                                        <td><?=$value['triage_id']?></td>
                                        <td>
                                            <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?> <?=$value['triage_nombre']?> 
                                        </td>
                                        <td> <?=$value['tipo_ingreso']?></td>
                                        <td> <?php $Medico=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                                                'empleado_id'=>$value['ingreso_medico']
                                            ),'empleado_nombre, empleado_apellidos')[0];?>
                                            <?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?>
                                        </td>
                                        <td>
                                            <?php $Servicio=$this->config_mdl->sqlGetDataCondition('um_especialidades',array(
                                                'especialidad_id'=>$value['ingreso_servicio']
                                            ),'especialidad_nombre')[0];?>
                                            <?=$Servicio['especialidad_nombre']?>
                                        </td>

                                        <td>
                                            <?php   $camaInfo=$this->config_mdl->_get_data_condition('os_camas', array(
                                                    'cama_id' => $value['cama_id']
                                                    ), 'cama_nombre')[0]; 

                                                    $pisoInfo=$this->config_mdl->_get_data_condition('os_pisos', array(
                                                        'area_id' => $value['area_id']
                                                    ))[0];

                                            ?>
                                            <?=$value['cama_id']!='' ? $camaInfo['cama_nombre'].'-'.$pisoInfo['piso_nombre_corto']: '<b style="color:#256659">Por asignar</b><br>' ?>
                                        </td>
                                        <td>
                                            <?php if($value['triage_via_registro']=='Hora Cero TR'){?>
                                                <a href="<?= base_url()?>Asistentesmedicas/Triagerespiratorio/Registro/<?=$value['triage_id']?>?a=edit" target="_blank">
                                                <i class="fa fa-pencil icono-accion tip" data-original-title="Editar datos"></i>
                                            </a>&nbsp;
                                            <?php }else{?>

                                            <a href="<?= base_url()?>Admisionhospitalaria/Registro/<?=$value['triage_id']?>" target="_blank">
                                                <i class="fa fa-pencil icono-accion tip" data-original-title="Editar datos"></i>
                                            </a>&nbsp;
                                            <?php }?>
                                            <?php 
                                            $sqlST7=$this->config_mdl->sqlGetDataCondition('paciente_info',array(
                                                'triage_id'=>$value['triage_id']
                                            ),'pia_lugar_accidente')[0];
                                            ?>
                                            <?php if(CONFIG_AM_HOJAINICIAL=='Si'){?>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumentoMultiple(base_url+'inicio/documentos/HojaFrontal/<?=$value['triage_id']?>','Hoja Frontal',200)" data-original-title="Generar Hoja Frontal"></i>
                                            <?php }?>
                                            <?php if($sqlST7['pia_lugar_accidente']=='TRABAJO'){?>
                                            &nbsp;<i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumentoMultiple(base_url+'inicio/documentos/ST7/<?=$value['triage_id']?>','ST7',200)" data-original-title="Generar ST7"></i>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php }?>
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
<!-- <script src="<?= base_url('assets/libs/jquery-moment/moment.js?')?>" type="text/javascript"></script>  -->
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>
<script src="<?= base_url('assets/js/Asistentemedica.js?'). md5(microtime())?>" type="text/javascript"></script> 
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(document).ready(function() {
        $('#fecharange').click(function() {
            console.log('click')
        });
    });

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
                console.log(fechaInicial);
                console.log(fechaFinal);
                $('.loader').show();
                $.ajax({
                        type:'POST',
                        url: base_url+"Admisionhospitalaria/AjaxPacientes",
                        data:{
                              fechaInicial:fechaInicial,
                              fechaFinal:fechaFinal
                        },
                        
                })
            
            });
        cb(start, end);

    });
    
   
      
    </script>