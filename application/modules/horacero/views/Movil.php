<?= modules::run('Sections/Menu/HeaderHC'); ?> 
<div class="box-row" >
    <div class="box-cell">
        <div class="box-inner padding col-md-6 col-centered"> 
            <div class="panel panel-default " style="margin-top: -10px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-align: center;">
                        <center><strong>FOLIO DE INGRESO</strong></center>
                    </span>
                    <div style="position: relative">
                        <div style="position: absolute;right: 0px;top: -24px;">
                            <i class="pointer pantalla-completa accion-windows fa fa-arrows-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row" style="margin: calc(20%) 0px 0px 0px">
                        <div class="col-sm-12 col-xs-12">
                            <div class="md-form-group text-center tituloHosp" style="margin-top: -70px;text-transform: uppercase;font-size: 30px">
                                <b>Hospital de Especialidades</b>
                            </div> 
                            <div class="md-form-group text-center tituloHospNombre" style="margin-top: -55px;text-transform: uppercase;font-size: 1.5em">
                                <b>“Dr. Bernardo Sepúlveda”</b><br><br>
                            </div> 
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <center>
                                <style>
                                    .agregar-horacero-paciente i{ color: white;}.agregar-horacero-paciente i:hover{color: white;}
                                </style>
                                <a  md-ink-ripple="" class="agregar-horacero-paciente-movil md-btn md-fab m-b back-imss waves-effect " id="ticketButton" style="width: 420px;height: 420px;padding: 115px">
                                    <i class="fa fa-user-plus fa-5x" style="font-size: 200px!important"></i>
                                </a>
                                <div class="msj-generando-ticket hide">
                                    <i class="fa fa-spinner fa-pulse fa-5x"></i><br>
                                    <h5>IMPRIMIENDO TICKET ESPERE POR FAVOR...</h5>
                                </div>
                            </center>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="md-form-group text-center tituloDir" style="margin-top:calc(10%);margin-bottom: calc(10%);font-size: 18px">
                                Av. Cuauhtémoc 330, Col. Doctores, Del. Cuauhtémoc, C.P 06720.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- background no visible-->
                <div style="display:none;">
                    <canvas id="canvas" width="412" height="380"></canvas>    
                    <img id="logo" src="<?= base_url('assets/img/logo_imss.png')?>"  alt="">
                </div>
        </div>
    </div>
</div>
<input type="hidden" name="FullScreen" value="Si">
<?= modules::run('Sections/Menu/FooterHC'); ?>
<script type="text/javascript">
        // Settings
        var ipaddr = '11.47.37.13';
        var devid = 'local_printer';
        var timeout = '60000';
        var grayscale = false;
        var layout = false;
</script>
<script src="<?= base_url('assets/js/Movil.js?').md5(microtime())?>" type="text/javascript"></script>
<script type="text/javascript" src="<?= base_url('assets/js/epson-tm/epos-print-4.1.0.js')?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/epson-tm/barcode.js')?>"></script>
