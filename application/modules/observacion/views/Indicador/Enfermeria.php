<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12">
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-body b-b b-light">
                    <div class="row" >
                        <div class="col-md-12 text-center">
                            <h4> <b>INDICADOR DE PRODUCTIVIDAD</b></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control" name="TIPO_BUSQUEDA">
                                    <option value="POR_FECHA">POR FECHA</option>
                                    <option value="POR_HORA">POR HORA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group POR_FECHA">
                                <input type="text" placeholder="Fecha inicio" name="POR_FECHA_FI" class="form-control datepicker-obs">
                            </div>
                            <div class="form-group POR_HORA hide">
                                <input type="text" placeholder="Fecha" name="POR_HORA_FI" class="form-control datepicker-obs">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group POR_FECHA">
                                <input type="text" placeholder="Fecha fin" name="POR_FECHA_FF" class="form-control datepicker-obs">
                            </div>
                            <div class="form-group POR_HORA hide">
                                <input type="text" placeholder="Hora inicio" name="POR_HORA_HI" class="form-control clockpicker-obs">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block POR_FECHA btn-indicador-obs-enf">Buscar</button>
                            <div class="form-group POR_HORA hide ">
                                <input type="text" placeholder="Hora Fin" name="POR_HORA_HF" class="form-control clockpicker-obs">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block POR_HORA hide btn-indicador-obs-enf"> Buscar</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row obs-enfermeria-result hide">
                <a href="" class="obs-enfermeria-ingreso">
                    <div class="col-md-6">
                        <div class="panel panel-default " >
                            <div class="panel-body b-b b-light text-center">
                                <h2>0 Pacientes</h2>
                                <h5>TOTAl INGRESOS ENFERMERÍA OBSERVACIÓN</h5>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="" class="obs-enfermeria-egreso">
                    <div class="col-md-6">
                        <div class="panel panel-default " >
                            <div class="panel-body b-b b-light text-center">
                                <h2>0 Pacientes</h2>
                                <h5>TOTAl EGRESOS ENFERMERÍA OBSERVACIÓN</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/os/observacion.js?'). md5(microtime())?>" type="text/javascript"></script> 
<script src="<?= base_url('assets/js/Observacion.js?'). md5(microtime())?>" type="text/javascript"></script>