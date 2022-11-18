<?php echo modules::run('Sections/Menu/index'); ?>
<link href="<?= base_url()?>assets/libs/carousel/owl.carousel.css" type="text/css">
<link href="<?= base_url()?>assets/libs/carousel/owl.theme.css" type="text/css">
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding" style="margin-top: 60px">
            <div class="row">
                <?php foreach ($Alerts as $value) {?>
                <div class="col-md-12 col-centered no-padding">
                    <div class="alert <?=$value['alert_type']?> text-justify">
                        <div class="row">
                            <div class="col-md-1 <?=$value['alert_icon']==''? 'hidden':''?>">
                                <center><i class="<?=$value['alert_icon']?>" style="color: #F44336"></i> </center>
                            </div>
                            <div class=" <?=$value['alert_icon']==''? 'col-md-12':'col-md-11'?>">
                                <?=$value['alert_text']?> <?php if($value['alert_url']!=''){?><strong><a href="<?= base_url()?><?=$value['alert_url']?>">AQUÍ</a></strong><?php }?>
                            </div> 
                        </div>  
                    </div>
                </div>
                <?php }?>
                <div class="col-md-6 no-padding hide Graficas">
                    <div class="panel panel-default ">
                        <div class="panel-body b-b b-light text-center">
                            <h5><b>PORCENTAJE HOMBRES-MUJERES: <?= date('d/m/Y')?></b></h5><br>
                            <div class="loading-grafica">
                                <center>
                                    <i class="fa fa-spinner fa-pulse fa-3x"></i>
                                </center>
                            </div>
                            <canvas id="GraficaSexo" class="hide" style="height: 250px;width: 100%"></canvas><br>
                            <h5 class="TOTAL_GENERO mayus-bold"></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 no-padding hide Graficas">
                    <div class="panel panel-default ">
                        <div class="panel-body b-b b-light text-center">
                            <h5><b>PORCENTAJE POR CLASIFICACIÓN: <?= date('d/m/Y')?></b></h5><br>
                            <div class="loading-grafica">
                                <center>
                                    <i class="fa fa-spinner fa-pulse fa-3x"></i>
                                </center>
                            </div>
                            <canvas id="GraficaClasificacion" class="hide" style="height: 250px;width: 100%"></canvas><br>
                            <h5 class="TOTAL_CLASIFICACION mayus-bold"></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 hide">
                    <div class="alert alert-danger">
                        <h5 style="margin-top: -8px;margin-bottom: -5px;line-height: 1.4">
                            EVITE QUE SU MATRICULA TENGA UN MAL USO, AHORA YA PUEDE SOLICITAR CONTRASEÑA Al INICIAR SESIÓN PARA MANTENER UNA MEJOR SEGURIDAD Y EVITAR QUE OTRO USUARIO PUEDA HACER MAL USO DE SU MATRICULA. <a href="<?= base_url()?>Sections/Usuarios/MiPerfil" style="color: #2196F3">CLIC AQUI PARA PERSONALIZAR SU CUENTA</a>
                        </h5>
                    </div>
                </div>
                <div class="col-md-6 hide">
                    <div class="panel no-border">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <h3 style="margin-top: -8px" class="text-center">CAPACITACIÓN</h3>
                                        <h5 style="line-height: 1.5">
                                            <span>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                            </span>
                                        </h5>
                                        <br>
                                        <center>
                                            <a href="<?= base_url()?>Sections/Cursos/CursosView">
                                                <button class="btn btn-primary">Ver Cursos</button>
                                            </a>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 hide">
                    <div class="panel no-border">
                        <div class="panel-heading">
                            <?php if($TieneCurso>0){?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success">
                                        <h3 style="margin-top: -8px" class="text-center">NORMATIVA</h3>
                                        <h5 style="line-height: 1.5">
                                            <span>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                            </span>
                                        </h5>
                                        <br>
                                        <center>
                                            <button class="btn btn-primary">Iniciar Evaluación</button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="TieneCurso" value="<?=$TieneCurso?>">
        <input type="hidden" name="AreaAcceso" value="<?=$this->UMAE_AREA?>">
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url()?>assets/js/Chart.js?" type="text/javascript"></script>
<script src="<?= base_url()?>assets/js/Inicio.js?<?= md5(microtime())?>" type="text/javascript"></script>