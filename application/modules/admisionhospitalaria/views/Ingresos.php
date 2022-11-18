<?= modules::run('Sections/Menu/Header_modal'); ?> 

    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered" style="margin-top: -20px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss text-center">
                    <span><b>INGRESOS</b></span>
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
                                        <input type="text" name="input_fecha" class="form-control dp-yyyy-mm-dd" placeholder="Seleccionar fecha" autocomplete="off">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <button class="btn btn-primary btn-block btn-buscar-ingresos">Aceptar</button>
                                </div>
                            </div>
                            <div  class="row" style="margin-top: 20px">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12" style="font-size: 16px">
                                            <b>INGRESOS :</b> <span class="filtro-ingreso">0</span>&nbsp;&nbsp;
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="margin-top: 15px">
                                            <button class="btn btn-primary btn-ingresos-registros pdfIngresosHosp hide">GENERAR PDF</button>
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

<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/AdmisionHospitalaria.js?'). md5(microtime())?>" type="text/javascript"></script>