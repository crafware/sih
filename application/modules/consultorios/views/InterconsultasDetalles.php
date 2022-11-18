<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-9 col-centered" style="margin-top: -20px">
            <div class="panel panel-default ">
                
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">INTERCONSULTAS</span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>FECHA DE SOLICITUD </b> <?=date("d-m-Y", strtotime($info['doc_fecha']));?> <?=$info['doc_hora']?>
                            </h5>
                            <h5><b>SERVICIO SOLICITANTE: </b> <?=$info['doc_servicio_envia']?></h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                <b>FECHA DE REALIZACIÓN: </b> <?=date("d-m-Y", strtotime($info['doc_fecha_r']));?> <?=$info['doc_hora_r']?>
                            </h5>
                            <h5><b>SERVICIO REQUERIDO: </b> <?=$info['doc_servicio_solicitado']?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><b>MÉDICO INTERCONSULTANTE: </b></h5>
                            <h5><b>MÉDICO TRATANTE: </b></h5>
                        </div>
                        <div class="col-md-6">
                            <h5><?=$info['empleado_matricula']?></h5>
                            <h5><?=$MedicoTratante['empleado_matricula']?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">    
                            <h5 style="line-height: 1.6"><b>DIAGNOSTICO PRESUNCIONAL: </b> <?=$info['doc_diagnostico']?></h5>
                            
                            <h5><b>TIEMPO TRANSCURRIDO: </b> 
                                <?php
                                $TT= Modules::run('Config/CalcularTiempoTranscurrido',array(
                                    'Tiempo1'=>$info['doc_fecha'].' '.$info['doc_hora'],
                                    'Tiempo2'=>$info['doc_fecha_r'].' '.$info['doc_hora_r']
                                ));
                                echo $TT->h.' Horas'.' '.$TT->i.' Minutos';   
                                ?>
                            </h5>
                            
                        </div>
                        <div class="col-md-8">
                            <button class="md-btn md-raised m-b btn-fw blue waves-effect" onclick="AbrirDocumento(base_url+'Inicio/Documentos/GenerarNotas/<?=$info['doc_nota_id']?>')">
                                Ver Nota de Valoración
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn back-imss pull-right btn-block" onclick="window.top.close()">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cerrar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </button>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Consultorios.js?'). md5(microtime())?>" type="text/javascript"></script>