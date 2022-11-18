<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-9 col-centered">
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">Tratamientos Quirúrgicos</span>
                    
                    <div class="card-tools" style="margin-top: 10px">
                        <ul class="list-inline">
                            <li class="dropdown">
                                <a md-ink-ripple data-toggle="dropdown" class="md-btn md-fab green md-btn-circle tip btn-add-tratamiento-quirurgico" data-triage-id="<?=$this->uri->segment(4)?>">
                                    <i class="mdi-social-person-add i-24 " ></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 0px">
                            <table class="table table-bordered table-hover footable"  data-limit-navigation="7" data-filter="#filter" data-page-size="10">
                                <thead>
                                    <tr>
                                        <th>Fecha & Hora</th>
                                        <th>Tratamiento Quirúrgico</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tratamientos as $value) {?>
                                    <tr>
                                        <td><?=$value['tratamiento_fecha']?> <?=$value['tratamiento_hora']?></td>
                                        <td><?=$value['tratamiento_nombre']?></td>
                                        <td>
                                            <i class="fa fa-pencil icono-accion icono-editar-tratamiento pointer" data-triage_id="<?=$this->uri->segment(4)?>" data-tratamiento_id="<?=$value['tratamiento_id']?>" data-tratamiento_nombre="<?=$value['tratamiento_nombre']?>"></i>&nbsp;
                                            <a href="<?= base_url()?>Sections/Documentos/DocumentosTratamientoQuirurgico/<?=$value['tratamiento_id']?>/?folio=<?=$this->uri->segment(4)?>" target="_blank">
                                                <i class="fa fa-files-o icono-accion tip" data-original-title="Solicitar Documentos"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/sections/TratamientoQuirurgico.js')?>" type="text/javascript"></script>