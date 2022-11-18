<?= modules::run('Sections/Menu/index'); ?> 
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/libs/light-bootstrap/all.min.css" />
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-11 col-centered" style="margin-top: 10px ">
            <div class="box-inner ">
                <?php if($SignosVitales['sv_ta']==''){?>
                <div class="row " style="margin-top: -10px;padding: 16px;">
                    <div class="col-md-12 col-centered back-imss" style="padding:10px;margin-bottom: -7px;">
                        <h6 style="font-size: 20px;text-align: center">
                            <b>EN ESPERA DE CAPTURA DE SIGNOS VITALES</b>
                        </h6>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="row " style="margin-top: -30px;padding: 16px;">
                    <div class="col-md-12 col-centered " style="padding: 0px;margin-bottom: -7px;">
                        <h6 style="font-size: 8px;text-align: right">
                            FECHA Y HORA DE REGISTRO: 
                            <b>
                                <span style="font-size: 12px">
                                <?=$info['triage_horacero_f']?> <?=$info['triage_horacero_h']?>
                                </span>
                            </b>
                        </h6>
                    </div>
                    <div class="col-md-3 text-center back-imss" style="padding-left: 0px;padding: 20px;">
                        <h5 class=""><b>T.A </b></h5>
                        <h2 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_ta']?></h2>
                    </div>
                    <div class="col-md-3  text-center back-imss" style="border-left: 1px solid white;padding: 20px;">
                        <h5><b>TEMP</b></h5>
                        <h2 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_temp']?> °C</h2>
                    </div>
                    <div class="col-md-3  text-center back-imss" style="border-left: 1px solid white;padding: 20px;">
                        <h5><b>F.C </b> </h5>
                        <h2 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_fc']?> X MIN</h2>
                    </div>
                    <div class="col-md-3  text-center back-imss" style="border-left: 1px solid white;padding: 20px;">
                        <h5><b>F.R </b></h5>
                        <h2 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_fr']?> X MIN</h2>
                    </div>
                </div>
                <?php }?>
                <div class="panel panel-default " style="margin-top: -8px">
                    <?php if($_GET['tipo']=='Choque'){?>
                    <div class="hf_donador hide back-imss" style="height: 60px;width: 100%;text-align: left;margin-bottom: -35px;">
                        <span style="font-size: 30px;padding: 8px 5px 0px 14px;color: white"><b>POSIBLE DONADOR</b></span>
                    </div>
                    <?php }?>
                    
                    <div class="panel-heading p teal-900 back-imss" style="padding-bottom: 0px;">
                        <span style="font-size: 18px;font-weight: 500;text-transform: uppercase">  
                            <div class="row" style="margin-top: -20px;">
                                <div style="position: relative">
                                    <div style="top: 4px;margin-left: -1px;position: absolute;height: 105px;width: 35px;" class="<?= Modules::run('Config/ColorClasificacion',array('color'=>$info['triage_color']))?>"></div>
                                </div>
                                <div class="col-md-10" style="padding-left: 40px">
                                    <h3>
                                        
                                        <b>PACIENTE:  <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?> </b>
                                    </h3>
                                    <h4>
                                        <?=$info['triage_paciente_sexo']?> <?=$PINFO['pic_indicio_embarazo']=='Si' ? '| Posible Embarazo' : ''?>
                                    </h4>
                                    <h4 style="margin-top: -5px;text-transform: uppercase">
                                        <?php 
                                            if($info['triage_fecha_nac']!=''){
                                                $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                                                if($fecha->y<15){
                                                    echo 'PEDIATRICO';
                                                }if($fecha->y>15 && $fecha->y<60){
                                                    echo 'ADULTO';
                                                }if($fecha->y>60){
                                                    echo 'GERIATRICO';
                                                }
                                            }else{
                                                echo 'S/E';
                                            }
                                        ?> | <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEA: '.$PINFO['pia_procedencia_espontanea_lugar'] : ': '.$PINFO['pia_procedencia_hospital'].' '.$PINFO['pia_procedencia_hospital_num']?> | <?=$info['triage_color']?>
                                    </h4>
                                </div>
                                <div class="col-md-2 text-right">
                                    <h3>
                                        <b>EDAD</b>
                                    </h3>
                                    <h1 style="margin-top: -10px">
                                        <?php 
                                        if($info['triage_fecha_nac']!=''){
                                            $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                                            echo $fecha->y.' <span style="font-size:25px"><b>Años</b></span>';
                                        }else{
                                            echo 'S/E';
                                        }
                                        ?>
                                    </h1>
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="panel-body b-b b-light">
                        <div class="card-body" style="padding: 20px 0px;">     
                            <form class="guardar-solicitud-hf" style="margin-top: 0px">
                                <div class="row" >
                                    <div class="col-md-12 hide">
                                        <div class="input-group m-b">
                                            <span class="input-group-addon">FORMATO DE HOJA FRONTAL</span>
                                            <select class="form-control" name="hf_documento">
                                                <option value="HOJA FRONTAL 4 30 128" selected="">HOJA FRONTAL 4 30 128</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" >
                                        <div class="form-group">
                                            <label><b>INTOXICACIÓN</b></label><br>
                                            <div class="row">
                                                <div class="col-md-2" style="padding-right: 0px">
                                                    <label class="md-check">
                                                        <input type="radio" name="hf_intoxitacion" data-value="<?=$hojafrontal[0]['hf_intoxitacion']?>" value="Si" class="has-value">
                                                        <i class="indigo"></i>Si
                                                    </label>&nbsp;&nbsp;&nbsp;
                                                    <label class="md-check">
                                                        <input type="radio" name="hf_intoxitacion" checked="" value="No" class="has-value">
                                                        <i class="indigo"></i>No
                                                    </label>        
                                                </div>
                                                <div class="col-md-10 hf_intoxitacion hide" style="padding-left: 0px">
                                                    <input type="text" name="hf_intoxitacion_descrip" value="<?=$hojafrontal[0]['hf_intoxitacion_descrip']?>" class="form-control" placeholder="Especifique" style="margin-top: -10px">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label><b>URGENCIA</b></label><br>
                                                    <label class="md-check">
                                                        <input type="radio" name="hf_urgencia"id="hf_urgencia_si" data-value="<?=$hojafrontal[0]['hf_urgencia']?>"  value="Urgencia Real" class="has-value">
                                                        <i class="green"></i>Urgencia Real
                                                    </label>&nbsp;&nbsp;&nbsp;
                                                    <label class="md-check">
                                                        <input type="radio" name="hf_urgencia" id="hf_urgencia_no" data-value="<?=$hojafrontal[0]['hf_urgencia']?>" value="Urgencia Sentida" class="has-value">
                                                        <i class="green"></i>Urgencia Sentida
                                                    </label>        
                                                </div>
                                                <div class="col-md-3">
                                                    <label><b>ATENCIÓN</b></label><br>
                                                    <label class="md-check">
                                                        <input type="radio" name="hf_atencion" data-value="<?=$hojafrontal[0]['hf_atencion']?>"  value="1° VEZ" class="has-value">
                                                        <i class="green"></i>1° VEZ
                                                    </label>&nbsp;&nbsp;&nbsp;
                                                    <label class="md-check">
                                                        <input type="radio" name="hf_atencion"  data-value="<?=$hojafrontal[0]['hf_atencion']?>" value="SUBS" class="has-value">
                                                        <i class="green"></i>SUBS
                                                    </label>            
                                                </div>
                                                <div class="col-md-5">
                                                    <label><b>ESPECIALIADAD</b></label>
                                                    <select name="hf_especialidad" class="form-control" data-value="<?=Modules::run('Consultorios/ObtenerEspecialidad',array('Consultorio'=>$ce[0]['ce_asignado_consultorio']))?>" style="margin-top: -6px">
                                                    <?php foreach ($Especialidades as $value) {?>
                                                        <option value="<?=$value['especialidad_nombre']?>"><?=$value['especialidad_nombre']?></option>
                                                    <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                                   
                                        </div>
                                        <div class="form-group">
                                            <label><b>MOTIVO DE URGENCIA</b> <i class="fa fa-plus-circle pointer icono-accion" onclick="AbrirDocumento(base_url+'Sections/Plantillas/SeleccionarContenido?plantilla=Notivo de Urgencia&input=hf_motivo&type=textarea')"></i></label>
                                            <textarea class="form-control" rows="3" name="hf_motivo"><?=$hojafrontal[0]['hf_motivo']?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><b>MECANISMO DE LESIÓN</b></label>
                                                    <select class="select2 width100" id="hf_mecanismolesion" name="hf_mecanismolesion[]" data-value="<?=$hojafrontal[0]['hf_mecanismolesion']?>" multiple="">
                                                        <option value="Arma blanca">Arma blanca</option>
                                                        <option value="Traumatismo directo">Traumatismo directo</option>
                                                        <option value="ACC. Vial">ACC. Vial</option>
                                                        <option value="Maquinaria">Maquinaria</option>
                                                        <option value="Mordedura">Mordedura</option>
                                                        <option value="Caida">Caida</option>
                                                        <option value="Otros">Otros</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mecanismo-lesion-caida hide">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="hf_mecanismolesion_mtrs" value="<?=$hojafrontal[0]['hf_mecanismolesion_mtrs']?>" placeholder="Mtrs de la Caida">
                                                </div>
                                            </div>  
                                            <div class="col-md-6 mecanismo-lesion-otros hide" >
                                                <div class="form-group">
                                                    <input name="hf_mecanismolesion_otros" class="form-control" value="<?=$hojafrontal[0]['hf_mecanismolesion_otros']?>" placeholder="Otros">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label><b>QUEMADURA</b></label>
                                                <select class="select2 width100" id="hf_quemadura" multiple="" name="hf_quemadura[]" data-value="<?=$hojafrontal[0]['hf_quemadura']?>">
                                                    <option value="Fuego Directo">Fuego Directo</option>
                                                    <option value="Corriente Electrica">Corriente Electrica</option>
                                                    <option value="Escaldadura">Escaldadura</option>
                                                    <option value="Quimica">Quimica</option>
                                                    <option value="Otros">Otros</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 quemadura-otros hide">
                                                <div class="form-group">
                                                    <input name="hf_quemadura_otros" value="<?=$hojafrontal[0]['hf_quemadura_otros']?>" class="form-control" style="margin-top: 23px" placeholder="Otros">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><b>ANTECEDENTES</b> <i class="fa fa-plus-circle pointer icono-accion" onclick="AbrirDocumento(base_url+'Sections/Plantillas/SeleccionarContenido?plantilla=Antecedentes&input=hf_antecedentes&type=textarea')"></i></label>
                                            <textarea class="form-control hf_antecedentes" rows="4" name="hf_antecedentes"><?=$hojafrontal[0]['hf_antecedentes']?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label><b>EXPLORACIÓN FÍSICA</b>
                                                <i class="fa fa-plus-circle pointer icono-accion" onclick="AbrirDocumento(base_url+'Sections/Plantillas/SeleccionarContenido?plantilla=Exploración Física&input=hf_exploracionfisica&type=textarea')"></i>
                                            </label>
                                            <textarea class="form-control hf_exploracionfisica" id="hf_exploracionfisica" rows="4" name="hf_exploracionfisica"><?=$hojafrontal[0]['hf_exploracionfisica']?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label><b>INTERPRETACIÓN</b>
                                            <i class="fa fa-plus-circle pointer icono-accion"  onclick="AbrirDocumento(base_url+'Sections/Plantillas/SeleccionarContenido?plantilla=Interpretación&input=hf_interpretacion&type=textarea')"></i>
                                            </label>
                                            <textarea class="form-control hf_interpretacion" rows="4" name="hf_interpretacion"><?=$hojafrontal[0]['hf_interpretacion']?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="mayus-bold">DIAGNOTICOS <i class="fa fa-question-circle pointer icono-accion tip" data-original-title="PARA AGREGAR UN DIAGNOSTICO CIE10 ESCRIBA EN EL CAMPO DE ABAJO Y SELECCIONE UNO DE LA LISTA DE SUGERENCIAS HACIENDO CLICK EN EL"></i> </label><br>
                                                    <div class="input-group m-b">
                                                        <span class="input-group-addon back-imss border-back-imss">
                                                            <i class="fa fa-user-md"></i>
                                                        </span>
                                                        <input type="text" class="form-control" name="cie10_nombre" placeholder="Buscar diagnóstico CIE10" >
                                                        <span class="input-group-addon back-imss border-back-imss add-cie10">
                                                            <i class="fa fa-plus-circle pointer"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row row-diagnosticos"></div>
                                        </div>
                                        <div class="form-group">
                                            <label><b>DIAGNOSTICOS</b> 
                                            <i class="fa fa-plus-circle pointer plantilla-add icono-accion" onclick="AbrirDocumento(base_url+'Sections/Plantillas/SeleccionarContenido?plantilla=Diagnosticos&input=hf_diagnosticos&type=textarea')"  ></i>
                                            </label>
                                            <textarea class="form-control hf_diagnosticos" rows="3" name="hf_diagnosticos"><?=$hojafrontal[0]['hf_diagnosticos']?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label><b>DIAGNOSTICO BREVE</b></label>
                                            <textarea class="form-control" rows="3" name="hf_diagnosticos_lechaga"><?=$hojafrontal[0]['hf_diagnosticos_lechaga']?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label><b>TRATAMIENTO</b></label>
                                            <div class="row">
                                                <div class="col-md-6" style="padding-right: 0px">
                                                    <select class="select2 width100" name="hf_trataminentos[]" multiple="" id="hf_trataminentos" data-value="<?=$hojafrontal[0]['hf_trataminentos']?>">
                                                        <option value="Curación">Curación</option>
                                                        <option value="Sutura">Sutura</option>
                                                        <option value="Vendaje">Vendaje</option>
                                                        <option value="Ferula">Ferula</option>
                                                        <option value="Vacunas">Vacunas</option>
                                                        <option value="Otros">Otros</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 hf_trataminentos_otros hide" >
                                                    <input type="text" name="hf_trataminentos_otros" placeholder="Otros" value="<?=$hojafrontal[0]['hf_trataminentos_otros']?>" class="form-control">
                                                </div>
                                                <div class="col-md-3 hf_trataminentos_por">
                                                    <input type="number" name="hf_trataminentos_por" value="<?=$hojafrontal[0]['hf_trataminentos_por']?>" placeholder="N° de Dias" class="form-control">
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label><b>RECETA POR</b>
                                            <i class="fa fa-plus-circle pointer" onclick="AbrirDocumento(base_url+'Sections/Plantillas/SeleccionarContenido?plantilla=Receta&input=hf_receta_por&type=textarea')"></i>
                                            </label>
                                            <textarea class="form-control" rows="6" name="hf_receta_por"><?=$hojafrontal[0]['hf_receta_por']?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label><b>INDICACIONES</b>
                                            <i class="fa fa-plus-circle pointer" onclick="AbrirDocumento(base_url+'Sections/Plantillas/SeleccionarContenido?plantilla=Indicaciones&input=hf_indicaciones&type=textarea')"></i>
                                            </label>
                                            <textarea class="form-control hf_indicaciones" rows="6" name="hf_indicaciones"><?=$hojafrontal[0]['hf_indicaciones']?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>NOTIFICACIÓN AL MINISTERIO PUBLICO</b></label><br>
                                            <label class="md-check">
                                                <input type="radio" name="hf_ministeriopublico" data-value="<?=$hojafrontal[0]['hf_ministeriopublico']?>" value="Si" class="has-value">
                                                <i class="red"></i>Si
                                            </label>&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                                <input type="radio" name="hf_ministeriopublico" checked="" data-value="<?=$hojafrontal[0]['hf_ministeriopublico']?>" value="No" class="has-value">
                                                <i class="red"></i>No
                                            </label>  
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php if( $_GET['tipo']=='Consultorios'){?>
                                        <div class="form-group">
                                            <?php if($ce[0]['ce_status']=='Salida'){?>
                                            <label><b>ALTA A :</b> </label> <?=$ce[0]['ce_hf']?>
                                            <?php }else{?>
                                            <label><b>ALTA A : </b></label>
                                            <select name="hf_alta" data-value="<?=$hojafrontal[0]['hf_alta']?>" class="form-control">
                                                <option value="Domicilio">Alta a Domicilio</option>
                                                <option value="Se interna al servicio de Observación">Se interna al servicio de Observación</option>
                                                <option value="Otros">Otros</option>
                                            </select>
                                            <?php }?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="col-md-2 hf_alta_otros hide">
                                        <div class="form-group">
                                            <label class="text-color-white">.</label>
                                            <input type="text" name="hf_alta_otros" placeholder="Otros" value="<?=$hojafrontal[0]['hf_alta_otros']?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        
                                        
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label><b>AMERITA INCAPACIDAD</b></label><br>
                                                    <label class="md-check">
                                                        <input type="radio" name="asistentesmedicas_incapacidad_am" data-value="<?=$am[0]['asistentesmedicas_incapacidad_am']?>" required="" value="Si" class="has-value  hojafrontal-info">
                                                        <i class="blue"></i>Si
                                                    </label>&nbsp;&nbsp;
                                                    <label class="md-check">
                                                        <input type="radio" name="asistentesmedicas_incapacidad_am" data-value="<?=$am[0]['asistentesmedicas_incapacidad_am']?>" required="" checked="" value="No" class="has-value  hojafrontal-info">
                                                        <i class="blue"></i>No
                                                    </label>&nbsp;&nbsp;

                                                </div>
                                                <div class="col-md-3">
                                                    <label><b>GENERAR INCAPACIDAD</b></label><br>
                                                    <label class="md-check">
                                                        <input type="radio" name="asistentesmedicas_incapacidad_ga" disabled="" data-value="<?=$am[0]['asistentesmedicas_incapacidad_ga']?>" required="" value="Si" class="has-value  hojafrontal-info">
                                                        <i class="blue"></i>Si
                                                    </label>&nbsp;&nbsp;
                                                    <label class="md-check">
                                                        <input type="radio" name="asistentesmedicas_incapacidad_ga" disabled="" data-value="<?=$am[0]['asistentesmedicas_incapacidad_ga']?>" required="" checked="" value="No" class="has-value  hojafrontal-info">
                                                        <i class="blue"></i>No
                                                    </label>&nbsp;&nbsp;

                                                </div>
                                                <div class="col-md-3">
                                                    <select name="asistentesmedicas_incapacidad_tipo" disabled="" data-value="<?=$am[0]['asistentesmedicas_incapacidad_tipo']?>" class="form-control" style="margin-top: 15px">
                                                        <option value="">Tipo de Incapacidad</option>
                                                        <option value="Inicial">Inicial</option>
                                                        <option value="Subsecuente">Subsecuente</option>
                                                        <option value="Recaida">Recaida</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 " >
                                                    <input type="hidden" name="asistentesmedicas_incapacidad_dias_a" value="<?=$am[0]['asistentesmedicas_incapacidad_dias_a']?>" class="form-control  hojafrontal-info" placeholder="Dias acomulados" style="margin-top: 15px">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 10px">
                                                <div class="col-md-3" >
                                                    <input type="text" name="asistentesmedicas_incapacidad_folio" value="<?=$am[0]['asistentesmedicas_incapacidad_folio']?>" readonly="" class="form-control  hojafrontal-info" placeholder="Folio">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="asistentesmedicas_incapacidad_fi"  value="<?=$am[0]['asistentesmedicas_incapacidad_fi']?>" readonly=""   class="form-control d-m-y  hojafrontal-info" placeholder="Fecha de Inicio de Incapacidad">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" name="asistentesmedicas_incapacidad_da" value="<?=$am[0]['asistentesmedicas_incapacidad_da']?>" readonly="" class="form-control  hojafrontal-info" placeholder="Dias Autorizados" >
                                                </div>
                                                <div class="col-md-3" style="">
                                                    <div style="margin-top: 7px">
                                                        <label class="md-check">
                                                            <input type="radio" name="hf_incapacidad_ptr_eg" data-value="<?=$hojafrontal[0]['hf_incapacidad_ptr_eg']?>" value="PTR" class="has-value">
                                                            <i class="indigo"></i>PTR
                                                        </label>&nbsp;&nbsp;
                                                        <label class="md-check">
                                                            <input type="radio" name="hf_incapacidad_ptr_eg" data-value="<?=$hojafrontal[0]['hf_incapacidad_ptr_eg']?>" value="EG" class="has-value">
                                                            <i class="indigo"></i>EG
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 10px"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <label><b>MÉDICO TRATANTE</b></label>
                                                    <input type="text" name="asistentesmedicas_mt" value="<?=$INFO_USER[0]['empleado_nombre'].' '.$INFO_USER[0]['empleado_apellidos']?>" readonly="" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label><b>MATRICULA</b></label>
                                                    <input type="text" name="asistentesmedicas_mt_m" value="<?=$INFO_USER[0]['empleado_matricula']?>" readonly="" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="pia_lugar_accidente" value="<?=$PINFO['pia_lugar_accidente']?>">
                                    <div class="row col-hojafrontal-info hide" style="padding: 6px;">
                                        <div class="col-md-12 back-imss text-center">
                                            <h6>
                                                <b>DATOS DE TRABAJO REQUISITADOS POR LA ASISTENTE MÉDICA</b>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-12 hide col-hojafrontal-info">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><b>EMPRESA</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_nombre']?>" readonly="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label><b>REGISTRO PATRONAL</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_rp']?>" readonly="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><b>MODALIDAD</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_modalidad']?>" readonly="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label><b>FECHA DE ÚLTIMO MOVIMIENTO</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_fum']?>" readonly="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><b>TELÉFONO (LADA)</b></label>
                                                    <input type="text" value="<?=$DirEmpresa['directorio_telefono']?>" readonly="" class="form-control"> 
                                                </div>
                                                <div class="form-group">
                                                    <label><b>COLONIA</b></label>
                                                    <input type="text" value="<?=$DirEmpresa['directorio_colonia']?>" readonly="" class="form-control"> 
                                                </div>
                                                <div class="form-group">
                                                    <label><b>HORA ENTRADA</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_he']?>" readonly="" class="form-control"> 
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><b>CÓDIGO POSTAL</b></label>
                                                    <input type="text" value="<?=$DirEmpresa['directorio_cp']?>" readonly="" class="form-control"> 
                                                </div>
                                                <div class="form-group">
                                                    <label><b>MUNICIPIO</b></label>
                                                    <input type="text" value="<?=$DirEmpresa['directorio_municipio']?>" readonly="" class="form-control"> 
                                                </div>
                                                <div class="form-group">
                                                    <label><b>HORA SALIDA</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_he']?>" readonly="" class="form-control"> 
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><b>CALLE Y NÚMERO</b></label>
                                                    <input type="text" value="<?=$DirEmpresa['directorio_cn']?>" readonly="" class="form-control"> 
                                                </div>
                                                <div class="form-group">
                                                    <label><b>ESTADO</b></label>
                                                    <input type="text" value="<?=$DirEmpresa['directorio_estado']?>" readonly="" class="form-control"> 
                                                </div>
                                                <div class="form-group">
                                                    <label><b>DÍA DE DESCANCO P. AL ACCIDENTE</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_he']?>" readonly="" class="form-control"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-hojafrontal-info hide" style="padding: 6px;">
                                        <div class="col-md-12 back-imss text-center">
                                            <h6>
                                                <b>DATOS DE LA ST7</b>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-12 hide col-hojafrontal-info">
                                        <div class="form-group">
                                            <label><b>OMITIR DATOS DE ST7</b></label><br>
                                            <label class="md-check">
                                                <input type="radio" name="asistentesmedicas_omitir" data-value="<?=$am[0]['asistentesmedicas_omitir']?>" value="Si" class="has-value  hojafrontal-info">
                                                <i class="amber"></i>Si
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                                <input type="radio" name="asistentesmedicas_omitir" data-value="<?=$am[0]['asistentesmedicas_omitir']?>" checked="" value="No" class="has-value  hojafrontal-info">
                                                <i class="amber"></i>No
                                            </label>
                                        </div>
                                        <div class="form-group asistentesmedicas_omitir">
                                            <label><b>SEÑALAR CLARAMENTE COMO OCURRIO EL ACCIDENTE</b></label>
                                            <textarea name="asistentesmedicas_da" required="" maxlength="500" class="form-control hojafrontal-info" rows="3"><?=$am[0]['asistentesmedicas_da']?></textarea>
                                        </div>
                                        <div class="form-group asistentesmedicas_omitir">
                                            <label><b>DESCRIPCIÓN DE LA(S) LESIÓN(ES) Y TEMPO DE EVOLUCIÓN</b></label>
                                            <textarea name="asistentesmedicas_dl" required="" maxlength="500" class="form-control  hojafrontal-info" rows="3"><?=$am[0]['asistentesmedicas_dl']?></textarea>
                                        </div>
                                        <div class="form-group asistentesmedicas_omitir">
                                            <label><b>IMPRESIÓN DIAGNOSTICA</b></label>
                                            <textarea name="asistentesmedicas_ip" required="" maxlength="400" class="form-control  hojafrontal-info" rows="3"><?=$am[0]['asistentesmedicas_ip']?></textarea>
                                        </div>
                                        <div class="form-group asistentesmedicas_omitir">
                                            <label><b>TRATAMIENTOS</b></label>
                                            <textarea name="asistentesmedicas_tratamientos" required="" maxlength="400" class="form-control  hojafrontal-info" rows="3"><?=$am[0]['asistentesmedicas_tratamientos']?></textarea>
                                        </div>
                                        <div class="form-group asistentesmedicas_omitir">
                                            
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label><b>SIGNOS Y SINTOMAS</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Intoxicación Alcoholica</label>&nbsp;&nbsp;&nbsp;
                                                            <label class="md-check">
                                                                <input type="radio" name="asistentesmedicas_ss_in" data-value="<?=$am[0]['asistentesmedicas_ss_in']?>" required="" value="Si" class="has-value  hojafrontal-info">
                                                                <i class="amber"></i>Si
                                                            </label>
                                                            <label class="md-check">
                                                                <input type="radio" name="asistentesmedicas_ss_in" checked="" data-value="<?=$am[0]['asistentesmedicas_ss_in']?>" required="" value="No" class="has-value  hojafrontal-info">
                                                                <i class="amber"></i>No
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Intoxicación por Enervantes</label>&nbsp;&nbsp;&nbsp;
                                                            <label class="md-check">
                                                                <input type="radio" name="asistentesmedicas_ss_ie" data-value="<?=$am[0]['asistentesmedicas_ss_ie']?>" required="" value="Si" class="has-value  hojafrontal-info">
                                                                <i class="pink"></i>Si
                                                            </label>
                                                            <label class="md-check">
                                                                <input type="radio" name="asistentesmedicas_ss_ie" checked="" data-value="<?=$am[0]['asistentesmedicas_ss_ie']?>" required="" value="No" class="has-value  hojafrontal-info">
                                                                <i class="pink"></i>No
                                                            </label>
                                                        </div>        
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label><b>OTRAS CONDICIONES</b></label><br>
                                                    <label>Hubo riña</label>&nbsp;&nbsp;&nbsp;
                                                    <label class="md-check">
                                                        <input type="radio" name="asistentesmedicas_oc_hr" data-value="<?=$am[0]['asistentesmedicas_oc_hr']?>" value="Si" required="" class="has-value  hojafrontal-info">
                                                        <i class="orange"></i>Si
                                                    </label>
                                                    <label class="md-check">
                                                        <input type="radio" name="asistentesmedicas_oc_hr" checked="" data-value="<?=$am[0]['asistentesmedicas_oc_hr']?>" value="No" required="" class="has-value  hojafrontal-info">
                                                        <i class="orange"></i>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                         
                                        <div class="form-group asistentesmedicas_omitir">
                                            <label><b>ATENCIÓN MÉDICA PREVIA EXTRAINSTITUCIONAL</b></label>
                                            <textarea name="asistentesmedicas_am" maxlength="200" class="form-control hojafrontal-info" required="" rows="2"><?=$am[0]['asistentesmedicas_am']?></textarea>
                                        </div>
                                    </div>
                                    <?php if($_GET['tipo']=='Choque'){?>
                                    <hr style="margin-top: 30px;">
                                    <div class="col-md-4" style="margin-top: 10px">
                                        <div class="form-group">
                                            <label><b>POSIBLE DONADOR</b></label>&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                                <input type="radio" name="po_donador"  data-value="<?=$po[0]['po_donador']?>" value="Si" class="has-value">
                                                <i class="indigo"></i>Si
                                            </label>&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                                <input type="radio" name="po_donador" checked="" value="No" class="has-value">
                                                <i class="indigo"></i>No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-8" style="margin-top: 10px">
                                        <div class="form-group po_donador hide" style="margin-top: -10px">
                                            <select class="form-control" name="po_criterio" data-value="<?=$po[0]['po_criterio']?>">
                                                <option value="">Seleccionar</option>
                                                <option value="Lesión encefalica severa">Lesión encefalica severa</option>
                                                <option value="Glasgow">Glasgow</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <?php }?>
                                    <div class="col-md-offset-6 col-md-3">
                                        <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.top.close()">Cancelar</button>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="hidden" name="csrf_token" >
                                        <input type="hidden" name="triage_id" value="<?=$_GET['folio']?>">
                                        <input type="hidden" name="hf_id" value="<?=$_GET['hf']?>">
                                        <input type="hidden" name="accion" value="<?=$_GET['a']?>">
                                        <input type="hidden" name="tipo" value="<?=$_GET['tipo']?>">
                                        <input type="hidden" name="ce_status" value="<?=$ce[0]['ce_status']?>">
                                        <button class="btn back-imss btn-block" type="submit">Guardar</button>                     
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script type="text/javascript" src="<?= base_url()?>assets/libs/light-bootstrap/shieldui-all.min.js"></script>
<script src="<?= base_url('assets/js/sections/CIE10.js?md5='). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Documentos.js?md5='). md5(microtime())?>" type="text/javascript"></script>