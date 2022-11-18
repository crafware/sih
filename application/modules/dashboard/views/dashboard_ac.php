<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-control" content="no-cache">
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>
        <meta name="description" content="<?=$this->UM_CLASIFICACION?> | <?=$this->UM_NOMBRE?>" />
        
        <!-- Le styles -->
        <link href="<?=  base_url()?>assets/libs/assets/animate.css/animate.css" rel="stylesheet" type="text/css" />
        <link href="<?=  base_url()?>assets/assets_ac/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="<?=  base_url()?>assets/assets_ac/css/main.css" rel="stylesheet" type="text/css"/>
        <link href="<?=  base_url()?>assets/assets_ac/css/font-style.css" rel="stylesheet" type="text/css"/>
        <link href="<?=  base_url()?>assets/assets_ac/css/flexslider.css" rel="stylesheet" type="text/css"/>
        <link href="<?=  base_url()?>assets/libs/assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
        
    	<!-- <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script> -->

        <style type="text/css">
          body {
            padding-top: 60px;
          }
        </style>

    
    </head>
    <body>
        <div class="navbar-nav navbar-inverse navbar-fixed-top">
            <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html"><img src="assets/img/logo30.png" alt=""> PACIENTES ADMISIÓN CONTINUA</a>
        </div> 
          <div class="navbar-collapse collapse">
            
          </div><!--/.nav-collapse -->
        </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-lg-4">
                    <!-- OBSERVACION BLOCK -->
                    <div class="dash-unit">
                        <dtitle  style="letter-spacing: 1px;"><i class="fa fa-bed"></i> Observación</dtitle>
                        <hr>
                        <div class="framemail">
                            <div class="window"> 
                                <ul class="mail result_camas">                                   
                                </ul>
                            </div>
                        </div>
                    </div><!-- /dash-unit -->
                </div>
                <!-- OBSERVACION CORTA ESTANCI BLOCK -->
                <div class="col-sm-4 col-lg-4">
                    <div class="dash-unit">
                        <dtitle><i class="fa fa-wheelchair"></i> Corta Estancia</dtitle>
                        <hr>
                        <div class="framemail">
                            <div class="window">
                                <ul class="mail listaPacientesCortaEstancia">                                   
                                </ul>
                            </div>
                        </div>

                    
                    </div>
                </div>
                <div class="col-sm-4 col-lg-4">
                    <div class="dash-unit">
                        <dtitle><i class="fa fa-user-md"></i> Paciente Asignado</dtitle>
                        <hr>
                        <div class="framemail">
                            <div class="window">
                                <ul class="mail listaPacientesAsignados">                                   
                                </ul>
                            </div>
                        </div>

                    
                    </div>
                </div>
            </div>
        </div>
        <script>var base_url = "<?= base_url(); ?>"</script>
        <script src="<?=  base_url()?>assets/libs/jquery/jquery/dist/jquery.js"></script>
        <script type="text/javascript" src="<?=  base_url()?>assets/assets_ac/js/bootstrap.js"></script>
        
        
        <!-- NOTY JAVASCRIPT -->
        <!-- <script type="text/javascript" src="<?=  base_url()?>assets/assets_ac/js/noty/jquery.noty.js"></script>
        <script type="text/javascript" src="<?=  base_url()?>assets/assets_ac/js/noty/layouts/top.js"></script>
        <script type="text/javascript" src="<?=  base_url()?>assets/assets_ac/js/noty/layouts/topLeft.js"></script>
        <script type="text/javascript" src="<?=  base_url()?>assets/assets_ac/js/noty/layouts/topRight.js"></script>
        <script type="text/javascript" src="<?=  base_url()?>assets/assets_ac/js/noty/layouts/topCenter.js"></script> -->
        
        <!-- You can add more layouts if you want -->
       <!--  <script type="text/javascript" src="<?=  base_url()?>assets/assets_ac/js/noty/themes/default.js"></script> -->
       
        <script src="<?=  base_url()?>assets/assets_ac/js/jquery.flexslider.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/js/jquery.cookie.js"></script>
        <script src="<?= base_url('assets/js/Dashboard.js?'). md5(microtime())?>" type="text/javascript"></script>
        <script type="text/javascript">var csrf_token = $.cookie('csrf_cookie');</script>
    </body>
</html>