<?php echo modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding">
            <div class="col-md-12">
                <div class="card">
                    <div class="lt p text-center">
                        <h3 style="margin-top: 0px;margin-bottom: 0px">
                            INDICADORES
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url()?>Urgencias/Graficas/Indicador/Triage">
                    <div class="card">
                        <div class="lt p text-center">
                            <h3 style="font-size: 18px">TRIAGE</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url()?>Urgencias/Graficas/Indicador/Consultorios">
                    <div class="card">
                        <div class="lt p text-center">
                            <h3 style="font-size: 18px">CONSULTORIOS</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url()?>Urgencias/Graficas/Indicador/Observacion">
                    <div class="card">
                        <div class="lt p text-center">
                            <h3 style="font-size: 18px">OBSERVACIÓN</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url()?>Urgencias/Graficas/Indicador/Choque">
                    <div class="card">
                        <div class="lt p text-center">
                            <h3 style="font-size: 18px">CHOQUE</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url()?>Urgencias/Graficas/Indicador/Interconsultas">
                    <div class="card">
                        <div class="lt p text-center">
                            <h3 style="font-size: 18px">INTERCONSULTAS</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url()?>Urgencias/Graficas/Indicador/TriageRespiratorio">
                    <div class="card">
                        <div class="lt p text-center">
                            <h3 style="font-size: 18px">TRIAGE RESPIRATORIO</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<?php echo modules::run('Sections/Menu/footer'); ?>


