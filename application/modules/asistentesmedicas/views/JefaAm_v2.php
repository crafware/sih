<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered" style="margin-top: -20px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss text-center">
                    <span><b>INDICADOR POR TURNOS JEFA ASISTENTES MÉDICAS</b></span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h5><b></b></h5>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss no-border">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" name="input_fecha" class="form-control dp-yyyy-mm-dd" placeholder="Seleccionar fecha">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss no-border">
                                            <i class="fa fa-clock-o"></i>
                                        </span>
                                        <select class="form-control" name="inputSelectTurno">
                                            <option value="Mañana">Turno Mañana</option>
                                            <option value="Tarde">Turno Tarde</option>
                                            <option value="Noche">Turno Noche</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <button class="btn btn-primary btn-block btn-turnos-v2">Aceptar</button>
                                </div>
                            </div>
                            <div  class="row" style="margin-top: 20px">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3><b>CONSULTORIOS/OBSERVACIÓN</b></h3>
                                            <hr>
                                        </div>
                                        <div class="col-md-12" style="font-size: 16px">
                                            <b>INGRESO :</b> <span class="filtro-ingreso">0</span>&nbsp;&nbsp;
                                            <b>EGRESO :</b> <span class="filtro-egreso">0</span>&nbsp;&nbsp;
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="margin-top: 15px">
                                            <button class="btn btn-primary btn-ingresos-registros pdf-4-30-29 hide">GENERAR PDF 4-30-29</button>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6" style="border-left: 2px solid #256659!important">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3><b>OBSERVACIÓN CAMAS Y CORTA ESTANCIA</b></h3>
                                            <hr>
                                        </div>
                                        <div class="col-md-12" style="font-size: 16px">
                                            <b>INGRESO :</b> <span class="observacion-ingreso">0</span>&nbsp;&nbsp;
                                            <b>EGRESO :</b> <span class="observacion-egreso">0</span>&nbsp;&nbsp;
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-12" style="margin-top: 15px">
                                            <button class="btn btn-primary btn-egresos-registros pdf-4-30-21-I hide">GENERAR PDF INGRESOS 4-30-21/ I</button><br><br>
                                            <button class="btn btn-primary btn-egresos-registros pdf-4-30-21-E hide">GENERAR PDF EGRESOS 4-30-21/ E</button>
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
</div>
<?= Modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Asistentemedica.js?'). md5(microtime())?>" type="text/javascript"></script> 

