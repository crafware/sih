<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12">
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">Contenido</span>
                    <a class="md-btn md-fab m-b green waves-effect pull-right" onclick="AbrirDocumento(base_url+'Sections/Plantillas/AgregarContenido?con=0&a=add&plantilla=<?=$this->uri->segment(4)?>')">
                        <i class="mdi-content-add i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    
                    <div class="" >
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 0px">
                            <table class="table footable table-bordered table-hover" data-limit-navigation="7" data-filter="#filter" data-page-size="10">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>PLANTILLA</th>
                                        <th style="width: 60%">CONTENIDO</th>
                                        <th style="width: 10%">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($Gestion as $value) {$i++;?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$value['plantilla_nombre']?></td>
                                        <td><?=$value['contenido_datos']?></td>
                                        <td>
                                            <i class="fa fa-pencil icono-accion pointer" onclick="AbrirDocumento(base_url+'Sections/Plantillas/AgregarContenido?con=<?=$value['contenido_id']?>&a=edit&plantilla=<?=$this->uri->segment(4)?>')"></i>&nbsp;
                                            <i class="fa fa-trash-o icono-accion pointer eliminar-contenido" data-id="<?=$value['contenido_id']?>"></i>&nbsp;&nbsp;
                                            
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                                <tfoot class="hide-if-no-paging">
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <ul class="pagination"></ul>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/sections/Plantillas.js?').md5(microtime())?>" type="text/javascript"></script>