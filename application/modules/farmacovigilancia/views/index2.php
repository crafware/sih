<?php echo modules::run('Sections/Menu/index'); ?>
<div class="box-row">
            <div class="box-cell">
                <div class="box-inner padding">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="lt p text-center">
                                <h3 style="margin-top: 0px;margin-bottom: 0px ">
                                    PRESCRIPCIONES TOTALES
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url()?>Farmacovigilancia/PreinscripcionesTotales">
                            <div class="card">
                                <div class="lt p text-center">
                                    <h3 style="font-size: 18px">Nuevas</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url()?>Urgencias/Graficas/Indicador/Consultorios">
                            <div class="card">
                                <div class="lt p text-center">
                                    <h3 style="font-size: 18px">Canceladas</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url()?>Urgencias/Graficas/Indicador/Observacion">
                            <div class="card">
                                <div class="lt p text-center">
                                    <h3 style="font-size: 18px">Revisadas a modificar</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url()?>Urgencias/Graficas/Indicador/Choque">
                            <div class="card">
                                <div class="lt p text-center">
                                    <h3 style="font-size: 18px">Revisadas a validar</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url()?>Urgencias/Graficas/Indicador/Interconsultas">
                            <div class="card">
                                <div class="lt p text-center">
                                    <h3 style="font-size: 18px">Comentarios farmaceuticos</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url()?>Urgencias/Graficas/Indicador/TriageRespiratorio">
                            <div class="card">
                                <div class="lt p text-center">
                                    <h3 style="font-size: 18px">Pendientes por validar</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url()?>Urgencias/Graficas/Indicador/TriageRespiratorio">
                            <div class="card">
                                <div class="lt p text-center">
                                    <h3 style="font-size: 18px">Antibióticos</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
</div>
<?php echo modules::run('Sections/Menu/footer'); ?>


<script src="<?= base_url('assets/js/Farmacovigilancia.js?'). md5(microtime())?>" type="text/javascript"></script>
