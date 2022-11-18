<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">GESTIÓN DE CAMAS</span>
                    <?php if($_GET['tipo']=='Ocupados'){?>
                    <a onclick="AbrirDocumento(base_url+'Inicio/Documentos/CamasOcupadas?area=<?=$_GET['area']?>&tipo=<?=$_GET['tipo']?>')" href="#"  md-ink-ripple="" class="md-btn md-fab m-b green waves-effect pull-right tip " data-original-title="Indicadores">
                        <i class="fa fa-file-pdf-o i-24"></i>
                    </a>
                    <?php }?>
                </div>
                <style>
                    .color-amarillo{ background-color: #FFC107;color: white;}
                    .color-naranja{background-color: #ff9800;color: white;}
                </style>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered  footable table-usuarios"  data-filter="#Filtro_Camas" data-page-size="40" data-limit-navigation="7">
                                <thead>
                                    <tr>
                                        <th>ÁREA</th>
                                        <th>CAMA</th>
                                        <th style="width: 20%;">PACIENTE</th>
                                        <th>INGRESO</th>
                                        <th>TIEMPO EN CAMA</th>
                                        <th>ACCIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {?>
                                    <?php 
                                    if($_GET['tipo']=='Ocupados'){
                                        $Tiempo=Modules::run('Config/CalcularTiempoTranscurrido',array(
                                                'Tiempo1'=> date('d-m-Y').' '. date('H:i'),
                                                'Tiempo2'=> str_replace('/', '-', $value['cama_ingreso_f'].' '.$value['cama_ingreso_h']),
                                                
                                        ));
                                        if($Tiempo->d==0 && $Tiempo->h>=12 && $Tiempo->h<18 ){
                                            $class="color-amarillo";
                                        }else if($Tiempo->d==0 && $Tiempo->h>=18 ){
                                            $class="color-naranja";
                                        }else if($Tiempo->d>0 ){
                                            $class="red";
                                        }else{
                                            $class='';
                                        }
                                    }else{
                                        $class='';
                                    }
                                    ?>
                                    <tr class="<?=$class?>">
                                        <td><?=$value['area_nombre']?></td>
                                        <td ><?=$value['cama_nombre']?></td>
                                        
                                        <td style="font-size: 10px">
                                            <?php if($_GET['tipo']=='Ocupados'){?>
                                            <?php 
                                            $sqlPaciente=$this->config_mdl->_get_data_condition('os_triage',array(
                                                'triage_id'=>$value['cama_dh']
                                            ))[0];
                                            ?>
                                            <?=$sqlPaciente['triage_nombre']?> <?=$sqlPaciente['triage_nombre_ap']?> <?=$sqlPaciente['triage_nombre_am']?>
                                            <?php }else{?>
                                            No Aplica
                                            <?php }?>
                                        </td>
                                        <td>
                                            <?php if($_GET['tipo']=='Ocupados'){?>
                                            <?=$value['cama_ingreso_f']?> <?=$value['cama_ingreso_h']?>
                                            <?php }else{?>
                                            No Aplica
                                            <?php }?>
                                        </td>
                                        <td>
                                            <?php if($_GET['tipo']=='Ocupados'){?>
                                            <?= $Tiempo->d.' Dias '.$Tiempo->h.' Horas '.$Tiempo->i.' Minutos';?>
                                            <?php }else{?>
                                            No Aplica
                                            <?php }?>
                                        </td>
                                        <td>
                                            <?php if($_GET['tipo']=='Ocupados'){?>
                                            <a href="<?= base_url()?>Sections/Documentos/Expediente/<?=$value['cama_dh']?>/?tipo=Consultorios&url=Enfemeria" target="_blank">
                                                <i class="fa fa-share-square-o  tip" data-original-title="Expediente"></i>
                                            </a>&nbsp;
                                            <a href="<?= base_url()?>Sections/Pacientes/Paciente/<?=$value['cama_dh']?>" target="_blank">
                                                <i class="fa fa-user  tip" data-original-title="Historial del Paciente"></i>
                                            </a>
                                            <?php }?>
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