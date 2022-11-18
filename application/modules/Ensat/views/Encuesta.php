<?= modules::run('Sections/Menu/HeaderBasico'); ?> 
<div class="box-row" id="FullScreen">
    <div class="box-cell">
        <div class="box-inner col-sm-12 col-centered" style="margin-top: 10px">
            <div class="panel panel-default ">
                <?php if(!empty($Encuestas)){?>
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 25px;font-weight: 500;text-transform: uppercase">
                        <b><?=$Encuestas[0]['encuesta_nombre']?></b>
                    </span>
                    <div style="position: relative">
                        <div style="position: absolute;right: 0px;top: -34px;">
                            <i class="pointer pantalla-completa accion-windows fa fa-arrows-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="panel-body b-b b-light">
                    <form class="ensat-evaluacion" method="GET">
                        <div class="row">
                            <?php 
                            $Preguntas=$this->config_mdl->sqlGetDataCondition('um_ensat_encuesta_preg',array(
                                'encuesta_id'=>$Encuestas[0]['encuesta_id']
                            ));
                            $i=0;
                            foreach ($Preguntas as $preg) {
                                $i++;
                            ?>
                            <div class="col-md-12 col_pregunta<?=$preg['pregunta_id']?>">
                                <div class="form-group">
                                    <label class="mayus-bold" style="font-size: 30px"><?=$i?>.- <?=$preg['pregunta_nombre']?></label>
                                    <div class="row">
                                        <?php 
                                        $Respuesta=$this->config_mdl->sqlGetDataCondition('um_ensat_encuesta_preg_res',array(
                                            'pregunta_id'=>$preg['pregunta_id']
                                        ));
                                        foreach ($Respuesta as $resp) {
                                        ?>
                                        <div class="col-sm-2 text-center">
                                            <img src="<?= base_url()?>assets/img/emoji/<?=$resp['respuesta_icon']?>" class="input-radio-save" data-value="<?=$Encuestas[0]['encuesta_id']?>;<?=$preg['pregunta_id']?>;<?=$resp['respuesta_id']?>" style="width: 100px;height: 100px"><br>
                                            <h6 class=""><?=$resp['respuesta_nombre']?></h6>
                                        </div>
                                    <?php }?>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            <div class="col-sm-offset-6 col-sm-6">
                                <input type="hidden" name="csrf_token">
                                <input type="hidden" name="triage_tipo" value="<?=$_GET['tipo']?>">
                                <input type="hidden" name="triage_id" value="<?=$_GET['triage_id']?>">
                                <input type="hidden" name="encuesta_id" value="<?=$Encuestas[0]['encuesta_id']?>">
                                <input type="hidden" name="TotalPreguntas" value="<?=count($Preguntas)?>">
                                <input type="hidden" name="TotalRespondidas" value="">
                            </div>
                        </div>    
                        
                    </form>
                </div>
                <?php }else{?>
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase;text-align: center">
                        <b class="text-center">
                            <center>NO HAY ENCUESTAS DISPONIBLES</center>
                            
                        </b>
                    </span>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script src="<?= base_url('assets/js/Ensat.js?').md5(microtime())?>" type="text/javascript"></script>