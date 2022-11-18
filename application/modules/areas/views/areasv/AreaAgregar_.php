<?= modules::run('Sections/Menu/HeaderBasico'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-10 col-centered" >
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">AGREGAR ÁREA</span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-area-guardar">
                                <div class="form-group">
                                    <input type="text" name="area_nombre" placeholder="Nombre del Área" value="<?=$info['area_nombre']?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="area_horario_visita" placeholder="Horario de Visita" value="<?=$info['area_horario_visita']?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <select name="area_modulo" data-value="<?=$info['area_modulo']?>" class="form-control">
                                        <option value="">Seleccionar Modulo</option>
                                        <option value="Observación">Observación</option>
                                        <option value="Pisos">Pisos</option>
                                        <option value="Choque">Choque</option>
                                    </select>
                                </div>
                                <div class="form-group mod-genero hide">
                                    <select name="area_genero" data-value="<?=$info['area_genero']?>" class="form-control">
                                        <option value="">Seleccionar Tipo</option>
                                        <option value="Adultos Mujeres">Adultos Mujeres</option>
                                        <option value="Adultos Hombres">Adultos Hombres</option>
                                        <option value="Pediatría">Pediatría</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="area_id" value="<?=$_GET['area']?>">
                                    <input type="hidden" name="accion" value="<?=$_GET['accion']?>">
                                    <input type="hidden" name="csrf_token">
                                    <input type="hidden" name="CONFIG_ENFERMERIA_OBSERVACION" value="<?=CONFIG_ENFERMERIA_OBSERVACION?>">
                                    <button class="btn back-imss btn-block">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script src="<?= base_url('assets/js/areas/areas.js?').md5(microtime())?>" type="text/javascript"></script>