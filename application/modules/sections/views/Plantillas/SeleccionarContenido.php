<?= modules::run('Sections/Menu/HeaderBasico'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-8 col-centered">
    
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">Nuevo Contendio</span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row" >
                        <div class="col-md-12">
                            <table class="table footable table-bordered" id="SeleccionarContenido">
                                <thead>
                                    <tr>
                                        <th>CONTENIDO</th>
                                        <th>ACCIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {?>
                                    <tr >
                                        <td class="contentSeleccion"><?=$value['contenido_datos']?></td>
                                        <td>
                                            <label class="md-check">
                                                <input type="radio" name="SeleccionarContenido" value="<?=$value['contenido_id']?>">
                                                <i class="blue"></i>
                                            </label>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php if(empty($Gestion)){?>
                                    <tr>
                                        <td colspan="2">NO SE ENCONTRARÓN CONTENIDOS PARA ESTA PLANTILLA</td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                        <a href="" class="md-btn md-fab md-fab-bottom-right pos-fix teal select-content">
                            <i class="fa fa-check i-24"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<input type="hidden" name="SeleccionarContenido" value="Si">
<input type="hidden" name="inputName" value="<?=$_GET['input']?>">
<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script src="<?= base_url('assets/js/sections/Plantillas.js?').md5(microtime())?>" type="text/javascript"></script>