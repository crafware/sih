<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12">
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">INDICADOR ASISTENTE MÉDICA</span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control" name="TIPO_BUSQUEDA">
                                    <option value="POR_FECHA">REALIZAR FILTRO POR FECHA</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-md-4">
                            <div class="input-group m-b">
                                <span class="input-group-addon back-imss" style="border:1px solid #256659">
                                    <i class="fa fa-calendar-minus-o"></i>
                                </span>
                                <input type="text" name="inputFechaInicio" value="<?= date('Y-m-d')?>" class="form-control dp-yyyy-mm-dd" placeholder="Seleccionar Fecha">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button class="btn back-imss btn-buscar-st7-rc btn-block">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <a href="#" class="TOTAL_AM">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body b-b b-light text-center">
                                <h3>TOTAL DE PACIENTES: <span>0 Pacientes</span></h3>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="col-md-6">
                    <a href="#" class="TOTAL_ST7_INICIADA">
                        <div class="panel panel-default">
                            <div class="panel-body b-b b-light text-center">
                                <h3>Total de ST7 Iniciadas</h3>
                                <h2></h2>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="TOTAL_ST7_TERMINADA">
                        <div class="panel panel-default">
                            <div class="panel-body b-b b-light text-center">
                                <h3>Total de ST7 Terminadas</h3>
                                <h2></h2>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="TOTAL_ESPONTANEA">
                        <div class="panel panel-default">
                            <div class="panel-body b-b b-light text-center">
                                <h3>Procedencia Espontánea</h3>
                                <h2></h2>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="TOTAL_NO_ESPONTANEA">
                        <div class="panel panel-default">
                            <div class="panel-body b-b b-light text-center">
                                <h3>Procedencia No Espontánea</h3>
                                <h2 ></h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Asistentemedica.js?').md5(microtime())?>" type="text/javascript"></script>