<?php echo modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body b-b b-light ">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h5>
                                    <strong>INDICADORES POR TURNOS</strong>
                                </h5>
                                <hr>
                            </div>
                            <div class="col-md-4" >
                                <select class="select2 width100" name="productividad_tipo">
                                    <option>SELECCIONAR TIPO</option>
                                    <option value="Hora Cero" selected="">HORA CERO</option>
                                    <option value="Triage Enfermería">TRIAGE ENFERMERÍA</option>
                                    <option value="Triage Médico">TRIAGE MÉDICO</option>
                                    <option value="Asistente Médica">ASISTENTE MÉDICA</option>
                                    <option value="RX">RX</option>
                                    <option value="Consultorios Especialidad">CONSULTORIOS DE ESPECIALIDAD</option>
                                    <option value="Choque">CHOQUE</option>
                                    <option value="Enfermería Observación">ENFERMERÍA OBSERVACIÓN</option>
                                    <option value="Médico Observación">MÉDICO OBSERVACIÓN</option>
                                    <option value="Cirugía Ambulatoria">CIRUGÍA AMBULATORIA</option>
                                    <option value="Egresos Pacietes A.M">EGRESOS PACIENTES A.M</option>
                                </select>
                            </div>
                            <div class="col-md-4" style="padding-left: 0px">
                                <select class="select2 width100" name="productividad_turno">
                                    <option>SELECCIONAR TURNO</option>
                                    <option value="1" selected="">TURNO MAÑANA</option>
                                    <option value="2">TURNO TARDE</option>
                                    <option value="3">TURNO NOCHE</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="productividad_fecha" placeholder="Seleccionar Fecha" value="<?=  date('d/m/Y')?>" class="form-control dd-mm-yyyy">
                            </div>
                            <div class="col-md-4">
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button class="btn btn-primary btn-block" onclick="location.reload()">ACTUALIZAR</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-primary btn-block btn-turnos-v2">BUSCAR</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row row-productividad ">
                            <hr>
                            
                            <div class="col-md-3 text-center TOTAl_HORACERO pointer ">
                                <h1>0</h1>
                                <h5>Total de Tickets Generados</h5>
                            </div>
                            <div class="col-md-3 text-center TOTAL_TRIAGE_E pointer " >
                                <h1>0</h1>
                                <h5>Total de Pacientes Triage Enfermería</h5>
                            </div>
                            <div class="col-md-3 text-center TOTAL_TRIAGE_M pointer ">
                                <h1>0</h1>
                                <h5>Total de Pacientes Triage Médico</h5>
                            </div>
                            <div class="col-md-3 text-center TOTAL_AM pointer ">
                                <h1>0</h1>
                                <h5>Total de Pacientes Asistentes Médicas</h5>
                            </div>
                            <div class="col-md-3 text-center TOTAL_RX pointer ">
                                <h1>0</h1>
                                <h5>Total de Pacientes RX</h5>
                            </div>
                            <div class="col-md-3 text-center TOTAL_CE pointer ">
                                <h1 >0</h1>
                                
                                <h5 class="text-center">Total de Pacientes Consultorios</h5>
                            </div>
                            <div class="col-md-3 text-center TOTAL_CHOQUE pointer ">
                                <h1>0</h1>
                                <h5>Total de Pacientes Choque</h5>
                            </div>
                            <div class="col-md-3 text-center TOTAL_OBSERVACION_E pointer ">
                                <h1>0</h1>
                                <h5>Pacientes Observación Enfermería</h5>
                            </div>
                            <div class="col-md-3 text-center TOTAL_OBSERVACION_M pointer ">
                                <h1>0</h1>
                                <h5>Pacientes Observación Médico</h5>
                            </div>
                            <div class="col-md-3 text-center TOTAL_CE_CA pointer ">
                                <h1>0</h1>
                                <h5 class="text-center">Cirugía Ambulatoria</h5>
                            </div>
                            <div class="col-md-3 text-center TOTAL_EGRESOS_AM pointer ">
                                <h1>0</h1>
                                <h5>Egresos Pacietes A.M</h5>
                            </div>
                        </div>
                        <div class="row row-productividad hide">
                            <hr>
                            <div class="col-md-12">
                                <div class="panel no-border">
                                    <div class="panel-body">
                                        <div id="grafica_turnos"  style="width: 100%;height: 260px"> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo modules::run('Sections/Menu/footer'); ?>
<script src="<?=  base_url()?>assets/libs/jquery/flot/jquery.flot.js" type="text/javascript"></script>
<script src="<?=  base_url()?>assets/libs/jquery/flot/jquery.flot.resize.js" type="text/javascript"></script>
<script src="<?=  base_url()?>assets/libs/jquery/flot/jquery.flot.pie.js" type="text/javascript"></script>
<script src="<?=  base_url()?>assets/libs/jquery/flot.tooltip/js/jquery.flot.tooltip.min.js" type="text/javascript"></script>
<script src="<?=  base_url()?>assets/libs/jquery/flot-spline/js/jquery.flot.spline.min.js" type="text/javascript"></script>
<script src="<?=  base_url()?>assets/libs/jquery/flot.orderbars/js/jquery.flot.orderBars.js" type="text/javascript"></script>
<script src="<?=  base_url()?>assets/js/Urgencias.js?<?= md5(microtime())?>"></script>

