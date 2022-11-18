<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-8 col-centered" style="margin-top: -20px">
        <div class="box-inner padding">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">INDICADORES DE PRODUCTIVIDAD</span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="card-body" style="padding: 0px">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control" name="Turno">
                                        <option value="" disabled selected>SELECCIONAR TURNO</option>
                                        <option value="Mañana">MATUTINO</option>
                                        <option value="Tarde">VESPERTINO</option>
                                        <option value="Noche">NOCTURNO</option>
                                    </select>
                                    <label class="error hidden" id="select_error" style="color:#FC2727"><b> Advertencia: Debe de seleccionar un turno.</b></label>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding: 0px">
                                <div class="form-group">
                                    <input type="text" name="inputFechaInicio"  class="form-control" id="fechaProductividad" placeholder="Seleccionar Fecha" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button class="btn back-imss btn-block btn-indicador-ce-obs">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row" style="margin-top: -10px">
                <div class="col-md-12">
                    <div class="panel panel-default ">
                        <div class="panel-body b-b b-light text-center">
                            <br>
                            <h4 class="TOTAL_PACIENTES_CONSULTORIOS_OBS mayus-bold" >REGISTROS ENCONTRADOS: <span>0</span></h4>
                            <br><br>
                            <a href="#" class="GENERAR_LECHUGA_CONSULTORIOS_OBS hide">
                                <button class="btn back-imss ">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Generar Lechuga
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </button>
                            </a>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?=  base_url()?>assets/js/Chart.js" type="text/javascript"></script>
<script src="<?= base_url('assets/js/Indicadores.js?'). md5(microtime())?>" type="text/javascript"></script>

