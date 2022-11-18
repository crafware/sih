<?= modules::run('Sections/Menu/index'); ?> 
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/libs/light-bootstrap/all.min.css" />
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
                                    <select class="form-control" name="area_ac">
                                        <option value="">Seleccionar Área</option>
                                        <option value="Triage" >Triage</option>
                                        <option value="Cons-Obs" >Consultorios/Observación</option>
                                    </select>
                                </div>
                            </div>
                           <div class="col-md-4">
                                <div class="form-group">
                                  <!-- <input class="search_query form-control" type="text" name="medico_ac" id="medico_ac" placeholder="Escribir Médico..."> -->
                                   <select name="id_medico" class="form-control" >
                                        <option value='' disabled selected>Seleccionar Médico</option>
                                        <?php foreach ($medicosAC as $value) {?>
                                        <option value="<?=$value['empleado_id']?>"><?=$value['empleado_nombre']?> <?=$value['empleado_apellidos']?></option>
                                        <?php }?>
                                    </select>         
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control" name="Turno" id="Turno" required>
                                        <option value="" disabled selected>Seleccionar Turno</option>
                                        <option value="Mañana">Matutino</option>
                                        <option value="Tarde">Vespertino</option>
                                        <option value="Noche">Nocturno</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="inputFechaInicio"  class="form-control" id="fechaProductividad" placeholder="Seleccionar Fecha" autocomplete="Off">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button class="btn back-imss btn-block btn-indicador-ac">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row Registros hide" style="margin-top: -10px" >
                <div class="col-md-12">
                    <div class="panel panel-default ">
                        <div class="panel-body b-b b-light text-center">
                            <br>
                            <h4 class="TOTAL_PACIENTES mayus-bold" >REGISTROS: <span>0 Pacientes</span></h4>
                            <br><br>
                            <a href="#" class="GENERAR_LECHUGA_CONSULTORIOS hide">
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
<script src="<?= base_url('assets/js/productividad.js?'). md5(microtime())?>" type="text/javascript"></script>