<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-10 col-centered" style="margin-top: -20px">
            <div class="panel panel-default ">
                
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">DOCUMENTOS PARA EL EXPEDIENTE</span>
                    <a  onclick="AbrirVista(base_url+'Sections/Especialidades/DocumentosNuevo?doc=0&a=add',400,300)" class="md-btn md-fab m-b green waves-effect pull-right tip " data-original-title="Indicadores">
                        <i class="mdi-av-queue i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row ">
                        <div class="col-md-6">
                            <div class="input-group m-b ">
                                <span class="input-group-addon back-imss no-border" ><i class="fa fa-user-plus"></i></span>
                                <input type="text" class="form-control" id="filter" placeholder="Buscar...">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover footable"data-filter="#filter" data-limit-navigation="7"data-page-size="10">
                                <thead>
                                    <tr>
                                        <th style="width: 40%;">DOCUMENTO</th>
                                        <th>TIPO DE DOCUMENTO</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {?>
                                    <tr>
                                        <td><?=$value['doc_nombre']?></td>
                                        <td><?=$value['doc_tipo']?></td>
                                        <td>
                                            <i class="fa fa-pencil icono-accion pointer" onclick="AbrirVista(base_url+'Sections/Especialidades/DocumentosNuevo?doc=<?=$value['doc_id']?>&a=edit',400,300)"></i>
                                            <i class="fa fa-trash-o pointer icono-accion pc-doc-del" data-id="<?=$value['doc_id']?>"></i>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                                <tfoot class="hide-if-no-paging">
                                <tr>
                                    <td colspan="7" class="text-center">
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
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Especialidades.js?'). md5(microtime())?>" type="text/javascript"></script>