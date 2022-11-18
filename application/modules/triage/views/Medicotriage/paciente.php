<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="">
            <div class="box-inner col-md-12 col-centered" style="margin-top: 10px">
            <div class="panel panel-default " style="margin-top: 0px">
               
                <?php if($info['triage_paciente_sexo']=='MUJER'){?>
                <div  style="background: pink;width: 100%;height: 10px;border-radius: 3px 3px 0px 0px"></div>
                <?php }?>
                <div class="panel-heading p teal-900 back-imss text-center" style="height: 10px">
                    <span style="position: relative; top:-9px"><strong>PROCEDIMIENTO PARA LA CLASIFICACIÓN DE PACIENTES</strong></span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="card-body">
                        <!-- FORMULARIO PARA CLASIFICACION DE URGENCIA -->
                        <form class="agregar-paso2" id="Clasificacion">
                            <div class="row" style="margin-top: -40px">
                                <div class="col-md-8" style="padding-left: 0px">
                                    <h4>
                                        <b>PACIENTE:  <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?> </b>
                                    </h4>
                                    <h5>
                                        <?=$info['triage_paciente_sexo']?> <?=$PINFO['pic_indicio_embarazo']=='Si' ? '| POSIBLE EMBARAZO' : ''?>
                                    </h5>
                                    <h5 style="margin-top: -5px;text-transform: uppercase">
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
                                        ?> | <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEA: '.$PINFO['pia_procedencia_espontanea_lugar'] : ': '.$PINFO['pia_procedencia_hospital'].' '.$PINFO['pia_procedencia_hospital_num']?>
                                    </h5>
                                    <h6 style="font-size: 14px;text-align: left;color:red;">
                                        <b>MOTIVO DE ATENCIÓN: </b><span style="font-size: 14px"><?=$info['triage_motivoAtencion']?></span>  
                                    </h6>
                                </div>
                                <div class="col-md-4 text-right">
                                    <h5>
                                        <b>EDAD</b>
                                    </h5>
                                    <h2 style="margin-top: -10px">
                                        <?php 
                                        if($info['triage_fecha_nac']!=''){
                                            $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                                            echo $fecha->y.' <span style="font-size:25px"><b>Años</b></span>';
                                        }else{
                                            echo 'S/E';
                                        }
                                        ?>
                                        <?php
                                              $codigo_atencion = Modules::run('Config/ConvertirCodigoAtencion', $info['triage_codigo_atencion']);
                                              echo ($codigo_atencion != '')?"<br><span style='font-size:20px; color:red'><b>Código $codigo_atencion</b></span>":"";
                                          ?>
                                    </h2>
                                </div>
                                <div class="col-md-4 text-right" style="float:right; margin-top: -15px">
                                    <h6 style="font-size: 10px;text-align: right;">
                                        <b>
                                        FECHA Y HORA DE REGISTRO:                     
                                            <span style="font-size: 10px">
                                            <?=$info['triage_horacero_f']?> <?=$info['triage_horacero_h']?>
                                            </span>
                                        </b>
                                    </h6>
                                </div>
                            </div>
                            <div class="row " style="margin-top: -0px;">                            
                                <div class="col-md-2 text-center back-imss" style="padding-left: 0px;padding: 5px;">
                                    <h5 class=""><b>P.A</b></h5>
                                    <h4 style="margin-top: -8px;font-weight: bold" id="qsofa_p"> <?=$SignosVitales['sv_ta']?> (mmHg)</h4>
                                </div>
                                <div class="col-md-2  text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
                                    <h5><b>TEMP</b></h5>
                                    <h4 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_temp']?> °C</h4>
                                </div>
                                <div class="col-md-2  text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
                                    <h5><b>F.C</b></h5>
                                    <h4 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_fc']?> (lat/min)</h4>
                                </div>
                                <div class="col-md-2  text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
                                    <h5><b>F.R </b></h5>
                                    <h4 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_fr']?> (rpm)</h4>
                                </div>
                                <div class="col-md-2 text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
                                    <h5><b>SpO2</b></h5>
                                    <h4 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_oximetria']?> %</h4>
                                </div>
                                <div class="col-md-2 text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
                                    <h5><b>GLUCEMIA</b></h5>
                                    <h4 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_dextrostix']?> mg/dl</h4>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 0px">
                                <div class="col-md-12" style="padding: 0px">
                                    <table class="evaluar-medico-area-efectiva table table-striped table-bordered table-no-padding" >
                                        <caption class="mayus-bold text-center">
                                            Evalúa la necesidad de atención inmediata
                                        </caption>
                                        <thead class="back-imss" >
                                            <tr>
                                                <th style="width: auto" class="text-center mayus-bold">Parámetro</th>
                                                <th style="width: auto" class="text-center mayus-bold">Ausente</th>
                                                <th style="width: auto" class="text-center mayus-bold">Presente</th>
                                            </tr>      
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="mayus-bold">Pérdida súbita del estado de alerta</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="radio" checked="" name="triage_preg1_s1" value="0" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="radio" name="triage_preg1_s1" value="31" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Apnea</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="radio" name="triage_preg2_s1" checked="" value="0" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                        
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="radio" name="triage_preg2_s1" value="31" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                        
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Ausencia de pulso</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="radio" name="triage_preg3_s1" checked="" value="0" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="radio" name="triage_preg3_s1" value="31" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Intubación de vía respiratoria</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="radio" checked="" name="triage_preg4_s1" value="0" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="radio" name="triage_preg4_s1" value="31" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Angor o equivalente</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="radio" name="triage_preg5_s1" checked="" value="0" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="radio" name="triage_preg5_s1" value="31" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- <div class="col-md-12 col-omitir-clasificacion" style="padding: 0px"> -->
                                <div class="col-md-12" style="padding: 0px">
                                    <table class="evaluar-medico-area-efectiva table table-striped table-bordered table-no-padding" style="margin-bottom: -10px">
                                        <caption class="mayus-bold text-center">
                                            Evalúa el motivo de atención y algún otro dato relevante que se detecte en el paciente
                                        </caption>
                                        <thead class="back-imss">
                                            <tr>
                                                <th style="width: auto" class="mayus-bold">Parámetro</th>
                                                <th style="width: auto" colspan="4" class="mayus-bold">Puntuación</th>
                                                <th style="width: auto"  class="mayus-bold">Puntaje</th>
                                            </tr>      
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td ></td>
                                                <td colspan="">0</td>
                                                <td>5</td>
                                                <td>10</td>
                                                <td colspan="2">15</td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Traumatismo</td>
                                                <td >
                                                    <label class="md-check ">
                                                        <input type="radio" name="triage_preg1_s2" value="0" checked="" class="has-value">
                                                        <i class="green"></i>Ausente
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Menor: cuando es única y no pone en riesgo la vida ni la función de algún órgano o sistema;">
                                                        <input type="radio" name="triage_preg1_s2" value="5" class="has-value" >
                                                        <i class="green"></i>Menor
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Moderado: cuando siendo única o múltiple, pone en riesgo la función del órgano o sistema afectado en forma transitoria">
                                                        <input type="radio" name="triage_preg1_s2" value="10" class="has-value" >
                                                        <i class="green"></i>Moderado
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Mayor: cuando es múltiple, ha provocado fracturas expuestas y/o pone en riesgo la vida o función del órgano o sistema">
                                                        <input type="radio" name="triage_preg1_s2" value="15" class="has-value" >
                                                        <i class="green"></i>Mayor
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Herida(s)</td>
                                                <td>
                                                    <label class="md-check tip" >
                                                        <input type="radio" name="triage_preg2_s2" value="0" checked="" class="has-value" >
                                                        <i class="green"></i>Ausente
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Superficial: cuando sólo involucra piel y tejido celular subcutáneo;">
                                                        <input type="radio" name="triage_preg2_s2" value="5" class="has-value" >
                                                        <i class="green"></i>Superficial
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="No penetrante: cuando sobrepasa los planos anteriores, pero no involucra alguna cavidad;">
                                                        <input type="radio" name="triage_preg2_s2" value="10" class="has-value" >
                                                        <i class="green"></i>No Penetrante
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Extensa-profunda: cuando involucra la apertura de una o más de las cavidades corporales (cráneo, tórax o abdomen), o cuando por ser múltiples o de gran tamaño ponen en peligro inminente la vida o la función de órganos o sistemas.">
                                                        <input type="radio" name="triage_preg2_s2" value="15" class="has-value" >
                                                        <i class="green"></i>Extensa-profunda:
                                                    </label>

                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td  class="mayus-bold">Aumento del trabajo respiratorio</td>
                                                <td>
                                                    <label class="md-check">
                                                        <input type="radio" name="triage_preg3_s2" value="0" checked="" class="has-value">
                                                        <i class="green"></i>Ausente
                                                    </label>

                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Leve: cuando sólo se observa un incremento en la frecuencia respiratoria;">
                                                        <input type="radio" name="triage_preg3_s2" value="5" class="has-value">
                                                        <i class="green"></i>Leve
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Moderado: cuando se observa un incremento del trabajo de los músculos accesorios de la respiración,los intercostales;">
                                                        <input type="radio" name="triage_preg3_s2" value="10" class="has-value">
                                                        <i class="green"></i>Moderado
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Severo: cuando el incremento; además, de lo anterior, involucran los músculos abdominales y del cuello.">
                                                        <input type="radio" name="triage_preg3_s2" value="15" class="has-value">
                                                        <i class="green"></i>Severo
                                                    </label>

                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Cianosis</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" checked="" name="triage_preg4_s2" value="0" class="has-value">
                                                        <i class="green"></i>Ausente
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Leve: cuando está presente en labios y lechos ungueales;">
                                                        <input type="radio" name="triage_preg4_s2" value="5" class="has-value">
                                                        <i class="green"></i>Leve
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Moderada: cuando además de lo anterior está presente en las extremidades;">
                                                        <input type="radio" name="triage_preg4_s2" value="10" class="has-value">
                                                        <i class="green"></i>Moderado
                                                    </label>

                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Severa: cuando es generalizada.">
                                                        <input type="radio" name="triage_preg4_s2" value="15" class="has-value">
                                                        <i class="green"></i>Severo
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Palidez</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Severa: cuando es generalizada.">
                                                        <input type="radio" name="triage_preg5_s2" value="0" checked="" class="has-value">
                                                        <i class="green"></i>Ausente
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Leve: cuando está circunscrita a las regiones distales (lóbulos de las orejas, punta de los dedos, punta de la nariz, etc.);">
                                                        <input type="radio" name="triage_preg5_s2" value="5" class="has-value">
                                                        <i class="green"></i>Leve
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Moderada: cuando abarca palmas, labios, lengua, mucosa oral y palpebral;">
                                                        <input type="radio" name="triage_preg5_s2" value="10"  class="has-value">
                                                        <i class="green"></i>Moderado
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Severa: cuando es generalizada y la decoloración es intensa.">
                                                        <input type="radio" name="triage_preg5_s2" value="15"  class="has-value">
                                                        <i class="green"></i>Severo
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Hemorragia</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg6_s2" checked="" value="0"  class="has-value">
                                                        <i class="green"></i>Ausente
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Inactiva-leve: cuando no hay extravasación sanguínea al momento de la evaluación o el volumen perdido es aproximadamente menor al 15% y causa síntomas clínicos mínimos sobre la frecuencia cardiaca, la tensión arterial o el estado de alerta;">
                                                        <input type="radio" name="triage_preg6_s2" value="5"  class="has-value">
                                                        <i class="green"></i>Inactiva-Leve
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Moderada: cuando el volumen perdido es aproximadamente entre el 15 y el 30%, la frecuencia cardiaca es mayor de 100 latidos por minuto, pero menor a 140, puede haber ansiedad o confusión y la tensión arterial aun se mantiene dentro de la normalidad;">
                                                        <input type="radio" name="triage_preg6_s2" value="10"  class="has-value">
                                                        <i class="green"></i>Moderado
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Severa: cuando el volumen perdido es aproximadamente mayor al 30%, la frecuencia cardiaca supera los 140 latidos por minuto o es menor de 60; la tensión arterial ha descendido de la normalidad y neurológicamente puede existir confusión o letargo.">
                                                        <input type="radio" name="triage_preg6_s2" value="15"  class="has-value">
                                                        <i class="green"></i>Severa
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Dolor (Escala análoga visual 0-10)</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg7_s2" checked="" value="0"  class="has-value">
                                                        <i class="green"></i>0
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg7_s2" value="5"  class="has-value">
                                                        <i class="green"></i>1-4/10
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg7_s2" value="10"  class="has-value">
                                                        <i class="green"></i>5-8/10
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg7_s2" value="15"  class="has-value">
                                                        <i class="green"></i>9-10/10
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Intoxicación o auto-daño</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg8_s2" value="0" checked=""  class="has-value">
                                                        <i class="green"></i>Ausente
                                                    </label>
                                               </td>
                                                <td>

                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg8_s2" value="10"  class="has-value">
                                                        <i class="green"></i>Dudosa
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg8_s2" value="15" class="has-value">
                                                        <i class="green"></i>Evidente
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Convulsiones</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg9_s2" value="0" checked=""  class="has-value">
                                                        <i class="green"></i>Ausente
                                                    </label>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg9_s2" value="10"class="has-value">
                                                        <i class="green"></i>Estado Postictal
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg9_s2" value="15"class="has-value">
                                                        <i class="green"></i>Presente
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Escala de Glasgow Neurológico</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg10_s2" value="0" checked="" class="has-value">
                                                        <i class="green"></i>15
                                                    </label>

                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg10_s2" value="5" class="has-value">
                                                        <i class="green"></i>14-12
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg10_s2" value="10" class="has-value">
                                                        <i class="green"></i>11-8
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg10_s2" value="15" class="has-value">
                                                        <i class="green"></i>&lt;8
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Deshidratación</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" checked="" name="triage_preg11_s2" value="0" class="has-value">
                                                        <i class="green"></i>Ausente
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg11_s2" value="5" class="has-value">
                                                        <i class="green"></i>Leve
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg11_s2" value="10" class="has-value">
                                                        <i class="green"></i>Moderado
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg11_s2" value="15" class="has-value">
                                                        <i class="green"></i>Presente
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Psicosis, agitación o violencia</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" checked="" name="triage_preg12_s2" value="0" class="has-value">
                                                        <i class="green"></i>Ausente
                                                    </label>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="Está conformada por los signos vitales y cuando sea necesario la medición de glucemia capilar del paciente. En esta sección la escala de medición tiene los valores normales ubicados en la columna central y las desviaciones de la normalidad a izquierda o derecha de acuerdo a que sean menores de la normalidad o mayores a la misma; la primera desviación (menos grave) se le da un valor de 5 puntos y la segunda desviación (más grave) se le asignan 10 puntos.">
                                                        <input type="radio" name="triage_preg12_s2" value="15" class="has-value">
                                                        <i class="green"></i>Presente
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br><br>
                                    <table class="evaluar-medico-area-efectiva table table-striped table-bordered table-no-padding" >
                                        <thead class="back-imss">
                                            <tr>
                                                <th style="width: auto" class="mayus-bold">Parámetro</th>
                                                <th style="width: auto" colspan="5" class="mayus-bold">Puntuación</th>
                                                <th style="width: auto" class="mayus-bold">Puntaje</th>
                                            </tr>      
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td >10</td>
                                                <td >5</td>
                                                <td>0</td>
                                                <td>5</td>
                                                <td>10</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Frecuencia Cardiaca</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg1_s3" value="10" class="has-value">
                                                        <i class="green"></i>&lt;40
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg1_s3" value="5" class="has-value">
                                                        <i class="green"></i>40 -59 
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg1_s3" checked="" value="0" class="has-value">
                                                        <i class="green"></i>60 – 100
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg1_s3" value="5" class="has-value">
                                                        <i class="green"></i>101 – 140
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg1_s3" value="10" class="has-value">
                                                        <i class="green"></i>>140
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Temperatura °C</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg2_s3" value="10" class="has-value">
                                                        <i class="green"></i>&lt;34.5
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg2_s3" value="5" class="has-value">
                                                        <i class="green"></i>34.5 - 35.9 
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg2_s3" checked="" value="0" class="has-value">
                                                        <i class="green"></i>36 – 37
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg2_s3" value="5" class="has-value">
                                                        <i class="green"></i>37.1 – 39
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg2_s3" value="10" class="has-value">
                                                        <i class="green"></i>>39
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Frecuencia Respiratoria</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg3_s3" value="10" class="has-value">
                                                        <i class="green"></i>&lt;8
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg3_s3" value="5" class="has-value">
                                                        <i class="green"></i>8 - 12 
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg3_s3" checked="" value="0" class="has-value">
                                                        <i class="green"></i>13 – 18
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg3_s3" value="5" class="has-value">
                                                        <i class="green"></i>19 – 25
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg3_s3" value="10" class="has-value">
                                                        <i class="green"></i>>25
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Tensión Arterial</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg4_s3" value="10" class="has-value">
                                                        <i class="green"></i>&lt;70/50
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg4_s3" value="5" class="has-value">
                                                        <i class="green"></i>70/50 - 90/60 
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg4_s3" checked="" value="0" class="has-value">
                                                        <i class="green"></i>91/61 – 120/80
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg4_s3" value="5" class="has-value">
                                                        <i class="green"></i>121/81 - 160/110 
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg4_s3" value="10" class="has-value">
                                                        <i class="green"></i>>160/110
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Glucemia capilar</td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg5_s3" value="10" class="has-value">
                                                        <i class="green"></i>&lt;40
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio" name="triage_preg5_s3" value="5" class="has-value">
                                                        <i class="green"></i>40 -60 
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg5_s3" checked="" value="0" class="has-value">
                                                        <i class="green"></i>61 – 140
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg5_s3" value="5" class="has-value">
                                                        <i class="green"></i>141 – 400
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="md-check tip" data-original-title="">
                                                        <input type="radio"  name="triage_preg5_s3" value="10" class="has-value">
                                                        <i class="green"></i>>400
                                                    </label>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row qsofa" style="margin-top: 20px">
                               <table class="table table-striped table-bordered table-no-padding">
                                     <thead class="" style="background: #F7F7F7">
                                        <th style="width: auto" class="text-center mayus-bold">EVALUACIÓN DE QUICK SOFA SCORE</th>
                                        <th style="width: auto" class="text-center mayus-bold">PUNTUACIÓN</th>
                                        <th style="width: auto" class="text-center">PUNTUACIÓN TOTAL</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>ESTADO MENTAL ALTERADO O EMPEORADO (Es decir, GCS < 15)</td>
                                            <td class="text-center">
                                                <span class="badge badge-danger qsofa1">0</span>
                                            </td>
                                            <td rowspan="3" class="text-center"><div><h3 id="qsofaTotal">0</h3><h4 id="qsofaMsg"></h4></div></td>
                                        </tr>
                                        <tr>
                                            <td>FRECUENCIA RESPIRATORIA MAYOR O IGUAL A 22 r.p.m</td>
                                            <td class="text-center">
                                               <span class="badge badge-danger qsofa2">0</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PRESIÓN ARTERIAL SISTOLICA MENOR O IGUAL A 100 mmHG</td>
                                            <td class="text-center">
                                                <span class="badge badge-pill badge-success qsofa3">0</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                                
                            </div>
                            <div class="row" style="margin-top: 20px">
                                <div class="col-md-7" style="padding-left: 0px">
                                    <label class="mayus-bold">¿CONSIDERA ENVIAR PACIENTE A UMF / HGZ / OTRO?</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="md-check mayus-bold">
                                        <input type="radio" class="has-value"  name="envio_otraunidad" value="Si" required="">
                                        <i class="blue"></i>Si
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="md-check mayus-bold">
                                        <input type="radio" class="has-value"  name="envio_otraunidad" value="No" checked>
                                        <i class="blue"></i>No
                                    </label>
                                </div>
                            </div>
                            <div class="row div-envio hide" style="margin-top: 5px; border: 0px">   
                                <label class="mayus-bold" style="margin-top: 5px">ENVIAR A:</label>   
                                <select name="select_envio" class="select_envio" style="width: 235px;">
                                    <option value="">Seleccionar</option>
                                    <option value="UMF">UMF</option>
                                    <option value="HGZ">HGZ</option>
                                    <option value="Ginecología">GINECOLOGÍA</option>
                                    <option value="Tramautología y Ortopedia">TRAUMATOLOGÍA Y ORTOPEDIA</option>
                                    <option value="Otra unidad imss">OTRA UNIDAD MÉDICA IMSS</option>
                                    <option value="Otra unidad no imss">OTRA UNIDAD MÉDICA NO IMSS</option>
                                    <option value="Domicilio">DOMICILIO</option>
                                </select>
                                <label id="msgSelectEnvio" style="color: red"></label>
                            </div>
                            <?php if($this->UMAE_AREA=='Medico Triage Respiratorio') {?>
                            <div class="row hidden tratamiento" style="margin-top: 20px">
                               <table class="table">
                                     <thead class="" style="background: #F7F7F7">
                                        <th style="width: auto" class="text-left mayus-bold">TRATAMIENTO</th>
                                        <th>SELECCIONAR</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>OSELTAMIVIR 75 mg C/12 hrs POR 5 DIAS</td>
                                            <td>
                                                <label class="md-check">
                                                    <input type="checkbox" name="trat[]" id="trat_1" value="1"><i class="green"></i>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PARACETAMOL 500 mg C/8 hrs POR 5 DIAS</td>
                                            <td>
                                                <label class="md-check">
                                                    <input type="checkbox" name="trat[]" id="trat_2" value="2">
                                                    <i class="green"></i>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CLARITROMICINA 500 mg C/12 hrs POR 7 DIAS</td>
                                            <td>
                                                <label class="md-check">
                                                    <input type="checkbox" name="trat[]" id="trat_3" value="3">
                                                    <i class="green"></i>
                                                </label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                                
                            </div>
                        <?php }?>
                            <?php if($info['triage_via_registro']=='Choque'){?>
                                    <div class="row">
                                        <h3 style="text-align:center;color:red">
                                            <i class="fa fa-warning"></i>
                                            PACIENTE DE ATENCIÓN INMEDIATA
                                        </h3>
                                    </div>
                                    <div class="col-md-12" style="padding: 0px">
                                        <label class="mayus-bold"><b>COLOR CLASIFICACIÓN:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label id="msgColor" style="color: red"></label>
                                        <label class="md-check mayus-bold">
                                            <input type="radio" name="clasificacionColor" value="Rojo">
                                            <i class="blue"></i>Rojo
                                        </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label class="md-check mayus-bold">
                                            <input type="radio" name="clasificacionColor" value="Naranja">
                                            <i class="blue"></i>Naranja
                                        </label>
                                    </div>
                            <?php }else {?>
                                    
                                    
                                <?php if($this->ConfigExcepcionCMT=='Si'){ ?>
                                    <hr>
                                    <div class="row" style="margin-top: 20px">
                                        <div class="col-md-5" style="padding-left: 0px">
                                            <label class="mayus-bold">¿EVALUAR CLASIFICACIÓN A SU CRITERIO?</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="md-check mayus-bold">
                                                <input type="radio" name="inputOmitirClasificacion" value="Si">
                                                <i class="blue"></i>Si
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="md-check mayus-bold">
                                                <input type="radio" name="inputOmitirClasificacion" value="No" checked="">
                                                <i class="blue"></i>No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row row-clasificacion-omitida hide">
                                        <div class="col-md-12" style="padding: 0px">
                                            <div class="form-group">
                                                <label id="msgObs" style="color: red"></label>
                                                <textarea name="clasificacionObservacion" class="form-control obsOmitirClasificacion" rows="5" maxlength="590" placeholder="Agregar Observación u comentario por el cual esta reclasificando al paciente" id="comClasifica"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="padding: 0px">
                                            <label class="mayus-bold"><b>COLOR CLASIFICACIÓN:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label id="msgColor" style="color: red"></label>
                                            <label class="md-check mayus-bold">
                                                <input type="radio" name="clasificacionColor" value="Rojo">
                                                <i class="blue"></i>Rojo
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="md-check mayus-bold">
                                                <input type="radio" name="clasificacionColor" value="Naranja">
                                                <i class="blue"></i>Naranja
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="md-check mayus-bold">
                                                <input type="radio" name="clasificacionColor" value="Amarillo">
                                                <i class="blue"></i>Amarillo
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="md-check mayus-bold">
                                                <input type="radio" name="clasificacionColor" value="Azul">
                                                <i class="blue"></i>Azul
                                            </label>&nbsp;&nbsp;&nbsp;
                                            <label class="md-check mayus-bold">
                                                <input type="radio"name="clasificacionColor" value="Verde">
                                                <i class="blue"></i>Verde                                 
                                            </label>&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </div>
                                <?php }?>
                            <?php }?>
                            
                            <div class="row">        
                                <div class="col-md-offset-9 col-md-3">
                                    <input type="hidden" name="csrf_token">
                                    <input type="hidden" name="triage_id" value="<?=$this->uri->segment(3)?>">
                                    <input type="hidden" name="triage_consultorio">
                                    <input type="hidden" name="triage_consultorio_nombre">
                                    <input type="hidden" name="triage_solicitud_rx" value="No">
                                    <input type="hidden" name="triage_enviar_a" >
                                    <input type="hidden" name="ac_diagnostico" >
                                    <input type="hidden" name="viaRegistroPaciente" value="<?=$info['triage_via_registro']?>">
                                    <input type="hidden" name="qsofa_r" class="qsofa_r" value="<?=$SignosVitales['sv_fr']?>">
                                    <input type="hidden" name="qsofa_ta" class="qsofa_ta" value="<?=$SignosVitales['sv_ta']?>">
                                    <input type="hidden" name="qsofa">
                                    <br>
                                    <button class="btn pull-right back-imss btn-submit-paso2 btn-block" type="submit" style="margin-bottom: -10px">
                                        Guardar
                                    </button> 
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
<input type="hidden" name="ConfigDestinosMT" value="<?=$this->ConfigDestinosMT?>">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Medicotriage.js?').md5(microtime())?>" type="text/javascript"></script>
