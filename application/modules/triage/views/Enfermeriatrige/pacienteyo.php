<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-9 col-centered">
            <div class="box-inner padding">
                <div class="panel panel-default " style="margin-top: -20px">
                    <div class="paciente-sexo-mujer hide" style="background: pink;width: 100%;height: 10px"></div>
                    <div class="panel-heading p teal-900 back-imss">
                        <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">

                            <div class="row">
                                <div class="col-md-6">
                                    <b>Capturar datos del Paciente</b>&nbsp;
                                </div>
                                <div class="col-md-6 text-right">
                                    <b class="paciente-embarazo "></b>&nbsp;
                                    <span class="paciente-sexo"></span>&nbsp;
                                    <b class="paciente-tipo" hide></b>&nbsp;
                                    <b class="paciente-edad hide"></b>
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="panel-body b-b b-light">
                        <div class="">
                            <form class="guardar-triage-enfermeria">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group" >
                                                    <label><b>APELLIDO PATERNO</b> </label>
                                                    <input class="form-control" name="triage_nombre_ap"  value="<?=$info['triage_nombre_ap']?>">   

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group" >
                                                    <label><b>APELLIDO MATERNO</b> </label>
                                                    <input class="form-control" name="triage_nombre_am"  value="<?=$info['triage_nombre_am']?>">   
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group" >
                                                    <label><b>NOMBRE</b> </label>
                                                    <input class="form-control" name="triage_nombre" required="" placeholder="" value="<?=$info['triage_nombre']?>">   
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:-15px">
                                            <div class="col-md-4">
                                                <div class="form-group" >
                                                    <label><b>FECHA DE NACIMIENTO</b></label>
                                                    <input class="form-control dd-mm-yyyy" name="triage_fecha_nac" required="" placeholder="__/__/____" value="<?=$info['triage_fecha_nac']?>">   
                                                </div>   
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label ><b>SELECCIONAR SEXO</b></label>
                                                    <select class="form-control" name="triage_paciente_sexo" data-value="<?=$info['triage_paciente_sexo']?>">
                                                        <option value="">SELECCIONAR SEXO</option>
                                                        <option value="HOMBRE">HOMBRE</option>
                                                        <option value="MUJER">MUJER</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group triage_paciente_sexo hide" >
                                                    <label style="margin-bottom:10px"><b>INDICIO DE EMBARAZO:</b> </label><br>
                                                    <label class="md-check">
                                                        <input type="radio" name="pic_indicio_embarazo" value="Si" data-value="<?=$PINFO['pic_indicio_embarazo']?>"  class="has-value "><i class="green"></i>SI
                                                    </label>&nbsp;&nbsp;
                                                    <label class="md-check">
                                                        <input type="radio" name="pic_indicio_embarazo" value="No" data-value="<?=$PINFO['pic_indicio_embarazo']?>" checked=""><i class="green"></i>NO
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><b>PROCEDENCIA ESPONTÁNEA</b></label>&nbsp;
                                                    <label class="md-check">
                                                        <input type="radio" name="pia_procedencia_espontanea" data-value="<?=$PINFO['pia_procedencia_espontanea']?>" value="Si" checked="" ><i class="green"></i>SI
                                                    </label>&nbsp;&nbsp;
                                                    <label class="md-check">
                                                        <input type="radio" name="pia_procedencia_espontanea" value="No"><i class="green"></i>NO
                                                    </label>
                                                    <input class="form-control " required="" type="text" name="pia_procedencia_espontanea_lugar" value="<?=$PINFO['pia_procedencia_espontanea_lugar']?>" placeholder="Anote especialidad en caso de ser atendido en esta unidad">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-no-espontaneo hidden">
                                                <div class="form-group">
                                                    <label><b>HOSPITAL DE PROCEDENCIA</b></label>
                                                    <select name="pia_procedencia_hospital" data-value="<?=$PINFO['pia_procedencia_hospital']?>" class="form-control">
                                                        <option value="">SELECCIONAR</option>
                                                        <option value="UMF">UMF</option>
                                                        <option value="HGZ">HGZ</option>
                                                        <option value="UMAE">UMAE</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-no-espontaneo hidden">
                                                <div class="form-group">
                                                    <label class="mayus-bold">NOMBRE/NUMERO DEL HOSPITAL</label>
                                                    <input class="form-control" name="pia_procedencia_hospital_num"  value="<?=$PINFO['pia_procedencia_hospital_num']?>">   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 <?=$this->ConfigSolicitarOD=='No' ?'hidden' : ''?>">
                                        <div class="form-group">
                                            <label class="mayus-bold">OXIMETRÍA</label>
                                            <input type="text" name="sv_oximetria" value="<?=$SignosVitales['sv_oximetria']?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 <?=$this->ConfigSolicitarOD=='No' ?'hidden' : ''?>">
                                        <div class="form-group">
                                            <label class="mayus-bold">DEXTROSTIX</label>
                                            <input type="text" name="sv_dextrostix" value="<?=$SignosVitales['sv_dextrostix']?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" >
                                            <a href="<?=  base_url()?>assets/triage/anexo_2.pdf" target="blank" tabindex="-1" style="cursor: pointer;color: #5697E6">
                                                <label><b>TENSIÓN ARTERIAL</b> </label>
                                            </a><!--Blood Pressure-->
                                            <input class="form-control"  name="sv_ta" value="<?=$SignosVitales['sv_ta']?>" >   
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <a href="<?=  base_url()?>assets/triage/anexo_1.pdf" target="blank" tabindex="-1" style="cursor: pointer;color: #5697E6">
                                                <label><b>TEMPERATURA</b></label>
                                            </a>
                                            <input class="form-control" name="sv_temp"  value="<?=$SignosVitales['sv_temp']?>">   
                                        </div><!--TEMPERATURE-->
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <a href="<?=  base_url()?>assets/triage/anexo_3.pdf" target="blank" tabindex="-1" style="cursor: pointer;color: #5697E6">
                                                <label><b>FRECUENCIA CARD.</b> </label>
                                            </a><!---->
                                            <input class="form-control" name="sv_fc"  value="<?=$SignosVitales['sv_fc']?>">   
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <a href="<?=  base_url()?>assets/triage/anexo_4.pdf" target="blank" tabindex="-1" style="cursor: pointer;color: #5697E6">
                                                <label><b>FRECUENCIA RESP.</b></label>
                                            </a><!--Sp02-->
                                            <input class="form-control" name="sv_fr"  value="<?=$SignosVitales['sv_fr']?>">   
                                        </div>
                                    </div>
                                    <div class="col-md-offset-6 col-md-3">
                                        <button type="button" class="btn btn-block btn-imms-cancel" onclick="top.close()">Cancelar</button>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="hidden" name="via" value="<?=$_GET['via']?>">
                                        <input type="hidden" name="csrf_token" >
                                        <input type="hidden" name="triage_id" value="<?=$this->uri->segment(3)?>">
                                        <input type="hidden" name="sv_via" value="Manual">
                                        <input type='hidden' name="inputLocation">
                                        <input type='hidden' name="inputModelName">
                                        <input type='hidden' name="inputModelNumber">
                                        <input type='hidden' name="inputSerialNumber">
                                        <button class="btn btn-block back-imss" type="submit" style="margin-bottom: -10px">Guardar</button>                     
                                    </div>
                                    
                                </div>
                                
                            </form>
                        </div>
                        <form name="myform">
                            <div class="row hide">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Config</label>
                                        <input type="text" name="inputConfig" value="Auto" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Monitor Mode</label>
                                        <select name="inputMonitorMode" class="form-control">
                                            <option value="true">TRUE</option>
                                            <option value="false" selected="">FALSE</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>AX 3.x Test Script Version:</label>
                                        <input type='text' class="form-control" id='ScriptVersion' name="ScriptVersion" value="A">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>XML</label>
                                        <select name="inputXmlFile" class="form-control">
                                            <option value="pagereset" >LEER Y RESETEAR</option>
                                            <option value="pagenoreset" selected="">LEER Y NO RESETEAR</option>
                                            <option value="filereset">CREAR ARCHIVO Y RESETEAR</option>
                                            <option value="filenoreset">CREAR ARCHIVO Y NO RESETEAR</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Timeout</label>
                                        <input type="text"  name="inputTimeOut" value="2000" class="form-control">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input type="text" class="form-control" readonly="" name="inputEstatus" value="Initializing..........."><br>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Autodisplay</label>
                                        <select name="inputAutoDisplay" class="form-control">
                                            <option value="true" >True</option>
                                            <option value="false">False</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>SetTime (yyyy-mm-dd h:i:s)</label>
                                        <input type="text" name="inputSetTime" class="form-control"> 
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <h4><b>FISIOLÓGICO</b></h4>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Blood pressure:</label>
                                        <input type='text' name="inputSys" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Temperature:</label>
                                        <input type='text' name="inputTemp" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Clinician ID:</label>
                                        <input  type='text' name="inputCID" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Weight:</label>
                                        <input type='text' name="inputWeight" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Heart Rate:</label>
                                        <input type='text' name="inputHR" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Patient ID:</label>
                                        <input  type='text' name="inputPID" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>BMI</label>
                                        <input type='text' name="inputBMI" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Height</label>
                                        <input type='text' name="inputHeight" class="form-control">
                                    </div>
                                    
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>MAP:</label>
                                        <input type='text' name="inputMAP" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Pulse Ox:</label>
                                        <input type='text' name="inputPulse" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Resp:</label>
                                        <input type='text' name="inputResp" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Reading Date:</label>
                                        <input  type='text' name="inputReadingDate" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>pO2:</label>
                                        <input type='text' name="inputSpo2" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Pain:</label>
                                        <input type='text' name="inputPain" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Best HR:</label>
                                        <input type='text' name="inputBestHR" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <h5><b>COMANDOS</b></h5>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>BP Post Erase:</label>
                                        <input type='text' name="inputSysposterase" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>SpO2 Post Erase:</label>
                                        <input type='text' name="inputSpo2posterase" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Time Post Set:</label>
                                        <input type='text' name="inputTimeposterase" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <h5><b>INFORMACIÓN DEL DISPOSITIVO</b></h5>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>DATE:</label>
                                        <input type='text' vname="inputDate" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>MODEL NUMBER:</label>
                                        <input type='text' name="inputModelNumber" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>DISPLAY TEMP:</label>
                                        <input type='text' name="inputDisplayTemp" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>LOCATION:</label>
                                        <input type='text' name="inputLocation" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>SERIAL NUMBER:</label>
                                        <input type='text' name="inputSerialNumber" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>DISPLAY WEIGHT:</label>
                                        <input type='text' name="inputDisplayWeight" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>FIRMWARE</label>
                                        <input type='text' name="inputFirmware" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>DISPLAY HEIGHT:</label>
                                        <input type='text' name="inputDisplayHeight" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>DISPLAY SpHb</label>
                                        <input type='text' name="inputDisplayHemo" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>MODEL NAME</label>
                                        <input type='text' name="inputModelName" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>DISPLAY NIBP:</label>
                                        <input type='text' name="inputDisplayNIBP" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <h5><b>CONFIGURACIÓN DE DATOS</b></h5>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>HEIGHT UNITS</label>
                                        <input type='text' name="inputHeightUnits" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>SpHb Units:</label>
                                        <input type='text' name="inputHemoUnits" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>NIBP Units:</label>
                                        <input type='text' name="inputNIBPUnits" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>TEMP UNITS</label>
                                        <input type='text' name="inputTempUnits" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>WEIGHT UNITS</label>
                                        <input type='text' name="inputWeightUnits" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 hide">
                                    <textarea name="inpuXmlString" class="form-control" rows="8"></textarea><br>
                                    <textarea name="inputModifiers" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 Error-Formato-Fecha hide no-padding ">
                        <div class="card red-500">
                            <div class="card-heading">
                                <h2 class="font-thin" style="font-size: 15px"></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 Device-WelchAllyn-Status hide no-padding hidden">
                        <div class="card red-500">
                            <div class="card-heading">
                                <h2 class="font-thin" style="font-size: 15px"></h2>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/libs/moment.js?')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/Enfermeriatriage.js?').md5(microtime())?>" type="text/javascript"></script>
<!--<script hi src="<?= base_url('assets/js/WelchAllyn.js?').md5(microtime())?>" type="text/javascript"></script>-->