<?php echo modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="md-whiteframe-z0 bg-white">
                        <div class="tab-content p m-b-md b-t b-t-2x">
                            <div role="tabpanel" class="tab-pane animated fadeIn active" id="tab_1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4>Ver productividad por turno</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="select2 width100" name="productividad_turno">
                                            <option>Seleccionar turno</option>
                                            <option value="Mañana">Turno Mañana</option>
                                            <option value="Tarde">Turno Tarde</option>
                                            <option value="Noche">Turno Noche</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="productividad_fecha" placeholder="Seleccionar Fecha" value="<?=  date('d/m/Y')?>" class="form-control dd-mm-yyyy">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btn-block btn-turnos">Aceptar</button>
                                    </div>

                                    </div>
                                    <div class="row row-productividad hide" style="margin-top: 20px">
                                        <div class="col-md-6">
                                           <div id="grafica_turnos"  style="width: 100%;height: 260px"> </div>


                                        </div>
                                        <div class="col-md-6" style="border-left: 2px solid #256659">
                                            <h4 class="TOTAL_REGISTROS_FILTRO_INGRESO">0</h4>
                                            <h4 class="TOTAL_REGISTROS_FILTRO_EGRESO">0</h4>
                                            <button class="btn btn-primary btn-generar-luchaga-filtro-ingreso">Ingreso Filtro</button>
                                            <button class="btn btn-primary btn-generar-luchaga-filtro-egreso">Egreso Filtro</button><br><br>
                                            <button class="btn btn-primary btn-ingresos-registros">Ingresos Registros 4-30-21/35/90 I</button>
                                            
                                            <hr>
                                            <h4 class="TOTAL_REGISTROS_OBSERVACION_INGRESO">0</h4>
                                            <h4 class="TOTAL_REGISTROS_OBSERVACION_EGRESO">0</h4>
                                            <button class="btn btn-primary btn-generar-luchaga-observacion-ingreso">Ingreso Observación</button>
                                            <button class="btn btn-primary btn-generar-luchaga-observacion-egreso">Egreso Observación</button><br><br>
                                            <button class="btn btn-primary btn-egresos-registros">Egreso Registros 4-30-21/35/90 E</button>
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
<script src="<?=  base_url()?>assets/js/os/inicio/jefa_am.js"></script>

