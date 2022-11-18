<?= modules::run('Sections/Menu/index'); ?> 
<style>
    .td_resp {
        text-align: center;
        vertical-align: middle;
        font-size: 14px;
        color: white;
        font-weight: bold;
    }
    .td_sintoma {
        color: white;
        background: #0e71aa; 
    }
</style>
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
                        <div class="row" style="margin-top: -40px">
                            <div class="col-md-8" style="padding-left: 0px">
                                <h4>
                                    <b>PACIENTE:  <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?> </b>
                                </h4>
                                <h5>
                                    <b>NÚMERO DE AFILIACION:</b> <?=$PINFO['pum_nss']?> <?=$PINFO['pum_nss_agregado']?>
                                </h5>
                                <h5 style="margin-top: -5px;text-transform: uppercase">
                                    <?=$info['triage_paciente_sexo']?> <?=$PINFO['pic_indicio_embarazo']=='Si' ? '| POSIBLE EMBARAZO' : ''?>
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
                        <!-- FORMULARIO PARA CLASIFICACION DE URGENCIA -->
                        <form class="agregar-paso2" id="Clasificacion">
                            <div class="row" style="margin-top: 0px">
                                <div class="col-md-12" style="padding: 0px">
                                    <table class="table table-bordered table-no-padding">
                                        <caption class="mayus-bold text-center">
                                            Evalúa la necesidad de atención inmediata
                                        </caption>
                                        <thead class="back-imss" >
                                            <tr>
                                                <th style="width: auto" class="text-center mayus-bold">Sintomas</th>
                                                <th style="width: auto" class="text-center mayus-bold">Covid-19</th>
                                                <th style="width: auto" class="text-center mayus-bold">Influenza</th>
                                                <th style="width: auto"c>Indique</th>

                                                
                                            </tr>      
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3" bgcolor="#ffffcc" class="mayus-bold">CRITERIOS MAYORES</td>
                                            </tr>
                                            <tr>
                                                <td  class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/fiebre.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Fiebre</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">+</td>
                                                <td bgcolor="#c82100" class="td_resp">+++</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="fiebre" value="2" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                              
                                            </tr>
                                            <tr>
                                                <td  bgcolor="#0e71aa" class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/tos.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Tos</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">Seca e Irritativa</td>
                                                <td bgcolor="#c82100" class="td_resp">Productiva</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="tos" value="2" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                        
                                                    </center>
                                                </td>
                                            
                                            </tr>
                                            <tr>
                                                <td bgcolor="#0e71aa" class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/dolor_cabeza.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Cefalea (Dolor de cabeza)</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">++</td>
                                                <td bgcolor="#c82100" class="td_resp">+++</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="cefalea" value="2" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" bgcolor="#ffffcc" class="mayus-bold">OTROS SINTOMAS</td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/conjutivitis.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Conjuntivitis / Ojos rojos</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">Infrecuente</td>
                                                <td bgcolor="#c82100" class="td_resp">Común</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="conjuntivitis" value="1" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                               
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/moco_congestion.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Rinorrea (goteo nasal)</td>
                                                <td bgcolor="#c26d2a" class="td_resp">Ocasional</td>
                                                <td bgcolor="#c82100" class="td_resp">Ocasional</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="rinorrea" value="1" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/moco_congestion.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Prurito Nasal</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">Ocasional</td>
                                                <td bgcolor="#c82100" class="td_resp">Ocasional</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="prurito_nasal" value="1" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/estornudos.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Estornudos</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">Raro</td>
                                                <td bgcolor="#c82100" class="td_resp">Ocasional</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="estornudos" value="1" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/perdida_olfato_gusto.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Anosmia (Perdida del olfato)</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">Común</td>
                                                <td bgcolor="#c82100" class="td_resp">Raro</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="anosmia" value="1" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/dolor_garganta.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Dolor de garganta</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">+</td>
                                                <td bgcolor="#c82100" class="td_resp">++</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="dolor-garganta" value="1" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/disgeusia.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Disgeusia (perdida del gusto)</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">Ocasional</td>
                                                <td bgcolor="#c82100" class="td_resp">Raro</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="disgeusia" value="1" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/fatiga.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Cansancio/Fatiga</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">Común</td>
                                                <td bgcolor="#c82100" class="td_resp">Común</td>
                                               
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="cansancio" value="1" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                               
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/dolor_muscular.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Mialgia (dolor muscular)</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">Ocasional</td>
                                                <td bgcolor="#c82100" class="td_resp">Común</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="mialgia" value="1" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                               
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/artragias.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Artralgias (dolor articular)</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">Ocasional</td>
                                                <td bgcolor="#c82100" class="td_resp">Común</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="artragias" value="1" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                               
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/dolor_torax.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Dolor Torácico</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">+++</td>
                                                <td bgcolor="#c82100" class="td_resp">++</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="dolor-torax" value="1" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/diarrea.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Diarrea o Molestias Estomacales</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">++</td>
                                                <td bgcolor="#c82100" class="td_resp">+</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="diarrea" value="1" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>   
                                            <tr>
                                                <td colspan="3" style="background: #ffffcc" class="mayus-bold">FACTORES DE RIESGO</td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/disnea.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Falta de aire o dificultad para respirar</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">+++</td>
                                                <td bgcolor="#c82100" class="td_resp">+++</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="disnea" value="3" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/edad.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Edad mas de 65 años</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">+++</td>
                                                <td bgcolor="#c82100" class="td_resp">+++</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="edad65" value="3" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/spo2.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Oximetria < = a 93 %</span></td>
                                                <td bgcolor="#c26d2a" class="td_resp">+++</td>
                                                <td bgcolor="#c82100" class="td_resp">+++</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="spO2" value="3" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td class="mayus-bold td_sintoma"><img src="<?=base_url('assets/img/triage/obesidad.png')?>" width="50" heigth="46"><span style="padding-left: 10px">Sobrepeso-Obesidad</td>
                                                <td bgcolor="#c26d2a" class="td_resp">+++</td>
                                                <td bgcolor="#c82100" class="td_resp">++</td>
                                                
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="obesidad" value="3" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td colspan="3"><strong style="font-size: 16px">¿Fecha en la que aparecen los sintomas?</strong></td>
                                                <td align="center"><input type="date" name="inicio_sintomas"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><strong style="font-size: 16px">¿Infección previa de COVID-19?</strong></td>
                                                <td>
                                                    <label class="md-check mayus-bold">
                                                        <input type="radio" class="has-value"  name="infeccionPrevia" value="1">
                                                        <i class="blue"></i>Si
                                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label class="md-check mayus-bold">
                                                        <input type="radio" class="has-value"  name="infeccionPrevia" value="0">
                                                        <i class="blue"></i>No
                                                    </label>    
                                                </td>
                                                <td align="center">
                                                    <div class="divInfeccion"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><strong style="font-size: 16px">¿Aplicación de vacuna COVID-19?</strong></td>
                                                <td>
                                                    <label class="md-check mayus-bold">
                                                        <input type="radio" class="has-value"  name="vacunaCovid" value="1">
                                                        <i class="blue"></i>Si
                                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label class="md-check mayus-bold">
                                                        <input type="radio" class="has-value"  name="vacunaCovid" value="0">
                                                        <i class="blue"></i>No
                                                    </label>
                                                </td>
                                                <td align="center">
                                                    <div class="divVacuna"></div>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>   
                            </div>
                            <!-- Comorbilidades -->
                            <div class="row" style="margin-top: 0px">
                                <div class="col-md-12" style="padding: 0px">
                                    <table class="evaluar-medico-area-efectiva table table-striped table-bordered table-no-padding">
                                        <caption class="mayus-bold text-center">    
                                        </caption>
                                        <thead class="back-imss">
                                            <tr>
                                                <th style="width: auto" class="text-center mayus-bold">Comorbilidades del paciente</th>
                                                <th style="width: auto" class="text-center mayus-bold">Indique</th>                    
                                            </tr>      
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="mayus-bold">EPOC</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="epoc" value="3" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                              
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Diabetes Mellitus</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="diabetes" value="3" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                        
                                                    </center>
                                                </td>
                                            
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Hipertensión</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="hipertension" value="3" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                               
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Enfermedad Cardíaca</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="cardiopatia" value="3" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                               
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Enfermedad Renal</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="nefropata" value="3" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Enfermedades de Inmunodeficiencia</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="inmunodef" value="3" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mayus-bold">Enfermedades hepáticas</td>
                                                <td>
                                                    <center>
                                                        <label class="md-check">
                                                            <input type="checkbox" name="hepatopatia" value="3" class="has-value">
                                                            <i class="green"></i>
                                                        </label>
                                                    </center>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Glasgow -->
                            <div class="row" style="margin-top: 0px">
                                <div class="col-md-12" style="padding: 0px">
                                    <table class="evaluar-medico-area-efectiva table table-striped table-bordered table-no-padding" style="margin-bottom: -10px">
                                        <caption class="mayus-bold text-center">
                                        </caption>
                                        <thead class="back-imss">
                                            <tr>
                                                <th style="width: auto" class="mayus-bold">Parámetro</th>
                                                <th style="width: auto" colspan="4" class="mayus-bold">Puntuación</th>
                                            </tr>      
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="mayus-bold">Escala de Glasgow Neurológico 
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target='#myModal1' style="margin-left: 15px">Evaluar</button>
                                                </td>
                                                
                                                <td class="text-center">
                                                    <input type="hidden" name="glasgow" required="">
                                                    <span class="badge badge-pill badge-success glasgow"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>  
                                </div>
                            </div>
                            <!-- Evaluacion de QSOFA -->
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
                            <!-- Observaciones -->
                            <div class="row" style="margin-top: 0px">
                                <div class="col-md-12" style="padding: 0px">
                                    <div class="form-group">
                                        <label id="msgObs" style="color: red"></label>
                                        <textarea name="observaciones" class="form-control" rows="5" maxlength="2600" placeholder="Agregar Observaciónes"></textarea>
                                    </div>
                                </div>
                            </div>    
                            <div class="row" style="margin-top: 10px">
                                <div class="col-md-7">
                                    <label><b>¿SE REALIZA PRUEBA DIAGNÓSTICA PARA COVID-19?</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="md-check mayus-bold">
                                        <input type="radio" class="has-value"  name="test_qcovid" value="1" required="">
                                        <i class="blue"></i>Si
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="md-check mayus-bold">
                                        <input type="radio" class="has-value"  name="test_qcovid" value="0">
                                        <i class="blue"></i>No
                                    </label>
                                </div>      
                            </div>
                         
                            <div class="row" style="margin-top: 10px">
                                <div class="col-md-7">
                                    <label><b>¿EL PACIENTE ES TRABAJADOR IMSS?</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="md-check mayus-bold">
                                        <input type="radio" class="has-value"  name="paciente_imss" value="1" required="">
                                        <i class="blue"></i>Si
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="md-check mayus-bold">
                                        <input type="radio" class="has-value"  name="paciente_imss" value="0">
                                        <i class="blue"></i>No
                                    </label>
                                </div>
                                <div class="col-md-7 puesto_empleado">
                                    
                                </div>      
                            </div>                                        
                            <div class="row tratamiento" style="margin-top: 20px">
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
                                        <!--
                                        <tr>
                                            <td>CLOROQUINA tabs 150 mgs  tomar 600 mgs VO cada 12 hrs por un día</td>
                                            <td>
                                                <label class="md-check">
                                                    <input type="checkbox" name="trat[]" id="trat_5" value="5">
                                                    <i class="green"></i>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CLOROQUINA tabs 150 mgs, tomar 300 mgs VO cada 12 hrs por 6 días </td>
                                            <td>
                                                <label class="md-check">
                                                    <input type="checkbox" name="trat[]" id="trat_6" value="6">
                                                    <i class="green"></i>
                                                </label>
                                            </td>
                                        </tr>
                                    -->
                                        <tr>
                                            <td colspan="2" bgcolor="#ffffcc" class="mayus-bold">ANTIBIOTICOS</td>
                                        </tr>
                                        <tr>
                                            <td>CIPROFLOXACINO  250 mg VO (2 TABLETAS) C/12 hrs POR 5 DIAS</td>
                                            <td>
                                                <label class="md-check">
                                                    <input type="checkbox" name="trat[]" id="trat_3" value="3">
                                                    <i class="green"></i>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>LEVOFLOXACINO 750 mg VO C/12 hrs POR 7 DIAS</td>
                                            <td>
                                                <label class="md-check">
                                                    <input type="checkbox" name="trat[]" id="trat_4" value="4">
                                                    <i class="green"></i>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CLARITROMICINA Tabs 250mgs, tomar 500 mgs VO cada 12 hrs por 7 días </td>
                                            <td>
                                                <label class="md-check">
                                                    <input type="checkbox" name="trat[]" id="trat_7" value="7">
                                                    <i class="green"></i>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong style="font-size: 16px">¿Se entrega Kit COVID con Oximetro al paciente?</strong></td>
                                            <td><label class="md-check mayus-bold">
                                                        <input type="radio" class="has-value"  name="entrega_kit" value="1" required="">
                                                        <i class="blue"></i>Si
                                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label class="md-check mayus-bold">
                                                        <input type="radio" class="has-value"  name="entrega_kit" value="0">
                                                        <i class="blue"></i>No
                                                </label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                                
                            </div>                                                    
                            <?php if($this->ConfigExcepcionCMT=='No'){ ?>
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
                                        <label class="mayus-bold"><b>COLOR CLASIFICACIÓN:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label id="msgColor" style="color: red"></label>
                                        <label class="md-check mayus-bold">
                                            <input type="radio" name="clasificacionColor" value="Rojo">
                                            <i class="blue"></i>Rojo
                                        </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label class="md-check mayus-bold">
                                            <input type="radio" name="clasificacionColor" value="Amarillo">
                                            <i class="blue"></i>Amarillo
                                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label class="md-check mayus-bold">
                                            <input type="radio"name="clasificacionColor" value="Verde">
                                            <i class="blue"></i>Verde                                 
                                        </label>&nbsp;&nbsp;&nbsp;
                                    </div>
                                </div>
                                <?php }?>
                            
                            <div class="row">        
                                <div class="col-md-offset-9 col-md-3">
                                    <input type="hidden" name="csrf_token">
                                    <input type="hidden" name="triage_id" value="<?=$this->uri->segment(3)?>">
                                    <input type="hidden" name="triage_consultorio">
                                    <input type="hidden" name="triage_consultorio_nombre">
                                    <input type="hidden" name="triage_solicitud_rx" value="No">
                                    <input type="hidden" name="triage_enviar_a" >
                                    <input type="hidden" name="ac_diagnostico" > <!-- proviene de Jquery -->
                                    <input type="hidden" name="viaRegistroPaciente" value="<?=$info['triage_via_registro']?>">
                                    <input type="hidden" name="qsofa_r" class="qsofa_r" value="<?=$SignosVitales['sv_fr']?>">
                                    <input type="hidden" name="qsofa_ta" class="qsofa_ta" value="<?=$SignosVitales['sv_ta']?>">
                                    <input type="hidden" name="glassgow">
                                    <input type="hidden" name="qsofa">
                                    <br>
                                    <button class="btn pull-right back-imss btn-submit-paso2 btn-block" type="submit" style="margin-bottom: -10px">
                                        Guardar
                                    </button> 
                                </div>
                            </div>
                            <!-- Modal Escala de glasgow -->
                            <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg" >
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Puntuación de la Escala de Glasgow</h4>
                                  </div>
                                    <div class="modal-body">
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border label_glasgow_ocular"><b>APERTURA OCULAR</b></legend>
                                                <div class="form-group">
                                                    <label class="md-check">
                                                    <input type="radio" class='sum_glasgow' name="apertura_ocular" value="4" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Espontánea</label>&nbsp;&nbsp;
                                                    <label class="md-check">
                                                    <input type="radio" class='sum_glasgow' name="apertura_ocular" value="3" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Hablar</label>&nbsp;&nbsp;
                                                    <label class="md-check">
                                                    <input type="radio" class='sum_glasgow' name="apertura_ocular" value="2" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Dolor</label>&nbsp;&nbsp;
                                                    <label class="md-check">
                                                    <input type="radio" class='sum_glasgow' name="apertura_ocular" value="1" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausente</label>
                                                </div>
                                        </fieldset>
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border label_glasgow_motora"><b>RESPUESTA MOTORA</b></legend>
                                                <div class="form-group">
                                                    <label class="md-check">
                                                        <input type="radio" class='sum_glasgow' name="respuesta_motora" value="6" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 6 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Obedece</label>&nbsp;&nbsp;
                                                        <label class="md-check">
                                                        <input type="radio" class='sum_glasgow' name="respuesta_motora" value="5" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 5 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Localiza</label>&nbsp;&nbsp;
                                                        <label class="md-check">
                                                        <input type="radio" class='sum_glasgow' name="respuesta_motora" value="4" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Retira</label>
                                                        <label class="md-check">
                                                        <input type="radio" class='sum_glasgow' name="respuesta_motora" value="3" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Flexión normal</label>&nbsp;&nbsp;
                                                        <label class="md-check">
                                                        <input type="radio" class='sum_glasgow' name="respuesta_motora" value="2" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Extensión anormal</label>&nbsp;&nbsp;
                                                        <label class="md-check">
                                                        <input type="radio" class='sum_glasgow' name="respuesta_motora" value="1" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausencia de repuesta</label>
                                                </div>
                                        </fieldset>
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border label_glasgow_verbal"><b>RESPUESTA VERBAL</b></legend>
                                                <div class="form-group">
                                                    <label class="md-check">
                                                    <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="5" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 5 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Orientado&nbsp;&nbsp;</label>
                                                    <label class="md-check">
                                                    <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="4" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Confuso&nbsp;&nbsp;</label>
                                                    <label class="md-check">
                                                    <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="3" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Incoherente&nbsp;&nbsp;</label>
                                                    <label class="md-check">
                                                    <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="2" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Sonidos Incomprensibles&nbsp;&nbsp;</label>
                                                    <label class="md-check">
                                                    <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="1" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausencia de respuesta</label>
                                                </div>

                                                    <div class="form-group">PUNTUACIÓN TOTAL: &nbsp;<input type="text" name="glasgow" size="3" disable></div>
                                        </fieldset>
                                    </div> <!-- div del cuerpo del modal -->
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-primary btn_modal_glasgow" data-dismiss="">Aceptar</button>
                                </div>
                                </div>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="ConfigDestinosMT" value="<?=$this->ConfigDestinosMT?>">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Medicotriage_r.js?').md5(microtime())?>" type="text/javascript"></script>
