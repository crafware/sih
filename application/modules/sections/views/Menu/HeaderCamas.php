<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$this->UM_CLASIFICACION?> | <?=$this->UM_NOMBRE?></title>
        <meta http-equiv="Cache-control" content="no-cache">
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>
        <meta name="description" content="<?=$this->UM_CLASIFICACION?> | <?=$this->UM_NOMBRE?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link href="<?=  base_url()?>assets/libs/jquery/bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/libs/assets/animate.css/animate.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/libs/assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/libs/jquery/waves/dist/waves.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/styles/material-design-icons.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/libs/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?=  base_url()?>assets/libs/bootstrap-datepicker/css/datepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/libs/bootstrap-fileinput/css/fileinput.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/libs/jquery-notifications/css/messenger.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?=  base_url()?>assets/libs/jquery-notifications/css/messenger-theme-flat.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?=  base_url()?>assets/libs/jquery-notifications/css/location-sel.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?=  base_url()?>assets/libs/bootstrap-tag/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
        <link href="<?=  base_url()?>assets/libs/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css" />
        <!-- <link href="<?=  base_url()?>assets/libs/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" /> -->
        <link href="<?=  base_url()?>assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/libs/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/libs/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?=  base_url()?>assets/libs/boostrap-clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?=  base_url()?>assets/libs/html5imageupload/demo.html5imageupload.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?=  base_url()?>assets/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?=  base_url()?>assets/styles/font.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/styles/app.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/styles/style.css?time=<?= sha1(microtime())?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>assets/styles/beds.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/img/imss.png" rel="icon" type="image/png">
    </head>
    <body>
        <div class="app">
            <div class=" bg-big">
                <div class="box-cell">
                    <div id="content" class="app-content" role="main">
                        <div class="box">
                            <div class="navbar md-whiteframe-z1 no-radius back-imss-all" >
                                <a md-ink-ripple  data-toggle="modal" data-target="#aside" class="navbar-item pull-left visible-xs visible-sm"><i class="mdi-navigation-menu i-24"></i></a>
                                <ul class="nav nav-sm navbar-tool pull-left" style="padding-left: 5px;">
                                    <li>
                                        <p class="time" style="font-size: 40px;margin: 0px 0px 0px 0px">
                                            <b class="hora" ><?= date('H')?></b>:<b class="minuto"><?= date('i')?></b>:<b class="segundo"><?= date('s')?></b> 
                                        </p>
                                        <p style="text-transform: uppercase;font-size: 9px;margin: -5px 0px 0px 0px">
                                        <b class="fecha" ></b> 
                                        </p>
                                    </li>
                                    <li class=""> 
                                        
                                    </li>
                                </ul>
                                <ul class="nav navbar-nav">
                                    <li class="dropdown">
                                        <?php if($this->UMAE_AREA == 'Admisión Hospitalaria'){?>
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="margin-left: 40px">
                                                    Admisión Hospitalaria <span class="caret"></span></a>
                                                  <ul class="dropdown-menu">
                                                    <li><a class="pre_registro" data-toggle="modal" href="#">Pre-Registro</a></li>
                                                    <li><a class="paciente"     data-toggle="modal" href="#">Pacientes</a></li>
                                                    <li role="separator" class="divider"></li>
                                                    <li class="dropdown-header">Reportes</li>
                                                    <li><a href="#" class="ingresos" data-toggle="modal">Ingresos</a></li>
                                                    <li><a class="altas" data-toggle="modal" href="#">Prealtas / Altas</a></li> 
                                                  </ul>      
                                        <?php }else if($this->UMAE_AREA == "Conservación"){?>
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="margin-left: 40px">Conservación <span class="caret"></span></a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="reportes-conservacion" data-toggle="modal" href="#">Reportes</a></li>
                                                    </ul>
                                        <?php }else if($this->UMAE_AREA == "Limpieza e Higiene"){?>
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="margin-left: 40px">Limpieza e Higiene <span class="caret"></span></a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="reportes-limpieza" data-toggle="modal" href="#">Reportes</a></li>
                                                </ul>
                                        <?php }?>
                                    </li>
                                    
                                </ul>
                                <ul class="nav nav-sm navbar-tool pull-right">
                                    <li>
                                        <div style="margin: 17px">
                                            <span class="font-bold" style="font-size: 15px;text-transform: uppercase">
                                                <?=$info[0]['empleado_nombre']?> <?=$info[0]['empleado_apellidos']?>
                                            </span>
                                            <?php $servicio = $this->config_mdl->_get_data_condition('um_especialidades',array(
                                                        'especialidad_id'=> $info[0]['empleado_servicio']
                                                    ));
                                            ?>
                                            <span class="" style="display:block">
                                                <?=$servicio[0]['especialidad_nombre']?>
                                            </span>
                                            
                                        </div>
                                    </li>
                                    <li class="notificaciones-total-list ">
                                        <a href="#" style="margin-top: 5px;margin-left: -5px">
                                            <i class="fa fa-bell-o text-lg" ></i>
                                            <b class="badge bg-danger up notificaciones-total" ></b>
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <div style="width: 30px;height: 30px;margin-top: 16px;border-radius: 100px!important">
                                            <a href="#">
                                            <img src="<?=  base_url()?>assets/img/perfiles/<?=$info[0]['empleado_perfil']?>" style="width: 30px;height: 30px;">
                                            </a>
                                        </div>
                                    </li>
                                    
                                    <li class="dropdown">
                                        <a md-ink-ripple data-toggle="dropdown">
                                            <i class="mdi-navigation-more-vert i-24"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up text-color">
                                            <li>
                                                <div style="background: url(<?= base_url()?>assets/img/perfiles/background.jpg);width: 100%;height: 100px;margin-top: -5px;background-size: cover"></div>
                                                <div style="position: absolute;left: 40px;margin-top: -92px;background: white;padding: 2px; width: 90px;border-radius: 50%;">
                                                    <center>
                                                        <img src="<?=  base_url()?>assets/img/perfiles/<?=$info[0]['empleado_perfil']?>" style="width: 86px;height: 83px;border-radius: 50%">
                                                    </center>
                                                </div>
                                            </li>
                                            <li class="" style="margin-top: 7px;">
                                                <a href="<?= base_url()?>Sections/Usuarios/MiPerfil">
                                                    <i class="mdi-social-person i-24 text-color-imss"></i>&nbsp;&nbsp;Mi Perfil
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="<?=  base_url()?>config/CerrarSesion">
                                                    <i class="fa fa-sign-out i-24 text-color-imss"></i>&nbsp;&nbsp;Cerrar sesión
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <!-- Modales en admision hospitalaraia -->
                            <!-- Modal de pre-registro -->                         
                            <div class="modal fade" id="modal-preregistro" tabindex="-1">
                                <div  role="dialog" style=" width:90%; height:90%; position: absolute; left: 5%;  top: 5%;" >
                                    <div class="modal-content" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <h4 class="modal-title">PRE-REGISTRO DE PACIENTE PARA INGRESO HOSPITALARIO</h4>
                                        </div>
                                        <div class="modal-body">
                                            <iframe id="iframe-modal" src=""  width="100%"  height="600" frameborder="0"></iframe>
                                        </div>
                                        <div class="modal-footer" >
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal de busqueda paciente -->
                            <div class="modal fade" id="modal-paciente" tabindex="-1">
                                <div  role="dialog" style=" width:80%; height:80%; position: absolute; left: 10%;  top: 10%;" >
                                    <div class="modal-content" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <h4 class="modal-title">BUSCAR PACIENTE</h4>
                                        </div>
                                        <div class="modal-body">
                                            <iframe id="iframe-paciente" src=""  width="100%"  height="600" frameborder="0"></iframe>
                                        </div>
                                        <div class="modal-footer" >
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal de Ingreso Hospitalario -->
                            <div class="modal fade" id="modal-ingresos" tabindex="-1">
                                <div  role="dialog" style=" width:80%; height:80%; position: absolute; left: 10%;  top: 10%;" >
                                    <div class="modal-content" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <h4 class="modal-title">REGISTRO DE PACIENTES INGRESO HOSPITALARIO</h4>
                                        </div>
                                        <div class="modal-body">
                                            <iframe id="iframe-ingresos" src=""  width="100%"  height="600" frameborder="0"></iframe>
                                        </div>
                                        <div class="modal-footer" >
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal de Reporte de Altas -->
                            <div class="modal fade" id="modal-altas" tabindex="-1">
                                <div  role="dialog" style=" width:80%; height:80%; position: absolute; left: 10%;  top: 10%;" >
                                    <div class="modal-content" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <h4 class="modal-title">Reporte de Pre-altas y Altas pacientes Hospitalizados</h4>
                                        </div>
                                        <div class="modal-body">
                                            <iframe id="iframe-altas" src=""  width="100%"  height="600" frameborder="0"></iframe>
                                        </div>
                                        <div class="modal-footer" >
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>