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
                <a href="<?= base_url()?>Hospitalizacion/Indicadores/Indicador/interconsultas">
                    <div class="card">
                        <div class="lt p text-center">
                            <h3 style="font-size: 18px">INTERCONSULTAS</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url()?>Hospitalizacion/Indicadores/Indicador/ingresos">
                    <div class="card">
                        <div class="lt p text-center">
                            <h3 style="font-size: 18px">INGRESOS</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url()?>Hospitalizacion/Indicador/Egresos">
                    <div class="card">
                        <div class="lt p text-center">
                            <h3 style="font-size: 18px">EGRESOS</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url()?>Hospitalizacion/Indicador/Prealtas">
                    <div class="card">
                        <div class="lt p text-center">
                            <h3 style="font-size: 18px">PREALTAS</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url()?>Hospitalizacion/Indicadores/Indicador/Interconsultas">
                    <div class="card">
                        <div class="lt p text-center">
                            <h3 style="font-size: 18px">MEDICAMENTOS</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url()?>Hospitalizacion/Indicadores/Indicador/TriageRespiratorio">
                    <div class="card">
                        <div class="lt p text-center">
                            <h3 style="font-size: 18px">PROCEDIMIENTOS</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<?php echo modules::run('Sections/Menu/footer'); ?>