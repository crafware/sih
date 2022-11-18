<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-6 col-centered"> 
            <div class="panel panel-default " style="margin-top: 10px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">
                        <strong>HORA CERO</strong><br>
                    </span>
                </div>
                <div class="panel-body b-b b-light">
                    
                    <div class="row" style="margin-top: 0px">
                        <div class="col-sm-12">
                            <div class="md-form-group text-center" style="margin-top: -15px;text-transform: uppercase;font-size: 26px">
                                <b><?=$this->UM_TIPO?></b><br>
                                <b style="font-size: 16px"><?=$this->UM_NOMBRE?></b>
                                
                            </div>
                            <div class="md-form-group text-center " style="margin-top: 0px;text-transform: uppercase;font-size: 1.2em">
                                <center>
                                <style>
                                    .agregar-horacero-paciente i{ color: white;}.agregar-horacero-paciente i:hover{color: white;}
                                </style>
                                <a  md-ink-ripple="" class="agregar-horacero-paciente md-btn md-fab m-b back-imss waves-effect " style="width: 150px;height: 150px;padding: 43px">
                                    <i class="mdi-social-person-add fa-5x"></i>
                                </a>
                            </center>
                            </div> 
                            <div class="md-form-group text-center" style="margin-top:-20px">
                                <?=$this->UM_DIRECCION?>
                            </div> 

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Horacero.js?').md5(microtime())?>" type="text/javascript"></script>