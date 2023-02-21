<?php echo modules::run('Sections/Menu/index'); ?>

<!-- Ionicons -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/bower_components/Ionicons/css/ionicons.min.css">
<!-- Theme style -->
<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/libs/dist/css/AdminLTE.css"> -->
<link rel="stylesheet" href="<?= base_url() ?>assets/styles/dashboards.css">
<!-- Morris chart -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/bower_components/morris.js/morris.css">
<!-- jvectormap -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/bower_components/jvectormap/jquery-jvectormap.css">

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
                    <div class="row">
                        <!-- Altas -->
                        <div class="col-lg-2 col-xs-4">                            
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3 id="I_D_Altas_Pacientes"></h3>
                                    <p>Altas</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-child"></i>
                                </div>
                                <a href="#" class="small-box-footer">Más detalles <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- Pre altas-->
                        <div class="col-lg-2 col-xs-4">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3 id="I_D_Prealtas">0</h3>
                                    <p>Prealtas</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user-circle-o"></i>
                                </div>
                                <a href="#" class="small-box-footer">Más detalles <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- Interconsultas solicitadas -->
                        <div class="col-lg-2 col-xs-4 ">
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3 id="I_D_Interconsultas_Solicitadas">0</h3>
                                    <p>Interconsultas solicitadas</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">Más detalles <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- Interconsultas atendidas -->
                        <div class="col-lg-2 col-xs-4">
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3 id="I_D_Interconsultas_Atendidas">0</h3>
                                    <p>Interconsultas atendidas</p>
                                </div>
                                <div class="icon">
                                    <i class="glyphicon glyphicon-user" style="font-size:68px;"></i>
                                </div>
                                <a href="#" class="small-box-footer">Más detalles <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- Pacientes ingresados -->
                        <div class="col-lg-2 col-xs-4">
                            <div class="small-box bg-red">
                                <div class="inner  PacientesIngresosText">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h3 id="I_D_Pacientes_Ingresados">0</h3>
                                        </div>
                                        <div class="col-md-9 hidden-xs" >
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4 class="text-right" id="I_D_Pacientes_Ingresados_Pro">0</h4>
                                                </div>
                                                <div class="v-line"></div>
                                                <div class="col-md-5">
                                                    <h4 class="text-right" id="I_D_Pacientes_Ingresados_Urg">0</h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4 class="text-right" style="line-height: 0px; margin: 0 0 -10px; font-size :12px">Programados</h4>
                                                </div>
                                                <div class="col-md-5">
                                                    <h4 class="text-right" style="line-height: 0px; margin: 0 0 -10px; font-size :12px">Urgencias</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <p>Pacientes ingresados<p>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bed"></i>
                                </div>
                                <a href="#" class="small-box-footer">Más detalles <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- Codigo mater -->
                        <div class="col-lg-2 col-xs-4">
                            <div class="small-box bg-fuchsia">
                                <div class="inner">
                                    <h3 id="pic_indicio_embarazo"></h3>
                                    <p>Codigo mater</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-female"></i>
                                </div>
                                <a href="#" class="small-box-footer">Más detalles <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Gráfico Principal -->
                    <div class="row">
                        <section class="col-lg-12 connectedSortable">
                            <!-- solid sales graph -->
                            <div class="box box-solid bg-teal-gradient">
                                <div class="box-header">
                                    <i class="fa fa-th"></i>
                                    <h3 class="box-title">Gráfica de Productividad</h3>
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

