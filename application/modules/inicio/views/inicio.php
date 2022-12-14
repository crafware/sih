<?php echo modules::run('Sections/Menu/index'); ?>
<link href="<?= base_url() ?>assets/libs/carousel/owl.carousel.css" type="text/css">
<link href="<?= base_url() ?>assets/libs/carousel/owl.theme.css" type="text/css">


<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/bower_components/bootstrap/dist/css/bootstrap.min.css" type="text/css">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/bower_components/Ionicons/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/dist/css/skins/_all-skins.min.css">
<!-- Morris chart -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/bower_components/morris.js/morris.css">
<!-- jvectormap -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/bower_components/jvectormap/jquery-jvectormap.css">
<!-- Date Picker -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<style>
    .PacientesIngresosNo h3 h4 {
        font-weight: 700;
        font-size: 16px;
    }

    .PacientesIngresosText p {
        font-weight: 400;
        font-size: 14px;
    }

    .v-line {
        border-left: solid #fff;
        height: 140%;
        left: 50%;
        position: absolute;
    }
</style>

<?php
function getServerIp()
{
    if ($_SERVER['SERVER_ADDR'] === "::1") {
        return "localhost";
    } else {
        return $_SERVER['SERVER_ADDR'];
    }
}
?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding" style="margin-top: 60px">
            <div class="row">
                <?php foreach ($Alerts as $value) { ?>
                    <div class="col-md-12 col-centered no-padding">
                        <div class="alert <?= $value['alert_type'] ?> text-justify">
                            <div class="row">
                                <div class="col-md-1 <?= $value['alert_icon'] == '' ? 'hidden' : '' ?>">
                                    <center><i class="<?= $value['alert_icon'] ?>" style="color: #F44336"></i> </center>
                                </div>
                                <div class=" <?= $value['alert_icon'] == '' ? 'col-md-12' : 'col-md-11' ?>">
                                    <?= $value['alert_text'] ?> <?php if ($value['alert_url'] != '') { ?><strong><a href="<?= base_url() ?><?= $value['alert_url'] ?>">AQUÍ</a></strong><?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-6 no-padding hide Graficas">
                    <div class="panel panel-default ">
                        <div class="panel-body b-b b-light text-center">
                            <h5><b>PORCENTAJE HOMBRES-MUJERES: <?= date('d/m/Y') ?></b></h5><br>
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
                            <h5><b>PORCENTAJE POR CLASIFICACIÓN: <?= date('d/m/Y') ?></b></h5><br>
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
                <!-- dashboard -->
                <div class="no-padding dashboard hide">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-2 col-xs-4">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3 id="I_D_Altas_Pacientes"></h3>
                                    <p>Altas</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-child"></i>
                                </div>
                                <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-4">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3 id="I_D_Prealtas">0</h3>
                                    <p>Prealtas</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user-circle-o"></i>
                                </div>
                                <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-4 ">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3 id="I_D_Interconsultas_Solicitadas">0</h3>
                                    <p>Interconsultas solicitadas</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-4">
                            <!-- small box -->
                            <div class="small-box bg-purple">
                                <!--olive-->
                                <div class="inner">
                                    <h3 id="I_D_Interconsultas_Atendidas">0</h3>
                                    <p>Interconsultas atendidas</p>
                                </div>
                                <div class="icon">
                                    <i class="glyphicon glyphicon-user" style="font-size:68px;"></i>
                                    <!--fa fa-universal-access -->
                                </div>
                                <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-4">
                            <!-- small box -->
                            <div class="small-box bg-red" style="margin: 0 0 -10px;">
                                <div class="inner  PacientesIngresosText">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h3 id="I_D_Pacientes_Ingresados">0</h4>
                                        </div>
                                        <div class="col-md-9 hidden-xs" >
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <center>
                                                        <h4 id="I_D_Pacientes_Ingresados_Pro">0</h4>
                                                    </center>
                                                </div>
                                                <div class="v-line"></div>
                                                <div class="col-md-5">
                                                    <center>
                                                        <h4 id="I_D_Pacientes_Ingresados_Urg">0</h4>
                                                    </center>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p style="line-height: 20px; margin: 0 0 -10px">Programados</p>
                                                </div>
                                                <div class="col-md-5">
                                                    <p style="line-height: 20px; margin: 0 0 -10px">Urgencias</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p style="margin: 0 0 -10px;">Pacientes ingresados </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bed"></i>
                                </div>
                                <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-4">
                            <!-- small box -->
                            <div class="small-box bg-maroon-active">
                                <div class="inner">
                                    <h3 id="pic_indicio_embarazo"></h3>
                                    <p>Codigo mater</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-female"></i>
                                </div>
                                <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                            </div>
                        </div>
                        <!-- ./col -->
                        
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <section class="col-lg-12 connectedSortable">
                            <!-- solid sales graph -->
                            <div class="box box-solid bg-teal-gradient">
                                <div class="box-header">
                                    <i class="fa fa-th"></i>
                                    <h3 class="box-title">Sales Graph</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body border-radius-none">
                                    <div class="chart" id="line-chart" style="height: 250px;"></div>
                                </div>
                            </div>
                            <!-- /.box -->
                        </section>
                        <!-- right col -->
                    </div>
                    <!-- /.row (main row) -->
                </div>
                <div class="col-md-12 hide">
                    <div class="alert alert-danger">
                        <h5 style="margin-top: -8px;margin-bottom: -5px;line-height: 1.4">
                            EVITE QUE SU MATRICULA TENGA UN MAL USO, AHORA YA PUEDE SOLICITAR CONTRASEÑA Al INICIAR SESIÓN PARA MANTENER UNA MEJOR SEGURIDAD Y EVITAR QUE OTRO USUARIO PUEDA HACER MAL USO DE SU MATRICULA. <a href="<?= base_url() ?>Sections/Usuarios/MiPerfil" style="color: #2196F3">CLIC AQUI PARA PERSONALIZAR SU CUENTA</a>
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
                                            <a href="<?= base_url() ?>Sections/Cursos/CursosView">
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
                            <?php if ($TieneCurso > 0) { ?>
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
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="TieneCurso" value="<?= $TieneCurso ?>">
        <input type="hidden" name="AreaAcceso" value="<?= $this->UMAE_AREA ?>">
        <input type="hidden" name="IdEmpleado" value="<?= $this->UMAE_USER ?>">
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url() ?>assets/js/Chart.js?" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/Inicio.js?<?= md5(microtime()) ?>" type="text/javascript"></script>
<script src="<?= "http://" . getServerIp() . ':3001/socket.io/socket.io.js' ?>">
    type = "text/javascript" >
</script>
<script src="<?= base_url('assets/js/AdmisionHospitalariaSocket/AdmisionHospitalariaSocketClient.js?') . md5(microtime()) ?>" type="text/javascript"></script>
<script>
    VisualizarDashboard()
</script>
<!-- jQuery 3 -->
<script src="<?= base_url() ?>assets/libs/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url() ?>assets/libs/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url() ?>assets/libs/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?= base_url() ?>assets/libs/bower_components/raphael/raphael.min.js"></script>
<script src="<?= base_url() ?>assets/libs/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url() ?>assets/libs/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= base_url() ?>assets/libs/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= base_url() ?>assets/libs/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url() ?>assets/libs/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url() ?>assets/libs/bower_components/moment/min/moment.min.js"></script>
<script src="<?= base_url() ?>assets/libs/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?= base_url() ?>assets/libs/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/libs/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?= base_url() ?>assets/libs/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url() ?>assets/libs/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/libs/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="<?= base_url() ?>assets/libs/dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<!--<script src="<?= base_url() ?>assets/libs/dist/js/demo.js"></script>-->