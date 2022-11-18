<?php echo modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding">
           <ol class="breadcrumb" style="margin-top: -20px">
                <li><a href="#">Inicio</a></li>
                <li><a href="#"><?=$_SESSION['UMAE_AREA']?></a></li>
            </ol>
            <div class="col-md-12">
                <div class="panel panel-default ">
                    <div class="panel-body b-b b-light">
                        <div class="row">
                            <div class="col-md-2" style='padding-right: 0px'>
                                <select class="width100 select_filter" data-value="<?=$_GET['filter_select']?>">
                                    <option>Buscar por</option>
                                    <option value="by_fecha">Fechas</option>
                                    <option value="by_hora">Hora</option>
                                </select>
                            </div>
                            <form action="<?=  base_url()?>inicio/jefa_enfermeras" class="by_fecha <?=$_GET['filter_select']=='by_fecha'?'':'hide'?>" method="GET">
                                <div class="col-md-2">
                                    <input type="text" name="fi" value="<?=$_GET['fi']?>" placeholder="DEL " class="input-date form-control">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="ff" value="<?=$_GET['ff']?>" placeholder="AL " class="input-date form-control">
                                </div>
                                <div class="col-md-2">
                                    <select name="triage_color" class="form-control" data-value="<?=$_GET['triage_color']?>">
                                        <option value="Todos">Todos</option>
                                        <option value="Rojo">Rojo</option>
                                        <option value="Naranja">Naranja</option>
                                        <option value="Amarillo">Amarillo</option>
                                        <option value="Verde">Verde</option>
                                        <option value="Azul">Azul</option>

                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="hidden" name="filter_select" value="<?=$_GET['filter_select']?>">
                                    <button class="btn btn-primary">Buscar</button>
                                </div>
                            </form>

                            <form action="<?=  base_url()?>inicio/jefa_enfermeras" class="by_hora <?=$_GET['filter_select']=='by_hora'?'':'hide'?>" method="GET">
                                <div class="col-md-2">
                                    <input type="text" name="fi" value="<?=$_GET['fi']?>" placeholder="DEL " class="input-date form-control">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="hi" value="<?=$_GET['hi']?>" placeholder="DE " class="input-time form-control">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="hf" value="<?=$_GET['hf']?>" placeholder="A" class="input-time form-control">
                                </div>
                                <div class="col-md-2">
                                    <select name="triage_color" class="form-control" data-value="<?=$_GET['triage_color']?>">
                                        <option value="Todos">Todos</option>
                                        <option value="Rojo">Rojo</option>
                                        <option value="Naranja">Naranja</option>
                                        <option value="Amarillo">Amarillo</option>
                                        <option value="Verde">Verde</option>
                                        <option value="Azul">Azul</option>

                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="hidden" name="filter_select" value="<?=$_GET['filter_select']?>">
                                    <button class="btn btn-primary">Buscar</button>
                                </div>
                            </form>
                            <form action="<?=  base_url()?>inicio/jefa_enfermeras" class="by_like <?=$_GET['filter_select']=='by_like'?'':'hide'?>" method="GET">
                                <div class="col-md-2">
                                    <select class="width100 select2" name="filter_by">
                                        <option value="triage_id">Papeleta</option>
                                        <option value="triage_nombre" selected="">Nombre</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="like" value="<?=$_GET['like']?>" placeholder="Ejemplo: felipe "class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <select name="triage_color" class="form-control" data-value="<?=$_GET['triage_color']?>">
                                        <option value="Todos">Todos</option>
                                        <option value="Rojo">Rojo</option>
                                        <option value="Naranja">Naranja</option>
                                        <option value="Amarillo">Amarillo</option>
                                        <option value="Verde">Verde</option>
                                        <option value="Azul">Azul</option>

                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="hidden" name="filter_select" value="<?=$_GET['filter_select']?>">
                                    <button class="btn btn-primary">Buscar</button>
                                </div>
                            </form>
                            <div class="col-md-4 pull-right hide">
                                <div class="input-group m-b ">
                                    <span class="input-group-addon back-imss no-border" ><i class="fa fa-search"></i></span>
                                    <input type="text" class="form-control" id="filter" placeholder="Filtro General">
                                </div>
                            </div>
                            <?php if($_GET['filter_select'] && !empty($Gestion)){?>
                            <form action="<?=  base_url()?>inicio/formato_2430_003_039" target="_blank">
                                <input type="hidden" name="fi" value="<?=$_GET['fi']?>" class="color-black">
                                <input type="hidden" name="ff" value="<?=$_GET['ff']?>" class="color-black">
                                <input type="hidden" name="filter_select" value="<?=$_GET['filter_select']?>" class="color-black">
                                <input type="hidden" name="triage_color" value="<?=$_GET['triage_color']?>" class="color-black">
                                <input type="hidden" name="hi" value="<?=$_GET['hi']?>" class="color-black">
                                <input type="hidden" name="hf" value="<?=$_GET['hf']?>" class="color-black">
                                <button md-ink-ripple="" class="md-btn md-fab m-b back-imss waves-effect" style="position: absolute;top: 10px"><i class="fa fa-file-pdf-o fa-2x"></i></button>
                            </form>
                            <?php }?>
                        </div>
                        
                        
                        <div class="row" style="margin-top: 20px">
                            <div class="col-md-6" >
                                <h3>Total de registros encontrados: <?=  count($Gestion)?> Registros</h3><br><br>
                            </div>
                            <div class="col-md-6" >
                                <h3>Tiempo Promedio Transcurruido: 
                                    <?php 
                                    $total_minutos=0;
                                    foreach ($Gestion as $value) {
                                        date_default_timezone_set('America/Mexico_City');
                                        $am=new DateTime(str_replace('/', '-', $value['asistentesmedicas_fecha'].' '.$value['asistentesmedicas_hora']));
                                        $ce=new DateTime(str_replace('/', '-', $value['ce_fs'].' '.$value['ce_hs']));
                                        $time=$am->diff($ce);
                                        $total_minutos=$total_minutos+$time->h*60 + $time->i;
                                       
                                    }
                                    echo $total_minutos.' Min';
                                    ?>
                                </h3><br><br>
                            </div>
                            <?php if($_GET['filter_select'] && !empty($Gestion) ){?>
                            <div class="col-md-6">
                                <div ui-jp="plot" ui-options="
                                     [{label:'Clasificados', data: <?=  count($CLASIFICADOS)?>}, {label:'No Clasificados', data: <?=  count($NO_CLASIFICADOS)?>}],
                                  {
                                    series: { pie: { show: true, innerRadius: 0.6, stroke: { width: 3 }, label: { show: true, threshold: 0.05 } } },
                                    colors: ['#4CAF50','#078BF4'],
                                    grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#212121' },   
                                    tooltip: true,
                                    tooltipOpts: { content: '%s: %p.0%' }
                                  }
                                " style="height:240px"></div>
                            </div>
                            <div class="col-md-6" style="padding: 0px;border-left: 2px solid #256659">
                                <div ui-jp="plot" ui-options="
                                     [{label:'Reanimación', data: <?=  count($triage_rojo)?>}, {label:'Emergencia', data: <?=  count($triage_naranja)?>},{label:'Urgencia',data:<?=$triage_amarillo?>}, {label:'Urgencia Menor',data:<?=$triage_verde?>}, {label:'Sin Urgencia',data:<?=$triage_azul?>}],
                                  {
                                    series: { pie: { show: true, innerRadius: 0.6, stroke: { width: 3 }, label: { show: true, threshold: 0.05 } } },
                                    colors: ['#F92718','#FF9800','#FFC107','#00C853','#2196F3'],
                                    grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#212121' },   
                                    tooltip: true,
                                    tooltipOpts: { content: '%s: %p.0%' }
                                  }
                                " style="height:240px"></div>
                            </div>
                            <?php }?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo modules::run('Sections/Menu/footer'); ?>
<script src="<?=  base_url()?>assets/js/os/urgencias/graficas.js"></script>
<script src="<?=  base_url()?>assets/js/os/inicio/filtros.js"></script>
<script src="<?=  base_url()?>assets/js/os/triage/triage.js"></script>

