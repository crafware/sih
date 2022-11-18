<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">GESTIÓN DE SESIONES DE USUARIOS</span>
                    
                </div>
                <div class="panel-body b-b b-light">
                    
                    <div class="row">
                        <div class="col-md-4 ">
                            <div class="input-group m-b ">
                                <span class="input-group-addon back-imss no-border" ><i class="fa fa-search-plus"></i></span>
                                <input type="text" class="form-control" id="filter" placeholder="Filtro General">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block btn-sesiones-activas">
                                    <b>
                                        <i class="fa fa-users"></i> SESIONES ACTIVAS:
                                    </b> 
                                    <span>0</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button class="btn btn-danger btn-block cerrar-sesion-usuario" data-id="0">
                                    <i class="fa fa-warning"></i> Cerrar Todas las Sesiones
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover footable table-sessiones"  data-filter="#filter" data-page-size="10">
                                <thead>
                                    <tr>
                                        <th style="width:25%">Nombre</th>
                                        <th>Área de Acceso</th>
                                        <th>Tiempo en área</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
                    <a href="" class="md-btn md-fab md-fab-bottom-right pos-fix teal actualizar-sesiones">
                        <i class="mdi-action-cached i-24"></i>
                    </a>
                    <input type="hidden" name="UsuariosModulo" value="Sesiones">
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Usuarios.js?'). md5(microtime())?>" type="text/javascript"></script>