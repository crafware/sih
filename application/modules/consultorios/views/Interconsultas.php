<?= modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12" style="margin-top: -20px">
            <div class="panel panel-default ">
                <ul class="nav nav-md nav-tabs nav-lines b-info back-imss" style="color: white!important">
                    <li class="active">
                        <a href="" data-toggle="tab" data-target="#tab_1" aria-expanded="false" style="color: white!important">Pendientes</a>
                    </li>
                    <li class="active">
                        <a href="" data-toggle="tab" data-target="#tab_2" aria-expanded="false" style="color: white!important">Realizadas</a>
                    </li>
                    <li class="">
                        <a href=""  data-toggle="tab" data-target="#tab_3" style="color: white!important">Buscar Paciente</a>
                    </li>
                </ul>            
                <div class="tab-content p m-b-md b-t b-t-2x">
                    <div role="tabpanel" class="tab-pane animated fadeIn active" id="tab_1">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover footable" data-filter="#TriageIdFilter" data-limit-navigation="7"data-page-size="10">
                                    <thead>
                                        <tr class="bg-dark">
                                            <th style="width: 20%;">PACIENTE</th>
                                            <th>FOLIO</th>
                                            <th>FECHA DE SOLICITUD</th>
                                            <th>SERVICIO SOLICITANTE</th>
                                            <!-- <th>ÁREA SOLICITADA</th> -->
                                            <th>MOTIVO</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($Gestion as $value) {?>
                                        <tr id="<?=$value['triage_id']?>" >
                                            <td class=""  style="font-size: 10px;width: 13%">
                                                <?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?>
                                            </td>
                                            <td><?=$value['triage_id']?></td>
                                            <td style="width: 16%"><?=date("d-m-Y", strtotime($value['doc_fecha']))?> <?=$value['doc_hora']?></td>
                                            <td style="width: 18%;text-align: center">
                                                <?=$value['esp_nom2']?><br>
                                                (<?=$value['doc_modulo']?>)
                                            </td>
                                            <!-- <td style="width: 18%;text-align: center"><?=$value['esp_nom1']?></td> -->
                                            <td style="width: 15%" class="ver-texto pointer" data-content-title="DIAGNOSTICO" data-content-text="<?=$value['motivo_interconsulta']?>">
                                                <?= substr($value['motivo_interconsulta'], 0,20)?>...
                                            </td>
                                            <td >
                                                <?php if($value['doc_estatus']=='En Espera'){?>
                                                    <?php if($value['empleado_envia']!=$this->UMAE_USER){?>
                                                    <a href="<?=  base_url()?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Interconsulta&folio=<?=$value['triage_id']?>&via=Interconsulta&doc_id=<?=$value['doc_id']?>" target="_blank" rel="opener">
                                                        <i class="fa fa-pencil-square-o icono-accion tip" data-original-title="Realizar Nota de Interconsulta (valoración)"></i>
                                                    </a>&nbsp;
                                                    <?php }?>
                                                <?php }?>
                                                <a href="<?=  base_url()?>Sections/Documentos/Expediente/<?=$value['triage_id']?>/?tipo=Consultorios&url=Enfermeria" target="_blank">
                                                    <i class="fa fa-share-square-o icono-accion tip" data-original-title="VER EXPEDIENTE"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
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
                    <div role="tabpanel" class="tab-pane animated fadeIn" id="tab_3">
                        <div class="row">
                            <form class="formSearch">
                                <div class="col-md-4" >
                                    <div class="form-group">
                                        <div class="form-group">
                                            <select class="form-control" name="inputSelect">
                                                <option value="POR_NUMERO">N° DE PACIENTE</option>
                                                <option value="POR_NOMBRE">NOMBRE DEL PACIENTE</option>
                                                <option value="POR_NSS">N.S.S (SIN AGREGADO)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5" style="padding-right: 2px">
                                    <div class="input-group m-b ">
                                        <span class="input-group-addon back-imss "  style="border:1px solid #256659">
                                            <i class="fa fa-search"></i>
                                        </span>
                                        <input type="text" name="inputSearch" class="form-control" autocomplete="off" placeholder="Ingresar N° de Paciente">
                                    </div>
                                </div>
                                <div class="col-md-3" style="padding-left: 0px">
                                    <div class="form-group">
                                        <input type="hidden" name="csrf_token">
                                        <button class="btn btn-block back-imss" name="btnSearch">BUSCAR</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="inputSelectNombre hide" style="color: red;margin-top: -10px"><i class="fa fa-warning"></i> ESTA CONSULTA ESTA LIMITADA A: 100 REGISTROS</h6>
                                <table class="footable table table-bordered" id="tableResultSearch" data-filter="#search" data-page-size="20" data-limit-navigation="7">
                                    <thead>
                                        <tr>
                                            <th data-sort-ignore="true">N° DE PACIENTE</th>
                                            <th data-sort-ignore="true">FECHA INGRESO</th>
                                            <th data-sort-ignore="true">NOMBRE</th>
                                            <th data-sort-ignore="true">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h5>NO SE HA REALIZADO UNA BÚSQUEDA</h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-center">
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
<input type="hidden" name="umae_user" value="<?=$this->UMAE_USER?>">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/interconsultas.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/Consultorios.js?'). md5(microtime())?>" type="text/javascript"></script>
