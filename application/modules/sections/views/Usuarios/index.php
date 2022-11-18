<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12" style="margin-top: 10px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">GESTIÓN DE USUARIOS</span>
                    <a href="<?=  base_url()?>Sections/Usuarios/Usuario/0/?a=add" target="_blank" class="md-btn md-fab m-b red waves-effect pull-right" rel="opener">
                        <i class="mdi-social-person-add i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row" style="margin-top: 15px">
                        <div class="col-md-3">
                            <div class="form-group" >
                                <select name="FILTRO_TIPO">
                                    <option value="">SELECCIONAR TIPO DE FILTRO</option>
                                    <option value="empleado_id">POR ID</option>
                                    <option value="empleado_matricula">POR MATRICULA</option>
                                    <option value="empleado_nombre">POR NOMBRE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group m-b">
                                <input type="text" name="FILTRO_VALUE" class="form-control" placeholder="Buscar...">
                                <span class="input-group-addon no-border back-imss pointer input-buscar">
                                    <i class="fa fa-search-plus " style="font-size: 22px"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-1">
                            <div class="form-group" >
                                <input type="text" class="form-control" id="filter" placeholder="Filtro General">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover footable table-usuarios"  data-filter="#filter" data-page-size="10" data-limit-navigation="7">
                                <thead>
                                    <tr>
                                        <th>Matrícula</th>
                                        <th>Nombre</th>
                                        <th data-hide="phone">Apellidos</th>
                                        <th data-hide="phone">Categoria</th>
                                        <th data-hide="phone">Servicio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot class="hide-if-no-paging">
                                <tr>
                                    <td colspan="6" class="text-center">
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
<script src="<?= base_url('assets/js/Usuarios.js?'). md5(microtime())?>" type="text/javascript"></script>