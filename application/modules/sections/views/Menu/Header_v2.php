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
        <link href="<?=  base_url()?>assets/libs/assets/animate.css/animate.css" rel="stylesheet" type="text/css" />
        <!-- <link href="<?=  base_url()?>assets/libs/assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" /> -->
        <link href="<?=  base_url()?>assets/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/libs/jquery/waves/dist/waves.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/styles/material-design-icons.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/libs/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?=  base_url()?>assets/libs/bootstrap-datepicker/css/datepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/libs/jquery/bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
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
        <link href="<?=  base_url()?>assets/styles/dashboard.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/img/imss.png" rel="icon" type="image/png">
    </head>
    <body>
        <div class="app">
            <aside id="aside" class="app-aside modal  " role="menu">
                <div class="left ">
                    <div class="box back-imss">
                        <?php 
                        if($this->UMAE_AREA=='Administrador'){
                            $Fondo='back-imss-all';
                            $Fondo2='back-imss-all color-white';
                            $BoxShadow='box-shadow: none';
                        }else{
                            $Fondo='back-imss-all';
                            $Fondo2='back-imss-all color-white';
                            $BoxShadow='';
                        }
                        ?>
                        <style> nav ul.nav li a > .icon:before, nav ul.nav li .nav-item > .icon:before {opacity: 1!important;}</style>
                        <div class="navbar md-whiteframe-z1 waves-effect no-radius text-center  <?=$Fondo?> "  style="padding:11.5px;width: 100%;<?=$BoxShadow?>">
                            <span class="h2 " style="font-weight: bold;font-size: 25px;"><?=$this->UM_CLASIFICACION?></span>
                            <br>
                            <span class="h2 " style="font-size: 13px;"><?= substr($this->UM_TIPO, 0,40)?></span>
                        </div>
                        
                        <div class="box-row">
                            <div class="box-cell scrollable ">
                                <div class="box-inner ">
                                    <div class="p hidden-folded blue-50 text-center back-imss" >
                                        <div class="rounded bg-white inline pos-rlt" style="width: 120px;height: 120px">
                                            <center>
                                            <img src="<?=  base_url()?>assets/img/<?=$this->UM_LOGO?>" class="img-responsive " style="background-size: cover;width: 80px;height: 85px; margin-top: 15px;background-size: cover">
                                            </center>
                                        </div>
                                        <a class="block m-t-sm" target="#nav, #account">
                                            <span class="block font-bold" style="font-size: 15px;text-transform: uppercase">
                                                <?=$info[0]['empleado_nombre']?> <?=$info[0]['empleado_apellidos']?>
                                            </span>
                                            <hr style="margin-top: 3px;margin-bottom: 3px;">
                                            <p>
                                                <b style="text-transform: uppercase"><?=$this->UMAE_AREA?></b>
                                            </p>
                                        </a>
                                    </div>
                                    <div id="nav">
                                        <nav ui-nav>
                                            <ul class="nav">
                                                <li>
                                                    <a md-ink-ripple href="<?=  base_url()?>inicio">
                                                        <i class="icon fa fa-home i-20"></i>
                                                        <span class="font-normal color-white" style="margin-left: -15px;">Inicio</span>
                                                    </a>
                                                </li>
                                                <?=  Modules::run('menu/ObtenerMenu')?> 
                                                <br><br>
                                            </ul>
                                        </nav>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <nav>
                            <ul class="nav b-t b back-imss-all hide">
                                <li>
                                    <a href="#"  md-ink-ripple>
                                        <input type="hidden" name="csrf_token">
                                        <span> Sitio desarrollado por bienTICS </span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </aside>
            <div id="content" class="app-content" role="main">
                <div class="box">
                    <div class="navbar md-whiteframe-z1 no-radius <?=$Fondo2?>" >
                        <a md-ink-ripple  data-toggle="modal" data-target="#aside" class="navbar-item pull-left visible-lg visible-xs visible-sm">
                            <i class="mdi-navigation-menu i-24"></i>
                        </a>
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
                        <ul class="nav nav-sm navbar-tool pull-right">
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
                    