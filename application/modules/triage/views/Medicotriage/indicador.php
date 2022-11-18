<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-10 col-centered">
        <div class="box-inner padding">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">INDICADOR DE INGRESOS DE PACIENTES</span>
                    
                </div>
                <div class="panel-body b-b b-light">
                    <div class="card-body">
                        <div class="row" style="margin-top: -10px">
                            <form class="form-indicador-triage">
                                <div class="col-md-6 " >
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss no-border">TURNO</span>
                                        <select class="form-control" name="Turno">
                                            <option value="" disabled selected>SELECCIONE</option>
                                            <option value="Mañana">MATUTINO</option>
                                            <option value="Tarde">VESPERTINO</option>
                                            <option value="Noche">NOCTURNO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 " >
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss no-border">FECHA</span>
                                        <input type="text" name="inputFecha" class="form-control dp-yyyy-mm-dd" required="" placeholder="Seleccionar Fecha" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <input type="hidden" name="csrf_token">
                                    <button class="btn back-imss btn-block">Buscar</button>
                                </div>    
                            </form>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center" style="border-top: 2px solid #256659">
                                <h3 class="Total-Pacientes">0 Pacientes</h3>
                                <h5>TOTAL DE PACIENTES</h5>

                                <a href="#" class="GENERAR_LECHUGA_CONSULTORIOS hide">
                                    <button class="btn back-imss ">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Generar Lechuga
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </button>
                                </a>

                            </div>
                        </div>
                        <hr>
                        <input class="area" name="login_area" value="<?=$this->UMAE_AREA?>" type="hidden" >
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?=  base_url()?>assets/js/Chart.js" type="text/javascript"></script>
<script src="<?= base_url('assets/js/Medicotriage.js?').md5(microtime())?>" type="text/javascript"></script>
