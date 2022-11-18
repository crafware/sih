<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered"> 
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-align: center!important">
                        <strong>CHOQUE</strong><br>
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
                            <table class="table table-hover table-bordered footable" style="font-size: 13px">
                                <thead class="back-imss">
                                    <tr>
                                        <th>FOLIO</th>
                                        <th>TIPO PAC.</th>
                                        <th style="width: 27%">NOMBRE/PSEUDONIMO</th>
                                        <th>N.S.S</th>
                                        <th>SEXO</th>
                                        <th>FECHA INGRESO</th>
                                         <?php if($this->UMAE_AREA=='Asistente Médica Admisión Continua') {?>
                                        <th class="text-center">ACCIONES</th>
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {?>
                                    <?php 
                                    $sqlInfo=$this->config_mdl->_get_data_condition('paciente_info',array(
                                        'triage_id'=>$value['triage_id']
                                    ))[0];
                                    ?>
                                    <tr>
                                        <td><?=$value['triage_id']?></td> 
                                        <td ><?=$value['triage_tipo_paciente']?></td>
                                        <td ><?=$value['triage_nombre']=='' ? $value['triage_nombre_pseudonimo'] : $value['triage_nombre_ap'].' '.$value['triage_nombre_am'].' '.$value['triage_nombre']?> </td>
                                        <td style="font-size: 12px">
                                            <?=$sqlInfo['pum_nss_armado']!='' ? '<b style="color:#F44336">N.S.S ARMADO</b><br>'.$sqlInfo['pum_nss_armado'].'<br>' : ''?>
                                            <?=$sqlInfo['pum_nss']!='' ? '<b style="color:#256659">N.S.S</b><br>'.$sqlInfo['pum_nss']: ''?>
                                        </td>
                                        <td><?=$value['triage_paciente_sexo']?></td>
                                        <td style="font-size: 11px">
                                            <?=date("d-m-Y", strtotime($value['triage_horacero_f']));?>
                                            <?=$value['triage_horacero_h']?></td>
                                        <?php if($this->UMAE_AREA=='Asistente Médica Admisión Continua') {?>
                                        <td class="text-center">
                                            <a href="<?= base_url()?>Asistentesmedicas/Choque/AsistenteMedica/<?=$value['triage_id']?>" target="_blank">
                                                <i class="fa fa-share-square-o icono-accion tip" data-original-title="Requisitar Información" ></i>
                                            </a>                               
                                        </td>
                                        <?php }?>
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
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/AsistentemedicaChoque.js?').md5(microtime())?>" type="text/javascript"></script>

