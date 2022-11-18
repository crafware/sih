<?= modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-10 col-centered" style="margin-top: 10px">
            <div class="">
                <div class="panel panel-default">
                    <div class="panel-heading p teal-900 back-imss">
                        <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">LISTA DE FAMILIARES PARA LOS PASES DE VISITAS</span>
                        <a class="md-btn md-fab m-b red pull-right tip " style="right: 60px;position: absolute">
                            <i class="mdi-action-print i-24" onclick="AbrirDocumento(base_url+'Inicio/Documentos/PaseDeVisita/<?=$_GET['folio']?>?tipo=<?=$_GET['tipo']?>')"></i>
                        </a>
                        <a class="md-btn md-fab m-b red pull-right tip " style="right: 0px;position: absolute" onclick="AbrirVista(base_url+'AdmisionHospitalaria/AgregarFamiliar?folio=<?=$_GET['folio']?>&accion=add&familiar=0&tipo=<?=$_GET['tipo']?>',400,300)">
                            <i class="mdi-social-group-add i-24" ></i>
                        </a>
                    </div>
                    <div class="panel-body b-b b-light">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group m-b">
                                    <span class="input-group-addon back-imss border-back-imss">
                                        <i class="fa fa-user-plus"></i>
                                    </span>
                                    <input type="text" id="filter" class="form-control" placeholder="Buscar...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped table-no-padding footable"  data-filter="#filter" data-page-size="15">
                                    <thead>
                                        <tr>
                                            <th colspan="2">NOMBRE</th>
                                            <th>PERENTESCO</th>
                                            <th>REGISTRO</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($Gestion as $value) {?>
                                        <tr id="<?=$value['familiar_id']?>" >
                                            <td style="padding: 0px!important">
                                                <?php if($value['familiar_perfil']!=''){?>
                                                <img src="<?= base_url()?>assets/img/familiares/<?=$value['familiar_perfil']?>?<?=md5(microtime())?>" onclick="ViewImage($(this).attr('src'),'small')" class="pointer" style="width: 46px;height: 40px;margin-right: -4px;">
                                                <?php }else{?>
                                                
                                                <?php }?>
                                                
                                            </td>
                                            <td>
                                                <?=$value['familiar_nombre']?> <?=$value['familiar_nombre_ap']?> <?=$value['familiar_nombre_am']?>
                                            </td>
                                            <td><?=$value['familiar_parentesco']?></td>
                                            <td><?=$value['familiar_registro']?></td>
                                            <td>
                                                <i class="fa fa-pencil icono-accion pointer" onclick="AbrirVista(base_url+'AdmisionHospitalaria/AgregarFamiliar?folio=<?=$_GET['folio']?>&accion=edit&familiar=<?=$value['familiar_id']?>&tipo=<?=$_GET['tipo']?>',400,300)"></i>
                                                <i class="fa fa-image pointer icono-accion" onclick="AbrirVista(base_url+'AdmisionHospitalaria/AgregarFamiliarFoto?familiar=<?=$value['familiar_id']?>&triage_id=<?=$value['triage_id']?>',700,500)"></i>&nbsp;
                                                <i class="fa fa-trash-o icono-accion pointer pases-eliminar-familiar" data-id="<?=$value['familiar_id']?>"></i>
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
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/AdmisionHospitalaria.js?'). md5(microtime())?>" type="text/javascript"></script>