<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered"> 
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-align: center!important">
                        <strong>AREA DE TRIAGE RESPIRATORIO</strong><br>
                    </span>
                    
                </div>
                <div class="panel-body b-b b-light">
                    
                    <div class="row" style="margin-top: 0px">
                        <div class="col-sm-12">
                            <div class="md-form-group text-center" style="margin-top: -15px;text-transform: uppercase;font-size: 25px">
                                <b>Hospital de Especialidades CMN Siglo XXI</b>
                            </div> 
                            <div class="md-form-group text-center" style="margin-top: -40px;text-transform: uppercase;font-size: 1.2em">
                                <b>“Dr. Bernardo Sepúlveda Gutiérrez”</b><br>
                            </div> 
                        </div>
                       <?php if ($this->UMAE_AREA == 'Enfermeria Triage'){?>  <!-- Solo enfermeria puede asisgnar folios -->
                        <div class="col-md-12">
                            <center>
                                <style>
                                    .agregar-horacero-paciente i{ color: white;}.agregar-horacero-paciente i:hover{color: #256659;}
                                </style>
                                <a md-ink-ripple="" class="agregar-horacero-paciente md-btn md-fab m-b red waves-effect " style="width: 100px;height: 100px;padding: 15px">
                                    <i class="fa fa-ambulance fa-5x"></i>
                                </a>
                            </center>
                        </div>
                        <div class="col-md-12">
                            <div class="md-form-group text-center " style="margin-top: 0px;text-transform: uppercase;font-size: 1.2em">
                                <button class="btn btn-primary btn-continuar-horacero" style="display: none"><i class="mdi-navigation-arrow-forward i-24"></i>Continuar</button>
                            </div> 
                        </div>
                        <?php }?>
                    </div>
                    <div class="row">
                         <div class="col-md-12">
                            <table class="table footable table-filtros table-bordered table-hover table-no-padding"  data-limit-navigation="10" data-filter="#filter" data-page-size="10">
                                <thead>
                                    <tr>
                                        <th>N° DE FOLIO</th>
                                        <th>HORA CERO</th>
                                        <th style="width: 25%">NOMBRE DEL PACIENTE</th>
                                        <th>GENERO</th>
                                        <th>NSS</th>
                                        <th>TIPO DE INGRESO</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_filas=  count($infoPaciente);
                                    
                                    ?>
                                    <?php foreach ($infoPaciente as $value) {
                                         $sqlInfo=$this->config_mdl->_get_data_condition('paciente_info',array(
                                        'triage_id'=>$value['triage_id']
                                        ))[0];?>
                                    <tr id="<?=$value['triage_id']?>">
                                        <td><?=$value['triage_id']?></td>
                                        <td><?=date("d-m-Y", strtotime($value['triage_horacero_f']));?>
                                            <?=$value['triage_horacero_h']?>    
                                        </td>
                                        <td class="<?= Modules::run('Config/ColorClasificacion',array('color'=>$value['triage_color']))?>" style="color: white">
                                           <?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?>
                                        </td>
                                        <td><?=$value['triage_paciente_sexo']?></td>
                                        <td style="font-size: 12px">
                                            <?=$sqlInfo['pum_nss']!='' ? $sqlInfo['pum_nss']: '<b style="color:#256659">No derechohabiente</b><br>'?>
                                        </td>
                                        <td>
                                            <?php if($value['acceso_tipo'] == 'Triage Médico'){
                                                echo 'Urgente';
                                            }?>
                                        </td>
                                        <td>

                                           <a href="<?= base_url()?>Asistentesmedicas/Triagerespiratorio/Registro/<?=$value['triage_id']?>" target='_blank' rel="opener">
                                            
                                           <i class="fa fa-pencil-square-o icono-accion pointer tip" data-original-title="Requisitar Información 43051"></i>  
                                           </a> 
                                           <i class="fa fa-share-square-o icono-accion pointer tip salida-paciente" data-id="<?=$value['triage_id']?>" data-original-title="Registrar salida de paciente"></i>    
                                        </td>
                                    </tr>
                                    <?php } ?>
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
<?= modules::run('Sections/Menu/footer'); ?>

<script src="<?= base_url('assets/js/Asistentemedica_tr.js?').md5(microtime())?>" type="text/javascript"></script>

