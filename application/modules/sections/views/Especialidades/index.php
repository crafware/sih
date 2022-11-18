<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-8 col-centered" style="margin-top: 10px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">GESTIÓN DE ESPECIALIDADES</span>
                    <a class="md-btn md-fab m-b red pull-right" onclick="AbrirVista(base_url+'Sections/Especialidades/Agregar/?es=0&accion=add',400,300)">
                        <i class="mdi-av-queue i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover footable table-usuarios"  data-filter="#filter" data-page-size="10" data-limit-navigation="7">
                                <thead>
                                    <tr>
                                        <th>ESPECIALIDAD</th>
                                        <th>CONSULTORIOS</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {?>
                                    <tr>
                                        <td><?=$value['especialidad_nombre']?></td>
                                        <td><?=$value['especialidad_consultorios']?></td>
                                        <td>
                                            <i class="fa fa-pencil icono-accion pointer" onclick="AbrirVista(base_url+'Sections/Especialidades/Agregar/?es=<?=$value['especialidad_id']?>&accion=edit',400,300)"></i>&nbsp;
                                            <a href="<?= base_url()?>Sections/Especialidades/Consultorios?es=<?=$value['especialidad_id']?>">
                                                <i class="fa fa-trello icono-accion"></i>
                                            </a>
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
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/sections/Especialidades.js?'). md5(microtime())?>" type="text/javascript"></script>