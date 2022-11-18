<?= Modules::run('Sections/Menu/HeaderBasico')?>
<div class="box-row" style="margin-top: 10px">
    <div class="box-cell col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default " style="height: calc(50%)">
                    
                    <div class="panel-body b-b b-light">
                        <div class="row row-loading" style="margin: calc(12.5%)">
                            <div class="col-md-12">
                                <center>
                                    <i class="fa fa-spinner fa-pulse fa-4x"></i>
                                </center>
                            </div>
                        </div>
                        <div class="row row-load hide">
                            <div class="col-md-12 text-left" style="margin-top: -19px;margin-bottom: 12px">
                                <h6 style="margin-top: 7px;margin-bottom: -6px;margin-left: -15px;    text-align: right;" >
                                    <span class="fecha-actual"></span>&nbsp;&nbsp; <span class="ultima-actualizacion"></span>
                                </h6>
                            </div>
                        </div>
                        <div class="row row-load hide">
                            <div class="col-md-12 last_lista_no">
                                <table class="table m-b-none consultoriosespecialidad_last_lista" style="border: none!important">
                                    <tbody style="border: none!important">
                                        <tr class="" style="border: none!important">
                                            <td colspan="4" style="border: none!important">

                                                <h2 style="font-size: 41px;text-align: center;font-weight: bold;margin-top: 40px;">
                                                    UMAE | Hospital de Especilidades del CMN Siglo XXI<br>
                                                </h2>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4 ">
                                <div class="row">

                                    <div class="col-md-12 col-seccion-1">
                                        <img src="<?=  base_url()?>assets/multimedia/ser_imss.jpg" style="width: 100%;margin-top: 5px;height: 266px;">
                                    </div>
                                    <div class="col-md-12 col-seccion-2">
                                        <img src="<?=  base_url()?>assets/multimedia/cigarro.jpg" style="width: 100%;margin-top: 5px;height: 174px;">
                                    </div>
                                    <div class="col-seccion-3"></div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h1 class="text-center table-pacientes-especialidad-no hide" style="margin-top: calc(15%);margin-bottom: calc(15%)">NO HAY LISTA DE PACIENTES </h1>
                                <div class="row table-pacientes-especialidad">
                                    <h1 class="text-center " style="margin-top: calc(15%);margin-bottom: calc(15%)">NO HAY LISTA DE PACIENTES </h1>
                                </div>
                            </div>
                        </div>                          
                    </div>

                </div>  
            </div>
        </div>
    </div>
</div>
<?= Modules::run('Sections/Menu/FooterBasico')?>
<script src="<?=  base_url()?>assets/js/sections/Lista_ce.js?<?= md5(microtime())?>" type="text/javascript"></script> 
<script type="text/javascript">
$(document).ready(function() {
    setTimeout(function() {
        $('.row-loading').addClass('hide');
        $('.row-load').removeClass('hide');
    },2000)
})
</script>