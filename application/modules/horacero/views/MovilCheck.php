<?= modules::run('Sections/Menu/HeaderBasico'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-6 col-centered"> 
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">
                        <strong>HORA CERO</strong><br>
                    </span>
                </div>
                <div class="panel-body b-b b-light">
                    
                    <div class="row" style="margin: calc(10%) 0px 0px 0px">
                        <div class="col-sm-12">
                            <div class="md-form-group text-center" style="margin-top: -15px;text-transform: uppercase;font-size: 25px">
                                <b>Hospital de Especialidades</b>
                            </div> 
                            <div class="md-form-group text-center" style="margin-top: -40px;text-transform: uppercase;font-size: 1.2em">
                                <b>“Dr. Bernardo Sepúlveda Gutiérrez”</b><br>
                            </div> 
                        </div>
                        <div class="col-md-12">
                            <div class="md-form-group text-center" style="margin-top:calc(0%);margin-bottom: calc(10%)">
                                 Av. Cuauhtémoc 330, Col. Doctores, Del. Cuauhtémoc, C.P 06720.
                            </div> 
                            <input type="hidden" name="inputAutoPrint" value="0">
                        </div>
                        <div class="col-md-12 text-center">
                            <hr>
                            <h4 class="total-ingresos">
                                <b>TOTAL DE FOLIOS GENERADOS:</b> 0 FOLIOS
                            </h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script src="<?= base_url('assets/js/Horacero.js?').md5(microtime())?>" type="text/javascript"></script>